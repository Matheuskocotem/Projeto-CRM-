<template>
  <div>
    <div class="d-flex flex-row align-items-center justify-content-between">
      <h4 style="font-family: grotesque">
        {{ funnel?.name }}
      </h4>
      <font-awesome-icon
        :icon="['far', 'trash-can']"
        data-bs-toggle="modal"
        :data-bs-target="'#modalDelete' + funnel?.id"
        class="trash"
      />
    </div>
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
              @click="funnelDelection(funnel)"
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
// TERMINAR DE COMPONENTIZAR ISTO
export default {
    name: "DeleteFunnelModal",
    data() {
        return {
            funnel: this.funnel
        }
    },
    props: {
        funnel: {
            type: Object,
            required: true,
        }
    },
    methods: {
        deleteFunnel() {
            this.$emit("deleteFunnel", {
                funnel: this.funnel
            })
        }
    }
}
</script>
