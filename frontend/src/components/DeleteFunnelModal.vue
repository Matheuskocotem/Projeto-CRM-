<template>
  <div>
    <div
      class="modal fade"
      :id="'modalDelete' + funnel?.id"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5 fw-bolder">Excluir Funil</h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              ref="CloseDeleteModal"
            ></button>
          </div>
          <div
            class="modal-body d-flex flex-column align-items-center justify-content-center"
          >
            <h1 class="fs-4 fw-bolder">
              Tem certeza que deseja excluir este funil?
            </h1>
            <p>A ação não poderá ser desfeita.</p>

            <button
              type="button"
              class="btn btn-secondary w-75 my-1"
              data-bs-dismiss="modal"
            >
              Não
            </button>
            <button
              type="button"
              class="btn btn-danger w-75 my-1"
              @click="deleteFunnel(funnel)"
            >
              Sim
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DeleteFunnelModal",
  props: {
    funnel: {
      type: Object,
      required: true,
    },
  },
  methods: {
    deleteFunnel(funnel) {
      this.$emit("deleteFunnel", funnel);
      const modalElement = document.querySelector("#modalDelete" + funnel.id);
      const closeButton = modalElement.querySelector(
        '[data-bs-dismiss="modal"]'
      );
      closeButton.click();
    },
  },
};
</script>
