<template>
  <div class="problem-detail-container">
    <div class="temp-problem-detail">
      <div class="title">{{ problem_info.id }} {{ problem_info.title }}</div>
      <div class="other-info">
        <div class="source" v-if="problem_info.source.trim()">{{ problem_info.source }}</div>
      </div>
      <div id="render-latex-content">
        <div class="problem-background" v-if="problem_info.background.trim()">
          <span class="sub-title">题目背景</span>
          <span class="content render-scroll-area" v-html="Marked(problem_info.background)"></span>
        </div>
        <div class="describe" v-if="problem_info.describe.trim()">
          <span class="sub-title">题目描述</span>
          <span class="content" v-html="Marked(problem_info.describe)"></span>
        </div>
        <div class="io-standard">
          <span class="sub-title">输入格式</span>
          <span
            class="content render-scroll-area"
            v-html="Marked(problem_info.input_sample)"
          ></span>
        </div>
        <div class="io-standard">
          <span class="sub-title">输出格式</span>
          <span
            class="content render-scroll-area"
            v-html="Marked(problem_info.output_sample)"
          ></span>
        </div>
      </div>
      <div class="example-data">
        <span class="sub-title">样例</span>
        <div
          class="example-data-element"
          v-for="index in problem_info.example.length"
          :key="'sample-' + index"
        >
          <label :for="'example' + index">{{ "Case #" + index }}</label>
          <div
            :id="'example' + index"
            class="example-content"
            style="height: auto;"
          >
            <div style="height: auto;">
              <div class="example-top">
                <span>Input:</span>
                <button
                  class="example-copy-btn"
                  @click="copy(problem_info.example[index - 1].input)"
                >
                  复制
                </button>
              </div>
              <textarea
                class="input-example sub-example"
                readonly
                v-model="problem_info.example[index - 1].input"
                :rows="getSampleRows(index - 1)"
              ></textarea>
            </div>
            <div>
              <div class="example-top">
                <span>Output:</span>
                <button
                  class="example-copy-btn"
                  @click="copy(problem_info.example[index - 1].output)"
                >
                  复制
                </button>
              </div>
              <textarea
                class="output-example sub-example"
                readonly
                v-model="problem_info.example[index - 1].output"
                :rows="getSampleRows(index - 1)"
              ></textarea>
            </div>
          </div>
        </div>
        <div v-if="problem_info.example.length === 0">无</div>
      </div>
      <div class="hint" v-if="problem_info.hint != ''">
        <span class="sub-title">Hint</span>
        <div
          class="content render-scroll-area"
          v-html="Marked(problem_info.hint)"
          id="render-latex-hint"
        ></div>
      </div>
      <div class="function-btn-group">
        <button
          class="judgelog-btn"
          @click="gotoJudgelog(pid || $route.query.pid)"
          :disabled="cid || $route.query.cid"
        >
          提交记录
        </button>
        <button
          class="submit-btn"
          @click="gotoSubmit(pid || $route.query.pid, cid || $route.query.cid)"
        >
          Submit
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { getProblem } from "../api/getData";
import { Clipboard } from "../api/common";
import marked from "marked";

export default {
  name: "problem-detail",
  props: ['pid', 'cid'],
  data() {
    return {
      problem_info: {
        id: this.pid || this.$route.query.pid,
        title: "",
        background: "",
        describe: "",
        input_sample: "",
        output_sample: "",
        example: [
          // {
          //     input: '这里是样例输入#1',
          //     output: '这里是样例输出#1'
          // },
        ],
        hint: "",
        source: ""
      }
    };
  },
  created() {
    if (this.pid || this.$route.query.pid) this.renderProblemDetail();
  },
  methods: {
    gotoJudgelog(pid) {
      this.$router.push(`/submission?p=${pid}`);
    },
    gotoSubmit(pid, cid = null) {
      if (window.isWap) {
        this.$parent.callSubmit({
          pid: pid,
          cid: cid,
        });
      } else {
        this.$emit("open-submit", {
          pid: pid,
          cid: cid,
        });
      }
    },
    renderProblemDetail: async function() {
      this.$loading.open();
      let requestData = {
        problem_id: parseInt(this.pid || this.$route.query.pid),
      };
      if ((this.cid || this.$route.query.cid) != undefined) {
        requestData.contest_id = this.cid || this.$route.query.cid;
      }
      let response = await getProblem(requestData);
      if (response.status == 0) {
        if (response.message == "题目不可用") {
          this.$message({
            message: response.message,
            type: "error",
          });
        } else {
          let data = response.data;
          this.problem_info = Object.assign(this.problem_info, {
            title: data.title,
            background: data.background,
            describe: data.describe,
            input_sample: data.input_format,
            output_sample: data.output_format,
            hint: data.hint,
            source: data.source
          });
          data.sample.forEach((val) => {
            this.problem_info.example.push(val);
          });
        }
      } else {
        if (response.status === 504) {
          this.$message({
            message: "请求超时",
            type: "error",
          });
        } else {
          this.$message({
            message: response.message,
            type: "error",
          });
        }
      }
      this.$loading.hide();
      this.LaTeXed();
    },
    Marked: function(content) {
      return marked(content);
    },
    LaTeXed: function() {
      // 使用$nextTick等组件数据渲染完之后再调用MathJax渲染方法
      this.$nextTick(() => {
        window.MathJax.Hub.Queue([
          "Typeset",
          window.MathJax.Hub,
          document.getElementById("render-latex-content"),
        ]);
        window.MathJax.Hub.Queue([
          "Typeset",
          window.MathJax.Hub,
          document.getElementById("render-latex-hint"),
        ]);
      });
    },
    copy: function(val) {
      if (Clipboard.copy(val)) {
        this.$message({
          message: "复制成功",
          type: "info",
        });
      } else {
        this.$message({
          message: "复制失败, 请手动复制",
          type: "warning",
        });
      }
    },
    getSampleRows: function(index) {
      try {
        let content1 = this.problem_info.example[index].input || "";
        let content2 = this.problem_info.example[index].output || "";
        let lines = Math.max(
          content1.split(/\r\n|\r|\n|<br>/).length,
          content2.split(/\r\n|\r|\n|<br>/).length
        );
        if (lines <= 2) return 2;
        else return lines;
      } catch (e) {
        return 0;
      }
    },
  },
  computed: {
    problem_id: function() {
      return this.pid;
    },
  },
};
</script>

<style lang="scss" scoped>
.problem-detail-container {
  padding-top: 30px;
}

.temp-problem-detail {
  user-select: text;
  position: relative;
  padding: 30px 20px 20px 20px;
}

.title {
  display: flex;
  flex-direction: column;
  font: {
    weight: bold;
    size: 32px;
  }
  // &::after {
  //   content: "";
  //   position: absolute;
  //   top: 75px;
  //   height: 1px;
  //   background: gray;
  //   width: 70%;
  // }
}

.other-info {
  display: flex;
  flex-direction: row;
  
  .source {
    color: gray;
    font-size: 12px;
  }
}


.sub-title {
  display: block;
  font-weight: bold;
  font-size: 21px;
  margin-top: 12px;
  margin-bottom: 5px;
}

.content {
  font-size: 17px;
}

.function-btn-group {
  margin-top: 25px;
  > button {
    margin-right: 15px;
    &:last-child {
      margin-right: 0;
    }
  }
}

.judgelog-btn {
  border-radius: 0.5em;
  font-size: 16px;
  padding: 5px 20px;
  background: #4288ce;
  color: white;
  border: solid 1px #4288ce;
  cursor: pointer;
  &:hover {
    text-decoration: underline;
  }
  &:disabled {
    display: none;
  }
}

.submit-btn {
  border-radius: 0.5em;
  font-size: 16px;
  padding: 5px 20px;
  background: #4288ce;
  color: white;
  border: solid 1px #4288ce;
  cursor: pointer;
  &:hover {
    text-decoration: underline;
  }
}

.example-data-element {
  width: 100%;
  margin: 20px 0;
  > label {
    font: {
      size: 15px;
      weight: bold;
    }
  }
  > div {
    display: flex;
    justify-content: flex-start;
  }
  .example-content {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }
}

.example-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2px;
}

.sub-example {
  overflow-x: scroll;
  overflow-y: visible;
  background: #eeeeee;
  border: 1px solid #aaaaaa;
  border-radius: 0.4em;
  padding: 10px 0 10px 15px;
  width: 250px;
  height: auto;
  user-select: text;
  resize: none;
  font-family: RobotoMono;
}

.example-copy-btn {
  background: none;
  border: 1px solid #4288ce;
  border-radius: 0.3em;
  color: #4288ce;
  width: 50px;
  cursor: pointer;
  line-height: 18px;
  &:hover {
    text-decoration: underline;
  }
}

.function-btn-group {
  display: flex;
  justify-content: flex-end;
  padding: 0 20px 10px 20px;
}

@media (max-width: 650px) {
  .problem-detail-container {
    top: 20px;
    &::-webkit-scrollbar {
      display: none;
    }
  }

  .temp-problem-detail > .title::after {
    width: calc(100% - 40px);
  }

  .example-data {
    width: 100%;
    margin-right: 0;

    .example-data-element {
      width: 100%;
      margin-right: 0;

      .example-content {
        display: flex;
        flex-flow: row wrap;
        > div {
          width: 100%;
          > textarea {
            width: 100%;
          }
          &:last-child {
            margin-left: unset;
          }
        }
      }
    }
  }

  .render-scroll-area {
    min-width: 100%;
    width: auto;
    overflow-x: auto;
    white-space: pre-wrap;
    &::-webkit-scrollbar {
      display: none;
    }
  }
}
</style>
