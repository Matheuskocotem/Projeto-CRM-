<template>
  <div class="overflow-x-auto w-100">
    <div class="stage mx-2" style="height: 78vh; width: 16vw">
      <DeleteStageModal :stage="stage" />
      <div
        class="bar w-100 rounded-4"
        :style="{ '--background-color': funnel.color }"
      ></div>
      <StageHeader
        :stage="stage"
        :funnel="funnel"
        @updateContact="updateContact"
      />
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
  </div>
</template>

<script>
import CardContact from "./CardContact.vue";
import { mapGetters, mapActions } from "vuex";
import draggable from "vuedraggable";
import OffCanvasContact from "./OffCanvasContact.vue";
import DeleteStageModal from "./DeleteStageModal.vue";
import StageHeader from "./StageHeader.vue";

export default {
  name: "StageKanban",
  components: {
    CardContact,
    draggable,
    OffCanvasContact,
    DeleteStageModal,
    StageHeader,
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
      console.log("a");
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
.scroll {
  height: 100%;
}

.bar {
  height: 1vh;
  background-color: var(--background-color);
}

.dropItem:hover {
  background-color: #f3f3f3;
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
