<template>
  <div class="stage mx-2" style="height: 100vh; width: 16vw; overflow-y: auto">
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
      class="stage-header d-flex justify-content-between w-100 mt-2"
    >
      <h1
        class="w-75 mt-1"
        style="font-size: 1vw; font-weight: 600; margin-left: 6px"
      >
        {{ stage.name }}
      </h1>
      <button
        class="mx-1 border-0 rounded-2 justify-content-center d-flex"
        data-bs-toggle="offcanvas"
        :data-bs-target="'#offcanvasRight' + stage.id"
        aria-controls="offcanvasRight"
        style="width: 1.6vw; height: 2.5vh; font-size: 1.2rem; color:#6e8398; "
      >
        +
      </button>
    </div>
    <draggable
      v-model="contacts"
      group="cards"
      item-key="id"
      animation="250"
      @change="(event) => onChange(event, stage.id)"
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
    ...mapActions("contacts", ["swapBetweenPhases", "swap"]),
    updateContact() {
      this.contacts = this.getContactsByStage(this.stage.id);
    },
    onChange(e, stage) {
      if (e.added) {
        const contact_id = e.added.element.id;
        const new_position = e.added.newIndex + 1;
        this.swapBetweenPhases({
          funnel_id: this.funnel.id,
          contact_id: contact_id,
          changes: {
            new_position,
            new_stage_id: stage,
          },
        });
      }
      if (e.moved) {
        const contact_id = e.moved.element.id;
        const new_position = e.moved.newIndex + 1;
        this.swap({
          funnel_id: this.funnel.id,
          contact_id: contact_id,
          changes: {
            new_position: new_position,
            stage_id: stage,
          },
        });
      }
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
  height: 1vh;
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
