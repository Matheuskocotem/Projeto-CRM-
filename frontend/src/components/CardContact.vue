<template>
  <div class="card border-1 rounded-1 p-2 m-1">
    <h5>{{ contact.name }}</h5>
    <p>{{ contact.buyValue }}</p>
  </div>
</template>

<script>
export default {
  name: "CardContact",
  props: {
    contact: {
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