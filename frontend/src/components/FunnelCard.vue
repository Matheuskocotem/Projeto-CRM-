<template>
  <div class="cardFunnel d-flex flex-column p-2 mx-3 mb-3">
    <h4 class="mx-2" ref="Funnel" style="font-family: grotesque">
      {{ funnel?.name }}
    </h4>
    <p class="mt-5">Value</p>
  </div>
</template>

<script>
export default {
  name: "FunnelCard",
  props: {
    funnel: Object
  },
  methods: {
    changeColor() {
        this.$emit("changeColor", "FunnelColor");
    }
  }
};
</script>

<style scoped lang="scss">
.cardFunnel {
  width: 20%;
  min-width: 17%;
  height: 130px;
  border-left: solid 6px var(--border-color);
  border-bottom: solid 6px var(--border-color);
  border-radius: 12px;
}
</style>