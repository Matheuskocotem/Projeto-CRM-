<template>
  <div id="main-wrapper">
    <backEffect />
    <div id="main">
      <div id="banner">
        <div id="icons">
          <img src="../assets/vencedor/message3c.png" alt="message" />
          <img src="../assets/vencedor/asterisc3c.png" alt="asterisc" />
          <img src="../assets/vencedor/plus3c.png" alt="plus" />
        </div>
        <div id="title">
          <div id="title-line">
            <p id="mais" style="font-family: grotesque" class="carac mr-1">
              Mais
            </p>
            <div v-if="showWord">
              <span
                v-for="(char, index) in titleChars"
                :key="index"
                id="animated-word"
                :style="{ animationDelay: `${index * 0.1}s` }"
                >{{ char }}</span
              >
            </div>
          </div>
          <p class="carac">no seu negócio</p>
          <p id="subject">
            Uma ferramenta all-in-one para você vender, atender, cobrar e
            otimizar o seu tempo e o seu dinheiro.
          </p>
        </div>
      </div>
      <form>
        <h1 style="font-family: grotesque">Comece por aqui!</h1>
        <InputForm
          type="text"
          v-model="name"
          placeholder="Nome"
          id="name"
          label="Nome"
          class="input my-2"
        />
        <InputForm
          type="email"
          v-model="email"
          placeholder="Email ou Ramal"
          id="email"
          label="Email"
          class="input my-2"
        />
        <InputForm
          type="password"
          v-model="password"
          placeholder="Senha"
          id="password"
          label="Senha"
          class="input my-2"
        />
        <InputForm
          type="password"
          v-model="password_confirmation"
          placeholder="Confirme sua senha"
          id="password_confirmation"
          label="Confirme sua senha"
          class="input my-2"
        />
        <div
          class="btn-group w-50 my-2"
          role="group"
          aria-label="Basic radio toggle button group"
        >
          <input
            type="radio"
            class="btn-check"
            name="btnradio"
            id="btnradio1"
            autocomplete="off"
            value="CPF"
            v-model="documentType"
            checked
          />
          <label class="btn btn-outline-primary" for="btnradio1">CPF</label>
          <input
            type="radio"
            class="btn-check"
            name="btnradio"
            id="btnradio2"
            autocomplete="off"
            value="CNPJ"
            v-model="documentType"
          />
          <label class="btn btn-outline-primary" for="btnradio2">CNPJ</label>
        </div>
        <InputForm
          type="text"
          v-model="documentNumber"
          v-maska="Mask"
          :placeholder="`Número do ${documentType}`"
          id="docNum"
          :maxlength="documentMaxLength"
          :label="`Número do ${documentType}`"
          class="input my-2"
        />
        <button type="button" class="btn btn-primary w-75" @click="Register">
          Registrar-se
        </button>
      </form>
    </div>
    <AppFooter />
  </div>
</template>

<script>
import backEffect from "../components/backEffect.vue";
import AppFooter from "../components/AppFooter.vue";
import InputForm from "../components/InputForm.vue";
import Error from "../components/Error.vue";
import Success from "../components/Success.vue";
import { useToast } from "vue-toastification";
import { mapActions } from "vuex";

export default {
  name: "Register",
  components: {
    backEffect,
    AppFooter,
    InputForm,
    Error,
    Success,
  },
  data() {
    return {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      documentType: "CPF",
      documentNumber: "",
      words: ["lucro", "produtividade", "vendas", "crescimento", "resultados"],
      currentWordIndex: 0,
      currentWord: "",
      showWord: false,
    };
  },
  computed: {
    titleChars() {
      return this.currentWord.split("");
    },
    Mask() {
      if (this.documentType == "CPF") {
        return "###.###.###-##";
      } else {
        return "##.###.###/####-##";
      }
    },
  },
  mounted() {
    this.updateWord();
    setInterval(() => {
      this.updateWord();
    }, 5000);
  },
  methods: {
    updateWord() {
      this.showWord = false;
      setTimeout(() => {
        this.currentWord = this.words[this.currentWordIndex];
        this.currentWordIndex = (this.currentWordIndex + 1) % this.words.length;
        this.showWord = true;
      }, 100);
    },
    showError(errorMessage) {
      const toast = useToast();
      toast.error({
        component: Error,
        props: {
          errorMessage,
        },
      });
    },
    showSuccess(successMessage) {
      const toast = useToast();
      toast.success({
        component: Success,
        props: {
          successMessage,
        },
      });
    },
    async Register() {
      if (this.password !== this.password_confirmation) {
        this.showError("As senhas não coincidem");
        return;
      }
      if (!this.name) {
        this.showError("Nome inválido");
        return;
      }
      if (!this.email) {
        this.showError("Email inválido");
        return;
      }
      if (this.password.length < 6) {
        this.showError("A senha deve ter mais que 6 dígitos");
        return;
      }
      if (!this.documentNumber) {
        this.showError("Documento inválido");
        return;
      }

      const response = await this.register({
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation,
        documentType: this.documentType,
        documentNumber: this.documentNumber,
      });
      if (response == 201) {
        this.showSuccess("Faça o seu login a seguir!");
        this.$router.push("/login");
      } else {
        this.showError(response[0]);
      }
    },
    ...mapActions("user", ["register"]),
  },
};
</script>

<style scoped lang="scss">
#icons img {
  width: 30px;
  height: 30px;
  margin: 0px 20px 0px 0px;
}

#title {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding: 20px 0px;
  color: #212529;
}

#title-line {
  display: flex;
  align-items: baseline;
  margin-bottom: -20px;
}

#banner {
  margin-top: 60px;
  align-items: flex-start;
  display: flex;
  flex-direction: column;
}

#mais {
  margin-right: 20px;
}

.carac {
  font-weight: bolder;
  font-size: 60px;
  margin: 0;
}

#subject {
  margin-top: 20px;
  display: flex;
  align-items: flex-start;
  font-size: 22px;
  width: 80%;
}

@keyframes slideIn {
  0% {
    transform: translateX(0%);
    opacity: 1;
  }
  30% {
    opacity: 0;
  }
  70% {
    opacity: 0;
  }
  100% {
    transform: translateX(0%);
    opacity: 0;
  }
}

#animated-word {
  color: rgb(48, 87, 242);
  font-size: 60px;
  font-weight: bolder;
  display: inline-block;
  animation: slideIn 1s linear;
}

.hidden {
  visibility: hidden;
}

#main-wrapper {
  width: 100%;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

#main {
  width: 85%;
  position: absolute;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  z-index: 1;
  margin-bottom: 40px;
  align-items: center;
}

form {
  display: inherit;
  width: 70%;
  flex-direction: column;
  align-items: center;
  background-color: #ffffff;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  padding: 30px;
}

form button {
  width: 50%;
  height: 40px;
  margin-top: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

form button:hover {
  background-color: #0056b3;
}
</style>
