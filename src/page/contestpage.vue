<template>
  <div id="main" class="contestpage">
    <div id="canvas" class="mask" v-if="!isBegin">
      <div class="mask-background"></div>
      <div class="last-time">{{ leftBeforeBegin }}</div>
    </div>
    <div class="top">
      <div class="top-tips">
        <label class="countdown-label">
          <span id="time-before-end">距离比赛结束还有: {{ leftTime }}</span>
          <span id="frozen" v-if="isFrozen">&nbsp;&nbsp;已经封榜</span>
        </label>
          
        <label class="tips"
          >点击题号查看题面 Please click problem label to see the detail</label
        >
      </div>
      <div class="table-box">
        <div class="table-inner-box" @scroll="handleScroll">
          <table
            class="problem-status-form"
            cellspacing="10"
            cellpadding="12"
          >
            <thead>
              <tr style="height: 42px;">
                <th
                  class="status-rank style-border-left"
                  @click="$router.push('/rank/' + contest_info.id)"
                  :style="{width: isWap?'70px':'128px'}"
                >
                  <span>排名 Rank</span>
                  <span class="see-more">(点我查看榜单)</span>
                </th>
                <th :style="{width: isWap?'70px':'128px'}">罚时 Penalty</th>
                <th
                  v-for="index in contest_info.problems.length"
                  :key="'preblem-head'+index"
                  class="problem-head"
                  @click="callProblem(contest_info.problems[index - 1], contest_info.id)"
                >
                  {{ String.fromCharCode(64 + index) }}
                </th>
              </tr>
            </thead>
            <tr style="height: 42px;">
              <td class="style-border-left">
                {{ userData.rank }}
              </td>
              <td>
                {{ userData.penalty | penaltyFilter }}
              </td>
              <td
                v-for="(Item, index) in contest_info.problems"
                :key="'problem-status'+index"
                class="problem-status"
              >
                <div
                  v-if="
                    myProblemStatus[Item] !== undefined
                  "
                >
                  <!-- TODO 封榜 Try 逻辑 -->
                  <status-icon
                    :icon-type="
                      myProblemStatus[Item]
                        .success_time != 0
                        ? 'ac'
                        : 'wa'
                    "
                    :times="
                      myProblemStatus[Item]
                        .success_time != 0
                        ? myProblemStatus[Item].times
                        : myProblemStatus[Item].times
                    "
                  />
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <span class="notice-tips" v-if="isDisplayRightContinue">&nbsp;&nbsp;友情提示：题目条可以横向滚动～</span>
    </div>
    <div class="bottom">
      <div class=problem-list>
        <span class="title">问题列表</span>
        <ol>
          <li>
            <div v-for="index in contest_info.problems.length"
                :key="'preblem-self'+index"
                class="problem-self"
                @click="callProblem(contest_info.problems[index - 1], contest_info.id)">
              {{ `${String.fromCharCode(64 + index)} ${problemsInfo[index - 1] ? (problemsInfo[index - 1].title || "") : ""}` }}  
            </div>
          </li>
        </ol>
        <div class="problem-pager">
          <el-pagination
            v-if="contest_info.problems.length > 0"
            background
            layout="prev, pager, next"
            :page-size="8"
            :total="contest_info.problems.length"
            :current-page="1"
            :pager-count="5"
          />
        </div>
      </div>
      <div class="discuss-and-submit">
      <div class="discuss-list">
        <span class="title">
          讨论板 Discuss list
          <span
            class="see-more tips"
            @click="$router.push('/discuss/' + contest_info.id)"
            >点我查看更多, 提问问题</span
          >
        </span>
        <ol>
          <li>
            <div
              class="discuss-card"
              :key="'discuss-card'+index"
              v-for="index in discusses.length"
              @click="
                $router.push(
                  '/discuss/' + contest_info.id + '/' + discusses[index - 1].id
                )
              "
              :class="[
                discusses[index - 1].status === 8
                  ? 'style-border-left-warning'
                  : 'style-border-left',
              ]"
            >
              <div class="discuss-problem-id">
                {{
                  String.fromCharCode(
                    contest_info.problems.indexOf(
                      `${discusses[index - 1].problem_id}`
                    ) + 65
                  )
                }}
              </div>
              <div class="discuss-title">
                {{ discusses[index - 1].title }}
              </div>
              <div class="discuss-author">
                <span
                  style="color: orange;"
                  v-if="discusses[index - 1].status === 8"
                  >{{ `\{管理员公示\}&nbsp;` }}</span
                >
                {{ discusses[index - 1].author }}
              </div>
            </div>
            <div v-if="discusses.length === 0">暂无与您相关的讨论内容</div>
          </li>
        </ol>
        <div class="discuss-pager">
          <el-pagination
            v-if="discussCounts > 0"
            background
            layout="prev, pager, next"
            :page-size="2"
            :total="discussCounts"
            :current-page="currentDiscussPage"
            @current-change="changeDiscussPage"
            :pager-count="5"
          />
        </div>
      </div>
    

      <div class="submit-log-list">
        <span class="title">提交记录 Submit log</span>
        <span id="submit-log-tips" class="tips">点击查看具体记录</span>
        <ul class="submit-log-ul style-border-left">
          <li
            v-for="index in submit_log.length"
            :key="'submit-log'+index"
            :title="'RunID: ' + submit_log[index - 1].runid"
            class="submit-log-list-element submit-log-li"
            @click="
              $router.push(
                '/status?p=' +
                  submit_log[index - 1].problem +
                  '&s=' +
                  submit_log[index - 1].id +
                  '&c=' +
                  contest_info.id
              )
            "
          >
            <div class="log-element">
              <div class="log-element-left">
                <div class="log-element-left-top">
                  <span style="font-weight: bold;" class="log-problem-id">
                    {{
                      String.fromCharCode(
                        contest_info.problems.indexOf(
                          `${submit_log[index - 1].problem}`
                        ) + 65
                      )
                    }}
                  </span>
                  <span
                    style="font-weight:bold;"
                    :class="submit_log[index - 1].status + '-color'"
                    class="log-status"
                  >
                    {{ getErrorName(submit_log[index - 1].status) }}
                  </span>
                  <!-- Result -->
                </div>
                <div class="log-element-left-bottom">
                  <span>
                    {{ submit_log[index - 1].submit_time }}
                  </span>
                  <!-- Submit Time -->
                </div>
              </div>
              <div class="log-element-right">
                <div>
                  <!-- Time used -->
                  <span class="log-label">
                    Time
                  </span>
                  <span class="log-time-used">
                    {{ submit_log[index - 1].time_used | timeUsedFormat }}
                  </span>
                </div>
                <div>
                  <!-- Memory used -->
                  <span class="log-label">
                    Memory
                  </span>
                  <span class="log-mem-used">
                    {{ submit_log[index - 1].mem_used | memoryUsedFormat }}
                  </span>
                </div>
                <div>
                  <!-- Language -->
                  <span class="log-label">
                    Language
                  </span>
                  <span class="log-language">
                    {{ submit_log[index - 1].language }}
                  </span>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <div class="contest-submit-pager-box">
          <el-pagination
            class="contest-submit-pager"
            v-if="submitLogCounts > 0"
            background
            layout="prev, pager, next"
            :page-size="4"
            :total="submitLogCounts"
            :current-page="currentSubmitPage"
            @current-change="changeSubmitPage"
            :pager-count="5"
          />
        </div>
      </div>
      </div>
    </div>
  </div>
</template>

<script>
import { formatDate } from "../api/common";
import { getWholeErrorName, logoutWork } from "../api/common";
import { getContestProblem } from "../api/problem";
import StatusIcon from "../components/status-icon";
import {
  getContestLog,
  getSubmitInfo,
  checkUserContest,
  getUserDiscuss,
} from "../api/getData";
import { getContestRank } from "../api/rank";
import { getContest } from "../api/contest";
import { judgeWap } from "../utils";
import Discussion from './discussion.vue';

export default {
  components: { StatusIcon },
  name: "contestpage",
  data() {
    return {
      problemsInfo: [
        // {
        //   id: 42,
        //   title: "欢迎来到ACM@WUT"
        // }
      ],
      contest_info: {
        id: this.$route.params.id,
        title: "test",
        begin_time: 1611625965502 /*比赛开始时间*/,
        end_time: 2611625965502,
        frozen: 0,
        problems: [/*
          {title:1},
          {title:2},
          {title:3},
          {title:4},
          {title:5},
          {title:6},
          {title:7},
          {title:8},*/
        ],
        colors: [],
        // colors: ['924726','8cc590','b2c959','59785a','8e8c13','252b04','ccda06','8044a7','27e298','0cef7c','31f335','67f70e','0ea6ff'],
      },
      userData: {
        penalty: 0,
        rank: 0,
      },
      submit_log: [/*
        {
            runid: 21063965,
            problem: 1005,
            submit_time: 12, 
            time_used: 2000, 
            mem_used: 2.54,
            language: 'C++11',
            status: 'tle',
        }*/
      ],
      submitLogCounts: 0,
      currentSubmitPage: 1,
      discusses: [/*
      {
          id: '1',
          problem: 1001,
          title: 'title',
          author: 'author',
          time: 23,
          status: 1,
      },*/
      ],
      discussCounts: 0,
      currentDiscussPage: 1,
      leftBeforeBegin: "00:00:00",
      leftTime: "00:00:00",
      intervalBegin: null,
      intervalEnd: null,
      myProblemStatus: {},
      isDisplayRightContinue: false,
    };
  },
  computed: {
    isWap() {
      return judgeWap();
    },
    contestBeginTime: function() {
      let res = new Date(this.contest_info.begin_time).getTime();
      return res;
    },
    isBegin: function() {
      let begin = new Date(this.contest_info.begin_time).getTime();
      let now = new Date().getTime();
      if (now >= begin) return true;
      return false;
    },
    isFrozen: function() {
      let res = this.leftTime;
      let left =
        1000 *
        ((parseInt(res.slice(0, 2)) * 60 + parseInt(res.slice(3, 5))) * 60 +
          parseInt(res.slice(6, 8)));
      let beginTime = new Date(this.contest_info.begin_time).getTime();
      let endTime = new Date(this.contest_info.end_time).getTime();
      let total = endTime - beginTime;
      if (total - left >= total * (1 - this.contest_info.frozen)) return true;
      return false;
    },
  },
  filters: {
    formatDate(time) {
      let date = new Date(time);
      return formatDate(date, "yyyy.MM.dd hh:mm:ss");
    },
    timeUsedFormat: function(val) {
      let res = parseInt(val); // ns
      res /= 1000000; // ms
      return parseInt(res) + " ms";
    },
    memoryUsedFormat: function(val) {
      let res = parseInt(val); // byte
      res /= 1024.0 * 1024.0;
      if (res <= 0.01) {
        res *= 1024;
        res = res.toFixed(2);
        return res + " Kb";
      }
      res = res.toFixed(2);
      return res + " Mb";
    },
    penaltyFilter: function(val) {
      let res = parseInt(val);
      let hours = parseInt(res / 60 / 60);
      let mins = parseInt((res - hours * 60 * 60) / 60);
      let seconds = parseInt(res - hours * 60 * 60 - mins * 60);
      return hours + ":" + mins + ":" + seconds;
    },
  },
  async created() {
    // 渲染比赛信息
    this.getContestInfoCache(); // 从LS拿缓存
    await this.renderContestInfo(() => {
      this.getContestProblems(); // 获取比赛题目信息
      this.$nextTick(() => {
        this.checkRightContinue();
      });
    });
    // 检查登陆状态
    await this.checkJoin();
    
    this.countDownToBegin(); // 开始倒计时
    if (
      new Date(this.contest_info.begin_time).getTime() <= new Date().getTime()
    ) {
      // 比赛开始
      this.countDownToEnd(); // 结束倒计时
      this.renderStatusList(1, () => {
        this.$nextTick(() => {
          this.checkRightContinue();
        });
      }); // 渲染题目状态列表
      this.getDiscussListCache(); // 从LS缓存渲染讨论版
      this.renderDiscussList(); // 渲染讨论板列表
      this.getMyRank(); // 获取排名
    }
  },
  methods: {
    goto: function (link) {
      if (link == "") return;
      this.$router.push("/rank/" + link);
    },
    changeSubmitPage(page) {
      this.currentSubmitPage = page;
      this.renderStatusList(page);
    },
    changeDiscussPage(page) {
      this.currentDiscussPage = page;
      this.renderDiscussList(page);
    },
    checkRightContinue() {
      const ele = document.getElementsByClassName('table-inner-box')[0];
      if (ele.clientWidth < ele.scrollWidth) {
        ele.classList.add('right-continue');
        this.isDisplayRightContinue = true;
      }
    },
    handleScroll(e) {
      // const all = ['left-continue', 'right-continue', 'double-continue'];
      if (e.target.scrollLeft === 0) {
        e.target.classList.add('right-continue');
        e.target.classList.remove('left-continue');
        e.target.classList.remove('double-continue');
      } else if (e.target.scrollLeft + e.target.clientWidth === e.target.scrollWidth) {
        e.target.classList.add('left-continue');
        e.target.classList.remove('right-continue');
        e.target.classList.remove('double-continue');
      } else {
        e.target.classList.add('double-continue');
        e.target.classList.remove('left-continue');
        e.target.classList.remove('right-continue');
      }
    },
    callProblem(pid, cid) {
      if (this.isWap) {
        this.$router.push(`/problem?pid=${pid}&cid=${cid}`);
      } else {
        this.$emit('open-problem', { pid, cid });
      }
    },
    timeFormat(param) {
      return param < 10 ? "0" + param : param;
    },
    countDownToBegin() {
      this.intervalBegin = setInterval(() => {
        // 获取当前时间，同时得到活动结束时间数组
        let newTime = new Date().getTime();
        // 对结束时间进行处理渲染到页面
        let beginTime = new Date(this.contest_info.begin_time).getTime();
        let obj = null;
        // 如果活动未结束，对时间进行处理
        if (beginTime - newTime > 0) {
          let time = (beginTime - newTime) / 1000;
          // 获取天、时、分、秒
          let hou = parseInt((time % (60 * 60 * 24)) / 3600);
          let min = parseInt(((time % (60 * 60 * 24)) % 3600) / 60);
          let sec = parseInt(((time % (60 * 60 * 24)) % 3600) % 60);
          obj = {
            hou: this.timeFormat(hou),
            min: this.timeFormat(min),
            sec: this.timeFormat(sec),
          };
        } else {
          // 活动已结束，全部设置为'00'
          obj = {
            hou: "00",
            min: "00",
            sec: "00",
          };
          clearInterval(this.intervalBegin);
        }
        this.leftBeforeBegin = obj.hou + ":" + obj.min + ":" + obj.sec;
      }, 1000);
    },
    countDownToEnd() {
      this.intervalEnd = setInterval(() => {
        // 获取当前时间，同时得到活动结束时间数组
        let nowTime = Date.now();
        // 对结束时间进行处理渲染到页面
        let beginTime = new Date(this.contest_info.begin_time).getTime();
        let endTime = new Date(this.contest_info.end_time).getTime();
        let obj = {
          hou: "05",
          min: "00",
          sec: "00",
        };
        // 活动开始后才倒计时
        if (beginTime < nowTime) {
          // 如果活动未结束，对时间进行处理
          if (endTime - nowTime > 0) {
            let time = (endTime - nowTime) / 1000;
            // 获取天、时、分、秒
            let hou = parseInt(time / 3600);
            let min = parseInt((time - hou * 3600) / 60);
            let sec = parseInt(time % 60);
            obj = {
              hou: this.timeFormat(hou),
              min: this.timeFormat(min),
              sec: this.timeFormat(sec),
            };
          } else {
            // 活动已结束，全部设置为'00'
            obj = {
              hou: "00",
              min: "00",
              sec: "00",
            };
            clearInterval(this.intervalEnd);
          }
        }
        this.leftTime = obj.hou + ":" + obj.min + ":" + obj.sec;
      }, 1000);
    },
    getErrorName(status) {
      return getWholeErrorName(status);
    },
    renderContestInfo: async function(callback) {
      const response = await getContest(this.$route.params.id);
      localStorage.setItem("nowContest", this.$route.params.id);

      if (response.status === 0) {
        let resObj = Object.assign({}, this.contest_info, response.data);
        resObj.begin_time = response.data.begin_time.replace(/-/g, '/');
        resObj.end_time = response.data.end_time.replace(/-/g, '/');

        if(resObj.begin_time[19] == 'Z') resObj.begin_time = resObj.begin_time.substr(0,19);
        resObj.begin_time = resObj.begin_time.replace("T", " ");
        if(resObj.end_time[19] == 'Z') resObj.end_time = resObj.end_time.substr(0,19);
        resObj.end_time = resObj.end_time.replace("T", " ");//去除时间中的T和Z  timba   zimba
        resObj.problems = resObj.problems.slice(1,resObj.problems.length-1).split(",");
        if(resObj.problems[0] == "") resObj.problems.shift();

        this.contest_info = resObj;
        localStorage.setItem(`contestInfo-${this.$route.params.id}`, JSON.stringify(this.contest_info));
        typeof callback === "function" && callback();
      } else {
        this.$message({
          message: response.message,
          type: "error",
        });
      }
    },
    renderStatusList: async function(page = 1, callback) {
      let response = await getContestLog({
        contest_id: this.$route.params.id,
        // 保证传回来的是自己相关的状态（本页面的业务需求）
        user_id: localStorage.getItem("userId"),
        page,
      });
      this.submit_log = [];

      if (response.status == 0) {
        //this.userData.penalty = response.data.penalty.penalty;
        // response.data.penalty.problem.forEach( (val, index) => {
        // TODO
        // });
        /*let problemInfo = response.data.penalty.problem;
        let forTotal = this.contest_info.problems.length + 65 - 1;
        for (let index = 65; index <= forTotal; index++) {
          let cindex = String.fromCharCode(index);
          if (problemInfo[cindex] !== undefined) {
            this.myProblemStatus[cindex] = problemInfo[cindex];
          }
        }*/
        if(response.data.data != null) {
          response.data.data.forEach((val) => {
            if(val.submit_time[19] == 'Z') val.submit_time = val.submit_time.substr(0,19);
            val.submit_time = val.submit_time.replace("T", " ");
            this.submit_log.push({
              id: val.id,
              problem: val.problem_id,
              submit_time: val.submit_time, // TODO fix
              time_used: val.time,
              mem_used: val.memory,
              language: val.language,
              status: val.status.toLowerCase(),
            });
          });
        }
       
        this.submitLogCounts = response.data.count;

        typeof callback === "function" && callback();
      } else {
        if (response.status === 504) {
          // timeout
        } else {
          if (response.message == "未登录") {
            logoutWork();
            this.$router.go(-1);
            this.$message({
              message: "登陆状态过期，请重新登录",
              type: "error",
            });
          } else {
          }
        }
      }
    },
    renderDiscussList: async function(page = 1) {
      let response = await getUserDiscuss({
        contest_id: this.$route.params.id,
        page,
      });
      if (response.status == 0) {
        this.discusses = response.data.data;
        this.discussCounts = response.data.count;
        this.$store.dispatch("contest/contestDiscussList", JSON.stringify(response.data.data));
        localStorage.setItem(`contestDiscussList-${this.$route.params.id}-${page}`, JSON.stringify(response.data.data));
        // response.data.data.forEach((val) => {
        //   this.discusses.push({
        //     id: val.id,
        //     problem: val.problem_id,
        //     title: val.title,
        //     author: val.nick,
        //     time: val.time,
        //     status: parseInt(val.status),
        //   });
        // });
      } else {
        this.$message({
          message: "讨论版渲染失败",
          type: "error",
        });
      }
    },
    getMyRank: async function() {
      let response = await getContestRank(this.$route.params.id);
      if (response.status !== 0) return;
      let data = response.data;
      if(data == null) return;
      for(let index in data){
        if(data[index].user_id == parseInt(localStorage.getItem("userId"))){
          this.userData.penalty = data[index].penalty;
          let problemInfo = data[index].problem_id;
          for(let problemId in this.contest_info.problems){
            if(problemInfo[this.contest_info.problems[problemId]] != undefined){
              this.myProblemStatus[this.contest_info.problems[problemId]] =
                problemInfo[this.contest_info.problems[problemId]];
            }
          }
        }
      }
      //this.userData.penalty = response.data.penalty.penalty;
      // response.data.penalty.problem.forEach( (val, index) => {
      // TODO
      // });
      /*let problemInfo = response.data.penalty.problem;
      let forTotal = this.contest_info.problems.length + 65 - 1;
      for (let index = 65; index <= forTotal; index++) {
        let cindex = String.fromCharCode(index);
        if (problemInfo[cindex] !== undefined) {
          this.myProblemStatus[cindex] = problemInfo[cindex];
        }
      }*/
      let user_id = localStorage.getItem("userId");
      let rank = data.map((x) => x.user_id).indexOf(parseInt(user_id)) + 1;
      this.userData.rank = rank;
    },
    checkJoin: async function() {
      let response = await checkUserContest(
        this.$route.params.id,
      );
      if(response.status != 0) {
        this.$message({
          message: "请求失败",
          type: "error",
        });
        this.$router.go(-1);
      }
      else if (
        (response.data.status <  0 || response.data.status > 3) && 
        new Date(this.contest_info.end_time).getTime() > Date.now()
      ) {
        // 未参加比赛 且 比赛未结束
        // 无权查看比赛
        this.$message({
          message: "您尚未参加本场比赛",
          type: "error",
        });
        this.$router.go(-1);
      }
      else if (response.data.status == 3) {
        this.$message({
          message: "您作弊了",
          type: "error",
        });
        this.$router.go(-1);
      }
    },
    getContestInfoCache() {
      const str = localStorage.getItem(`contestInfo-${this.$route.params.id}`);
      try {
        const data = JSON.parse(str);
        this.contest_info = Object.assign(this.contest_info, data || {});
      } catch (e) {
        localStorage.removeItem(`contestInfo-${this.$route.params.id}`);
      }
    },
    getDiscussListCache(page = 1) {
      const str = localStorage.getItem(`contestDiscussList-${this.$route.params.id}-${page}`);
      try {
        const data = JSON.parse(str);
        this.discusses = data || [];
      } catch (e) {
        localStorage.removeItem(`contestDiscussList-${this.$route.params.id}-${page}`);
      }
    },
    async getContestProblems() { // 获取比赛相关的题目信息
      const resp = await getContestProblem(this.$route.params.id);
      if (resp.status === 0) {
        const data = resp.data;
        const problems = data.map((problem) => {
          const { id, info } = problem;
          const { title } = info;
          return { id, title };
        });
        console.log("deanti data", data);
        console.log("deanti problems", problems);
        this.problemsInfo = problems;
      } else {
        console.error("🙅‍♂️ getContestProblem API error: %s", resp.message);
        this.$message({
          message: resp.message,
          type: "error",
        });
      }
    }
  },
  beforeDestroy() {
    clearInterval(this.intervalBegin);
    clearInterval(this.intervalEnd);
  },
};
</script>

<style lang="scss" scoped>
$inner-left-border: 3px solid #4288ce;
$inner-left-border-warning: 3px solid orange;

ul,
ol {
  position: relative;
  list-style-type: none;
  padding-left: 5px;
  margin-top: 15px;
}

li {
  cursor: pointer;
  > span {
    margin: 0 3px;
  }
}

table {
  table-layout: fixed;
}

.style-border-left {
  border-left: $inner-left-border;
}

.style-border-left-warning {
  border-left: $inner-left-border-warning;
}

.top-tips {
  display: flex;
  justify-content: space-between;
  margin-bottom: 3px;
}

.tips {
  font: {
    size: 12px;
    weight: bold;
  }
  float: right;
}

.countdown-label {
  display: inline-block;
  font: {
    size: 12px;
    weight: bold;
  }
  height: 18px;
}

/* 布局 */

.contestpage {
  position: relative;
  width: 100%;
  height: 100%;
  overflow-x: hidden;
  overflow-y: scroll;

  padding-bottom: 40px;
}

/* 开赛前毛玻璃波纹效果 */

.mask {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  overflow: hidden;
  z-index: 999;
  &-background {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    overflow: hidden;
    filter: blur(3px) opacity(80%);
    background: white;
    z-index: 1;
  }
}

.last-time {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  padding-bottom: 6%;
  display: flex;
  align-items: center;
  justify-content: center;
  font: {
    size: 120px;
    family: countdown;
  }
  z-index: 1000;
  /*width:*/
}

/* 毛玻璃波纹 END */

.top {
  width: 80%;
  max-width: 990px;
  margin: 88px auto 0 auto;
}

#frozen {
  color: red;
}

.bottom {
  display: flex;
  width: 80%;
  max-width: 990px;
  margin: 15px auto 0 auto;
}

.problem-list{
  display: flex;
  flex-flow: column;
  width: 50%;
}
.problem-self{
  height: 40px;
  width: 95%;
  border-radius: 10px;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  z-index: 1;
  overflow: hidden;
  margin-bottom: 10px;
  background: white;
  border-left: $inner-left-border;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  padding: 2% 4%;
  margin-right: 0;
}

.problem-pager{
  height: 100%;
  display: flex;
  flex-flow: row;
  align-items: flex-end;
  /*margin-bottom: 60px;*/
  width: 100%;
  padding-left: 30%;
}

.discuss-and-submit{
  display: flex;
  flex-flow: column;
  width: 50%;
  height: 100%;
}

.table-box {
  width: 100%;
  overflow-x: hidden;
  filter: drop-shadow(0 2px 15px rgba(0, 0, 0, 0.08));
}

.table-inner-box {
  overflow-x: auto;
  border-radius: 10px;
  background: white;
  transition: box-shadow 300ms ease-in-out;

  &::-webkit-scrollbar {
    // position: absolute;
    // margin-top: 10px;
    // display: none;
  }
}

.notice-tips {
  display: inline-block;
  color: red;
  font-size: 12px;
  font-weight: bold;
  margin-top: 5px;
}

.left-continue {
  box-shadow: inset 15px 0 15px -15px #4288ce;
}

.right-continue {
  box-shadow: inset -15px 0 15px -15px #4288ce;
}

.double-continue {
  box-shadow: inset -15px 0 15px -15px #4288ce, inset 15px 0 15px -15px #4288ce;
}

.problem-status-form {
  overflow: hidden;
  text-align: center;
  border-radius: 10px;
  min-width: 100%;
  // box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
}

.problem-head {
  cursor: pointer;
  border-left: 1px rgba(0, 0, 0, 0.2) dashed;
  &:hover {
    text-decoration: underline;
  }
  /*
            TODO 点击后弹出题目
        */
}

.problem-status {
  /*display: flex;*/
  /*justify-content: center;*/
  /*align-items: center;*/
  /*cursor: pointer;*/
  border-left: 1px rgba(0, 0, 0, 0.2) dashed;
  /*
            TODO 点击后在提交列表内相应题目记录高亮，再次点击消除
        */
}

.status-rank {
  text-align: center;

  color: #338bb8;
  cursor: pointer;

  & > span {
    display: block;
    margin: 0 auto;
  }

  &:hover, &:hover > span {
    color: #5c8db7;
    text-decoration: underline;
  }
}

.see-more {
  cursor: pointer;
  margin-top: 5px;
  font-size: 12px;
}

.submit-log-list {
  height: 277px;
  width: 100%;
}

.submit-log-ul {
  padding-left: 0;
  border-radius: 10px;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  background: white;
}

.submit-log-li {
  cursor: pointer;
  height: 48px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  &:last-child {
    border: none;
  }
  > i {
    content: "";
    position: absolute;
    height: 16px;
    width: 16px;
    border-radius: 10px;
    margin-left: 11px;
    filter: brightness(130%);
  }
  > div {
    margin-left: 15px;
  }
}

#submit-log-tips {
  margin-top: 5px;
  margin-right: 4px;
}

.discuss-list {
  display: flex;
  flex-flow: column;
  width: 100%;
  height: 310px;
}

.title {
  padding-left: 5px;
  font-weight: bold;
  font-size: 16px;
}

.log-element {
  display: flex;
  flex-direction: row;
  width: 100%;
  margin-top: -4px;
  &-left {
    display: flex;
    flex-direction: column;
    width: 38%;
    &-bottom {
      font-size: 10px;
      height: 13px;
    }
  }
  &-right {
    display: flex;
    flex-direction: row;
    align-items: flex-end;
    justify-content: space-between;
    width: 58%;
    > div {
      display: flex;
      flex-direction: column;
      width: 33.3%;
      > span {
        &:last-child {
          font-weight: bold;
        }
      }
    }
  }
}

.log-language {
  // 开头字母大写
  text-transform: capitalize;
}

.log-label {
  font: {
    size: 12px;
    /*weight: bold;*/
  }
}

.discuss-card {
  height: 65px;
  border-radius: 10px;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  z-index: 1;
  overflow: hidden;
  margin-bottom: 10px;
  background: white;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  padding: 5px 10px;
  margin-right: 0;
}

.discuss-problem-id {
  /*top: 5px;*/
  /*left: 10px;*/
  width: 100%;
  font-size: 10px;
}

.discuss-title {
  width: 100%;
  height: calc(100% - 20px);
}

.discuss-author {
  font-size: 10px;
}

.contest-submit-pager-box, .discuss-pager {
  display: flex;
  justify-content: center;
  /*margin-bottom: 60px;*/
  width: 100%;
}

@media screen and (max-width: 650px) {
  .problem-status-form {
    & th {
      font-size: 12px;
    }
  }

  .top, .bottom {
    width: 100%;
    padding: 0 10px;
  }

  .bottom {
    display: flex;
    flex-direction: column-reverse;

    & > div {
      width: 100%;
      border-bottom: 0.5px solid rgba(0,0,0,0.1);
      padding-bottom: 30px;
      margin-bottom: 30px;
    }
  }
}
</style>
