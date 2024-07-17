<template>
  <div>
    
  </div>
</template>
  
<script>
import Error from "@/components/Error.vue";
import { useToast } from "vue-toastification";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      errorMessage: "",
    };
  },
  computed: {
    ...mapGetters(['isAuth']),
  },
  components: {
    Error,
  },
  methods: {
    showError(errorMessage) {
      const toast = useToast();
      toast.error({
        component: Error,
        props: {
          errorMessage
        },
      });
    },
  },
  verifyAuth(errorMessage){
    if(!this.isAuth){
      this.showError(errorMessage);
    }
  }
};
</script>
  
