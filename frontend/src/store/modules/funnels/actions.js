import { createFunnel, getFunnels, destroyFunnel } from "@/services/HttpService";

export default {
    async clearFunnels({ commit }) {
        commit('clearFunnels')
    },
    async saveFunnel({ commit, rootState }, funnel) {
        try {
            const token = rootState.user.token;
            const response = await createFunnel(funnel, token);
            commit('addFunnel', response.data);
            return response;
        } catch (error) {
            if (error.response && error.response.data && error.response.data.message){
                return error.response.data;
            } else {
                return error.response;
            }
        }
    },
    async deleteFunnel({ commit, rootState }, funnel) {
        try {
            const token = rootState.user.token;
            await destroyFunnel(funnel.id, token);
            commit('deleteFunnel', funnel.id);
        } catch (error) {
            error.response.data.message;
        }
    },
    async setFunnels({ commit, rootState }) {
        try {
            const token = rootState.user.token;
            const funnels = await getFunnels(token);
            // const relatories = await getRelatories(token, funnels);
            commit('setFunnels', funnels.data.data);
            commit('setPagination', funnels.data.meta);
        } catch (error) {
            error.response.data.message;
        }
    },
}