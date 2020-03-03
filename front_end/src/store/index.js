import Vue from 'vue';
import Vuex from 'vuex';
import login from './modules/login';
import ui from './modules/ui';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        login,
        ui
    },
})