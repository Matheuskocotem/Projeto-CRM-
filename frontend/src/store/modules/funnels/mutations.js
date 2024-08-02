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
    setPagination(state, pagination){
        state.pagination = pagination;
    },
    addFunnel(state, funnel) {
        state.funnels.push(funnel);
    },
    deleteFunnel(state, funnelId) {
        const index = state.funnels.findIndex(funnel => funnel.id === funnelId);
        if (index !== -1) {
            state.funnels.splice(index, 1);
        }
    }
}