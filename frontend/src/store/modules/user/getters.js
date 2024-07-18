export default {
    isAuth(state) {
        return !!state.token;
    },
    getToken(state) {
        return state.token;
    },
    getUser(state) {
        return state.user;
    },
    getLoading(state) {
        return state.loading;
    }
}