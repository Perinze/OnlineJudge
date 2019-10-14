const state = {
    isLogin: false,
    userId: null,
    nick: null,
    desc: null,
    avator: null,
    acNum: null,
    waNum: null
};

const getters = {
    isLogin: state => state.isLogin,
    userInfo: state => {
        return {
            userId: state.userId,
            nick: state.nick,
            desc: state.desc,
            avator: state.avator,
            acNum: state.acNum,
            waNum: state.waNum
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
        state.desc = data.desc;
        state.avator = data.avator;
        state.acNum = new Number(data.acNum);
        state.waNum = new Number(data.waNum);
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