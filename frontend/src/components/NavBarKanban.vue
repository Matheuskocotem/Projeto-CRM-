<template>
  <nav class="navbar" ref="nav">
    <form class="d-flex w-100 mx-3">
      <div class="w-50 m-3">
        <p class="p text-secondary">FUNIL</p>
        <p class="fs-2" style="font-family: grotesque">{{ funnel.name }}</p>
      </div>
      <div class="input-group h-100 w-25 mt-4">
        <button class="input-group-text mx-1">
          <font-awesome-icon :icon="['fas', 'search']" />
        </button>
        <input type="text" class="form-control" placeholder="Pesquisar" />
      </div>
      <button
        type="button"
        class="btn btn-primary h-100 w-25 mx-4 mt-4"
        data-bs-toggle="modal"
        data-bs-target="#CreateStageModal"
      >
        <font-awesome-icon class="mx-2" :icon="['fas', 'chart-simple']" />
        Criar nova Etapa
      </button>
    </form>
    <CreateStageModal :funnel="funnel" @updateStages="updateStages"/>
  </nav>
</template>

<script>
import CreateStageModal from "./CreateStageModal.vue";

export default {
  name: "NavBarKanban",
  components: {
    CreateStageModal,
  },
  props: {
    funnel: {
      type: Object,
      required: true,
    },
  },
  methods: {
    updateStages() {
      this.$emit("updateStages");
    }
  }
};
</script>

<style scoped lang="scss">
.navbar {
  --bs-navbar-padding-y: 0;
  transition: margin-left 0.5s;
  margin-left: 70px;
  height: 75px;
}

p {
  margin-bottom: 0 !important;
}

.p {
  font-size: 12px;
}

.form-control:focus {
  outline: none;
  box-shadow: none;
}
</style>
