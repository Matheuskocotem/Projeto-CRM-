import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import user from "./modules/user"
import funnels from "./modules/funnels";
import kanban from "./modules/kanban";

const state = createPersistedState({
  paths: ["user.user", "user.token"]
})

export default createStore({
  modules: {
    user,
    funnels,
    kanban  
  },
  plugins: [
    state
  ]

});
