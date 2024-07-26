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
          class="header d-flex mx-4 my-1 align-items-center justify-content-between"
        >
          <h1 class="fs-4 fw-bold mt-3" style="font-family: grotesque">
            Crie aqui novas oportunidades!
          </h1>
          <button
            type="button"
            class="btn-close fs-6"
            data-bs-dismiss="modal"
            aria-label="Close"
            ref="CloseModal"
          ></button>
        </div>
        <div
          class="d-flex flex-column justify-content-center align-items-center modal-body"
        >
          <InputForm
            class="my-2 w-75"
            type="text"
            v-model="funnelNameComp"
            placeholder="Nome do funil"
            id="name"
            label="Nome do funil"
          />
          <div class="colorInput d-flex mt-3 justify-content-center">
            <span class="fs-5 mx-2">Escolha a cor do seu funil! </span>
            <font-awesome-icon
              class="mt-1 fs-5"
              :icon="['fas', 'fill-drip']"
            /><input type="color" class="mx-3" v-model="funnelColorComp" />
          </div>
        </div>
        <div
          class="d-flex flex-column align-items-center justify-content-center mb-4"
        >
          <button
            type="button"
            class="w-50 btn btn-primary mx-1 my-1"
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
