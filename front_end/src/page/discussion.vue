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
        <button class="btn-add-discussion" @click="toPublish">发帖</button>
      </div>
      <div class="problem-discussion" v-if="btnTypes[0].isActive == true">
        <div class="discussion-item" v-for="item in problemDis.list" :key="item.title" @click="toProblemDis(item.id)">
          <h4 class="discussion-item-title">{{item.title}}</h4>
          <p class="discussion-item-content">{{item.background}}</p>
        </div>
        <pagination :total="problemDis.count" :pageSize="PAGESIZE" :pageCount="PAGECOUNT" :fetchData="handleFetchProblemDis"></pagination>
      </div>
      <div class="contest-discussion" v-if="btnTypes[1].isActive == true">
        <div class="discussion-item" v-for="item in contestDis.list" :key="item.title" @click="toContestDis(item.id)">
          <h4 class="discussion-item-title">{{item.contest_name}}</h4>
        </div>
        <pagination :total="contestDis.count" :pageSize="PAGESIZE" :pageCount="PAGECOUNT" :fetchData="handleFetchContestDis"></pagination>
      </div>
    </div>
  </div>
</template>

<script>
import pagination from "../components/pagination";
import { getAllTopic, getUserGroups } from "../api/getData";
import { PAGESIZE, PAGECOUNT } from "../config/index";

export default {
  name: "discussion",
  components: { pagination },
  data() {
    return {
      PAGESIZE,
      PAGECOUNT,
      btnTypes: [
        { label: "题目讨论区", isActive: true },
        { label: "比赛讨论区", isActive: false }
      ],
      problemDis: {
        list: [],
        count: 0,
        page: 0
      },
      contestDis: {
        list: [],
        count: 0,
        page: 0
      }
    };
  },
  mounted() {
    this.fetchProblemsDis(this.problemDis.page);
  },
  methods: {
    toggleType: function(index) {
      for (let i = 0; i < this.btnTypes.length; i++) {
        if (i === index) {
          this.btnTypes[i].isActive = true;
        } else {
          this.btnTypes[i].isActive = false;
        }
      }
      if (index == 0) {
        this.fetchProblemsDis(this.problemDis.page);
      } else {
        this.fetchContestsDis(this.contestDis.page);
      }
    },
    fetchProblemsDis: function(page) {
      let ret = getAllTopic({ page: page });
      ret
        .then(res => {
          if (res.status == 0) {
            const tempProblemDis = {
              list: res.data.data,
              count: res.data.count,
              page: page
            }
            this.problemDis = tempProblemDis;
          } else {
            this.$message({
              message: res.message,
              type: 'error'
            })
          }
        })
        .catch(err => console.log(err));
    },
    fetchContestsDis: function(page) {
      let ret = getAllTopic({ contest: 1, page: page });
      ret
        .then(res => {
          if (res.status == 0) {
            const tempContestDis = {
              list: res.data.data,
              count: res.data.count,
              page: page
            }
            this.contestDis = tempContestDis;
          } else {
            this.$message({
              message: res.message,
              type: 'error'
            })
          }
        })
        .catch(err => console.log(err));
    },
    handleFetchProblemDis: function(index) {
      this.fetchProblemsDis(index - 1);
    },
    handleFetchContestDis: function(index) {
      this.fetchContestsDis(index - 1);
    },
    toPublish: function() {
      for (let i = 0; i < this.btnTypes.length; i++) {
        if (this.btnTypes[i].isActive) {
          this.$router.push({name: "addDiscussion", params: {type: i}});
        }
      }
    },
    toProblemDis: function(id) {
      this.$router.push(`/discussionInfo?id=${id}`);
    },
    toContestDis: function(id) {
      this.$router.push(`/discussionInfo?id=${id}`);
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