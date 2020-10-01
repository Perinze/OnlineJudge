const state = {
  isShowTopnav: true,
};

const mutations = {
  updateIsShowTopnav(state, isShow) {
    state.isShowTopnav = isShow;
  },
};

const actions = {
  changeIsShowTopnav({ commit }, isShow) {
    commit("updateIsShowTopnav", isShow);
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
