import Vue from "vue";
import Vuex from "vuex";
import {
  Carousel,
  CarouselItem,
  Message,
  Table,
  TableColumn,
  Form,
  FormItem,
  DatePicker,
} from "element-ui";
import App from "./App";
import router from "./router/router";
import store from "./store";
import loadingPlugin from "./plugins/loading";
import codemirror from "vue-codemirror-lite";
import echarts from "echarts";

Vue.config.productionTip = false;

// Element-ui-Message add Install function to mount
Message.install = function(Vue) {
  Vue.prototype.$message = Message;
};
// echarts
Vue.prototype.$echarts = echarts;

// 引入
Vue.use(Vuex);
Vue.use(Carousel);
Vue.use(CarouselItem);
Vue.use(Message);
Vue.use(Table);
Vue.use(TableColumn);
Vue.use(Form);
Vue.use(FormItem);
Vue.use(DatePicker);
Vue.use(codemirror);
Vue.use(loadingPlugin, {
  progressColor: "#4288ce",
});

/* eslint-disable */
new Vue({
  render: (c) => c(App),
  router,
  store,
}).$mount("#app"); // VueCLI 3.0

// 登陆检测

router.beforeEach((to, from, next) => {
  let getFlag = localStorage.getItem("Flag");
  if (getFlag === "isLogin") {
    // 已经登陆
    store.state.login.isLogin = true;
    store.state.login.userId = localStorage.getItem("userId");
    store.state.login.nick = localStorage.getItem("nick");
    store.state.login.desc = localStorage.getItem("desc");
    store.state.login.avator = localStorage.getItem("avator");
    store.state.login.acCnt = localStorage.getItem("acCnt");
    store.state.login.waCnt = localStorage.getItem("waCnt");
    next();
  } else {
    // 未登陆
    if (to.meta.isLogin) {
      next(false);
      Vue.prototype.$message({
        message: "请先登录",
        type: "error",
      });
    } else {
      //用户进入无需登录的界面，则跳转继续
      next();
    }
  }
});

router.afterEach((route) => {
  window.scroll(0, 0);
});

// 判断isWap

window.onload = () => {
  judgeWap();
}

window.onresize = () => {
  judgeWap();
}

function judgeWap() {
  let bodyWidth = document.body.clientWidth;
  let bodyHeight = document.body.clientHeight;

  if (bodyHeight > bodyWidth || !IsPC()) {
    window.isWap = true;
  } else {
    window.isWap = false;
  }
}

function IsPC() {
  let userAgentInfo = navigator.userAgent;
  let Agents = new Array(
    "Android",
    "iPhone",
    "SymbianOS",
    "Windows Phone",
    "iPad",
    "iPod"
  );
  let flag = true;
  for (let v = 0; v < Agents.length; v++) {
    if (userAgentInfo.indexOf(Agents[v]) > 0) {
      flag = false;
      break;
    }
  }
  return flag;
}

function getExploreName() {
  let explorer = window.navigator.userAgent;
  let ua = window.navigator.userAgent;
  let isSafari = ua.indexOf("Safari") != -1 && ua.indexOf("Version") != -1;
  //判断是否为IE浏览器
  if (explorer.indexOf("MSIE") >= 0) {
    return "IE";
  }
  //判断是否为Firefox浏览器
  else if (explorer.indexOf("Firefox") >= 0) {
    return "Firefox";
  }
  //判断是否为Chrome浏览器
  else if (explorer.indexOf("Chrome") >= 0) {
    return "Chrome";
  }
  //判断是否为Opera浏览器
  else if (explorer.indexOf("Opera") >= 0) {
    return "Opera";
  }
  //判断是否为Safari浏览器
  else if (isSafari) {
    return "Safari";
  } else return "Unknown";
}
