import {
  createContact,
  destroyContact,
  getContacts,
  updateContact,
} from "@/services/HttpService";

export default {
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
