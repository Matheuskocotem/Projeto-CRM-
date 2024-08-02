<template>
  <div>
    <SideBar @toggleSideBar="toggleSideBar" />
    <NavBarKanban ref="NavBarKanban" :funnel="funnel" />
<<<<<<< HEAD
    <OffCanvasContact :funnel="funnel" />
    <div id="main-content" class="p-4 d-flex" ref="MainContent">
      <StageKanban v-for="stage in stages" :key="stage.id" :stage="stage" />
=======
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
              @change="onChange"
            />
          </div>
        </template>
      </draggable>
>>>>>>> origin/main
    </div>
  </div>
</template>

<script>
import CardContact from "@/components/CardContact.vue";
import NavBarKanban from "@/components/NavBarKanban.vue";
import OffCanvasContact from "@/components/OffCanvasContact.vue";
import SideBar from "@/components/SideBar.vue";
import StageKanban from "@/components/StageKanban.vue";
<<<<<<< HEAD
=======
import draggable from "vuedraggable";
>>>>>>> origin/main
import { mapActions, mapGetters } from "vuex";

export default {
  components: {
    SideBar,
    NavBarKanban,
    OffCanvasContact,
    CardContact,
    StageKanban,
<<<<<<< HEAD
  },
  data() {
    return {
=======
    draggable,
  },
  data() {
    return {
      funnel: null,
>>>>>>> origin/main
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
<<<<<<< HEAD
=======
    ...mapActions("contacts", ["swapBetweenPhases"]),
    onChange(e) {
      //VOU USAR PARA FAZER ORDENAÇÃO DE ETAPAS
      // console.log(e.moved);
      // console.log(e.added);
      // const toStageId = e.to.closest('[data-id]').dataset.id;
    },
>>>>>>> origin/main
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
<<<<<<< HEAD
  overflow: hidden;
  flex-wrap: wrap;
}
</style>

=======
  z-index: -1;
}

.ghost {
  opacity: 0.4;
  background-color: #f0f0f0;
  border: 1px dashed #ccc;
}
</style>
>>>>>>> origin/main
