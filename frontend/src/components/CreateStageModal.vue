<template>
  <div>
    <div
      class="modal fade"
      id="CreateStageModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5 fw-bolder">Criar nova Etapa</h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              ref="CloseStageModal"
            ></button>
          </div>
          <div
            class="modal-body d-flex flex-column align-items-center justify-content-center"
          >
            <h1 class="fs-4 fw-bolder mt-4 mb-3">
              Se organize, padronize e otimize.
            </h1>
            <InputForm
              class="my-2 w-50"
              type="text"
              v-model="StageName"
              placeholder="Nome da Etapa"
              id="name"
              label="Nome da Etapa"
            />

            <button
              type="button"
              class="btn btn-primary mb-4 mt-3"
              style="width: 60%"
              @click="sendStage"
            >
              Criar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import InputForm from "./InputForm.vue";

export default {
  name: "DeleteFunnelModal",
  data() {
    return {
      StageName: "",
    };
  },
  components: {
    InputForm,
  },
  props: {
    funnel: {
      type: Object,
      required: true,
    },
  },
  computed: {
    ...mapGetters("stages", ["getStages"]),
  },
  methods: {
    ...mapActions("stages", ["createStage"]),
    ...mapActions("user", ["showError", "showSuccess"]),
    async sendStage() {
      const response = await this.createStage({
        funnel_id: this.funnel.id,
        stage: {
          name: this.StageName,
          order: this.getStages.length + 1,
        },
      });
      if (response == 201) {
        this.$emit("updateStages");
        this.showSuccess("Etapa criada com sucesso!");
        this.$refs.CloseStageModal.click();
      } else {
        this.showError("Erro ao criar etapa!");
      }
    },
  },
};
</script>

<style scoped>
.btn-close {
  font-size: 12px;
}

.modal {
  --bs-modal-width: 45%;
  --bs-modal-padding: 0 !important;
}
</style>
