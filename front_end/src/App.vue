<template>
  <div id="app">
    <transition name="whole-page-mask">
      <div
        class="whole-page-mask"
        v-if="wholePageMaskOpen"
        @click="closeSideBar"
      ></div>
    </transition>
    <sidenav
      ref="sidenav"
      :is-display="sidebarDisplay"
      @close="closeSideBar"
      @call="callSideBar"
      @logout="doLogout"
    />
    <div class="layout-content" id="layout-content" :style="contentWidthObject">
      <topnav
        :topnavOpacity="topnavOpacity"
        :mineWidth="topnavWidth"
        @call-side-bar="callSideBar"
      />
      <keep-alive>
        <router-view
          id="combox"
          class="combox"
          :key="$route.fullPath + localUserId"
          @open-problem="callSideDrawer"
          @logout="doLogout"
          @call-problem="callProblem"
        />
      </keep-alive>
    </div>
    <topdrawer
      :pid="codeComponentData.pid"
      :cid="codeComponentData.cid"
      :is-display="topDisplay"
      @close="topDisplay = false"
      @close-all="
        topDisplay = false;
        sideDisplay = false;
      "
    />
    <sidedrawer
      :pid="problemComponentData.pid"
      :cid="problemComponentData.cid"
      :window-resize="windowResize"
      :is-display="sideDisplay"
      @close="sideDisplay = false"
      @open-submit="callSubmit"
    />
    <!--<div style="z-index: 1001;backdrop-filter: blur(30px);width: 500px;height: 500px;position: absolute;left: 470px;top: 100px;" @click="windowResize = ~windowResize;topDisplay=true;"></div>-->
  </div>
</template>

<script>
import topnav from "./components/top-nav";
import sidenav from "./components/side-nav";
import topdrawer from "./components/top-drawer";
import sidedrawer from "./components/side-drawer";
import { judgeWap } from "./utils";
import { logoutWork } from "./api/common";
import { logout } from "./api/getData";

export default {
  components: {
    topnav,
    sidenav,
    sidedrawer,
    topdrawer,
  },
  data() {
    return {
      bgsrc: "../assets/logo.png",
      topnavOpacity: 0,
      combox: null,
      topDisplay: false,
      sidebarDisplay: true, // 侧边导航栏
      sideDisplay: false, // 侧边drawer
      windowResize: true, // computed cache trick
      wholePageMaskOpen: false,
      problemComponentData: {
        pid: null,
        cid: null,
      },
      codeComponentData: {
        pid: null,
        cid: null,
        height: 480,
        code: "",
        lang: "text/x-csrc",
      },
    };
  },
  mounted() {
    this.initCombox();
    // 每当更换页面，要初始化一下顶部搜索栏的透明值
    this.$refs.sidenav.$on("change-content", () => {
      this.topnavOpacity = 0;
    });
    // window.onresize = () => {
    //   this.windowResize = ~this.windowResize;
    // };
    // setTimeout(() => {
    //   this.windowResize = ~this.windowResize;
    // }, 50);
    // 检测宽度，小于某值后自动关闭侧边栏
    this.judgeAndClose();
    window.onresize = () => {
      this.judgeAndClose();
    }
  },
  methods: {
    // 检测宽度，若达到阈值就close sideBar
    judgeAndClose: function () {
      let clientWidth = this.$el.clientWidth;
      if (clientWidth < 200 + 560) {
        this.closeSideBar();
      }
    },
    getCombox: function() {
      this.combox = document.getElementById("combox");
    },
    initCombox: async function() {
      setTimeout(() => {
        this.getCombox();
        this.combox.addEventListener(
          "scroll",
          () => {
            this.topnavOpacity = this.combox.scrollTop * 0.0033;
          },
          true
        ); // true 事件捕获
      }, 500);
    },
    callProblem(val) {
      if (this.isWap) {
        this.$router.push(`/problem?pid=${val}`);
        return;
      }
      this.callSideDrawer({ pid: val });
    },
    // 打开侧边抽屉
    callSideDrawer: function(val) {
      this.problemComponentData.pid = val.pid;
      if (val.cid !== undefined) {
        this.problemComponentData.cid = val.cid;
      } else {
        this.problemComponentData.cid = null;
      }
      this.sideDisplay = true;
    },
    // 打开顶部提交抽屉
    callSubmit: function(val) {
      this.codeComponentData.pid = val.pid;
      this.codeComponentData.cid = val.cid;
      this.codeComponentData.height = this.$root.$el.clientHeight * 0.95 - 95;
      this.topDisplay = true;
      // 指定CodeMirror Class加上style height
      document
        .getElementsByClassName("CodeMirror")[0]
        .setAttribute("style", `height: ${this.codeComponentData.height}px;`);
    },
    // 打开侧边栏
    callSideBar() {
      this.sidebarDisplay = true;
      if (this.isWap) {
        this.wholePageMaskOpen = true;
      }
    },
    // 收起侧边栏
    closeSideBar() {
      this.sidebarDisplay = false;
      if (this.isWap) {
        this.wholePageMaskOpen = false;
      }
    },
    doLogout: async function() {
      let response = await logout();
      if (response.status == 0) {
        // ok
        const procedure = new Promise((resolve) => {
          logoutWork();
          resolve();
        }).then(() => {
          this.$router.push('/main');
        });
      }
    },
  },
  computed: {
    nowPath: function() {
      return this.$route.path;
    },
    localUserId: function() {
      let ret = localStorage.getItem("userId");
      return ret;
    },
    contentWidthObject: function() {
      let trick = this.windowResize; // computed cache trick
      let phantom =
        this.$root.$el.clientWidth - (this.$root.$el.clientWidth - 200) / 2;
      if (this.isWap) {
        return {
          width: "100%",
          "padding-left": 0,
        };
      }
      return {
        width: this.sideDisplay ? `${phantom}px` : "100%",
        "padding-left": this.sidebarDisplay ? "200px" : 0,
      };
    },
    topnavWidth: function() {
      let res = this.contentWidthObject.width;
      if (this.isWap) {
        return res;
      }
      return this.sidebarDisplay ? `calc(${res} - 200px)` : res;
    },
    isWap() {
      return judgeWap();
    }
  },
  watch: {
    nowPath: function() {
      this.initCombox();
      if (this.isWap) {
        this.closeSideBar();
      }
    },
  },
};
</script>

<style lang="scss">
$acColor: #80dfc5;
$waColor: #f77669;
$tleColor: #82b1ff;
$mleColor: #decb6b;
$reColor: rgb(131, 118, 169);
#app {
  width: 100%;
  height: 100%;
  padding: 0;
  overflow-x: hidden;
}
.layout-content {
  position: relative;
  padding-left: 200px;
  height: 100%;
  transition: width 0.5s ease-in, padding-left 0.5s ease-in-out;
}
.combox {
  width: 100%;
  height: 100%;
  overflow-x: hidden;
  overflow-y: scroll;
  position: relative;
  &::-webkit-scrollbar {
    display: none;
  }
}
/*
  题目icon BEGIN
*/
.ac-icon::before {
  content: "A";
  color: $acColor;
}
.wa-icon::before {
  content: "W";
  color: $waColor;
}
.tle-icon::before {
  content: "T";
  color: $tleColor;
}
.mle-icon::before {
  content: "M";
  color: $mleColor;
}
.other-icon::before {
  content: "O";
  color: black;
}
.un-icon::before {
  content: "-";
  color: #8a8a8a;
}
/*
  题目icon END
*/
/*
  固定色 BEGIN
*/
.ac-color {
  color: $acColor;
}
.wa-color {
  color: $waColor;
}
.tle-color {
  color: $tleColor;
}
.mle-color {
  color: $mleColor;
}
.re-color {
  color: $reColor;
}
/*
  固定色END
*/
:focus {
  outline: 0;
}
/*
  Animation
*/

.whole-page-mask {
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background-color: #474773;
  opacity: 0.6;
  z-index: 1000;

  &-enter-active,
  &-leave-active {
    transition: all 0.5s ease-in-out;
  }
  &-enter,
  &-leave-to {
    opacity: 0;
  }
}
/*
  外部字体
*/
@font-face {
  font-family: countdown;
  src: url("../assets/font/countdown.ttf");
}
@font-face {
  font-family: dinnext;
  /*src: url("../assets/font/DINNext.otf");*/
  src: url("../assets/font/DINNext_min.ttf");
}
@font-face {
  font-family: DINCondensed;
  /*src: url("../assets/font/DINCondensed.otf");*/
  src: url("../assets/font/DINCondensed_min.ttf");
}
@font-face {
  font-family: RobotoMono;
  src: url("../assets/font/RobotoMono-Regular.ttf");
}
</style>

<!--CodeMirror Theme: material nord oceanic-next-->
