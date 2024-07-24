export default {
    setUser(state, user) {
        state.user = user
    },
    setLoading(state, isLoading) {
        state.loading = isLoading;
    },
    setToken(state, token) {
        state.token = token;
    },
    clearToken(state) {
        state.token = null;
    },
    clearUser(state) {
        state.user = {};
    }
}