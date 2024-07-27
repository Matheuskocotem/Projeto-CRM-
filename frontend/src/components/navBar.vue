<template>
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
        <font-awesome-icon :icon="['fas', 'filter-circle-dollar']" />
        Criar Funil
      </button>
    </form>
    <CreateFunnelModal
      :funnelName="funnelName"
      :funnelColor="funnelColor"
      @createFunnel="createFunnel"
    />
  </nav>
</template>

<script>
import { mapGetters } from "vuex";
import CreateFunnelModal from "./CreateFunnelModal.vue";

export default {
  name: "navBar",
  data() {
    return {
      name: "",
      funnelName: "",
      funnelColor: "#212529",
    };
  },
  components: {
    CreateFunnelModal,
  },
  props: {
    expanded: {
      type: Boolean,
      required: true,
    },
  },
  computed: {
    ...mapGetters("user", ["getUser"]),
  },
  created() {
    this.name = this.getUser.name;
  },
  methods: {
    createFunnel(funnel) {
      this.$emit('createFunnel', funnel);
    }
  },
  watch: {
    expanded(newValue) {
      if (newValue) {
        this.$refs.nav.style.marginLeft = "200px";
      } else {
        this.$refs.nav.style.marginLeft = "75px";
      }
    },
  },
};
</script>

<style>
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
