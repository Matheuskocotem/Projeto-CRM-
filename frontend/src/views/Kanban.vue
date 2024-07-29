<template>
  <div>
    <SideBar @toggleSideBar="toggleSideBar" />
    <NavBarKanban ref="NavBarKanban" :funnel="funnel" />
    <OffCanvasContact :funnel="funnel" />
    <div id="main-content" class="p-4 d-flex" ref="MainContent">
      <StageKanban v-for="stage in funnel.stages" :key="stage.id" :contacts="stage.contacts" />
    </div>
  </div>
</template>

<script>
import NavBarKanban from "@/components/NavBarKanban.vue";
import OffCanvasContact from "@/components/OffCanvasContact.vue";
import SideBar from "@/components/SideBar.vue";
import StageKanban from "@/components/StageKanban.vue";

export default {
  components: {
    SideBar,
    NavBarKanban,
    OffCanvasContact,
    StageKanban
  },
  created() {
    this.funnel = this.$route.params;
    console.log(this.funnel);
  },
  methods: {
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
  overflow: hidden;
  flex-wrap: wrap;
}
</style>
