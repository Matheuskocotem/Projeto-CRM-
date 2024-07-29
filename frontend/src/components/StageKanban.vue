<template>
    <div>
    </div>

</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: "StageKanban",
    props: {
        contacts: {
            type: Array,
            required: true
        }
    },
}
</script>
