<template>
  <div class="container">
    <h1 class="title">{{ title }}</h1>
    <div class="table">
      <el-table
        :data="discussions"
        style="width: 100%;"
        :header-cell-style="{
          fontSize: 16 + 'px',
          fontWeight: 'bold',
          color: 'rgba(124,127,132,1)',
        }"
        :cell-style="{
          fontSize: 14 + 'px',
          fontWeight: 'bold',
          color: 'rgba(124,127,132,1)',
        }"
        @row-click="toDiscussionInfo"
      >
        <el-table-column label="昵称" prop="nick"></el-table-column>
        <el-table-column label="标题" prop="title"></el-table-column>
        <el-table-column align="right">
          <template slot="header" slot-scope="scope">
            <button class="btn-add-discussion" @click="toAddDiscussion">
              发帖
            </button>
          </template>
        </el-table-column>
      </el-table>
      <pagination
        :total="count"
        :pageSize="20"
        :pageCount="7"
        :fetchData="fetchDiscussion"
      ></pagination>
    </div>
    <!-- <div class="info">
      <div
        class="info-content"
      >Here is the description of the algorithm. Here is the description of the algorithm.Here is the description of thedescrption of the aigorithm.Here is the description of thedescrption of the aigorithm.Here is the description of thedescrption of the aigorithm.Here is the description of the algorithm. Here is the description of the algorithm. Here is the description of th e algorithm. Here is the description of the algorithm. Here is the description of the algorithm. Here is the description of the algorithm.</div>
      <div class="imgs">
        <div class="img-item"></div>
        <div class="img-item"></div>
        <div class="img-item"></div>
        <div class="img-item"></div>
      </div>
      <button class="btn-add-discussion">评论</button>
    </div>
    <div class="discussion-list">
      <div class="discussion-list-item" v-for="item in discussions" :key="item.id">
        <div class="discussion-list-item-header">
          <div class="avatar"></div>
          <span class="name">{{item.id}}</span>
        </div>
        <p class="content">{{item.content}}</p>
      </div>
    </div>-->
  </div>
</template>

<script>
import { getDiscussList } from "../api/getData";
import pagination from "../components/pagination";

export default {
  name: "topicInfo",
  components: { pagination },
  data() {
    return {
      discussions: [
        { id: 12, avatar: "", content: "This is a comment." },
        { id: 14, avatar: "", content: "This is a comment." },
        { id: 15, avatar: "", content: "This is a comment." },
      ],
      count: 0,
    };
  },
  computed: {
    title: function() {
      if (!this.$route.params.title || !this.$route.query.type) return "";
      return `关于${this.$route.query.type === "problem" ? "题目" : "比赛"}: ${
        this.$route.params.title
      } 的讨论`;
    },
  },
  mounted() {
    window.console.log(this.$route);
    this.fetchDiscussion();
  },
  methods: {
    fetchDiscussion: function(index = 0) {
      let params =
        this.$route.query.type === "problem"
          ? {
              problem_id: this.$route.query.id,
              page: index,
            }
          : {
              contest_id: this.$route.query.id,
              page: index,
            };
      getDiscussList(params).then((res) => {
        window.console.log(res);
        this.discussions = res.data.data;
        this.count = res.count;
      });
    },
    toAddDiscussion: function() {
      this.$router.push("/addDiscussion");
    },
    toDiscussionInfo: function(row, column, event) {
      window.console.log(row);
      this.$router.push({
        name: "discussionInfo",
        query: { id: row.id },
        params: row,
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.container {
  padding: 44px 71px;
}
.title {
  font-size: 28px;
  font-weight: bold;
  color: rgba(112, 112, 112, 1);
}
.table {
  width: 100%;
  padding: 10px 20px;
  background: #fff;
  border-radius: 8px;
}
.btn-add-discussion {
  width: 98px;
  height: 35px;
  background: rgba(66, 136, 206, 1);
  border-radius: 5px;
  font-size: 15px;
  font-weight: 400;
  color: rgba(255, 255, 255, 1);
  line-height: 1;
}
// .info {
//   width: 100%;
//   padding: 30px 40px 66px 40px;
//   background: rgba(237, 239, 243, 1);
//   box-shadow: 0px 7px 9px 0px rgba(4, 0, 0, 0.1);
//   border-radius: 15px;
//   font-size: 18px;
//   font-weight: 400;
//   color: rgba(98, 98, 98, 1);
//   margin-bottom: 30px;
// }
// .imgs {
//   display: flex;
//   flex-wrap: wrap;
// }
// .img-item {
//   width: 291px;
//   height: 163px;
//   margin: 10px;
//   flex-shrink: 0;
//   background: #fff;
// }
// .btn-add-discussion {
//   width: 111px;
//   height: 26px;
//   margin-top: 10px;
//   background: rgba(66, 136, 206, 1);
//   border-radius: 12px;
//   font-size: 13px;
//   font-weight: bold;
//   color: rgba(255, 255, 255, 1);
//   float: right;
// }
// .discussion-list {
//   width: 100%;
//   padding: 0 30px;
//   background: rgba(251, 251, 251, 1);
//   border-radius: 8px;
// }
// .discussion-list-item {
//   padding: 0 10px;
//   padding: 30px 0;
//   border-bottom: 1px solid rgba(210, 210, 210, 1);
// }
// .discussion-list-item:last-of-type {
//   border: none;
// }
// .discussion-list-item-header {
//   display: flex;
//   align-items: center;
//   margin-bottom: 19px;
// }
// .avatar {
//   width: 42px;
//   height: 42px;
//   background: rgba(170, 170, 170, 1);
//   border-radius: 50%;
//   margin-right: 11px;
// }
// .name {
//   font-size: 20px;
//   font-weight: bold;
//   color: rgba(125, 125, 125, 1);
// }
// .content {
//   font-size: 18px;
//   font-weight: 400;
//   color: rgba(98, 98, 98, 1);
//   margin: 0;
// }
</style>
