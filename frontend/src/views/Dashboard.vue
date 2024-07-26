<template>
  <div id="app-container">
    <SideBar @toggleSideBar="toggleSideBar" />
    <div class="dashboard d-flex flex-column w-100">
      <nav class="navbar" ref="nav">
        <form class="d-flex w-100 mx-4 my-3">
          <h2 class="w-50">Bem vindo, {{ name }}.</h2>
          <div class="input-group h-100 w-25">
            <button class="input-group-text mx-1">
              <font-awesome-icon :icon="['fas', 'search']" />
            </button>
            <input type="text" class="form-control" placeholder="Pesquisar" />
          </div>
          <button
            type="button"
            class="btn btn-primary h-100 w-25 mx-4"
            data-bs-toggle="modal"
            data-bs-target="#modalCreate"
          >
            <font-awesome-icon :icon="['fass', 'filter-circle-dollar']" />
            Criar Funil
          </button>
        </form>
      </nav>
      <div id="main-content" class="p-4 d-flex flex-row" ref="MainContent">
        <div
          :style="{ '--border-color': funnel?.color }"
          v-for="(funnel, id) in funnels"
          :key="id"
          class="cardFunnel d-flex flex-column p-2 mx-3 mb-3"
        >
        </div>
      </div>
      <CreateFunnelModal
        :funnelName="funnelName"
        :funnelColor="funnelColor"
        @createFunnel="createFunnel"
      />
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import { useToast } from "vue-toastification";
import Error from "@/components/Error.vue";
import Success from "@/components/Success.vue";
import SideBar from "@/components/SideBar.vue";
import InputForm from "@/components/InputForm.vue";
import CreateFunnelModal from "@/components/CreateFunnelModal.vue";
import DeleteFunnelModal from "@/components/DeleteFunnelModal.vue";

export default {
  data() {
    return {
      errorMessage: "",
      successMessage: "",
      name: "",
      funnelName: "",
      funnelColor: "#212529",
      SearchRequest: "",
      funnels: {},
    };
  },
  computed: {
    ...mapGetters("user", ["getUser", "isAuth"]),
    ...mapGetters("funnels", ["getFunnels"]),
  },
  async created() {
    await this.setFunnels();
    this.funnels = this.getFunnels;
    this.name = this.getUser.name;
  },
  components: {
    Error,
    SideBar,
    InputForm,
    CreateFunnelModal,
    DeleteFunnelModal,
  },
  methods: {
    ...mapActions("user", ["logout"]),
    ...mapActions("funnels", ["saveFunnel", "setFunnels", "deleteFunnel"]),
    async createFunnel(funnel) {
      const response = await this.saveFunnel(funnel);
      if (response.status == 201) {
        this.showSuccess("Funil criado com sucesso!");
      } else {
        this.showError(response[0]);
      }
    },
    async funnelDelection(funnel) {
      try {
        await this.deleteFunnel(funnel);
        this.$refs.CloseDeleteModal.click();
        this.showSuccess("Funil deletado com sucesso.");
      } catch (error) {
        this.showError(error.message);
      }
    },
    toggleSideBar(expanded) {
      if (expanded) {
        this.$refs.MainContent.style.marginLeft = "200px";
        this.$refs.nav.style.marginLeft = "200px";
      } else {
        this.$refs.MainContent.style.marginLeft = "75px";
        this.$refs.nav.style.marginLeft = "75px";
      }
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
  },
};
</script>

<style scoped lang="scss">
#app-container {
  display: flex;
  height: 100vh;
  flex-direction: column;
  color: #212529;
}

#main-content {
  margin-left: 70px;
  transition: margin-left 0.5s;
  overflow: hidden;
  flex-wrap: wrap;
}

.cardFunnel {
  position: relative;
  display: inline-block;
  width: 20%;
  min-width: 200px;
  height: 130px;
  border-left: solid 6px var(--border-color);
  border-bottom: solid 6px var(--border-color);
  border-top: solid 1px var(--border-color);
  border-right: solid 1px var(--border-color);
  border-radius: 12px;
}

.trash {
  margin-top: -10px;
  display: none;
  position: absolute;
  right: 0;
  margin-right: 8px;
  cursor: pointer;
}

.cardFunnel:hover .trash {
  display: block;
}

.trash:hover {
  color: red;
}

img {
  width: 75px;
  height: 75px;
}

.navbar {
  --bs-navbar-padding-y: 0;
  transition: margin-left 0.5s;
  margin-left: 70px;
  height: 75px;
}

.form-control:focus {
  outline: none;
  box-shadow: none;
}

h2 {
  font-family: "grotesque";
  margin-bottom: 0 !important;
  display: inherit;
  margin-top: 5px;
}

.form-control:focus {
  outline: none;
  box-shadow: none;
}

.input-group
  > :not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(
    .valid-feedback
  ):not(.invalid-tooltip):not(.invalid-feedback),
.input-group-text {
  border-radius: 0.375rem !important;
}
</style>
  
