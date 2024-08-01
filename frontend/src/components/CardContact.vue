<template>
  <div
    class="card d-flex flex-column justify-content-between border-1 rounded-3 p-2 m-1"
    style="width: 96%; height: 80px"
  >
    <p style="font-size: 13px; font-weight: 600;">
      {{ contact.name }}
    </p>
    <p style="font-size: 10px; margin-bottom: 0 !important;">{{ contact.buyValue }}</p>
  </div>
</template>

<script>
export default {
  name: "CardContact",
  props: {
    contact: {
      type: Object,
      required: true,
    },
  },
};
</script>
