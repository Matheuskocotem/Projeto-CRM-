<template>
  <div class="card border-1 rounded-1 p-2 m-1">
    <Draggable v-model="getContacts"> </Draggable>
  </div>
</template>

<script>
import Draggable from "vuedraggable";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "CardContact",
  components: {
    Draggable,
  },
  props: {
    contact: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {};
  },
  created() {
    this.setContacts();
  },
  mounted: {
    ...mapGetters("contacts", ["getContacts"]),
  },
  methods: {
    ...mapActions("contacts", ["setContacts"]),
    
  },

};
</script>

<style scoped></style>
