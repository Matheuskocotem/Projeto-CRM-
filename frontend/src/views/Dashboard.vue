<template>
    <nav class="navbar navbar-expand-lg">
        <div class="collapse navbar-collapse flex-fill" id="navbarSupportedContent">
          <img src="../assets/vencedor/Plus3cLogo.jpeg" alt="logo" />
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Bem vindo. {{ name }}</a>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Dropdown
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a class="dropdown-item" href="#">Something else here</a>
                </li>
              </ul>
            </li>
          </ul>
          <form class="d-flex mx-3" role="search">
            <InputForm
              :type="search"
              v-model="SearchRequest"
              placeholder="Search"
              aria-label="Search"

            />
            <button class="btn btn-outline-success">
              Search
            </button>
            <button
            type="button"
            class="btn btn-primary w-100 mx-3"
            @click="CreateFunnel"
          >
            Criar Funil
          </button>
          </form>
        </div>
        <button @click="logoutzada">Sair</button>
    </nav>
</template>
  
<script>
import Error from "@/components/Error.vue";
import InputForm from "@/components/InputForm.vue";
import { useToast } from "vue-toastification";
import { mapActions, mapGetters } from "vuex";

export default {
  data() {
    return {
      name: "",
      errorMessage: "",
      SearchRequest: "",
    };
  },
  computed: {
    ...mapGetters("user", ["getUser"]),
  },
  created() {
    console.log(this.getUser);
    this.name = this.getUser.name
  },
  components: {
    Error,
    InputForm
  },
  methods: {
    ...mapActions("user", ["logout"]),
    logoutzada() {
      this.logout();
      this.$router.push('/login');
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
  },
};
</script>

<style>
img {
  width: 70px;
  height: 70px;
}

.navbar {
  --bs-navbar-padding-y: 0;
}
</style>
  
