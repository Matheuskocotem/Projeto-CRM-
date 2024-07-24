export default {
    clearFunnels(state) {
        state.funnels = {};
    },
    setFunnels(state, funnels){
        state.funnels = funnels;
    },
    setLoading(state, isLoading){
        state.loading = isLoading;
    },
    addFunnel(state, funnel) {
        state.funnels[funnel.id] = funnel;
    },
    deleteFunnel(state, funnelId){
        Vue.delete(state.funnels, funnelId);
    }
}