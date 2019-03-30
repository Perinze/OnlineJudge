import Vue from 'vue'
import ElementUI from 'element-ui';
import App from './App'
import 'element-ui/lib/theme-chalk/index.css';
import 'ant-design-vue/dist/antd.css'

Vue.config.productionTip = false;

Vue.use(ElementUI);

/* eslint-disable no-new */
new Vue({
    render: h => h(App)
}).$mount("#app"); // VueCLI 3.0