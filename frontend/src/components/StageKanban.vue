<template>
  <div class="stage mx-2" style="height: 80vh; width: 22vh; overflow-y: auto">
    <OffCanvasContact
      :funnel="funnel"
      :stage_id="stage.id"
      @updateContact="updateContact"
    />
    <div
      class="bar w-100 rounded-4"
      :style="{ '--background-color': funnel.color }"
    ></div>
    <div
      class="stage-header d-flex justify-content-between align-items-center w-100 mt-1"
    >
      <h1
        class="w-75 mt-2"
        style="font-size: 15px; font-weight: 600; margin-left: 6px"
      >
        {{ stage.name }}
      </h1>
      <button
        class="border-0 rounded-2 mb-2"
        style="
          height: 30px;
          margin-right: 5px;
          background-color: #e1e9f4;
          width: 30px;
        "
        data-bs-toggle="offcanvas"
        :data-bs-target="'#offcanvasRight' + stage.id"
        aria-controls="offcanvasRight"
      >
        <span class="fs-5">+</span>
      </button>
    </div>
    <draggable
      v-model="contacts"
      group="cards"
      item-key="id"
      animation="250"
      @change="onChange"
      :data-stage-id="stage.id"
    >
      <template #item="{ element }">
        <CardContact :contact="element" />
      </template>
    </draggable>
  </div>
</template>

<script>
import CardContact from "./CardContact.vue";
import { mapGetters, mapActions } from "vuex";
import draggable from "vuedraggable";
import OffCanvasContact from "./OffCanvasContact.vue";

export default {
  name: "StageKanban",
  components: {
    CardContact,
    draggable,
    OffCanvasContact,
  },
  data() {
    return {
      contacts: [],
    };
  },
  props: {
    funnel: {
      type: Object,
      required: true,
    },
    stage: {
      type: Object,
      required: true,
    },
  },
  computed: {
    ...mapGetters("contacts", ["getContactsByStage"]),
  },
  methods: {
    ...mapActions("contacts", ["setContacts"]),
    updateContact() {
      this.contacts = this.getContactsByStage(this.stage.id);
    },
    onChange(e) {
      const contact_id = e.added.element.id;
      const new_position = e.added.newIndex + 1;
      this.$emit('swapContactInPhases', {
        contact_id,
        new_position,
      })
    },
  },
  async created() {
    await this.setContacts(this.stage.funnel_id);
    this.contacts = this.getContactsByStage(this.stage.id);
  },
};
</script>

<style scoped lang="scss">
.bar {
  height: 6px;
  background-color: var(--background-color);
}
.stage:hover {
  background-color: #f0f4fa;
}
::-webkit-scrollbar {
  width: 5px;
  height: 2px;
}

::-webkit-scrollbar-thumb {
  background-color: #cccccc;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background-color: #d3d3d3;
}
</style>
