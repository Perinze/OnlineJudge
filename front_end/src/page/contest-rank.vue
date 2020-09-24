<template>
  <div class="contest-rank">
    <div class="rank-form-top">
      <label
        for="rank-form"
        id="rank-form-label"
        @click="$router.push('/contest/' + $route.params.id)"
        >返回比赛</label
      >
      <span v-if="isLogin">您的排名: {{ myRank }}</span>
    </div>
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
      <tr
        class="rank-form-element"
        v-for="index in rank_info.length"
        :key="'rank-row-' + index"
      >
        <td
          :class="[
            rank_info[index - 1].rank === ''
              ? ''
              : rank_info[index - 1].rank <= prizeNum[0]
              ? 'rank-au'
              : rank_info[index - 1].rank <= prizeNum[1]
              ? 'rank-ag'
              : rank_info[index - 1].rank <= prizeNum[2]
              ? 'rank-cu'
              : '',
          ]"
        >
          {{ rank_info[index - 1].rank }}
        </td>
        <td
          :class="[
            rank_info[index - 1].rank === ''
              ? ''
              : rank_info[index - 1].rank <= prizeNum[0]
              ? 'rank-au'
              : rank_info[index - 1].rank <= prizeNum[1]
              ? 'rank-ag'
              : rank_info[index - 1].rank <= prizeNum[2]
              ? 'rank-cu'
              : '',
          ]"
        >
          {{ rank_info[index - 1].nick }}
        </td>
        <td>{{ rank_info[index - 1].acNum }}</td>
        <td>{{ rank_info[index - 1].penalty | penaltyFilter }}</td>
        <td
          v-for="problemIndex in contest_info.problems.length"
          :key="'rank-problem-' + problemIndex"
        >
          <div class="solved-info-data">
            <div
              v-if="
                solveInfoMap(index - 1).indexOf(
                  String.fromCharCode(problemIndex + 64)
                ) !== -1
              "
            >
              <!-- TODO 封榜Try逻辑 -->
              <status-icon
                :icon-type="isSuccess(index - 1, problemIndex) ? 'ac' : 'wa'"
                :times="
                  isSuccess(index - 1, problemIndex)
                    ? rank_info[index - 1].solveInfo[
                        solveInfoMap(index - 1).indexOf(
                          String.fromCharCode(problemIndex + 64)
                        )
                      ].times + 1
                    : rank_info[index - 1].solveInfo[
                        solveInfoMap(index - 1).indexOf(
                          String.fromCharCode(problemIndex + 64)
                        )
                      ].times
                "
              />
              <!-- TODO 一血 蓝色加粗感叹号 -->
              <span>{{
                rank_info[index - 1].solveInfo[
                  solveInfoMap(index - 1).indexOf(
                    String.fromCharCode(problemIndex + 64)
                  )
                ].success_time
              }}</span>
            </div>
          </div>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
import { getContestRank, getContest } from "../api/getData";
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
    };
  },
  async created() {
    await this.getContestInfo();
    this.renderRankList();
    // this.intervalGetRank();
  },
  filters: {
    penaltyFilter: function(val) {
      let res = parseInt(val);
      let hours = parseInt(res / 60 / 60);
      let mins = parseInt((res - hours * 60 * 60) / 60);
      let seconds = parseInt(res - hours * 60 * 60 - mins * 60);
      return hours + ":" + mins + ":" + seconds;
    },
  },
  methods: {
    getContestInfo: async function() {
      let response = await getContest({
        contest_id: this.$route.params.id,
      });
      if (response.status == 0) {
        this.contest_info = {
          title: response.data.contest_name,
          problems: response.data.problems,
          prize: response.data.prize,
        };
      } else {
        this.$message({
          message: response.message,
          type: "error",
        });
      }
    },
    renderRankList: async function() {
      this.resRank = [];
      let response = await getContestRank({
        contest_id: this.$route.params.id,
      });
      if (response.status == 0) {
        let cnt = 1;
        response.data.array.forEach((val) => {
          this.resRank.push({
            id: val.user_id,
            rank: val.nick.indexOf("*") === 0 ? "" : cnt, // 打星
            nick: val.nick,
            acNum: val.ac_num,
            penalty: val.penalty,
            solveInfo: val.problem_id,
          });
          // 打星逻辑
          if (val.nick.indexOf("*") !== 0) {
            cnt++;
          }
        });
        this.total = cnt - 1;
        this.rank_info = this.resRank;
      } else {
        this.$message({
          message: response.message,
          type: "error",
        });
      }
    },
    intervalGetRank: function() {
      // 5秒轮询
      this.interval = setInterval(this.renderRankList, 5000);
    },
    solveInfoMap: function(index) {
      return this.rank_info[index].solveInfo.map((x) => x.problem_id);
    },
    isSuccess: function(index, problemIndex) {
      if (
        this.rank_info[index].solveInfo[
          this.solveInfoMap(index).indexOf(
            String.fromCharCode(problemIndex + 64)
          )
        ].success_time != ""
      )
        return true;
      else return false;
    },
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
      if (flag === null) return false;
      return true;
    },
    myRank: function() {
      let userNick = localStorage.getItem("nick");
      if (userNick === null) return "";
      let index = this.rank_info.map((x) => x.nick).indexOf(userNick);
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
  }
}
</style>
