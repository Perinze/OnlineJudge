<template>
  <div class="problemlist">
    <div
      class="problem-element"
      v-for="(item, index) in items"
      :key="'problem-' + index"
    >
      <div class="problem-info">
        <i class="icon" v-bind:class="items[index].status + '-icon'"></i>
        <span class="problem-id" @click="goto(items[index].id)">{{
          items[index].id
        }}</span>
        <span class="problem-title" @click="goto(items[index].id)">{{
          items[index].title
        }}</span>
      </div>
      <span class="problem-statistics">{{
        items[index].statistics.ac + "/" + items[index].statistics.all
      }}</span>
    </div>
    <div class="problem-pager" v-if="items.length > 0">
      <el-pagination
        background
        layout="prev, pager, next"
        :page-size="20"
        :total="counts"
        :current-page="currentPage"
        @current-change="changePage"
      />
    </div>
  </div>
</template>

<script>
import { getProblemList } from "../api/problem";

export default {
  name: "problemlist",
  data() {
    return {
      items: [],
      counts: 0,
      currentPage: 1
    };
  },
  async beforeMount() {
    await this.renderProblemList(1);
  },
  methods: {
    goto: function(pid) {
      // let res = '/problem?p='+pid;
      if (window.isWap) {
        this.$router.push(`/problem?pid=${pid}`);
      } else {
        this.$emit("open-problem", {
          pid: pid,
        });
      }
    },
    renderProblemList: async function(page = 0) {
      try {
        this.$loading.open();

        let LSdata = this.getProblemListCache(page); // 先获取存在LS里面的数据
        let response = await getProblemList({ page: page }); // 请求线上数据
        if (response.status == 0) {
          // success
          this.counts = response.data.count;
          let data = response.data.data;
          this.items = [];
          data.forEach((val) => {
            let Ac = 0, UnAc = 0;
            if(val.problem_submit_log.problem_id != undefined){
              Ac = parseInt(val.problem_submit_log.ac);
              UnAc =  parseInt(val.problem_submit_log.wa) +
                      parseInt(val.problem_submit_log.tle) +
                      parseInt(val.problem_submit_log.mle) +
                      parseInt(val.problem_submit_log.re) +
                      parseInt(val.problem_submit_log.se) +
                      parseInt(val.problem_submit_log.ce);
            }
            let res = {
              id: val.problem.problem_id,
              title: val.problem.title,
              status: "不知道",
              statistics: {
                ac: Ac,
                all: UnAc
              }
              //status: !(val.accepted + val.unaccepted) ?  "un" : val.accepted ? "ac" : "wa",
              /*statistics: {
                ac: parseInt(val.ac),
                all:
                  parseInt(val.ac) +
                  parseInt(val.wa) +
                  parseInt(val.tle) +
                  parseInt(val.mle) +
                  parseInt(val.re) +
                  parseInt(val.ce) +
                  parseInt(val.se),
              }*/

            };
            this.items.push(res);
          });
          if (LSdata === null) {
            LSdata = {};
          }
          LSdata[page] = {
            counts: this.counts,
            items: this.items
          };
          localStorage.setItem(`problem-list`, JSON.stringify(LSdata));
          /*this.$store.state.problem.storedData = JSON.stringify(LSdata);*/
        } else {
          // error
          if (response.status === 504) {
            this.$message({
              message: "请求超时",
              type: "error",
            });
          }
        }
      } catch (e) {
        this.$message({
          message: "系统错误，请联系管理员",
          type: "error",
        });
      } finally {
        this.$loading.hide();
      }
    },
    changePage(page) {
      document.getElementsByClassName('combox')[0].scrollTop = 0;
      this.renderProblemList(page);
      this.currentPage = page;
    },
    getProblemListCache(page) {
      const pageNumLimit = 3; // 最多存3页
      const str = localStorage.getItem(`problem-list`);
      /*const str = this.$store.state.problem.storedData;*/
      try {
        const data = JSON.parse(str);
        if (data[`${page}`] === undefined) {
          this.items = [];
          return data;
        }
        this.counts = data[`${page}`].counts;
        this.items = data[`${page}`].items;

        const keys = Object.keys(data);
        const keyLen = Object.keys(data).length;
        if (keyLen > pageNumLimit) {
          for (let i=pageNumLimit+1; i<keyLen; i++) {
            delete data[keys[i]];
          }
        }
        return data;
      } catch (e) {
        localStorage.removeItem(`problem-list`);
        /*this.$store.state.problem.storedData = null;*/
      }
      return null;
    }
  },
};
</script>

<style lang="scss" scoped>
.problemlist {
  position: relative;
}

.problem-element {
  position: relative;
  background: white;
  height: 45px;
  border-radius: 0.5em;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  &:first-child {
    margin-top: 88px;
  }
  &:last-child {
    margin-bottom: 80px;
  }
  > div {
    display: flex;
    align-items: center;
  }
}

.problem-element, .problem-pager {
  width: 75%;
  margin: 0 auto 10px auto;
  min-width: 500px;
  max-width: 990px;
  padding: 0 5px;
}

.problem-pager {
  display: flex;
  justify-content: center;
  margin-top: 8px;
}

.icon {
  content: " ";
  width: 27px;
  text-align: center;
  cursor: pointer;
  font: {
    style: normal;
    size: 18px;
    weight: bold;
  }
}

.problem-id {
  font: {
    weight: bold;
    style: italic;
  }
  margin-left: 7px;
}

.problem-title {
  font-weight: bold;
  /*left: 5px;*/
  /*width: 58%;*/
  margin-left: 10px;
  cursor: pointer;
}

.problem-statistics {
  text-align: center;
  width: 120px;
}

@media screen and (max-width: 650px) {
  .problem-element, .problem-pager {
    margin: inherit auto;
    width: calc(100% - 20px);
    min-width: unset;
  }
}
</style>
