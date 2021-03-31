import Vue from "vue";
import Vuex from "vuex";
import login from "./modules/login";
import ui from "./modules/ui";
import problem from "./modules/problem"
import contest from "./modules/contest"
import carousel from "./modules/carousel"
Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    login,
    ui,
    problem,
    contest,
    carousel
  },
});
