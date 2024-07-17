import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";

export default createStore({
  state: {
    token: null,
  },
  getters: {
    isAuth(state){
      return !!state.token;
    },
    getToken(state){
      return state.token;
    }
  },
  mutations: {
    setToken(state, token){
      state.token = token;
    },
    clearToken(state){
      state.token = null;
    }
  },
  actions: {
    saveToken({ commit }, token){
      commit('setToken', token);
    },
    removeToken({ commit }){
      ('clearToken');
    }
  },
  modules: {},
  plugins: [
    createPersistedState()
  ]
});
