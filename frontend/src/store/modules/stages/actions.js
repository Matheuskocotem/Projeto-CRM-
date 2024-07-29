import {
  createStage,
  destroyStage,
  getStages,
  updateStage,
} from "@/services/HttpService";

export default {
  async setStages({ commit, rootState }, funnel_id) {
    try {
      const token = rootState.user.token;
      const response = await getStages(funnel_id, token);
      commit("setStages", response.data);
    } catch (error) {
      console.log(error);
    }
  },
  async createStage({ commit, rootState }, stage) {
    try {
      const token = rootState.user.token;
      const funnel_id = rootState.funnel.id;
      const response = await createStage(funnel_id, stage, token);
      commit("addStage", response.data);
      return response.data;
    } catch (error) {
      console.log(error.response.data.message);
    }
  },
  async updateStage({ commit, rootState }, stage) {
    try {
      const token = rootState.user.token;
      const funnel_id = rootState.funnel.id;
      const stage_id = stage.id;
      const response = await updateStage(funnel_id, stage, token, stage_id);
      commit("updateStage", response.data);
      return response;
    } catch (error) {
      console.log(error.response.data.message);
    }
  },
  async deleteStage({ commit, rootState }, stage) {
    try {
      const token = rootState.user.token;
      const funnel_id = rootState.funnel.id;
      const stage_id = stage.id;
      await destroyStage(funnel_id, stage_id, token);
      commit("deleteStage", stage);
    } catch (error) {
      console.log(error.response.data.message);
    }
  },
};