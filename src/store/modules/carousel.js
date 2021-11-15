import util, { deepClone } from "../../utils"
const state = {
    carousel: null
}

const getters = {
    carousel: (state) => {
        return state.carousel;
    }
}

const mutations = {
    carousel(state, data){
        state.carousel = deepClone(data);
    }
}

const actions = {
    carousel({ commit }, data){
        commit("carousel", data);
    }
}

export default {
    namespace: true,
    state,
    getters,
    mutations,
    actions
}