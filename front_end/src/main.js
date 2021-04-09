import Vue from "vue";
import Vuex from "vuex";
// 按需引入element-ui
import {
  Carousel,
  CarouselItem,
  Message,
  Table,
  TableColumn,
  Form,
  FormItem,
  DatePicker,
  Pagination,
  Notification,
} from "element-ui";

import App from "./App";
import router from "./router/router";
import store from "./store";
import loadingPlugin from "./plugins/loading";
import notifyPlugin from "./plugins/notify";
import codemirror from "vue-codemirror-lite";
import { judgeWap } from "./utils";
import { checkLogin, logout } from "./api/login"

Vue.config.productionTip = false;

// Element-ui-Message add Install function to mount
Message.install = function(Vue) {
  Vue.prototype.$message = Message;
  Vue.prototype.$notify = Notification;
};
// echarts
// Vue.prototype.$echarts = echarts;

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
Vue.use(Pagination);
Vue.use(Notification);
Vue.use(codemirror);
Vue.use(loadingPlugin, {
  progressColor: "#4288ce",
});
Vue.use(notifyPlugin);

/* eslint-disable */
new Vue({
  render: (c) => c(App),
  router,
  store,
}).$mount("#app"); // VueCLI 3.0

// 登陆检测

router.beforeEach((to, from, next) => {
  /*let isLogin = store.state.login.isLogin;*/
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
    //已登录、未缓存
    /*let resp = checkLogin();
    if(resp.status == 0){
      logout();
    }*/
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
  /*if(isLogin != true) {
    if (to.meta.isLogin){
      next(false);
      Vue.prototype.$message({
        message: "请先登录",
        type: "error",
      })
    } else {
      next();
    }
  }*/
});

router.afterEach((route) => {
  window.scroll(0, 0);
});

// 判断isWap

window.onload = () => {
  window.isWap = judgeWap();
}

window.onresize = () => {
  window.isWap = judgeWap();
}
