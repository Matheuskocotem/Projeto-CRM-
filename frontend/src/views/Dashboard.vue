<template>
  <div>
    <div id="upper-bar">
      <img src="../assets/vencedor/Plus3cLogo.jpeg" alt="logo">
      <div id="tools">
        <button type="button" class="btn btn-primary" @click="CreateFunnel">Criar Funil</button>
      </div>
    </div>
    <Animation />
  </div>
</template>

<script>
import Error from "@/components/Error.vue";
import Animation from "@/components/Animation.vue";
import { useToast } from "vue-toastification";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      errorMessage: "",
    };
  },
  computed: {
    ...mapGetters(['isAuth']),
  },
  components: {
    Error,
    Animation
  },
  methods: {
    showError(errorMessage) {
      const toast = useToast();
      toast.error({
        component: Error,
        props: {
          errorMessage
        },
      });
    },
  },
  verifyAuth(errorMessage) {
    if (!this.isAuth) {
      this.showError(errorMessage);
    }
  }
};
</script>

<style></style>
