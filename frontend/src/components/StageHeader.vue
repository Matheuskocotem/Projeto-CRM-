<template>
  <div class="stage-header d-flex justify-content-between w-100 mt-2">
    <OffCanvasContact
      :funnel="funnel"
      :stage_id="stage.id"
      @updateContact="updateContact"
    />
    <DeleteStageModal :stage="stage" @updateStages="updateStage"/>
    <h1 class="w-100 mt-1 fs-6 mx-2" style="font-weight: bold;">
      {{ stage.name }}
    </h1>
    <font-awesome-icon
      class="dropdown-toggle mx-2"
      data-bs-toggle="dropdown"
      aria-expanded="false"
      style="width: 5px; height: 20px; color: #6e8398; cursor: pointer"
      :icon="['fas', 'ellipsis-vertical']"
    />
    <div class="btn-group dropup">
      <div class="dropdown-menu">
        <button
          type="button"
          class="dropItem btn w-100"
          data-bs-toggle="offcanvas"
          :data-bs-target="'#offcanvasRight' + stage.id"
          aria-controls="offcanvasRight"
        >
          <font-awesome-icon class="mx-1" :icon="['fas', 'user-plus']" />
          Criar contato
        </button>
        <button
          type="button"
          class="dropItem btn w-100"
          data-bs-toggle="modal"
          :data-bs-target="'#modalDelete' + stage.id"
        >
          <font-awesome-icon
            style="margin-right: 6px"
            :icon="['far', 'trash-can']"
          />
          Deletar Etapa
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import OffCanvasContact from './OffCanvasContact.vue';

export default {
  name: "StageHeader",
  components: {
    OffCanvasContact
  },
  props: {
    stage: {
      type: Object,
      required: true,
    },
    funnel: {
      type: Object,
      required: true,
    },
  },
  methods: {
    updateContact(){
      this.$emit("updateContact");
    }
  }
};
</script>
