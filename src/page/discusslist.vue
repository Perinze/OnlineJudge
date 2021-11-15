<template>
  <div class="discuss-list">
    <div class="question-bar">
      <span @click="$router.push('/contest/' + contest_id)" class="back-btn">
        回到比赛
      </span>
      <div>
        <input
          type="text"
          placeholder="在此键入提问标题(至少5个字符)..."
          v-model="question.title"
        />
        <textarea
          placeholder="在此键入提问内容(至少15个字符)..."
          v-model="question.content"
        />
        <div class="func-btns">
          <select v-model="question.problem_id">
            <option
              v-for="index in problems.length"
              :value="problems[index - 1]"
              :key="problems[index - 1]"
              >{{ String.fromCharCode(64 + index) }}</option
            >
          </select>
          <button class="submit-ques-btn" @click="doQuestion">Submit</button>
        </div>
      </div>
    </div>
    <div class="list">
      <div
        class="element-card"
        v-for="(item, index) in items"
        :key="'themeCard-' + index"
        @click="
          $router.push('/discuss/' + contest_id + '/' + item.id)
        "
      >
        <div class="title">
          <span class="problem-tag">{{
            String.fromCharCode(problems.map(x => +x).indexOf(+item.problem_id) + 65)
          }}</span>
          {{ item.title }}
        </div>
        <div class="content">
          {{ item.content }}
        </div>
        <div class="user-nick">{{ item.nick }}</div>
        <div class="time">{{ item.time }}</div>
      </div>
      <div class="discuss-pager">
        <el-pagination
          v-if="counts > 0"
          background
          layout="prev, pager, next"
          :page-size="20"
          :total="counts"
          :current-page="currentPage"
          @current-change="changePage"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { getDiscussList, addDiscuss } from "../api/discuss";
import { getContest } from "../api/contest";

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
      counts: 0,
      currentPage: 1,
    };
  },
  beforeMount() {
    this.renderList();
    this.getProblemList();
  },
  methods: {
    changePage(page) {
      this.currentPage = page;
      this.renderList(page);
    },
    renderList: async function(page = 1) {
      this.$loading.open();
      let response = await getDiscussList(this.$route.params.id, page);
      // console.log(response);
      if (response.status == 0) {
        this.items = response.data.data;
        this.counts = response.data.count;
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
      let response = await getContest(this.contest_id);
      if (response.status == 0) {
        this.problems = response.data.problems.slice(1,response.data.problems.length-1).split(",");
        this.question.problem_id = this.problems[0];
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
        contest_id: parseInt(this.contest_id),
        problem_id: parseInt(this.question.problem_id),
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
  }
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
    > .func-btns {
      padding: 5px;

      select {
        height: 26px;
        width: 50px;
        appearance: none;
        background: url("../../assets/icon/arrow-bottom.svg") no-repeat scroll
          right center transparent;
        background-size: 14px 14px;
        border: 1px solid gray;
        border-radius: 5px;
        padding: 0 15px 0 7px;
        margin-right: 5px;
      }

      .submit-ques-btn {
        background: none;
        height: 26px;
        border: 1px solid #4288ce;
        border-radius: 5px;
        color: #4288ce;
        width: 80px;
        cursor: pointer;
        &:hover {
          text-decoration: underline;
        }
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
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.content {
  padding-right: 25px;
  height: 50px;
  overflow : hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}

.user-nick {
  text-align: right;
}

.time {
  text-align: right;
}

.discuss-pager {
  display: flex;
  justify-content: center;
  margin-bottom: 60px;
  width: 100%;
}

@media screen and (max-width: 650px) {
  .discuss-list {
    padding-left: 0;
  }

  .question-bar, .list {
    width: 100%;
    padding: 0 20px;
  }

  .question-bar {
    & > div {
      width: 100%;
      min-width: unset;
      max-width: inherit;

      select {
        right: 110px;
      }

      .submit-ques-btn {
        right: 25px;
      }
    }    
  }

  .element-card {
    width: 100%;
    min-width: unset;
    max-width: inherit;
    padding: 15px 20px;
  }
}
</style>
