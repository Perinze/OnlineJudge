import Vue from 'vue'
import ElementUI from 'element-ui';
import App from './App'
import 'element-ui/lib/theme-chalk/index.css';
import 'ant-design-vue/dist/antd.css';
import router from './router/router';

Vue.config.productionTip = false;

Vue.use(ElementUI);

/* eslint-disable no-new */
new Vue({
    el: '#app',
    render: c => c(App),
    router: router
}).$mount("#app"); // VueCLI 3.0

window.onload = function() {
    var bodyWidth = document.body.clientWidth;
    var bodyHeight = document.body.clientHeight;

    var exploreName = getExploreName();
    var allowUA = ['Firefox','Chrome','Safari'];

    if(bodyHeight>bodyWidth || !IsPC()) {
        alert("本系统不支持移动端");
    }else if(bodyWidth<1280 || bodyHeight<660) {
        alert("由于您的网页分辨率过低，该系统暂不支持您的设备");
    }else if(allowUA.indexOf(exploreName) === -1) {
        alert("本网站暂不支持您的浏览器");
    }
};

function IsPC() {
    var userAgentInfo = navigator.userAgent;
    var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");
    var flag = true;
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}

function getExploreName(){
    var explorer = window.navigator.userAgent ;
    var ua = window.navigator.userAgent;
    var isSafari = ua.indexOf("Safari") != -1 && ua.indexOf("Version") != -1;
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