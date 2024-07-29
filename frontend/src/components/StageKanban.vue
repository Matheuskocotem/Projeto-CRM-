<template>
<<<<<<< HEAD
  <div class="stage">
    <h3>{{ stage.name }}</h3>
    <Draggable v-model="contacts" group="cards" item-key="id">
      <template #item="{ element }">
        <CardContact :contact="element" />
      </template>
    </Draggable>
  </div>
=======
    <div>
    </div>

>>>>>>> ae0c6ef (bizil)
</template>

<script>
import CardContact from "./CardContact.vue";
import { mapGetters, mapActions } from "vuex";
import Draggable from "vuedraggable";

export default {
  name: "StageKanban",
  components: {
    CardContact,
    Draggable,
  },
  data() {
    return {
      contacts: [],
    };
  },
  props: {
    stage: {
      type: Object,
      required: true,
    },
  },
  methods: {
    ...mapActions("contacts", ["setContacts"]),
  },
  async created() {
    await this.setContacts({
      funnel_id: this.stage.funnel_id,
      stage_id: this.stage.id,
    });
    
    console.log(this.getContacts);
    
    this.contacts = this.getContacts.filter(
      (contact) => contact.stage_id === this.stage.id
    );
  },
  computed: {
    ...mapGetters("contacts", ["getContacts"]),
  },
};
</script>
