<template>
  <div>
    <SideBar @toggleSideBar="toggleSideBar" />
    <NavBarKanban ref="NavBarKanban" :funnel="funnel" />
    <OffCanvasContact :funnel="funnel" />
    <div id="main-content" class="p-4 d-flex" ref="MainContent">
      <StageKanban v-for="stage in getStages" :key="stage.id" :stage="stage" :contacts="getContacts" />
    </div>
  </div>
</template>

<script>
import CardContact from "@/components/CardContact.vue";
import NavBarKanban from "@/components/NavBarKanban.vue";
import OffCanvasContact from "@/components/OffCanvasContact.vue";
import SideBar from "@/components/SideBar.vue";
import { mapActions, mapGetters } from "vuex";

export default {
  components: {
    SideBar,
    NavBarKanban,
    OffCanvasContact,
    CardContact,
  },
  computed: {
    ...mapGetters("contacts", ["getContacts"]),
    ...mapGetters("stages", ["getStages"]),
  },
  async created() {
    this.funnel = this.$route.params;
    await this.setContacts(this.funnel.id);
    await this.setStages(this.funnel.id);
  },
  methods: {
    ...mapActions("contacts", ["setContacts"]),
    ...mapActions("stages", ["setStages"]),
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
