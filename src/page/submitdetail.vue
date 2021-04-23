<template>
  <div class="submit-detail">
    <div class="content">
      <div class="content-head">
        <div>{{ pid }} {{ title }}</div>
        <div class="status-icon" :style="styleClass">
          {{ getErrorName(status.toLowerCase()) }}
        </div>
      </div>
      <div class="content-statistic">
        <div><span>Language: </span>{{ lang }}</div>
        <div><span>Time: </span>{{ timeUsed | timeUsedFormat }}</div>
        <div><span>Memory: </span>{{ memoryUsed | memoryUsedFormat }}</div>
        <div><span>Submit Time: </span>{{ submitTime }}</div>
        <div>
          <span
            id="back-contest-btn"
            @click="$router.push('/contest/' + cid)"
            v-if="cid !== undefined"
            >返回比赛</span
          >
        </div>
      </div>
      <div class="content-box">
        <div class="err-msg" v-if="errMsg">
          <label for="errMsgDisplay" class="title-label">编译信息</label>
          <textarea
            id="errMsgDisplay"
            readonly
            v-model="errMsg"
          ></textarea>
        </div>
        
        <label class="title-label" for="codeDisplay" v-if="errMsg">Source Code</label>
        <div class="content-code">
          <mycodemirror
            id="codeDisplay"
            :lang="cmlang"
            :readOnly="true"
            :precode="code"
            ref="codeViewer"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { getWholeErrorName } from "../api/common";
import { getProblem } from "../api/problem";
import {  getStatusById } from "../api/status";
import { getStatus } from "../api/getData"
import Mycodemirror from "../components/myCodemirror";
import { languages } from "../config/language";

export default {
  components: { Mycodemirror },
  name: "submitdetail",
  props: ["pid", "sid", "cid"],
  data() {
    return {
      title: "",
      status: "Judging",
      lang: "",
      code: "",
      memoryUsed: 0,
      timeUsed: 0,
      submitTime: "",
      interval: null,
      styleClass: {
        // color: 'white',
        // background: 'rgb(86,196,26)',
        // border: 'none'
      },
      errMsg: ""
    };
  },
  computed: {
    cmlang() {
      /*switch (this.lang.toLowerCase()) {
        case "c":
          return "text/x-csrc";
        case "c++11":
          return "text/x-c++src";
        case "java":
          return "text/x-java";
        case "python":
          return "python3.6";
        default:
          return "text/x-csrc";
      }*/
      return this.lang;
    },
  },
  filters: {
    timeUsedFormat: function(val) {
      let res = parseInt(val); // ns
      res /= 1000000; // ms
      return parseInt(res) + " ms";
    },
    memoryUsedFormat: function(val) {
      let res = parseInt(val); // byte
      res /= 1024.0 * 1024.0;
      if (res <= 0.01) {
        res *= 1024;
        res = res.toFixed(2);
        return res + " Kb";
      }
      res = res.toFixed(2);
      return res + " Mb";
    },
  },
  created() {
    this.renderProblemInfo();
  },
  mounted() {
    this.$nextTick(() => {
      this.renderStatus();
      this.setIntervaler();
    });
    
  },
  deactivated() {
    
  },
  destroyed() {
    clearInterval(this.interval);
  },
  methods: {
    getErrorName(status) {
      return getWholeErrorName(status);
    },
    renderProblemInfo: async function() {
      let requestData = {
        problem_id: this.pid,
      };
      if (this.cid != undefined) {
        requestData.contest_id = this.cid;
      }
      let response = await getProblem(requestData);
      if (response.status == 0) {
        this.title = response.data.title;
      } else {
        this.$message({
          message: "发生错误: " + response.message + ", 请联系管理员",
          type: "error",
        });
      }
    },
    renderStatus: async function() {
      this.$loading.open();
      let response = {};
      if(this.pid != undefined && this.pid != "" && this.sid == ""){
          response = await getStatus({
            problem_id: this.pid,
          });

      }
      else {
        response = await getStatusById({
          id: this.sid,
        });
      }
      if (response.status == 0) {
      let data = response.data;
      if (data.problem_id != this.pid) {
        this.$message({
          message: "不存在该提交",
          type: "error",
        });
        this.$router.go(-1);
        }
        this.lang = this.langToValue(data.language);
        this.status = data.status;
        this.code = data.source_code;
        this.submitTime = data.submit_time;
        if(this.submitTime[19] == "Z") this.submitTime = this.submitTime.substr(0, this.submitTime.length-1);
        this.submitTime = this.submitTime.replace("T", " ");
        this.timeUsed = data.time;
        this.memoryUsed = data.memory;
        this.errMsg = data.msg;
        this.$refs.codeViewer.code = this.code;
        if (data.status !== "Judging") {
          clearInterval(this.interval);
        }
      } else {
        this.$message({
          message: "发生错误: " + response.message + ", 请联系管理员",
          type: "error",
        });
        clearInterval(this.interval);
      }
      this.$loading.hide();
    },
    langToValue(val) {
      /*const len = languages.length;
      for (let i=0; i<len; i++) {
        if (val === languages[i].value) {
          return languages[i].name;
        }
      }
      return "Unknown Language";*/
      return String(val);
    },
    setIntervaler: function() {
      this.interval = setInterval(() => {
        this.renderStatus();
      }, 5000);
    },
  },
  watch: {
    status: function(val) {
      if (val.toLowerCase() != "judging") {
        clearInterval(this.interval);
      }
      switch (val.toLowerCase()) {
        case "ac":
          this.styleClass = {
            color: "white",
            background: "#52C41A",
            border: "none",
          };
          break;
        case "wa":
          this.styleClass = {
            color: "white",
            background: "#E74C3C",
            border: "none",
          };
          break;
        case "tle":
          this.styleClass = {
            color: "white",
            background: "#3498DB",
            border: "none",
          };
          break;
        case "mle":
        case "ce":
          this.styleClass = {
            color: "white",
            background: "#FADB14",
            border: "none",
          };
          break;
        case "se":
        case "re":
          this.styleClass = {
            color: "white",
            background: "black",
            border: "none",
          };
          break;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.submit-detail {
  position: relative;
  width: 100%;
  height: 100%;
  overflow-x: hidden;
  overflow-y: scroll;
  padding-left: 27px;
}

.content-box {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.content {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 88px;
  margin-bottom: 70px;
  > div {
    width: 80%;
  }
  &-head {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    font: {
      weight: bold;
      size: 20px;
    }
  }
  &-statistic {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
    margin-top: 10px;
    > div {
      margin-right: 45px;
      > span {
        font-weight: bold;
      }
    }
  }
  &-code {
    overflow: hidden;
    border-radius: 10px;
    margin-top: 7px;
    width: 100%;
  }
}

.status-icon {
  padding: 2px 15px;
  text-align: center;
  font: {
    size: 17px;
    weight: normal;
  }
  border: {
    width: 1px;
    style: solid;
    color: gray;
    radius: 0.5em;
  }
}

#back-contest-btn {
  float: right;
  color: red;
  cursor: pointer;
  &:hover {
    text-decoration: underline;
  }
}

.title-label {
  font-weight: bold;
}

.err-msg {
  display: flex;
  flex-direction: column;
  width: 100%;
  margin-top: 15px;
  margin-bottom: 15px;

  > textarea {
    border: none;
    resize: none;
    background: rgba(38,50,56,0.9);
    color: #E9EDED;
    border-radius: 10px;
    padding: 6px 13px;
    min-height: 100px;
    overflow: auto;
    margin-top: 7px;
  }
}

@media screen and (max-width: 650px) {
  .submit-detail {
    padding: 0 10px;
    width: 100%;

    > .content {
      width: 100%;
      max-width: inherit;
      min-width: unset;

      > * {
        width: 100%;
      }
    }
  }
}
</style>
