<template>
  <div class="contestlist">
    <div v-if="items.playing.length + items.done.length + items.coming.length === 0 && !loading">
      暂无比赛
    </div>
    <template v-for="k in itemsKeys">
      <template v-if="items[k].length !== 0">
        <div class="separator" :key="`contest-card-separator-${k}`">
          <i>
            {{
              k === "playing" ? "正在进行" :
              k === "coming" ? "即将到来" :
              "已经结束"
            }}
          </i>
        </div>
        <template v-for="(item, index) in items[k]">
          <div
            class="contest-card"
            :key="`contest-card-${k}-${index}`"
          >
            <div class="contest-content" @click="goto(item.contest_id)">
              <div class="content-words">
                <span class="contest-title">{{ item.title }}</span>
                <span class="contest-sub-title">{{ item.begin_time + " — " + item.end_time }}</span>
              </div>
            </div>
            <div class="function-btn-group">
              <!--disabled-->
              <button
                class="join"
                :class="[
                  item.status === 1 &&
                  new Date(item.end_time).getTime() > Date.now()
                    ? 'can-join'
                    : 'cant-join',
                ]"
                @click="doJoinContest(item)"
                v-show="!item.hasJoin"
              >
                {{
                  item.status === 1 &&
                  new Date(item.end_time).getTime() > Date.now()
                    ? "点我报名"
                    : "不可报名"
                }}
              </button>
              <button
                class="join"
                :class="[
                  item.status === 1 &&
                  new Date(item.end_time).getTime() > Date.now()
                    ? 'has-join'
                    : 'cant-join',
                ]"
                v-show="item.hasJoin"
              >
                已经报名
              </button>
            </div>
          </div>
        </template>
      </template>
    </template>
  </div>
</template>

<script>
import { getContestList, getUserContest, joinContest } from "../api/contest";
import { checkUserContest } from "../api/getData";
export default {
  name: "contestlist",
  data() {
    return {
      loading: true,
      items: {
        playing: [],
        coming: [],
        done: []
      },
      // items: [
        // {
        //     id: '1000',
        //     title: '2019年武汉理工大学第二届新生赛',
        //     begin_time: '2019.11.16',
        //     end_time: '2019.11.16',
        //     hasJoin: false,
        //     status: 1
        // },
      // ],
    };
  },
  methods: {
    renderList: async function () {
      this.$loading.open();
      let response = await getContestList();
      if (response.status === 0) {
        const data = response.data;
        if (data) {
          const retObj = this.classifyList(data.map((item) => {
            if(item.begin_time[19] == 'Z') item.begin_time = item.begin_time.substr(0,19);
            item.begin_time = item.begin_time.replace("T", " ");
            if(item.end_time[19] == 'Z') item.end_time = item.end_time.substr(0,19);
            item.end_time = item.end_time.replace("T", " ");
            return {
              contest_id: item.contest_id.toString(),
              title: item.contest_name,
              begin_time: item.begin_time.replace(/-/g, '/'),
              end_time: item.end_time.replace(/-/g, '/'),
              frozen: item.frozen,
              problem_str:item.problems,
              hasJoin: false,
              status: 0+item.status
            };
          }));
          this.items = retObj;
          /*this.$store.dispatch("contest/contestListNoLogin", retObj);*/
          localStorage.setItem('contest-list-nologin', JSON.stringify(this.items));
        } else {
          this.$message({
            content: "未知错误，请联系管理员",
            type: "error",
          });
        }
      } else {
        if (response.status === 504) {
          this.$message({
            content: "请求超时",
            type: "error",
          });
        }
      }
      this.$loading.hide();
      this.loading = false;
    },
    getUserContestList: async function () {
      let response = await getUserContest();
      if (response.status == 0) {
        response.data.forEach((val) => {
          this.itemsKeys.forEach((key) => {
            let itemsIndex = this.items[key]
              .map((x) => {
                /*console.log("!");
                console.log(x.contest_id);*/
                return parseInt(x.contest_id);
                })
              .indexOf(parseInt(val.contest_id));
              /*console.log(key);
              console.log(val.contest_id);
              console.log(itemsIndex);*/
            if (itemsIndex !== -1) this.items[key][itemsIndex].hasJoin = true;
          });
        });
        /*this.$store.dispatch("contest/contestList", retObj);*/
        localStorage.setItem('contest-list', JSON.stringify(this.items));
      }
    },
    doJoinContest: async function (info) {
      if (
        !(info.status === 1 &&
        new Date(info.end_time).getTime() > Date.now())
      ) {
        return;
      }
      this.$loading.open();
      /*user_id: this.$store.state.login.userId,*/
      let response = await joinContest({
        contest_id: info.contest_id,
        user_id: localStorage.getItem("userId"),
        status:0
      });
      if (response.status == 0) {
        info.hasJoin = true;
        this.$message({
          message: "参加比赛成功, 请记得按时参赛",
          type: "success",
        });
      } else {
        if (response.message == "未登录") {
          this.$emit('logout');
        }
        this.$message({
          message: "参加比赛失败: " + response.message,
          type: "error",
        });
      }
      this.$loading.hide();
    },
    goto: async function (link) {
      if (link == "") return;
      /*let data=new Object();
      console.log(link);
      for(let item in this.items.playing){
            console.log(this.items.playing[item]);
            console.log(this.items.playing[item].contest_id);
            console.log(typeof(link));

            if(this.items.playing[item].contest_id != undefined)
            if(this.items.playing[item].contest_id.toString() == link){
              data = this.items.playing[item];
            }
      }
      console.log(data);
      let problem_str = data.problem_str.toString();
      problem_str = problem_str.slice(1,problem_str.lenth-1);
      let problems = problem_str.split(",");
      data.problems = problems;
      */
     let response = await checkUserContest(link);
      if(response.status == 0){
        this.$router.push("/contest/" + link);
      }
      else {
        this.$message({
            content: "请点击参加比赛按钮",
            type: "error"
        });
      }
    },
    // 拆分数据
    classifyList: function (arr) {
      const now = (Date.now() || (new Date().getTime()));
      const retObj = { playing: [], coming: [], done: [] };
      arr.forEach((item) => {
        if (
          new Date(item.begin_time).getTime() <= now &&
          new Date(item.end_time).getTime() > now
        ) {
          retObj.playing.push(item);
        } else if ( new Date(item.begin_time).getTime() > now) {
          retObj.coming.push(item);
        } else {
          retObj.done.push(item);
        }
      });
      return retObj;
    },
    getContestListCache() {
      let str = "";
      if (localStorage.getItem("Flag") === "isLogin") {
        str = localStorage.getItem('contest-list');
      } else {
        str = localStorage.getItem('contest-list-nologin');
      }
      /*if(this.$store.state.login.isLogin == true) {
        str = this.$store.state.contest.contestList;
      } else {
        str = this.$store.state.contest.contestListNoLogin; 
      }*/
      try {
        const data = JSON.parse(str);
        if (data) {
          this.items = data;
          this.loading = false;
        }
      } catch (e) {
        /*this.$store.state.state.contestList = null;*/
        localStorage.removeItem('contest-list');
      }
    }
  },
  async created() {
    this.getContestListCache();
    await this.renderList();
    await this.getUserContestList();
  },
  filters: {
    timeFilter: function(val) {
      return val.slice(0, val.indexOf(" "));
    },
  },
  computed: {
    itemsKeys() {
      return Object.keys(this.items);
    }
  }
};
</script>

<style lang="scss" scoped>
.contestlist {
  position: relative;
  width: 100%;
  height: 100%;
  overflow-x: hidden;
  overflow-y: scroll;
  padding: 88px 0 80px 25px;
}

.separator {
  display: flex;
  justify-content: center;
  /*align-items: center;*/
  height: 30px;
  width: 90%;
  min-width: 555px;
  max-width: 990px;
  margin: 0 auto 10px auto;
  > i {
    margin: 0 9%;
    /*width: calc(100% - 100px);*/
    font: {
      size: 17px;
      weight: bold;
    }
  }
  &::before {
    content: "<----------------------------- ";
    font: {
      size: 17px;
      style: italic;
    }
  }
  &::after {
    content: " ----------------------------->";
    font: {
      size: 17px;
      style: italic;
    }
  }
}

.contest-card {
  background: url("../../assets/media/contest.jpeg");
  border-radius: 0.5em;
  width: 90%;
  height: 180px;
  display: flex;
  align-items: center;
  margin: 0 auto 10px auto;
  overflow: hidden;
  min-width: 555px;
  max-width: 990px;
  cursor: pointer;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
}

.contest-content {
  display: flex;
  flex-direction: column;
  position: relative;
  background: linear-gradient(
    -225deg,
    rgba(28, 28, 28, 0.6) 0%,
    rgba(48, 48, 48, 0.3) 100%
  );
  width: 100%;
  height: 100%;
}

.contest-title {
  position: relative;
  color: white;
  font-weight: bold;
  font-size: 25px;
  top: 30px;
  left: 30px;
}

.contest-sub-title {
  font-size: 18px;
  color: white;
  position: relative;
  top: 25px;
  left: 30px;
}

.content-words {
  display: flex;
  flex-direction: column;
}

.function-btn-group {
  position: relative;
  margin-top: 50px;
}

.join {
  /*left: 70%;*/
  /*position: relative;*/
  /*top: 95px;*/
  /*left: 58px;*/
  position: absolute;
  height: 40px;
  width: 120px;
  border: 2px solid rgba(250, 250, 250, 1);
  box-shadow: 0 3px 15px rgba(38, 38, 38, 0);
  background: rgba(38, 38, 38, 0.3);
  border-radius: 5px;
  font-weight: bold;
  color: white;
  cursor: pointer;
  right: 25px;
  left: auto;
}

.can-join:hover {
  text-decoration: underline;
}

.cant-join {
  text-decoration: none;
  border: 2px solid rgba(188, 188, 188, 1);
  color: rgba(188, 188, 188, 1);
  cursor: unset;
}

.has-join {
  border: 2px solid rgba(45, 183, 183, 1);
  color: rgba(45, 183, 183, 1);
  cursor: unset;
}

@media screen and (max-width: 650px) {
  .contestlist {
    padding-left: 10px;
    padding-right: 10px;

    & > * {
      font-family: PingFang SC;
      width: 100%;
      max-width: inherit;
      min-width: unset;
    }
  }

  .contest-card {
    width: 100%;
    height: 140px;
    border-radius: 15px;
    max-width: inherit;
    min-width: unset;

    .contest-content {
      width: 100%;
      height: 100%;

      .content-words {
        position: relative;
        top: unset;
        left: unset;
        padding: 10px 20px;

        & > * {
          top: unset;
          left: unset;
        }
        
        .contest-title {
          font-size: 18px;
          white-space: pre-wrap;
        }

        .contest-sub-title {
          font-size: 14px;
          top: 3px;
        }
      }
    }

    .function-btn-group > button {
      border-radius: 13px;
      border-width: 1.5px;
      width: 100px;
      height: 35px;
      font-weight: 400;
    }
  }

  .separator {
    justify-content: flex-start;
    width: 100%;
    &:after, &:before {
      content: '';
    }
    & > i {
      margin: 0 0 0 3px;
      font-size: 16px;
      font-style: normal;
    }
  }
}
</style>
