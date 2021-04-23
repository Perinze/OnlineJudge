import util, { deepClone } from "../../utils"
const state = {
    storedData: null
  };
  
  const getters = {
    storedData: (state) => {
      return state.storedData;
    }
};
  
  const mutations = {
    storedData(state, data) {
        state.storedData = deepClone(data);
    }
  };
  
  const actions = {
    storedData({ commit }, data){
        commit("storedData", data);
    }
  };
  
  export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
  };
  