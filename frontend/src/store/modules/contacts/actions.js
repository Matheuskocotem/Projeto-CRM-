import {
  createContact,
  destroyContact,
  getContacts,
<<<<<<< HEAD
=======
  swap,
  swapBetweenPhases,
>>>>>>> origin/main
  updateContact,
} from "@/services/HttpService";

export default {
<<<<<<< HEAD
  async setContacts({ commit, rootState }, params) {
    try {
      const token = rootState.user.token;
      const response = await getContacts(
        params.funnel_id,
        params.stage_id,
        token
      );
      commit("addContact", response.data);
    } catch (error) {
      console.log(error.response.data.message);
    }
  },
  async createContact({ commit, rootState }, params) {
    try {
      const token = rootState.user.token;
      const response = await createContact(
        params.funnel_id,
        params.stage_id,
        params.contact,
        token
      );
      commit("addContact", response.data);
=======
  async swapBetweenPhases({ rootState }, { funnel_id, contact_id, changes }) {
    try {
      const token = rootState.user.token;
      await swapBetweenPhases(funnel_id, contact_id, changes, token);
    } catch(error) {
      console.log(error);
    }
  },
  async swap({ rootState }, { funnel_id, contact_id, changes }){
    try {
      const token = rootState.user.token;
      await swap(funnel_id, contact_id, changes, token);
    } catch (error) {
      console.log(error);
    }
  },
  async refreshContacts({ rootState }, funnel_id) {
    try {
      const token = rootState.user.token;
      await getContacts(funnel_id, token);
    } catch(error){
      console.log(error);
    }
  },
  async setContacts({ commit, rootState }, funnel_id) {
    try {
      const token = rootState.user.token;
      const response = await getContacts(funnel_id, token);
      commit("setContacts", response.data);
    } catch (error) {
      console.log(error);
    }
  },
  async createContact({ commit, rootState }, { funnel_id, contact }) {
    try {
      const token = rootState.user.token;
      await createContact(funnel_id, contact, token);
      commit("addContact", contact);
>>>>>>> origin/main
    } catch (error) {
      console.log(error.response.data.message);
    }
  },
  async updateContact({ commit, rootState }, contact) {
    try {
      const token = rootState.user.token;
      const funnel_id = rootState.funnel.id;
      const stage_id = rootState.stage.id;
      const contact_id = contact.id;
      const response = await updateContact(
        funnel_id,
        stage_id,
        contact,
        contact_id,
        token
      );
      commit("updateContact", response.data);
    } catch (error) {
      console.log(error.response.data.message);
    }
  },
  async destroyContact({ commit, rootState }, contact) {
    try {
      const token = rootState.user.token;
      const funnel_id = rootState.funnel.id;
      const stage_id = rootState.stage.id;
      const contact_id = contact.id;
      await destroyContact(funnel_id, stage_id, contact_id, token);
      commit("deleteContact", contact);
    } catch (error) {
      console.log(error.response.data.message);
<<<<<<< HEAD
    } 
=======
    }
>>>>>>> origin/main
  },
};
