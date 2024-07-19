<template>
  <div id="main">
    <div id="main-container">
      <div id="formArea">
        <div id="logoArea">
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
        <div id="titleArea">
          <h1 class="h1s">Esqueci minha senha</h1>
          <p>Confirme seu e-mail para <br> receber o link redefinir<br> sua senha</p>
        </div>
        <div id="form">
          <div class="email-input">
            <InputForm
              type="email"
              v-model="email"
              placeholder="E-mail"
              id="email"
              label="E-mail"
              class="input"
            />
          </div>
          <button type="button" class="btn btn-primary" @click="handleResetPassword">
            Redefinir Senha
          </button>
          <p class="footer-text">
            Atenção agente: Contate o gestor ou<br>supervisor do sistema 3C PLUS na sua<br>
          </p>
        </div>
      </div>
      <AppFooter />
    </div>
  </div>

</template>


<script>
import { mapActions } from 'vuex';
import InputForm from "../components/InputForm.vue";
import AppFooter from "../components/AppFooter.vue";

export default {
  components: {
    InputForm,
    AppFooter,
  },
  data() {
    return {
      email: '',
    };
  },
  methods: {
    async handleResetPassword() {
      if (this.email) {
        try {
          const response = await fetch('http://localhost:8000/api/forgotPassword', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email: this.email }),
          });

          if (response.ok) {
            // Mostra mensagem de sucesso
            alert('Link de redefinição enviado para o seu e-mail.');
            //coloca toast aqui
            this.$router.push('/resetPassword/:token');
          } else {
            alert('Ocorreu um erro ao enviar o link de redefinição.');
          }
        } catch (error) {
          console.error('Erro ao resetar a senha:', error);
          alert('Ocorreu um erro ao enviar o link de redefinição.');
        }
      } else {
        alert('Por favor, insira um e-mail válido.');
      }
    },
  },
};
</script>

<style>
#main {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  height: 100vh;
  overflow: hidden;
}

/* FORM STYLE */
#main-container {
  width: 40%;
  height: 85%;
  position: relative;
  background-color: #ffffff;
  border-radius: 10px;
  padding: 56px;
  z-index: 1050 !important;
  box-shadow: 0 4px 18px 0 rgba(34, 54, 77, 0.12);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  color: #677c92;
}

/* FORM STYLE */

/* TITLE STYLE */
#formArea {
  display: flex;
  flex-direction: column;
  justify-content: center !important;
  align-items: center;
}

p {
  text-align: center;
  font-size: 1.125rem;
  margin-bottom: 0;
}

.h1s {
  font-size: 38px;
  margin-top: 40px;
  font-family: 'grotesque';
  color: #212529;
}

/* STYLE FROM THE FORM */
#form {
  width: 100%;
  margin: 8px 0px 0px;
}

#form .email-input {
  margin-bottom: 16px;
}

#form button {
  width: 100%;
  height: 40px;
  margin-bottom: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

#form button:hover {
  background-color: #0056b3;
}

.footer-text {
  font-size: 14px;
  color: #677c92;
  text-align: center;
  margin-top: 20px;
}

/* LOGO ANIMATION */
#logoArea {
  width: 100%;
  height: 65px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

#logo3c,
#pics3c {
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  top: 0;
  width: 100%;
  height: 100%;
}

@keyframes moveUp {
  0%,
  5% {
    transform: translateY(100%);
    visibility: hidden;
  }
  10%,
  45% {
    transform: translateY(0);
    visibility: visible;
  }
  50%,
  95% {
    transform: translateY(-100%);
    visibility: hidden;
  }
  100% {
    transform: translateY(100%);
    visibility: hidden;
  }
}

@keyframes moveUpDelayed {
  0%,
  55% {
    transform: translateY(100%);
    visibility: hidden;
  }
  60%,
  95% {
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

#logo3c #three {
  width: 41.18px;
  height: 60.41px;
}

#logo3c #LetterC {
  width: 50.18px;
  height: 60.41px;
}

#logo3c #plus {
  width: 21.06px;
  height: 21.06px;
  margin-left: -5px;
}

#pics3c #plusIcon,
#pics3c #messageIcon,
#pics3c #asterisc {
  width: 59.38px;
  height: 60.69px;
  margin: 0 10px;
}
</style>
