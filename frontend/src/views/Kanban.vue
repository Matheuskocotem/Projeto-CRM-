<template>
  <div>
    <SideBar @toggleSideBar="toggleSideBar" />
    <NavBarKanban ref="NavBarKanban" :funnel="funnel" />
    <div id="main-content" class="p-4" ref="MainContent">
      <draggable
        v-model="stages"
        group="stages"
        ghost-class="ghost"
        item-key="id"
        animation="250"
        class="d-flex flex-row"
      >
        <template #item="{ element }">
          <div :data-id="element.id">
            <StageKanban
              :key="element.id"
              :stage="element"
              :funnel="funnel"
              @change="swapContactInPhases"
              @swapContactInPhases="swapContactInPhases"
            />
          </div>
        </template>
      </draggable>
    </div>
  </div>
</template>

<script>
import CardContact from "@/components/CardContact.vue";
import NavBarKanban from "@/components/NavBarKanban.vue";
import OffCanvasContact from "@/components/OffCanvasContact.vue";
import SideBar from "@/components/SideBar.vue";
import StageKanban from "@/components/StageKanban.vue";
import draggable from "vuedraggable";
import { mapActions, mapGetters } from "vuex";

export default {
  components: {
    SideBar,
    NavBarKanban,
    OffCanvasContact,
    CardContact,
    StageKanban,
    draggable,
  },
  data() {
    return {
      funnel: null,
      stages: [],
    };
  },
  computed: {
    ...mapGetters("stages", ["getStages"]),
  },
  async created() {
    this.funnel = this.$route.params;
    await this.setStages(this.funnel.id);
    this.stages = this.getStages;
  },
  methods: {
    ...mapActions("stages", ["setStages"]),
    ...mapActions("contacts", ["swapBetweenPhases"]),
    swapContactInPhases(e) {
      //VOU USAR PARA FAZER ORDENAÇÃO DE ETAPAS
      // console.log(e.moved);
      // console.log(e.added);
      // const toStageId = e.to.closest('[data-id]').dataset.id;
      const new_stage_id = e.from.closest("[data-id]").dataset.id;
      console.log(new_stage_id);
      this.swapBetweenPhases(this.funnel.id, contact_id, {
        new_position,
        new_stage_id
      })
    },
    toggleSideBar(expanded) {
      if (expanded) {
        this.$refs.MainContent.style.marginLeft = "200px";
        this.$refs.NavBarKanban.$el.style.marginLeft = "200px";
      } else {
        this.$refs.MainContent.style.marginLeft = "75px";
        this.$refs.NavBarKanban.$el.style.marginLeft = "75px";
      }
    },
  },
};
</script>

<style>
#main-content {
  margin-left: 70px;
  transition: margin-left 0.5s;
  z-index: -1;
}

.ghost {
  opacity: 0.4;
  background-color: #f0f0f0;
  border: 1px dashed #ccc;
}
</style>
