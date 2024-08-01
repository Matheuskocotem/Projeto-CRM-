<template>
  <div id="app-container">
    <SideBar @toggleSideBar="toggleSideBar" />
    <navBar ref="NavBar" :expanded="expanded"  @createFunnel="createFunnel"/>
    <div id="main-content" class="p-4 d-flex flex-row" ref="MainContent">
      <CardFunnel
        v-for="funnel in getFunnels"
        :funnel="funnel"
        :key="funnel.id"
        @deleteFunnel="funnelDelection"
      />
    </div>
    <Pagination />
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
import NavBar from "@/components/navBar.vue";
import CardFunnel from "@/components/CardFunnel.vue";
import Pagination from "@/components/Pagination.vue";

export default {
  data() {
    return {
      name: "",
      funnelName: "",
      funnelColor: "#212529",
      SearchRequest: "",
      expanded: false,
    };
  },
  computed: {
    ...mapGetters("user", ["isAuth"]),
    ...mapGetters("funnels", ["getFunnels"]),
  },
  async created() {
    await this.setFunnels();
  },
  components: {
    Error,
    SideBar,
    NavBar,
    InputForm,
    CardFunnel,
    CreateFunnelModal,
    DeleteFunnelModal,
    Pagination,
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
        this.showSuccess("Funil deletado com sucesso.");
      } catch (error) {
        this.showError(error.message);
      }
    },
    toggleSideBar(expanded) {
      if (expanded) {
        this.$refs.MainContent.style.marginLeft = "200px";
        this.$refs.NavBar.$el.style.marginLeft = "200px";
      } else {
        this.$refs.MainContent.style.marginLeft = "75px";
        this.$refs.NavBar.$el.style.marginLeft = "75px";
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
</style>
