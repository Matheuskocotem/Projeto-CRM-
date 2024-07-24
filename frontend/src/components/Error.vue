<template>
  <div id="notification">
    <img src="../assets/vencedor/error.svg" alt="icon" id="icon" />
    <div id="content">
      <h4>Oops...</h4>
      <span>{{ errorMessage }} </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "Error",
  props: {
    errorMessage: "",
  },
};
</script>

<style scoped lang="scss">
#notification {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  width: 200px;
  height: 60px;
}

#icon {
  width: 70px;
  height: 70px;
  margin-right: 10px;
}

</style>