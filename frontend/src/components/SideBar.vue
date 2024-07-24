<template>
  <div
    ref="sidebar"
    id="sidebar"
    class="d-flex flex-column position-fixed"
    @mouseover="expand"
    @mouseout="collapse"
  >
    <div id="img" class="d-flex">
      <img src="../assets/vencedor/logo-3C.svg" class="my-2 mx-1" alt="logo" />
    </div>
    <p class="icon-text my-4 mx-2">
      <font-awesome-icon class="icon" :icon="['fas', 'phone']" /> Discadora
    </p>
    <p class="icon-text my-2 mx-2">
      <font-awesome-icon class="icon" :icon="['fas', 'chart-bar']" /> CRM
    </p>
    <p class="icon-profile mt-auto mx-2" @click="loggingOut">
      <font-awesome-icon class="icon" :icon="['far', 'user']" /> Perfil
    </p>
    <!-- @click="loggingOut" -->
  </div>
</template>

<script>
import { useToast } from 'vue-toastification';
import { mapActions } from 'vuex';
import Error from './Error.vue';
import Success from './Success.vue';


export default {
  name: "SideBar",
  components: {
    Error,
    Success
  },  
  data() {
    return {
      sideBarExpanded: false,
    };
  },
  methods: {
    ...mapActions("user", ["logout"]),
    ...mapActions("funnels", ["clearFunnels"]),
    expand() {
      this.sideBarExpanded = true;
      this.$refs.sidebar.style.width = "200px";
      this.$emit('toggleSideBar', true);
    },
    collapse() {
      this.sideBarExpanded = false;
      this.$refs.sidebar.style.width = "75px";
      this.$emit('toggleSideBar', false);
    },
    showError(errorMessage) {
      const toast = useToast();
      toast.error({
        component: Error,
        props: {
          errorMessage,
        },
      });
    },
    showSuccess(successMessage) {
      const toast = useToast();
      toast.success({
        component: Success,
        props: {
          successMessage,
        },
      });
    },
    async loggingOut() {
      try {
        await this.logout();
        await this.clearFunnels();
        this.$router.push({ name: "login" });
        this.showSuccess("Deslogado com sucesso.");
      } catch (error) {
        this.showError("Erro ao deslogar.");
      }
    },
  },
};
</script>

<style lang="scss">
#img {
  justify-content: center;
  align-items: center;
  background-color: #FFBB3A;
  height: 75px;
  img {
    width: 75%;
    height: 60px;
  }
}

.icon {
  margin-right: 27px;
  margin-left: 17px;
}

.icon-text:hover,
.icon-profile:hover,
.icon:hover {
  cursor: pointer;
  color: rgb(48, 87, 242);
}

.icon-text,
.icon-profile {
  display: flex;
  font-size: 20px;
}

.icon {
  font-size: 25px;
}

#sidebar {
  color: #677c92;
  height: 100%;
  width: 75px;
  transition: 0.5s;
  overflow-x: hidden;
  white-space: nowrap;
  position: fixed;
  z-index: 1000;
  box-shadow: -10px 0 30px -2px rgba(0, 0, 0, 0.5);
}

.icon-profile {
  margin-top: auto;
}
</style>