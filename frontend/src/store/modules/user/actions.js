import { login, register, resetPassword } from "@/services/HttpService";
import Error from "@/components/Error.vue";
import Success from "@/components/Success.vue";
import { useToast } from "vue-toastification";

export default {
  saveToken({ commit }, token) {
    commit("setToken", token);
  },
  removeToken({ commit }) {
    commit("clearToken");
  },
  removeAuthUser({ commit }) {
    commit("clearUser");
  },
  setLoading({ commit }, loading) {
    commit("setLoading", loading);
  },
  async login({ commit }, user) {
    try {
      const response = await login(user.email, user.password);

      commit("setUser", response.data.AuthUser);
      commit("setToken", response.data.access_token);

      return response.status;
    } catch (error) {
      return error.response.data.message;
    }
  },
  logout({ commit }) {
    commit("clearToken");
    commit("clearUser");
  },
  async register({ commit }, user) {
    try {
      const response = await register(
        user.name,
        user.email,
        user.password,
        user.password_confirmation,
        user.documentType,
        user.documentNumber
      );
      return response.status;
    } catch (error) {
      const firstErrorKey = Object.keys(error.response.data)[0];
      return error.response.data[firstErrorKey];
    }
  },
  async resetPassword({ commit }, email) {
    try {
      const response = await axios.post("/api/resetPassword/{token}", {
        email,
      });
      return response.status;
    } catch (error) {
      console.error("Erro ao enviar link de redefinição de senha:", error);
      throw error;
    }
  },
  showError({ commit }, errorMessage) {
    const toast = useToast();
    toast.error({
      component: Error,
      props: {
        errorMessage,
      },
    });
  },
  showSuccess({ commit }, successMessage) {
    const toast = useToast();
    toast.success({
      component: Success,
      props: {
        successMessage,
      },
    });
  },
};
