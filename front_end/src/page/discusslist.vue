<template>
  <div class="discuss-list">
    <div class="question-bar">
      <span @click="$router.push('/contest/' + contest_id)" class="back-btn"
        >回到比赛</span
      >
      <div>
        <input
          type="text"
          placeholder="在此键入提问标题(至少5个字符)..."
          v-model="question.title"
        />
        <textarea
          placeholder="在此键入提问内容(至少15个字符)..."
          v-model="question.content"
        ></textarea>
        <select v-model="question.problem_id">
          <option
            v-for="index in problems.length"
            :value="problems[index - 1]"
            :key="problem[index - 1]"
            >{{ String.fromCharCode(64 + index) }}</option
          >
        </select>
        <button class="submit-ques-btn" @click="doQuestion">Submit</button>
      </div>
    </div>
    <div class="list">
      <div
        class="element-card"
        v-for="index in items.length"
        :key="'themeCard-' + index"
        @click="
          $router.push('/discuss/' + contest_id + '/' + items[index - 1].id)
        "
      >
        <div class="title">
          <span class="problem-tag">{{
            String.fromCharCode(
              problems
                .map((x) => parseInt(x))
                .indexOf(parseInt(items[index - 1].problem_id)) + 64
            )
          }}</span>
          {{ items[index - 1].title | titleFilter }}
        </div>
        <div class="content">
          {{ items[index - 1].content | contentFilter }}
        </div>
        <div class="user-nick">{{ items[index - 1].nick }}</div>
        <div class="time">{{ items[index - 1].time }}</div>
      </div>
    </div>
  </div>
</template>

<script>
import { getDiscussList, addDiscuss, getContest } from "../api/getData";

export default {
  name: "discusslist",
  data() {
    return {
      display: false,
      question: {
        title: "",
        content: "",
        problem_id: "",
      },
      items: [
        // {
        //     id: '',
        //     problem_id: '',
        //     contest_id: '',
        //     user_id: '',
        //     nick: '',
        //     time: '',
        //     title: '',
        //     content: '',
        //     status: ''
        // }
      ],
      problems: [],
    };
  },
  beforeMount() {
    this.renderList();
    this.getProblemList();
  },
  methods: {
    renderList: async function() {
      this.$loading.open();
      this.items = [];
      let response = await getDiscussList({
        contest_id: this.$route.params.id,
      });
      // console.log(response);
      if (response.status == 0) {
        response.data.forEach((val) => {
          this.items.push(val);
        });
      } else {
        if (response.status === 504) {
          this.$message({
            message: "请求超时",
            type: "error",
          });
        }
      }
      this.$loading.hide();
    },
    getProblemList: async function() {
      let response = await getContest({
        contest_id: this.contest_id,
      });
      if (response.status == 0) {
        this.problems = response.data.problems;
        this.question.problem_id = response.data.problems[0];
      } else {
        this.$message({
          message: "System error: " + response.message,
          type: "error",
        });
      }
    },
    doQuestion: async function() {
      this.$loading.open();
      if (this.question.content.length < 15 || this.question.title.length < 5) {
        this.$loading.hide();
        this.$message({
          message: "填入信息不完整",
          type: "warning",
        });
        return;
      }
      let response = await addDiscuss({
        contest_id: this.contest_id,
        problem_id: this.question.problem_id,
        content: this.question.content,
        title: this.question.title,
      });
      if (response.status == 0) {
        this.question = {
          title: "",
          content: "",
          problem_id: this.problems[0],
        };
        this.$message({
          message: "发布讨论板成功",
          type: "success",
        });
      } else {
        this.$message({
          message: "发布讨论板失败，请联系管理员: " + response.message,
          type: "error",
        });
      }
      this.$loading.hide();
    },
  },
  computed: {
    contest_id: function() {
      return this.$route.params.id;
    },
  },
  filters: {
    titleFilter: function(val) {
      let len = val.length;
      if (len < 30) {
        return val;
      }
      return val.slice(0, 27) + "...";
    },
    contentFilter: function(val) {
      let len = val.length;
      if (len < 150) {
        return val;
      }
      return val.slice(0, 147) + "...";
    },
  },
};
</script>

<style lang="scss" scoped>
.discuss-list {
  position: relative;
  width: 100%;
  height: 100%;
  overflow-x: hidden;
  overflow-y: scroll;
  padding-left: 25px;
}

.back-btn {
  cursor: pointer;
  &:hover {
    text-decoration: underline;
  }
}

.question-bar {
  margin-top: 88px;
  margin-bottom: 30px;
  > * {
    display: flex;
    flex-direction: column;
    margin: 0 auto;
    width: 90%;
    min-width: 875px;
    max-width: 990px;
  }
  > div {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    height: 300px;
    background: white;
    border-radius: 0.5em;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    > input,
    > textarea {
      width: 100%;
      background: none;
      border: none;
      padding-left: 10px;
    }
    > input {
      height: 50px;
      border-bottom: 1px dashed gray;
    }
    > textarea {
      height: calc(100% - 50px);
      resize: none;
      padding: 7px 10px;
    }
    > select {
      position: absolute;
      height: 26px;
      width: 50px;
      margin-left: -110px;
      margin-top: 257px;
      appearance: none;
      background: url("../../assets/icon/arrow-bottom.svg") no-repeat scroll
        right center transparent;
      background-size: 14px 14px;
      margin-right: 1px;
      border: 1px solid gray;
      border-radius: 0.2em;
      padding: 0 15px 0 7px;
    }
    .submit-ques-btn {
      position: absolute;
      background: none;
      margin-left: -20px;
      margin-top: 255px;
      height: 30px;
      border: 1px solid #4288ce;
      border-radius: 10px;
      color: #4288ce;
      width: 80px;
      cursor: pointer;
      &:hover {
        text-decoration: underline;
      }
    }
  }
}

.element-card {
  background: white;
  border-radius: 0.5em;
  width: 90%;
  height: 150px;
  display: flex;
  flex-direction: column;
  margin: 0 auto 30px auto;
  overflow: hidden;
  min-width: 875px;
  max-width: 990px;
  cursor: pointer;
  padding: 16px 50px;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  > div {
    width: 100%;
  }
}

.problem-tag {
  margin-right: 7px;
}

.title {
  font-weight: bold;
  font-size: 17px;
}

.content {
  padding-right: 25px;
  height: 50px;
}

.user-nick {
  text-align: right;
}

.time {
  text-align: right;
}
</style>
