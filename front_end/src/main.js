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

// 防开发者模式 BEGIN

// window.onkeydown = window.onkeyup = window.onkeypress = function(event) {
// TODO 防止f12 但在MAC系统下会阻止输入大括号
// if (event.keyCode === 123) {
// console.log('here');
// event.preventDefault();
// window.event.returnValue = false;
// }
// };

window.oncontextmenu = function() {
  // event.preventDefault();
  // return false;
};

let threshold = 160;
window.setInterval(function() {
  if (
    window.outerWidth - window.innerWidth > threshold ||
    window.outerHeight - window.innerHeight > threshold
    //|| (window.console && window.console.log)
  ) {
    // alert("Please Close Develop Mode! ");
    // window.location.reload();
  }
}, 5e3);

// 目前无法防止提前打开浮动窗口模式的开发者窗口

// 防开发者模式 END

window.onload = function() {
  let bodyWidth = document.body.clientWidth;
  let bodyHeight = document.body.clientHeight;

  let exploreName = getExploreName();
  let allowUA = ["Firefox", "Chrome", "Safari"];

  if (bodyHeight > bodyWidth || !IsPC()) {
    alert("本系统不支持移动端");
  } else if (bodyWidth < 1280 || bodyHeight < 660) {
    // alert("由于您的网页分辨率过低，该系统暂不支持您的设备");
  } else if (allowUA.indexOf(exploreName) === -1) {
    alert("本网站暂不支持您的浏览器");
  }
};

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
