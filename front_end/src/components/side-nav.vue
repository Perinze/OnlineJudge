<template>
  <div id="side-bar" :style="styleObject">
    <transition name="user-card">
      <user-card
        v-if="displayUsercard"
        @close="displayUsercard = false"
        @logout="doLogout"
      />
    </transition>
    <transition name="welcome">
      <welcome
        @logged="recvLoginData"
        @close="displayWelcome = false"
        v-if="displayWelcome && !isLogin"
      />
    </transition>
    <transition name="open-btn">
      <div id="open-btn" v-show="!isDisplay && !isWap">
        <img
          src="../../assets/icon/next.svg"
          width="18"
          height="18"
          @click="$emit('call')"
        />
      </div>
    </transition>
    <div class="logo" @click="$emit('close')">
      <div style="position: relative;top: 9px">
        <img src="../../assets/media/logo.png" />
      </div>
    </div>
    <div class="menu-userbar" align="center">
      <div class="user-alias-border" :class="{'has-login': isLogin}">
        <div class="user-alias">
          <img
            id="user-alias-img"
            :src="avatorComputed"
            height="40"
            width="40"
            @click="callUsercard"
            :style="isLogin ? { cursor: 'pointer' } : { cursor: 'default' }"
          />
        </div>
      </div>
      <div class="user-info" :class="{'has-login': isLogin}" align="center" v-if="isLogin">
        <span id="user-nick">{{ userData.nick }}</span>
        <br />
        <span id="user-desc">{{ userData.desc }}</span>
      </div>
      <div class="user-data" :class="{'has-login': isLogin}" v-if="isLogin">
        <div style="width: 12px"></div>
        <div class="data-item">
          <strong class="data-font">提交量</strong>
          <br />
          <strong id="submit-num" class="data-num">{{
            parseInt(userData.acCnt) + parseInt(userData.waCnt)
          }}</strong>
        </div>
        <div class="data-item">
          <strong class="data-font">通过量</strong>
          <br />
          <strong id="ac-num" class="data-num">{{ userData.acCnt }}</strong>
        </div>
        <div class="data-item">
          <strong class="data-font">正确率</strong>
          <br />
          <strong id="ac-percent" class="data-num">{{ acPercent }}%</strong>
        </div>
        <div style="width: 5px"></div>
      </div>
      <div class="function-btn-group" v-if="!isLogin">
        <span id="unlog-guide">您还没登陆</span>
        <br />
        <button @click="callWelcome">注册/登录</button>
      </div>
    </div>
    <div>
      <!--            <div class="button-blank"></div>-->
      <menu-item
        v-for="(item, index) in items"
        :title="item.title"
        :key="item.keyName"
        :img-src="item.imgSrc"
        :class="[activeIndex === index ? 'menu-item-active' : 'menu-item']"
        :is-active="activeIndex === index"
        @click.native="
          if (activeIndex !== index) $emit('change-content');
          if ('/' + item.routeName !== activePath)
            $router.push('/' + item.routeName);
        "
      >
      </menu-item>
    </div>
    <div id="menu-footer" align="center">
      <span
        class="menu-footer-content"
        style="font-size: 14px;font-weight: 300;"
        >ACM@WUT</span
      >
      <span
        class="menu-footer-content"
        style="font-size: 10px;font-weight: 200;"
        >©{{new Date().getYear() + 1900}} WUT ACM Developer</span
      >
      <div id="surprise" hidden>
        ********************
        WUT OnlineJudge 的所有贡献者(以下排名不分先后)
        王熠弘（2017 级）：OnlineJudge、协会主页的前端开发
        李劲巍（2017 级）：后端业务逻辑、部分评测核心对接任务
        曾嘉豪（2017 级）：项目运维及评测核心对接任务
        黄  融（2018 级）：评测核心Ana项目及其对接任务
        郑文伟（2017 级）：WUTOJ 的UI设计工作
        周景尧（2017 级）：OnlineJudge 前端页面
        郑成锋（2016 级）：OnlineJudge 前端页面
        冷  瑜（2016 级）：压力测试及爬虫工作
        刘福鑫（2017 级）：协会主页前端开发
        王超睿（2020 级）：协会项目运维任务
        ********************
      </div>
    </div>
  </div>
</template>

<script>
import MenuItem from "./menu-item";
import userCard from "../components/userCard";
import welcome from "../components/welcome";
import { logoutWork } from "../api/common";
import { logout, checkLogin } from "../api/getData";
import { mapGetters } from "vuex";
import store from "../store";
import { judgeWap } from "../utils";

export default {
  components: { MenuItem, welcome, userCard },
  name: "side-nav",
  props: ["isDisplay"],
  data() {
    return {
      items: [
        {
          title: "主页 Home",
          keyName: "mainpage",
          imgSrc: require("../../assets/icon/home.svg"),
          routeName: "main",
        },
        {
          title: "题目 Problem",
          keyName: "problemlist",
          imgSrc: require("../../assets/icon/problem.svg"),
          routeName: "plist",
        },
        {
          title: "比赛 Contest",
          keyName: "contestpage",
          imgSrc: require("../../assets/icon/contest.svg"),
          routeName: "contest",
        },
        {
          title: "排名 Rank",
          keyName: "rank",
          imgSrc: require("../../assets/icon/rank.svg"),
          routeName: "rank",
        },
        // {
        //   title: "小组 Groups",
        //   keyName: "grouplist",
        //   imgSrc: require("../../assets/icon/group.svg"),
        //   routeName: "group",
        // },
        // {
        //   title: "成就 Achievement",
        //   keyName: "achievement",
        //   imgSrc: require("../../assets/icon/achievement.svg"),
        //   routeName: "achievement",
        // },
        {
          title: "讨论 Discussion",
          keyName: "discussion",
          imgSrc: require("../../assets/icon/discussion.svg"),
          routeName: "discussion",
        },
      ],
      userinfo: {
        avator: "/assets/media/avator.png",
      },
      displayUsercard: false,
      displayWelcome: false,
      imgs: {
        testAvator: require("../../assets/media/avator.png"),
        defaultAvator: require("../../assets/media/defualt-avator.png"),
      },
      // userData: {
      //     userId: '213',
      //     nick: 'Lemo Zheng',
      //     desc: 'You blow me away.',
      //     acCnt: 214,
      //     waCnt: 1654
      // }
    };
  },
  created() {
    this.initUser();
    this.checkLoginStatus();
    // this.testTimeout();
  },
  methods: {
    recvLoginData: function(data) {
      this.$store.dispatch("login/userInfoStorage", data);
      this.userinfo.isLogin = true;
    },
    doLogout: async function() {
      let response = await logout();
      if (response.status == 0) {
        // ok
        let procedure = new Promise((resolve) => {
          logoutWork();
          resolve();
        });
        procedure.then(() => {
          this.initUser();
          this.displayUsercard = false;
        });
      }
    },
    initUser() {
      let tmp = localStorage.getItem("Flag");
      if (tmp === "isLogin") {
        store.state.login.isLogin = true;
      } else {
        store.state.login.isLogin = false;
      }
      store.state.login.userId = localStorage.getItem("userId");
      store.state.login.nick = localStorage.getItem("nick");
      store.state.login.desc = localStorage.getItem("desc");
      store.state.login.avator = localStorage.getItem("avator");
      store.state.login.acCnt = parseInt(localStorage.getItem("acCnt"));
      store.state.login.waCnt = parseInt(localStorage.getItem("waCnt"));
    },
    checkLoginStatus: async function() {
      let response = await checkLogin({
        user_id: localStorage.getItem("userId"),
      });
      if (response.status == 0) {
        if (response.message.indexOf("不符") !== -1) {
          this.$message({
            message: "登陆状态错误, 请登出后重新登录",
            type: "warning",
          });
          this.$router.go(-1);
        }
      } else {
        if (response.status == -1) {
          this.$store.dispatch("login/userLogin", false);
          localStorage.removeItem("Flag");
          this.$message({
            message: "您还未登陆",
            type: "warning",
          });
        }
      }
    },
    // 打开userCard
    callUsercard() {
      if (localStorage.getItem("Flag") === "isLogin")
        this.displayUsercard = true;
      else return;
    },
    // 开关sideBar
    toggleMenu() {
      if (this.isDisplay) {
        this.$emit('close');
      } else {
        this.$emit('call');
      }
    },
    // 打开welcome卡
    callWelcome() {
      if (this.isWap) {
        this.$emit('close');
      }
      this.displayWelcome = true;
    }
  },
  computed: {
    activePath: function () {
      let res = this.$route.path + "/";
      return res.slice(0, res.indexOf("/", 1));
    },
    activeIndex: function () {
      let path = this.activePath;
      switch (path) {
        case "/main":
          return 0;
        case "/plist":
          return 1;
        case "/problem":
          return 1;
        case "/submit":
          return 1;
        case "/contest":
          return 2;
        case "/rank":
          return 3;
        case "/group":
          return 4;
        case "/achievement":
          return 5;
        case "/discussion":
          return 6;
      }
      return null;
    },
    acPercent: function () {
      let ac = parseInt(this.userData.acCnt);
      let total = ac + parseInt(this.userData.waCnt);
      if (total === 0) {
        return 0;
      } else {
        return (ac / total).toFixed(3) * 100;
      }
    },
    ...mapGetters("login", {
      userData: "userInfo",
      isLogin: "isLogin",
    }),
    avatorComputed: function () {
      if (this.isLogin) {
        return this.imgs.testAvator;
        // 配好nginx后改回来
        return this.userData.avator;
      } else {
        return this.imgs.defaultAvator;
      }
    },
    styleObject: function () {
      let ret = {
        "margin-left": 0,
      };
      if (!this.isDisplay) {
        ret["margin-left"] = "-100%";
      }
      return ret;
    },
    isWap: function () {
      return judgeWap();
    }
  }
};
</script>

<style lang="scss" scoped>
#side-bar {
  height: 100%;
  width: 200px;
  background: #fbfbfb;
  position: fixed;
  z-index: 1002;
  box-shadow: inset -10px 0 15px -15px rgba(0, 0, 0, 0.3);
  transition: margin-left 0.5s ease-in-out;
}

#open-btn {
  position: absolute;
  right: -25px;
  top: calc((100% - 18px) / 2);
  cursor: pointer;
  animation: notice 2s;
  animation-iteration-count: infinite;
}

.logo {
  align-items: center;
  text-align: center;
  height: 48px;
}

.logout-btn {
  position: absolute;
  top: 94px;
  left: 32px;
  cursor: pointer;
}

.menu-userbar {
  text-align: center;
  height: 200px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  .user-alias-border {
    position: relative;
    left: 75px;
    top: 20px;
    border-radius: 25px;
    border: 2px solid #5c8db7;
    height: 50px;
    width: 50px;
    .user-alias {
      position: relative;
      top: 3px;
      left: 3px;
      height: 40px;
      width: 40px;
      border-radius: 20px;
      overflow: hidden;
    }
  }
  .user-info {
    position: relative;
    top: 25px;
    #user-nick {
      font-weight: bold;
      font-size: 16px;
    }
    #user-desc {
      font-weight: 300;
      font-size: 10px;
    }
  }
  .user-data {
    position: relative;
    top: 35px;
    display: flex;
    .data-item {
      flex: 1 1 auto;
    }
  }
}

.menu-footer-content {
  align-self: center;
  color: #4d4f5c;
  opacity: 0.4;
}

.menu-item {
  transform: translate3d(0, 0, 0);
  transition: all 0.6s ease 0s;
  font: {
    size: 12px;
    weight: 300;
  }
  color: #a0a5ab;
  display: flex;
  flex-direction: row;
  justify-content: left;
  align-items: center;
  height: 50px;
  border-left: 7px solid transparent;
  cursor: pointer;
  &:hover {
    transform: translate3d(0, 0, 0);
    transition: all 0.6s ease 0s;
    background: #f5f5f5;
    border-left: 7px solid transparent;
    box-shadow: inset -10px 0 15px -16px rgba(0, 0, 0, 0.3);
  }
  &-active {
    font: {
      size: 12px;
      weight: 400;
    }
    color: #338bb8;
    display: flex;
    flex-direction: row;
    justify-content: left;
    align-items: center;
    height: 50px;
    background: #f5f5f5;
    border-left: 7px #5c8db7 solid;
    box-shadow: inset -10px 0 15px -16px rgba(0, 0, 0, 0.3);
    cursor: pointer;
  }
}

.data-item {
  .data-font {
    font-size: 12px;
    font-weight: 500;
  }
  .data-num {
    font-size: 22px;
    font-weight: 500;
  }
}

#menu-footer {
  float: top;
  width: 100%;
  display: block;
  position: absolute;
  bottom: 2%;
  > span {
    display: block;
  }
}

.function-btn-group {
  position: relative;
  top: 27px;
  > button {
    background: #4288ce;
    border: none;
    border-radius: 1.5em;
    color: white;
    height: 28px;
    width: 150px;
    margin-top: 20px;
    cursor: pointer;
  }
}

#unlog-guide {
  font-size: 13px;
}

/*
  Animation
*/

// open-btn

.open-btn {
  &-enter-active,
  &-leave-active {
    transition: all 0.5s ease-in-out;
  }
  &-enter,
  &-leave-to {
    opacity: 0;
    right: 20px;
  }
}

@keyframes notice {
  from {
    margin-right: -3px;
  }
  50% {
    margin-right: 0;
  }
  to {
    margin-right: -3px;
  }
}

// user-card

.user-card {
  &-enter-active,
  &-leave-active {
    transition: all 0.6s ease;
  }
  &-enter {
    transform: rotate(-60deg);
    opacity: 0.5;
  }
  &-leave-to {
    transform: rotate(-60deg);
    opacity: 0;
  }
}

// welcome

.welcome {
  &-enter-active,
  &-leave-active {
    transition: all 0.6s ease;
  }
  &-enter {
    opacity: 0.3;
  }
  &-leave-to {
    opacity: 0;
  }
}

/* TODO 660 warning */

@media (min-height: 695px) {
  .button-blank {
    width: 100%;
    height: 34px;
    max-height: 34px;
  }
}

/* 移动端适配 */

@media screen and (max-width: 650px) {
  #side-bar {
    width: 250px;
    border-radius: 0 10px 10px 0;
    & > * {
      z-index: 1;
    }

    & > .function-mask {
      z-index: -1;
    }
  }

  .logo {
    display: none;
  }

  .menu-userbar {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
    padding: 10px 30px;

    .user-alias-border {
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      border: 0.5px solid rgba(79,79,79,.4);
      margin: 0;
      top: unset;
      left: unset;

      .user-alias {
        top: unset;
        left: unset;
        width: 50px;
        height: 50px;
        & > img {
          width: 50px;
          height: 50px;
        }
      }
    }

    .function-btn-group {
      position: relative;
      top: 0;
      left: 0;
      width: 100%;
      height: initial;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: initial;
      padding: 0 5px 0 10px;

      & > button {
        margin: 0;
        width: 100%;
      }
    }

    .user-info {
      top: unset;
    }

    .user-data {
      display: flex;
      flex-direction: row;
      justify-content: space-around;
      width: 100%;
      top: unset;
    }
  }
}

</style>
