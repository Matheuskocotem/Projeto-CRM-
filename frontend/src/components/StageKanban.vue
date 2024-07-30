<template>
    <div class="stage ">
        <h3>{{ stage.name }}</h3>
        <Draggable v-model="getContacts" group="cards" item-key="id">
            <template #item="{element}">
                <CardContact :contact="element" />
            </template>
        </Draggable>
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
        stage: {
            type: Object,
            required: true,
        },
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
