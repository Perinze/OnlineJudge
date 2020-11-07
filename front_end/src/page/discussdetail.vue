<template>
  <div class="discuss-detail">
    <div
      @click="$router.push('/contest/' + themeInfo.contest_id)"
      class="back-btn"
    >
      回到比赛
    </div>
    <ul class="discuss-content">
      <li class="content-head">
        <div class="head-title">{{ problemNick }} {{ themeInfo.title }}</div>
        <div class="head-content">{{ themeInfo.content }}</div>
        <div class="head-user">{{ themeInfo.nick }}</div>
        <div class="head-time">{{ themeInfo.time }}</div>
      </li>
      <li
        class="content-element"
        v-for="index in replyItems.length"
        :key="'reply-' + index"
      >
        <div class="element-content">{{ replyItems[index - 1].content }}</div>
        <div class="element-user">{{ replyItems[index - 1].nick }}</div>
        <div class="element-time">{{ replyItems[index - 1].time }}</div>
      </li>
    </ul>
    <div class="reply-input-group">
      <textarea
        placeholder="在此填入回复内容(至少10个字符)..."
        v-model="replyContent"
      ></textarea>
      <button class="submit-reply-btn" @click="do_addReply">Reply</button>
    </div>
  </div>
</template>

<script>
import { getDiscussDetail, addReply, getContest } from "../api/getData";

export default {
  name: "discussdetail",
  data() {
    return {
      themeInfo: {
        id: "",
        contest_id: "",
        problem_id: "",
        user_id: "",
        nick: "",
        title: "",
        content: "",
        time: "",
        status: "",
      },
      replyItems: [
        // {
        //     id: '',
        //     discuss_id: '',
        //     user_id: '',
        //     nick: '',
        //     content: '',
        //     time: ''
        // },
      ],
      replyContent: "",
      problemNick: "@",
    };
  },
  async created() {
    await this.renderContent();
    await this.getProblemNick();
  },
  methods: {
    getProblemNick: async function() {
      let response = await getContest({
        contest_id: this.$route.params.id,
      });
      if (response.status == 0) {
        this.problemNick = String.fromCharCode(
          response.data.problems
            .indexOf(`${this.themeInfo.problem_id}`) + 65
        );
      }
    },
    renderContent: async function() {
      this.$loading.open();
      let response = await getDiscussDetail({
        discuss_id: this.$route.params.did,
      });
      if (response.status == 0) {
        this.themeInfo = response.data.discuss;
        response.data.reply.data.forEach((val) => {
          this.replyItems.push(val);
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
    do_addReply: async function() {
      this.$loading.open();
      if (this.replyContent.length < 10) {
        this.$message({
          message: "回复内容不应少于10字符",
          type: "warning",
        });
        this.$loading.hide();
        return;
      }
      let response = await addReply({
        id: this.$route.params.did,
        content: this.replyContent,
      });
      if (response.status == 0) {
        this.replyContent = "";
        this.$message({
          message: "添加回复成功",
          type: "success",
        });
      } else {
        this.$message({
          message: "添加回复失败: " + response.message,
          type: "error",
        });
      }
      this.$loading.hide();
    },
  },
};
</script>

<style lang="scss" scoped>
.discuss-detail {
  position: relative;
  width: 100%;
  height: 100%;
  overflow-x: hidden;
  overflow-y: scroll;
  padding-left: 25px;
}

.back-btn {
  cursor: pointer;
  margin: 88px auto 0 auto;
  width: 80%;
  &:hover {
    text-decoration: underline;
  }
}

.discuss-content {
  margin: 0 auto 30px auto;
  width: 80%;
  border-radius: 0.6em;
  overflow: hidden;
  background: white;
  box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.08);
}

ul {
  padding-left: 0;
}

li {
  list-style-type: none;
  height: 170px;
  border-top: 1px dashed gray;
  padding: 18px 20px;
}

.content-head {
  height: 250px;
  border-top: none;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.head {
  &-title {
    /*line-height: 2;*/
    width: 100%;
    font: {
      size: 17px;
      weight: bold;
    }
  }
  &-content {
    width: 100%;
    height: calc(100% - 25px - 19px - 19px);
  }
  &-user,
  &-time {
    font-size: 13px;
  }
}

.content-element {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.element {
  &-content {
    width: 100%;
    height: calc(100% - 19px - 19px);
  }
  &-user,
  &-time {
    font-size: 13px;
  }
}

.reply-input-group {
  background: white;
  width: 80%;
  height: 280px;
  margin: 30px auto 88px auto;
  overflow: hidden;
  border-radius: 0.6em;
  box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.08);
  > textarea {
    resize: none;
    border: none;
    background: none;
    height: 100%;
    width: 100%;
    padding: 7px 10px;
  }
  .submit-reply-btn {
    position: absolute;
    background: none;
    margin-left: -100px;
    margin-top: 235px;
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

@media screen and (max-width: 650px) {
  .discuss-detail {
    padding-left: 10px;
    padding-right: 10px;

    > * {
      width: 100%;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
  }
}
</style>
