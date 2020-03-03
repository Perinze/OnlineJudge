<template>
  <div class="container">
    <div class="discussion-block">
      <div class="discussion-block-header">
        <div class="operations">
          <button
            :class="['btn-type', item.isActive ? 'btn-type-active': '']"
            v-for="(item, index) in btnTypes"
            :key="item.label"
            @click="toggleType(index)"
          >{{item.label}}</button>
        </div>
      </div>
      <div
        class="discussion-item"
        v-for="item in discussions"
        @click="toDiscussionInfo(item.problem_id || item.contest_id, item.title || item.contest_name)"
      >
        <h4 class="discussion-item-title">{{ item.title || item.contest_name}}</h4>
        <p
          class="discussion-item-content"
        >{{ item.background || `${item.begin_time} —— ${item.end_time}`}}</p>
      </div>
      <pagination :total="count" :pageSize="20" :pageCount="7" :fetchData="fetchTopic"></pagination>
    </div>
  </div>
</template>

<script>
import pagination from "../components/pagination";
import { getAllTopic, getUserGroups } from "../api/getData";

export default {
  name: "topic",
  components: { pagination },
  data() {
    return {
      btnTypes: [
        { type: "problem", label: "题目讨论区", isActive: true },
        { type: "contest", label: "比赛讨论区", isActive: false }
      ],
      discussions: [
        // {
        //   title:
        //     "comment 1comment 1comment 1comment 1comment 1comment 1comment 1comment 1comment 1comment 1comment 1comment 1comment 1",
        //   content:
        //     "hello world.超出两行显示省略号1. css写法只对webkit内核的浏览器好用, 对safari浏览器有兼容2. css超出两行显示省略号(个人写法)1. css写法只对webkit内核的浏览...超出两行显示省略号1. css写法只对webkit内核的浏览器好用, 对safari浏览器有兼容2. css超出两行显示省略号(个人写法)1. css写法只对webkit内核的浏览...超出两行显示省略号1. css写法只对webkit内核的浏览器好用, 对safari浏览器有兼容2. css超出两行显示省略号(个人写法)1. css写法只对webkit内核的浏览"
        // },
        // { title: "comment 2", content: "This is a comment." }
      ],
      count: 0
    };
  },
  mounted() {
    this.fetchTopic();
  },
  methods: {
    fetchTopic: function(index = 0) {
      let params;
      for (let i = 0; i < this.btnTypes.length; i++) {
        if (this.btnTypes[i].isActive) {
          params =
            this.btnTypes[i].type === "problem"
              ? { page: index }
              : { contest: 1, page: index };
          break;
        }
      }
      getAllTopic(params).then(res => {
        window.console.log(res);
        this.discussions = res.data.data;
        this.count = res.data.count;
      });
    },
    toggleType: function(index) {
      for (let i = 0; i < this.btnTypes.length; i++) {
        if (i === index) {
          this.btnTypes[i].isActive = true;
        } else {
          this.btnTypes[i].isActive = false;
        }
      }
      this.fetchTopic();
    },
    toDiscussionInfo: function(id, title) {
      let type;
      for (let i = 0; i < this.btnTypes.length; i++) {
        if (this.btnTypes[i].isActive) {
          type = this.btnTypes[i].type;
          break;
        }
      }
      this.$router.push({
        name: "topicInfo",
        query: { type, id },
        params: { title }
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.container {
  padding: 120px 97px;
  overflow: hidden;
}
.discussion-block {
  background: rgba(251, 251, 251, 1);
  border-radius: 8px;
  padding: 19px 21px;
}
.discussion-block-header {
  padding: 0 16px 10px;
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid rgba(170, 170, 170, 1);
}
.operations {
  display: flex;
}
.btn-type {
  font-size: 18px;
  font-weight: 400;
  color: rgba(124, 127, 132, 1);
  padding: 0;
  background: rgba(251, 251, 251, 1);
}
.btn-type:first-of-type {
  padding-right: 11px;
  border-right: 1px solid rgba(124, 127, 132, 1);
}
.btn-type:last-of-type {
  padding-left: 11px;
}
.btn-type-active {
  color: rgba(66, 136, 206, 1);
}
.btn-add-discussion {
  width: 101px;
  height: 29px;
  background: rgba(66, 136, 206, 1);
  border-radius: 15px;
  font-size: 15px;
  font-weight: 400;
  color: rgba(255, 255, 255, 1);
}
.discussion-item {
  padding: 13px 16px;
  border-bottom: 1px solid rgba(210, 210, 210, 1);
}
.discussion-item-title {
  font-size: 15px;
  font-weight: bold;
  color: rgba(112, 112, 112, 1);
  margin-bottom: 8px;
  margin-top: 0;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.discussion-item-content {
  font-size: 15px;
  font-weight: 400;
  color: rgba(124, 127, 132, 1);
  margin: 0;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;
  overflow: hidden;
}
</style>