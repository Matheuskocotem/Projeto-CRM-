import {
  createContact,
  destroyContact,
  getContacts,
  updateContact,
} from "@/services/HttpService";

export default {
  async getContacts({ commit, rootState }) {
    try {
      const token = rootState.user.token;
      //devo passar o id do stage e o id do funnel
      const response = await getContacts(funnel_id, stage_id, token);
      commit("setContacts", response.data);
    } catch (error) {
      console.log(error.response.data.message);
    }
  },
  async createContact({ commit, rootState },funnel_id, stage_id, contact) {
    try {
      const token = rootState.user.token;
      const response = await createContact(funnel_id, stage_id, contact, token);
      commit("addContact", response.data);
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
    }
  },
};