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
            data-bs-target="#exampleModal"
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
          <h4 class="mx-2" ref="Funnel" style="font-family: grotesque">
            {{ funnel?.name }}
          </h4>
          <p class="mt-5">Value</p>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">
              Crie aqui seu funil!
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              ref="CloseModal"
            ></button>
          </div>
          <div class="modal-body">
            <InputForm
              class="my-2"
              type="text"
              v-model="FunnelName"
              placeholder="Nome"
              id="name"
              label="Nome"
            />
            <div class="colorInput d-flex mt-3 fs-5">
              <span class="inputTitle mx-2"
                >Escolha a cor de seu funil aqui!
              </span>
              <font-awesome-icon :icon="['fas', 'palette']" /><input
                type="color"
                class="mx-3"
                v-model="FunnelColor"
              />
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-center mb-4">
            <button
              type="button"
              class="w-25 mx-1 btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Fechar
            </button>
            <button type="button" class="w-25 btn btn-primary mx-1" @click="createFunnel">
              Criar Funil
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="btn-group dropup">
  <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
    Dropup
  </button>
  <ul class="dropdown-menu">
  </ul>
</div> -->
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import { useToast } from "vue-toastification";
import Error from "@/components/Error.vue";
import Success from "@/components/Success.vue";
import SideBar from "@/components/SideBar.vue";
import InputForm from "@/components/InputForm.vue";

export default {
  data() {
    return {
      errorMessage: "",
      successMessage: "",
      name: "",
      FunnelName: "",
      FunnelColor: "#212529",
      SearchRequest: "",
      funnels: {},
    };
  },
  computed: {
    ...mapGetters("user", ["getUser", "isAuth"]),
    ...mapGetters("funnels", ["getFunnels"]),
  },
  created() {
    this.funnels = this.getFunnels;
    this.name = this.getUser.name;
  },
  components: {
    Error,
    SideBar,
    InputForm,
  },
  methods: {
    ...mapActions("user", ["logout"]),
    ...mapActions("funnels", ["saveFunnel", "setFunnels", "deleteFunnel"]),
    async createFunnel() {
      const response = await this.saveFunnel({
        name: this.FunnelName,
        color: this.FunnelColor,
      });

      if (response.status == 201) {
        this.showSuccess("Funil criado com sucesso!");
        this.$refs.CloseModal.click();
      } else {
        this.showError(response[0]);
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
  width: 20%;
  min-width: 17%;
  height: 130px;
  border-left: solid 6px var(--border-color);
  border-bottom: solid 6px var(--border-color);
  border-radius: 12px;
}

.colorInput {
  align-items: center;
  justify-content: center;
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
  
