<template>
<<<<<<< HEAD
  <div class="card border-1 rounded-1 p-2 m-1">
    <h5>{{ contact.name }}</h5>
    <p>{{ contact.buyValue }}</p>
=======
  <div
    class="card d-flex flex-column justify-content-between border-1 rounded-3 p-2 m-1"
    style="width: 96%; height: 80px"
  >
    <p style="font-size: 13px; font-weight: 600;">
      {{ contact.name }}
    </p>
    <p style="font-size: 10px; margin-bottom: 0 !important;">{{ contact.buyValue }}</p>
>>>>>>> origin/main
  </div>
</template>

<script>
export default {
  name: "CardContact",
  props: {
    contact: {
<<<<<<< HEAD
        type: Object,
        required: true
    }
  },
}
</script>

<style scoped>
.card {
    height: 80px;
    width: 100px;
}
</style>

=======
      type: Object,
      required: true,
    },
  },
};
</script>
>>>>>>> origin/main
