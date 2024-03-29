<template>
  <div id="top-drawer" :style="styleObject" ref="topDrawer">
    <div class="function-group">
      <div>
        <label for="code-lang">编译语言: </label>
        <select v-model="lang" id="code-lang">
          <option
            v-for="index in langItems.length"
            :value="langItems[index - 1].value"
            :key="langItems[index - 1].value"
          >
            {{ langItems[index - 1].name }}
          </option>
        </select>
      </div>
      <div class="btn-group">
        <button class="test-btn" disabled>编译测试</button>
        <button class="submit-btn" @click="doSubmit" :disabled="submitting">提交代码</button>
      </div>
    </div>
    <div>
      <div class="tips">
        <span class="problem">Problem {{ pid }}</span>
        <span class="contest" v-if="cid != null">ContestID: {{ cid }}</span>
      </div>
      <code-editor ref="codeEditor" :lang="getCMLang"/>
    </div>
    <div class="close-btn" @click="close()">
      <img
        src="../../assets/icon/packup.svg"
        width="18"
        height="18"
        alt="close"
      />
    </div>
  </div>
</template>

<script>
import codeEditor from "./myCodemirror";
import { checkLogin } from "../api/login";
import { submitCode } from "../api/submit";
import { getProblem } from "../api/problem";
import { languages } from "../config/language";

export default {
  name: "top-drawer",
  props: ["isDisplay", "pid", "cid"],
  components: { codeEditor },
  data() {
    return {
      code: {},
      lang: "c.gcc",
      langItems: languages,
      submitting: false,
      lastSubmit: 0
    };
  },
  methods: {
    close() {
      this.$emit("close");
    },
    checkLoginStatus: async function() {
      /*user_id: this.$store.state.login.user_id,*/
      let response = await checkLogin({
        user_id: localStorage.getItem("userId"),
      });
      if (response.status == 0) {
        if (response.message.indexOf("不符") !== -1) {
          this.$message({
            message: "登陆状态错误, 请登出后重新登录",
            type: "warning",
          });
          return false;
        }
      } else {
        if (response.status == -1) {
          this.$store.dispatch("login/userLogin", false);
          localStorage.removeItem("Flag");
          this.$message({
            message: "登陆状态已过期, 请重新登录",
            type: "warning",
          });
          return false;
        }
      }
      return true;
    },
    doSubmit: async function() {
      if (this.submitting) return;
      else this.submitting = true;
      let nowTime = new Date().getTime();
      if(nowTime - this.lastSubmit < 3000){
        this.$message({
          message: "提交过于频繁,请稍后再试",
          type: "error",
        });
        this.$loading.hide();
      }
      else this.lastSubmit = nowTime;

      const tmp = await this.checkLoginStatus();
      if (!tmp) return;
      
      this.$loading.open();
      let requestData = {
        language: this.lang,
        source_code: this.$refs.codeEditor.code,
        problem_id: parseInt(this.pid), // 傻逼ljw后端只能传string
      };
      if (this.cid != undefined) {
        requestData.contest_id = parseInt(this.cid);
      }
      let response = await submitCode(requestData);
      if (response.status == 0) {
        this.$message({
          message: "提交成功",
          type: "success",
        });
        this.$loading.hide();
        let link = "/status?p=" + this.pid + "&s=" + response.data;
        if (this.cid != undefined) {
          link += "&c=" + this.cid;
        }
        // 提交成功,隐藏两个drawer
        this.$emit("close-all");
        // 跳转到状态表
        this.$router.push(link);
      } else {
        this.$message({
          message: "提交失败, 请联系管理员: " + response.message,
          type: "error",
        });
        this.$loading.hide();
      }
      this.submitting = false;
    },
  },
  computed: {
    styleObject() {
      let res = {
        "margin-top": 0,
      };
      if (this.isDisplay) {
        res["margin-top"] = 0;
      } else {
        res["margin-top"] = "-300%";
      }
      return res;
    },
    getCMLang() {
      let res = this.langItems.map((x) => x.value).indexOf(this.lang);
      if (res === -1) {
        return "text/x-csrc";
      } else {
        return this.langItems[res].cmValue;
      }
    }
  },
  watch: {
    lang(val, before) {
      // 保存之前的代码
      localStorage.setItem(`${before}-stash`, this.$refs.codeEditor.code);
      // 从未有过临时代码
      this.$refs.codeEditor.code = localStorage.getItem(`${val}-stash`) || ""; // || ""不能删 删了会有bug
    },
    isDisplay(val) {
      if (val) {
        this.lang = localStorage.getItem('code-language') || "c.gcc";
      } else {
        localStorage.setItem('code-language', this.lang);
      }
    }
  },
};
</script>

<style lang="scss" scoped>
#top-drawer {
  position: fixed;
  width: calc((100% - 200px) / 2 - 50px);
  // height: 95%;
  top: 0;
  left: 220px;
  background: rgba(255, 255, 255, 0.65);
  border: {
    bottom-left-radius: 0.8em;
    bottom-right-radius: 0.8em;
  }
  backdrop-filter: blur(10px);
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.18);
  z-index: 1001;
  transition: margin-top 0.6s ease-in-out;
}

.tips {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: rgba(38, 50, 56, 0.9);
  color: #537f7e;
  padding: 5px 6px 0 18px;
  > span {
    display: inline-block;
  }
  .problem {
    font-size: 12pt;
  }
  .contest {
    font-size: 10pt;
    padding-top: 1px;
  }
}

.function-group {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  height: 35px;
  padding: 0 10px;
  .btn-group {
    > button {
      height: 26px;
      padding: {
        left: 10px;
        right: 10px;
      }
      font-size: 13px;
      cursor: pointer;
      border-radius: 10px;
      &:hover {
        text-decoration: underline;
      }
    }
    .submit-btn {
      margin-left: 5px;
    }
  }
}

.close-btn {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 25px;
  margin-top: 5px;
  bottom: 0;
  cursor: pointer;
  padding-bottom: 2px;
  /*backdrop-filter: blur(3px);*/
}
@media (max-width: 650px) {
  #top-drawer {
    width: 90%;
    left: calc(100% / 2 - 90% / 2);
    // height: 90%;
  }
}
</style>
