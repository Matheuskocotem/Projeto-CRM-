import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import user from "./modules/user"
import funnels from "./modules/funnels";
import stages from "./modules/stages";
import contacts from "./modules/contacts";

const state = createPersistedState({
  paths: ["user.user", "user.token"]
})

export default createStore({
  modules: {
    user,
    funnels,
    stages,
    contacts
  },
  plugins: [
    state
  ]

});
