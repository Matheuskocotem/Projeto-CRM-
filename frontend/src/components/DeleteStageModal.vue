<template>
  <div>
    <div
      class="modal fade"
      :id="'modalDelete' + stage?.id"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5 fw-bolder">Excluir Etapa</h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              ref="CloseDeleteModal"
              @click.stop
            ></button>
          </div>
          <div
            class="modal-body d-flex flex-column align-items-center justify-content-center"
          >
            <h1 class="fs-4 fw-bolder mt-5 mb-4">
              Tem certeza que deseja excluir esta Etapa?
            </h1>
            <p class="fs-6">A ação não poderá ser desfeita.</p>

            <button
              type="button"
              class="btn btn-danger w-50 mt-4"
              @click="deleteStage()"
            >
              Sim
            </button>
            <button
              type="button"
              class="btn btn-light w-50 mt-2 mb-4"
              data-bs-dismiss="modal"
            >
              Não
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DeleteStageModal",
  props: {
    stage: {
      type: Object,
      required: true,
    },
  },
  methods: {
    deleteStage() {
      const modalElement = document.querySelector("#modalDelete" + funnel.id);
      const closeButton = modalElement.querySelector(
        '[data-bs-dismiss="modal"]'
      );
      closeButton.click();
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
