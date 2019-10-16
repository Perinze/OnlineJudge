const state = {
    isLogin: false,
    userId: null,
    nick: null,
    desc: null,
    avator: null,
    acCnt: null,
    waCnt: null
};

const getters = {
    isLogin: state => state.isLogin,
    userInfo: state => {
        return {
            userId: state.userId,
            nick: state.nick,
            desc: state.desc,
            avator: state.avator,
            acCnt: state.acCnt,
            waCnt: state.waCnt
        }
    }
};

const mutations = {
    userStatus(state, flag) {
        state.isLogin = flag;
    },
    userData(state, data) {
        state.userId = data.userId;
        state.nick = data.nick;
        state.desc = data.desc==null?'null':data.desc;
        state.avator = data.avator==undefined?'../../assets/media/avator.png':data.avator;
        state.acCnt = data.acCnt;
        state.waCnt = data.waCnt;
    }
};

const actions = {
    userLogin({ commit }, flag) {
        commit("userStatus", flag);
    },
    userInfoStorage({ commit }, data) {
        commit("userData", data);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}