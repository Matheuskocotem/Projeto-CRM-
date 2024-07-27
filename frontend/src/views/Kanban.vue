<template>
  <div>
    <SideBar @toggleSideBar="toggleSideBar" />
    <NavBarKanban ref="NavBarKanban" :expanded="expanded" :funnel="funnel" />
    <div id="main-content" class="p-4 d-flex" ref="MainContent">
      <!-- <v-for "etapas in quadro">
            <v-for "contatos in etapa"> -->
    </div>
  </div>
</template>

<script>
import NavBarKanban from "@/components/NavBarKanban.vue";
import SideBar from "@/components/SideBar.vue";

export default {
  components: {
    SideBar,
    NavBarKanban,
  },
  created() {
    this.funnel = this.$route.params;
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
