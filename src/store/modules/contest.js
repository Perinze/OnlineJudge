import util, { deepClone } from "../../utils"
const state = {
    contestInfo: null,
    contestDiscussList: null,
    contestLogList: null,
    contestList: null,
    contestListNoLogin: null
}
const getters = {
    contestInfo:(state) => {
        return state.contestInfo;
    },
    contestDiscussList:(state) => {
        return state.contestDiscussList;
    },
    contestLogList:(state) => {
        return state.contestLogList;
    },
    contestLogListNoLogin:(state) => {
        return state.contestListNoLogin;
    },
    contestList:(state) => {
        return state.contestList;
    }
}
const mutations = {
    contestInfo(state, data) {
        state.contestInfo = deepClone(data);
    },
    contestDiscussList(state, data) {
        state.contestDiscussList = deepClone(data);
    },
    contestLogList(state, data) {
        state.contestLogList = deepClone(data);
    },
    contestList(state, data) {
        state.contestList = deepClone(data);
    },
    contestLogListNoLogin:(state, data) => {
        state.contestListNoLogin = deepClone(data);
    }
}
const actions = {
    contestInfo({ commit }, data) {
        commit("contestInfo", data);
    },
    contestDiscussList({ commit }, data) {
        commit("contestDiscussList", data);
    },
    contestLogList({ commit }, data) {
        commit("contestLogList", data);
    },
    contestList({ commit }, data) {
        commit("contestList", data);
    },
    contestLogListNoLogin({ commit }, data) {
        commit('contestLogListNoLogin', data);
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
  };
  