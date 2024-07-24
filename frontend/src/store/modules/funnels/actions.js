import { createFunnel, getFunnels, destroyFunnel } from "@/services/HttpService";

export default {
    async clearFunnels ({commit}){
        commit('clearFunnels')
    },
    async saveFunnel({ commit, rootState }, funnel){
        try {
            const token = rootState.user.token;
            const response = await createFunnel(funnel, token);
            commit('addFunnel', response.data);
            return response;
        } catch(error) {
            return error.response.data.message;
        }
    },
    async deleteFunnel({ commit, rootState }, funnel){
        try {
            const token = rootState.user.token;
            await destroyFunnel(funnel.id, token);
            commit('deleteFunnel', funnel.id);
            return response;
        } catch(error) {
            error.response.data.message;
        }
    },
    async setFunnels({ commit, rootState }){
        try {
            const token = rootState.user.token;
            const funnels = await getFunnels(token);
            commit('setFunnels', funnels.data.data);
        } catch (error){
            error.response.data.message;
        }
    }
}