<template>
  <div class="contest-rank">
    <div class="rank-form-top">
      <label
        for="rank-form"
        id="rank-form-label"
        @click="$router.push('/contest/' + $route.params.id)"
        >返回比赛</label
      >
      <span v-if="isLogin">您的排名: {{ myRank || "无" }}</span>
    </div>
    <div style="overflow-x: auto;">
      <table
        id="rank-form"
        class="rank-form"
        rules="rows"
        frame="none"
        cellspacing="0"
      >
        <thead>
          <tr>
            <td>Rank</td>
            <td>Nick</td>
            <td>Solved</td>
            <td>Penalty</td>
            <td
              v-for="index in contest_info.problems.length"
              :key="'problem-head-' + index"
            >
              {{ String.fromCharCode(index + 64) }}
            </td>
          </tr>
        </thead>
        <!--
          <tr
          class="rank-form-element"
          v-for="index in rank_info.length"
          :key="'rank-row-' + index"
        >
        -->
        <tr
          class="rank-form-element"
          v-for="(i, index) in rank_info"
          :key="'rank-row-' + index"
        >
          <td
            :class="[
              rank_info[index].rank === ''
                ? ''
                : rank_info[index].rank <= prizeNum[0]
                ? 'rank-au'
                : rank_info[index].rank <= prizeNum[1]
                ? 'rank-ag'
                : rank_info[index].rank <= prizeNum[2]
                ? 'rank-cu'
                : '',
            ]"
          >
            {{ rank_info[index].rank }}
          </td>
          <td
            :class="[
              rank_info[index].rank === ''
                ? ''
                : rank_info[index].rank <= prizeNum[0]
                ? 'rank-au'
                : rank_info[index].rank <= prizeNum[1]
                ? 'rank-ag'
                : rank_info[index].rank <= prizeNum[2]
                ? 'rank-cu'
                : '',
            ]"
          >
            {{ rank_info[index].nick }}
          </td>
          <td>{{ rank_info[index].acNum }}</td>
          <td>{{ rank_info[index].penalty | penaltyFilter }}</td>
          <!--
            <td
            v-for="problemIndex in contest_info.problems.length"
            :key="'rank-problem-' + problemIndex"
          >
          -->
          <td
            v-for="(problemName, problemIndex) in contest_info.problems"
            :key="'rank-problem-' + problemIndex"
          >
            <!--
            <div class="solved-info-data">
              <div
                v-if="
                  solveInfoMap(index - 1).indexOf(
                    String.fromCharCode(problemIndex + 64)
                  ) !== -1
                "
              >
              -->
            <div class="solved-info-data">
              <div
                v-if="
                  rank_info[index].solveInfo[problemName] != undefined
                "
              >
                <!-- TODO 封榜一血逻辑 -->
                <status-icon
                  :icon-type="isSuccess(index, problemName) ? 'ac' : 'wa'"
                  :first-blood="isFirstBlood(index, problemName)"
                  :frozen="isFrozen(rank_info[index].solveInfo, problemName)"
                  :times="
                    isSuccess(index, problemName)
                      ? rank_info[index].solveInfo[
                            problemName
                        ].times
                      : rank_info[index].solveInfo[
                            problemName
                        ].times
                  "
                />
                <!--
                <span :class="{'tle-color': isFirstBlood(index, problemName)}">
                  {{
                    rank_info[index].solveInfo[
                        problemName
                    ].success_time | penaltyFilter
                  }}
                  {{
                    rank_info[index].solveInfo[
                        problemName
                      
                    ].times && rank_info[index].solveInfo[
                        problemName
                    ].success_time != 0 ? `(-${rank_info[index].solveInfo[
                        problemName
                    ].times})` : ''
                  }}
                </span>-->
              </div>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import { getContestRank } from "../api/rank";
import { getContest } from "../api/contest";
import statusIcon from "../components/status-icon";

export default {
  name: "contest-rank",
  components: { statusIcon },
  data() {
    return {
      contest_info: {
        title: "",
        problems: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        prize: [2, 3, 4],
      },
      rank_info: [
        // {
        //     id: 0,
        //     rank: 1,
        //     nick: 'ljwsb',
        //     acNum: 1,
        //     penalty: 1000,
        //     solveInfo: [
        //         {
        //             problem_id: 0,
        //             success_time: 100,
        //             times: 1
        //         },
        //         {
        //             problem_id: 1,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             problem_id: 2,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             problem_id: 3,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             problem_id: 4,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             problem_id: 5,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             problem_id: 6,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             problem_id: 7,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             problem_id: 8,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             problem_id: 9,
        //             successTime: 100,
        //             times: 1
        //         }
        //     ]
        // },
        // {
        //     id: 0,
        //     rank: 2,
        //     nick: 'ljwsb',
        //     acNum: 1,
        //     penalty: 1000,
        //     solveInfo: [
        //         {
        //             problem_id: 0,
        //             success_time: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         }
        //     ]
        // },
        // {
        //     id: 0,
        //     rank: 3,
        //     nick: 'ljwsb',
        //     acNum: 1,
        //     penalty: 1000,
        //     solveInfo: [
        //         {
        //             problem_id: 0,
        //             success_time: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         }
        //     ]
        // },
        // {
        //     id: 0,
        //     rank: 4,
        //     nick: 'ljwsb',
        //     acNum: 1,
        //     penalty: 1000,
        //     solveInfo: [
        //         {
        //             problem_id: 0,
        //             success_time: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         }
        //     ]
        // },
        // {
        //     id: 0,
        //     rank: 5,
        //     nick: 'ljwsb',
        //     acNum: 1,
        //     penalty: 1000,
        //     solveInfo: [
        //         {
        //             problem_id: 0,
        //             success_time: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         }
        //     ]
        // },
        // {
        //     id: 0,
        //     rank: 6,
        //     nick: 'ljwsb',
        //     acNum: 1,
        //     penalty: 1000,
        //     solveInfo: [
        //         {
        //             problem_id: 0,
        //             success_time: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         }
        //     ]
        // },
        // {
        //     id: 0,
        //     rank: 7,
        //     nick: 'ljwsb',
        //     acNum: 1,
        //     penalty: 1000,
        //     solveInfo: [
        //         {
        //             problem_id: 0,
        //             success_time: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         }
        //     ]
        // },
        // {
        //     id: 0,
        //     rank: 8,
        //     nick: 'ljwsb',
        //     acNum: 1,
        //     penalty: 1000,
        //     solveInfo: [
        //         {
        //             problem_id: 0,
        //             success_time: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         }
        //     ]
        // },
        // {
        //     id: 0,
        //     rank: 9,
        //     nick: 'ljwsb',
        //     acNum: 1,
        //     penalty: 1000,
        //     solveInfo: [
        //         {
        //             problem_id: 0,
        //             success_time: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         }
        //     ]
        // },
        // {
        //     id: 0,
        //     rank: 10,
        //     nick: 'ljwsb',
        //     acNum: 1,
        //     penalty: 1000,
        //     solveInfo: [
        //         {
        //             problem_id: 0,
        //             success_time: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         },
        //         {
        //             id: 0,
        //             successTime: 100,
        //             times: 1
        //         }
        //     ]
        // },
      ],
      total: 0,
      interval: null,
      firstBlood: {}
    };
  },
  async created() {
    await this.getContestInfo();
    this.renderRankList();
    // this.intervalGetRank();
  },
  filters: {
    penaltyFilter: function(val) {
      if (!val) {
        return "";
      }
      let res = parseInt(val);
      let hours = parseInt(res / 60 / 60);
      let mins = parseInt((res - hours * 60 * 60) / 60);
      let seconds = parseInt(res - hours * 60 * 60 - mins * 60);
      return hours + ":" + mins + ":" + seconds;
    },
  },
  methods: {
    getContestInfo: async function () {
      let response = await getContest(this.$route.params.id);
      if (response.status == 0) {
        this.contest_info = {
          title: response.data.contest_name,
          problems: response.data.problems.substr(1,response.data.problems.length-2).split(","),
          prize: [0, 0, 0],
        };
        // 后端返回的prize字段居然是字符串，我吐了
        try {
          this.contest_info.prize = JSON.parse(response.data.prize);
        } catch (e) {
          this.contest_info.prize = [0, 0, 0];
        } 
      } else {
        this.$message({
          message: response.message,
          type: "error",
        });
      }
    },
    renderRankList: async function () {
      let resRank = [];
      let response = await getContestRank(this.$route.params.id);
      if (response.status == 0) {
        let cnt = 1;
        response.data.forEach((val) => {
          // 保存榜单数据
          resRank.push({
            id: val.user_id,
            rank: val.nick.indexOf("*") === 0 ? "" : cnt, // 打星
            nick: val.nick,
            acNum: val.ac_num,
            penalty: val.penalty,
            solveInfo: val.problem_id,
          });
          // 跑一血数据
          for(let index in val.problem_id){
            if((!this.firstBlood[index]) || (this.firstBlood[index].time === "")){
              this.firstBlood[index] = {
                user_id: val.user_id,
                time: val.problem_id[index].success_time
              }
            } else{
              if(this.firstBlood[index].time > val.problem_id[index].success_time && val.problem_id[index].success_time !== "")[
                this.firstBlood[index] = {
                  user_id: val.user_id,
                  time: val.problem_id[index].success_time
                }
              ]
            }
          }
        /*val.problem_id.forEach((item) => {
            if ((!this.firstBlood[item.problem_id]) || (this.firstBlood[item.problem_id].time === "")) {
              this.firstBlood[item.problem_id] = {
                user_id: val.user_id,
                time: item.success_time
              }
            } else {
              if (this.firstBlood[item.problem_id].time > item.success_time && item.success_time !== "") {
                this.firstBlood[item.problem_id] = {
                  user_id: val.user_id,
                  time: item.success_time
                }
              }
            }
          }
          
          );*/

          // 打星逻辑
          if (val.nick.indexOf("*") !== 0) {
            cnt++;
          }
        });
        this.total = cnt - 1;
        this.rank_info = resRank;
      } else {
        this.$message({
          message: response.message,
          type: "error",
        });
      }
    },
    intervalGetRank: function () {
      // 5秒轮询
      this.interval = setInterval(this.renderRankList, 5000);
    },
    solveInfoMap: function (index) {
      let ret = [];
      for(let tmpIndex in this.rank_info[index].solveInfo){
        ret.push(tmpIndex);
      }
      return ret;
      //return this.rank_info[index].solveInfo.map((x) => x.problem_id); 
    },
    isSuccess: function (index, problemIndex) {
      if (
        /*
        this.rank_info[index].solveInfo[
          this.solveInfoMap(index).indexOf(
            String.fromCharCode(problemIndex + 64)
          )
        ].success_time != ""
        */
       this.rank_info[index].solveInfo[problemIndex].success_time != 0
      )
        return true;
      else return false;
    },
    isFirstBlood: function (uidx, pidx) {
      //const problemId = String.fromCharCode(pidx + String("A").charCodeAt(0) - 1);
      const problemId = pidx;
      if(this.rank_info[uidx] != undefined && this.firstBlood[problemId] != undefined)
      if (this.rank_info[uidx].id === this.firstBlood[problemId].user_id) {
        return true;
      }
      return false;
    },
    isFrozen: function (solveInfo, pidx) {
      return false;
      // 现在如果封榜了 后端直接不给数据 所以先注释了 恒false
      // solveInfo.filter((x) => {
      //   solveInfo[pidx].
      // });
    },
    getPenalty: function (solveInfo) {
      if (solveInfo.success_time === "") return solveInfo.success_time;
      return solveInfo.success_time + solveInfo.times * 20 * 60;
    }
  },
  computed: {
    contest_id: function() {
      return this.$route.params.id;
    },
    /**
     * 返回金银铜排名
     * @returns {Array}[3] = [Au last rank, Ag last rank, Cu last rank]
     */
    prizeNum: function() {
      let total = this.total;
      let data = this.contest_info.prize;
      let res = [];
      for (let i = 0; i < 3; i++) {
        let num = 0;
        if (String(data[i]).indexOf(".") !== -1) {
          // 小数
          num = total * parseFloat(data[i]);
          if (parseInt(num) === 0) {
            num = 1;
          }
        } else if (String(data[i]).indexOf("%") !== -1) {
          // 百分数
          num = (total * parseFloat(String(data[i]).replace("%", ""))) / 100;
          if (parseInt(num) === 0) {
            num = 1;
          }
        } else {
          // 整数
          num = parseInt(data[i]);
        }

        res[i] = parseInt(num);
        if (i !== 0) {
          res[i] += res[i - 1];
        }
      }
      return res;
    },
    isLogin: function() {
      let flag = localStorage.getItem("Flag");
      /*let isLogin = this.$store.state.login.isLogin;*/
      if (flag !== "isLogin") return false;
      return true;
    },
    myRank: function() {
      const id = localStorage.getItem("userId");
      /*const id = this.$store.state.login.userId;*/
      if (id === null || id === "") return "";
      const index = this.rank_info.map((x) => x.id).indexOf(+id);
      if (index === -1) return "";
      return this.rank_info[index].rank;
    },
    path: function() {
      return this.$route.fullPath;
    },
  },
  watch: {
    path: function() {
      clearInterval(this.interval);
      this.interval = null;
    },
  },
  activated() {
    this.intervalGetRank();
  },
  deactived() {
    clearInterval(this.interval);
    this.interval = null;
  },
  beforeDestroy() {
    clearInterval(this.interval);
    this.interval = null;
  },
};
</script>

<style lang="scss" scoped>
// sass变量
$auColor: rgb(242, 192, 86);
$agColor: rgb(133, 133, 116);
$cuColor: rgb(186, 110, 64);

.contest-rank {
  position: relative;
  padding-left: 24px;
}

.rank-form-top {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  width: 85%;
  padding-left: 5px;
  margin: 88px auto 5px auto;
}

#rank-form-label {
  display: block;
  cursor: pointer;
  &:hover {
    text-decoration: underline;
  }
}

.rank-form {
  width: 85%;
  margin: 0 auto 80px auto;
  border-radius: 1em;
  background: rgba(250, 250, 250, 0.7);
  backdrop-filter: blur(22px);
  text-align: center;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  > thead {
    font-weight: bold;
    font-style: italic;
    > tr > td {
      padding: 10px;
    }
  }
  > tr {
    > td {
      padding: 3px;
    }
    &:hover {
      background: rgba(200, 200, 200, 0.7);
    }
  }
}

.rank-form-element {
  height: 45px;
}

.rank {
  &-au {
    color: $auColor;
  }
  &-ag {
    color: $agColor;
  }
  &-cu {
    color: $cuColor;
  }
}

.solved-info-data {
  > div {
    display: flex;
    flex-direction: column;
    align-items: center;
    > span {
      // 通过时间
      font-size: 9px;
      line-height: 17px;
      margin-top: 3px;
    }
  }
}

@media screen and (max-width: 650px) {
  .contest-rank {
    width: 100%;
    padding: 0 10px;

    & > * {
      width: 100%;
    }

    & > .rank-form {
      width: auto;
    }
  }
}
</style>
