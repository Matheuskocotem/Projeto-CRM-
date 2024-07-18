import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import user from "./modules/user"

const userState = createPersistedState({
  paths: ["user.user", "user.token"]
})

export default createStore({
  modules: {
    user
  },
  plugins: [
    userState
  ]
});
