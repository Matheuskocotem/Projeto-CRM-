<template>
    <div class="stage ">
        <h3>{{ stage.name }}</h3>
        <VueDraggableNext :list="contacts" animation="150" item-key="id">
            <template #item="{element}">
                <CardContact :contact="element" />
            </template>
        </VueDraggableNext>
    </div>
</template>

<script>
import CardContact from './CardContact.vue';
import { mapGetters } from 'vuex';
import Draggable from 'vuedraggable';

export default {
    name: "StageKanban",
    components: {
        CardContact,
        Draggable
    },
    props: {
        contacts: {
            type: Array,
            required: true
        }
    },
    mounted: {
        ...mapGetters('stages', ['getContacts'])
    },
    computed: {
    }
}
</script>
