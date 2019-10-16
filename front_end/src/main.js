import Vue from 'vue'
import Vuex from 'vuex'
import { Carousel, CarouselItem } from 'element-ui';
import App from './App'
import 'element-ui/lib/theme-chalk/index.css';
import 'ant-design-vue/dist/antd.css';
import router from './router/router';
import store from './store';

Vue.config.productionTip = false;

Vue.use(Vuex);
Vue.use(Carousel);
Vue.use(CarouselItem);

/* eslint-disable no-new */
window.Vue = new Vue({
    el: '#app',
    render: c => c(App),
    router,
    store,
}).$mount("#app"); // VueCLI 3.0


// 登陆检测

router.beforeEach((to, from, next) => {
    let getFlag = localStorage.getItem("Flag");
    if(getFlag === "isLogin") {
        // 已经登陆
        store.state.login.isLogin = true;
        store.state.login.userId = localStorage.getItem("userId");
        store.state.login.nick = localStorage.getItem("nick");
        store.state.login.desc = localStorage.getItem("desc");
        store.state.login.avator = localStorage.getItem("avator");
        store.state.login.acCnt = localStorage.getItem("acCnt");
        store.state.login.waCnt = localStorage.getItem("waCnt");
        next();

        // if(!to.meta.isLogin) {
        //     // 已经登陆过
        //     console.log("已经登陆");
        // }
    }else{
        // 未登陆
        if(to.meta.isLogin){
            next({
                path: '/main',
            });
            console.log('请登录');
        }else{
            //用户进入无需登录的界面，则跳转继续
            next()
        }
    }
});

router.afterEach(route => {
    window.scroll(0,0);
});


// 防开发者模式 BEGIN

window.onkeydown = window.onkeyup = window.onkeypress = function(event) {
    // 防止f12
    if (event.keyCode === 123) {
        event.preventDefault();
        window.event.returnValue = false;
    }
};

window.oncontextmenu = function() {
    // event.preventDefault();
    // return false;
};

let threshold = 160;
window.setInterval(function() {
    if(window.outerWidth - window.innerWidth > threshold
        || window.outerHeight - window.innerHeight > threshold
        //|| (window.console && window.console.log)
    ) {
        // alert("Please Close Develop Mode! ");
        // window.location.reload();
    }
},5e3);

// 目前无法防止提前打开浮动窗口模式的开发者窗口

// 防开发者模式 END



window.onload = function() {
    let bodyWidth = document.body.clientWidth;
    let bodyHeight = document.body.clientHeight;

    let exploreName = getExploreName();
    let allowUA = ['Firefox','Chrome','Safari'];

    if(bodyHeight>bodyWidth || !IsPC()) {
        alert("本系统不支持移动端");
    }else if(bodyWidth<1280 || bodyHeight<660) {
        // alert("由于您的网页分辨率过低，该系统暂不支持您的设备");
    }else if(allowUA.indexOf(exploreName) === -1) {
        alert("本网站暂不支持您的浏览器");
    }
};

function IsPC() {
    let userAgentInfo = navigator.userAgent;
    let Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");
    let flag = true;
    for (let v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}

function getExploreName(){
    let explorer = window.navigator.userAgent ;
    let ua = window.navigator.userAgent;
    let isSafari = ua.indexOf("Safari") != -1 && ua.indexOf("Version") != -1;
    //判断是否为IE浏览器
    if (explorer.indexOf("MSIE") >= 0) {
        return 'IE';
    }
    //判断是否为Firefox浏览器
    else if (explorer.indexOf("Firefox") >= 0) {
        return 'Firefox';
    }
    //判断是否为Chrome浏览器
    else if(explorer.indexOf("Chrome") >= 0){
        return 'Chrome';
    }
    //判断是否为Opera浏览器
    else if(explorer.indexOf("Opera") >= 0){
        return 'Opera';
    }
    //判断是否为Safari浏览器
    else if(isSafari){
        return 'Safari';
    }else return 'Unknown';
}