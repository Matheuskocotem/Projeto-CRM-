<template>
  <div id="background-animation">
    <div id="logo3c">
      <img id="three" src="../assets/vencedor/3da3c.png" alt="three" />
      <img id="LetterC" src="../assets/vencedor/cDa3c.png" alt="c" />
      <img id="plus" src="../assets/vencedor/PlusDa3c.png" alt="plus" />
    </div>
    <div id="pics3c">
      <img id="plusIcon" src="../assets/vencedor/plus3c.png" alt="plus" />
      <img id="messageIcon" src="../assets/vencedor/message3c.png" alt="message" />
      <img id="asterisc" src="../assets/vencedor/asterisc3c.png" alt="asterisc" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'Animation'
};
</script>

<style scoped>
#background-animation {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  z-index: 0;
}

#logo3c,
#pics3c {
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  top: 50%;
  width: 100%;
  height: 100px;
}

@keyframes moveUp {
  0%, 5% {
    transform: translateY(100%);
    visibility: hidden;
  }
  10%, 45% {
    transform: translateY(0);
    visibility: visible;
  }
  50%, 95% {
    transform: translateY(-100%);
    visibility: hidden;
  }
  100% {
    transform: translateY(100%);
    visibility: hidden;
  }
}

@keyframes moveUpDelayed {
  0%, 55% {
    transform: translateY(100%);
    visibility: hidden;
  }
  60%, 95% {
    transform: translateY(0);
    visibility: visible;
  }
  100% {
    transform: translateY(-100%);
    visibility: hidden;
  }
}

#logo3c {
  animation: moveUp 15s ease-in-out infinite;
}

#pics3c {
  animation: moveUpDelayed 15s ease-in-out infinite;
}

#logo3c #three,
#logo3c #LetterC,
#logo3c #plus {
  width: 41.18px;
  height: 60.41px;
}

#pics3c #plusIcon,
#pics3c #messageIcon,
#pics3c #asterisc {
  width: 59.38px;
  height: 60.69px;
  margin: 0 10px;
}
</style>
