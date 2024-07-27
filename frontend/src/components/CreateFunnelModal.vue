<template>
  <div
    class="modal fade"
    id="modalCreate"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div
          class="modal-header d-flex mx-1 align-items-center justify-content-between"
        >
          <h1 class="fs-5 fw-bolder mt-3" style="font-family: CerebriSans">
            Crie aqui novas oportunidades!
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
            ref="CloseModal"
          ></button>
        </div>
        <div
          class="d-flex flex-row justify-content-center align-items-center modal-body"
        >
          <div class="w-50 mx-3 d-flex flex-column align-items-center justify-content-center">
            <h1 class="fs-5 fw-bolder mt-4">Qual o nome do seu funil?</h1>
            <InputForm
              class="mt-1 mb-2"
              type="text"
              v-model="funnelNameComp"
              placeholder="Nome do funil"
              id="name"
              label="Nome do funil"
            />
          </div>
          <div class="colorInput mx-4 d-flex flex-column mt-3 align-items-center justify-content-center">
            <h1 class="fs-5 fw-bolder mx-2"
              >Escolha a cor do seu funil!
            </h1>
            <div class="mx-3">
            <font-awesome-icon class="fs-4 mb-1" :icon="['fas', 'fill-drip']" />
            <input
              type="color"
              class="mx-3"
              v-model="funnelColorComp"
            />
          </div>
          </div>
        </div>
        <div
          class="d-flex flex-column align-items-center justify-content-center mb-4"
        >
        <button
        type="button"
        class="w-50 btn btn-light mx-1 mt-2"
        data-bs-dismiss="modal"
        >
        Fechar
      </button>
      <button
        type="button"
        class="w-50 btn btn-primary mx-1 mt-2"
        @click="createFunnel"
      >
        Criar Funil
      </button>
    </div>
      </div>
    </div>
  </div>
</template>

<script>
import InputForm from "./InputForm.vue";

export default {
  name: "CreateFunnelModal",
  data() {
    return {
      funnelNameComp: this.funnelName,
      funnelColorComp: this.funnelColor,
    };
  },
  components: {
    InputForm,
  },
  props: {
    funnelName: {
      type: String,
      required: true,
    },
    funnelColor: {
      type: String,
      required: true,
    },
  },
  methods: {
    createFunnel() {
      this.$refs.CloseModal.click();
      this.$emit("createFunnel", {
        name: this.funnelNameComp,
        color: this.funnelColorComp,
      });
    },
  },
};
</script>

<style scoped>
.btn-close {
  font-size: 12px;
}

.modal {
  --bs-modal-width: 55%;
  --bs-modal-padding: 0 !important;
}
</style>
