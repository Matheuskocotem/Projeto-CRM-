export default {
    haveFunnels(state){
        return !!state.funnels.length;
    },
    getFunnels(state){
        return state.funnels;
    },
    isLoading(state){
        return state.loading;
    }
}