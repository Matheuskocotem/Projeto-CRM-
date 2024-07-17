<template>
  <div id="notification">
    <img src="../assets/vencedor/pluszinhaSuccess.gif" alt="icon" id="icon" />
    <div id="content">
      <h4>Vamos lá!</h4>
      <span>{{ successMessage }} </span>
    </div>
  </div>
</template>
  
  <script>
export default {
  name: "Success",
  props: {
    successMessage: "",
  },
};
</script>
  
<style scoped lang="scss">
#notification {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  width: 250px;
  height: 60px;
}

#icon {
  width: 70px;
  height: 70px;
  margin-right: 10px;
  margin-left: 10px;
}
</style>
