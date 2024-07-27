<template>
  <div
    :style="{ '--border-color': funnel?.color }"
    class="cardFunnel d-flex flex-column p-2 mx-3 mb-3"
    @click="goToFunnel()"
  >
    <div
      class="d-flex flex-row align-items-center justify-content-between w-100"
    >
      <h4 class="w-50" style="font-family: grotesque">

        {{ funnel?.name }}
      </h4>
      <font-awesome-icon
        :icon="['far', 'trash-can']"
        data-bs-toggle="modal"
        :data-bs-target="'#modalDelete' + funnel.id"
        class="trash"
        @click.stop
      />
      <DeleteFunnelModal :funnel="funnel" @deleteFunnel="funnelDelection" />
    </div>
  </div>
</template>

<script>
import DeleteFunnelModal from "./DeleteFunnelModal.vue";

export default {
  name: "CardFunnel",
  components: {
    DeleteFunnelModal,
  },
  props: {
    funnel: {
      type: Object,
      required: true,
    },
  },
  methods: {
    goToFunnel() {
      this.$router.push({
        name: "Funil",
        params: {
          name: this.funnel.name,
          id: this.funnel.id,
        },
      });
    },
    funnelDelection(funnel) {
      this.$emit("deleteFunnel", funnel);
    },
  },
};
</script>

<style scoped lang="scss">
.cardFunnel {
  position: relative;
  display: inline-block;
  width: 20%;
  min-width: 200px;
  height: 130px;
  border-left: solid 6px var(--border-color);
  border-bottom: solid 6px var(--border-color);
  border-top: solid 1px var(--border-color);
  border-right: solid 1px var(--border-color);
  border-radius: 12px;
}

.trash {
  margin-top: -10px;
  display: none;
  position: absolute;
  right: 0;
  margin-right: 8px;
  cursor: pointer;
}

.cardFunnel:hover .trash {
  display: block;
}

.trash:hover {
  color: red;
}
</style>
