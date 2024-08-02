<template>
  <div
    class="offcanvas offcanvas-end"
    tabindex="-1"
<<<<<<< HEAD
    id="offcanvasRight"
=======
    :id="'offcanvasRight' + stage_id"
>>>>>>> origin/main
    aria-labelledby="offcanvasRightLabel"
  >
    <div class="offcanvas-header d-flex justify-content-between">
      <button
        type="button"
        class="btn border-0 d-flex mt-2"
        data-bs-dismiss="offcanvas"
        aria-label="Close"
<<<<<<< HEAD
=======
        ref="btnClose"
>>>>>>> origin/main
      >
        <font-awesome-icon class="mt-2 fs-5" :icon="['fas', 'angle-left']" />
        <p class="mx-3 mt-1 fs-5">Voltar</p>
      </button>
      <button
        type="button"
        class="btn btn-primary d-flex justify-content-center mb-1 w-50"
        @click="createNewContact"
      >
        Criar contato
      </button>
    </div>
    <div class="offcanvas-body">
      <div class="inputAcc d-flex flex-column w-100 rounded p-1">
        <input
          v-model="name"
          placeholder="Nome do contato*"
          class="form-control w-100 fs-5 border-0 fw-bolder text-dark mx-1 mt-2 mb-1"
        />
        <div class="border-bottom mx-3"></div>
        <div class="d-flex flex-column w-100 justify-content-between mt-3">
          <p class="mx-3 fw-bolder">{{ funnel.name }}</p>
<<<<<<< HEAD
          <div class="button-stage gap-1 d-flex flex-row">

=======
          <div class="gap-1 d-flex flex-row">
>>>>>>> origin/main
            <div v-for="stage in getStages" :key="stage.id">
              <input
                type="radio"
                class="btn-check"
                :name="'options'"
<<<<<<< HEAD
                :id="'option' + stage.id"
                v-model="stage_id"
                :value="stage.id"
              />
              <label class="item btn btn-light" :for="'option' + stage.id">
=======
                :id="'option' + stage.id + stage_id"
                v-model="chosen_stage_id"
                :value="stage.id"
                :checked="chosen_stage_id == stage.id"
              />
              <label
                :class="[
                  'stage-button',
                  'btn-light',
                  'd-flex',
                  'align-items-center',
                  'justify-content-center',
                  { selected: chosen_stage_id == stage.id },
                ]"
                :for="'option' + stage.id + stage_id"
              >
>>>>>>> origin/main
                {{ stage.name }}
              </label>
            </div>
          </div>
        </div>
      </div>
      <div
        class="contact accordion accordion-flush mt-4"
        id="accordionFlushExample"
      >
        <div class="accordion-item">
          <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#flush-collapseOne"
            aria-expanded="false"
            aria-controls="flush-collapseOne"
          >
            <span class="fw-bolder fs-6">Contatos</span>
          </button>
          <div
            id="flush-collapseOne"
            class="accordion-collapse collapse"
            data-bs-parent="#accordionFlushExample"
          >
            <div class="accordion-body">
              <label
                class="input d-flex align-items-center flex-row w-100 rounded p-1 mt-2"
                >Telefone:
                <span class="text-danger fs-5 fw-bolder">*</span>
                <input
                  class="input mx-4 border-0 mb-1"
                  type="text"
                  v-model="phoneNumber"
                  placeholder="Adicionar número"
                />
              </label>
              <label
                class="input d-flex align-items-center flex-row w-100 rounded p-1 mt-2"
                >E-mail:
                <span class="text-danger fs-5 fw-bolder">*</span>
                <input
                  class="input mx-4 border-0 mb-1"
                  type="email"
                  v-model="email"
                  placeholder="Adicionar e-mail"
                />
              </label>
            </div>
          </div>
        </div>
      </div>
      <div
        class="contact accordion accordion-flush mt-4"
        id="accordionFlushExampletwo"
      >
        <div class="accordion-item">
          <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#flush-collapseTwo"
            aria-expanded="false"
            aria-controls="flush-collapseTwo"
          >
            <span class="fw-bolder fs-6">Dados</span>
          </button>
          <div
            id="flush-collapseTwo"
            class="accordion-collapse collapse"
            data-bs-parent="#accordionFlushExampletwo"
          >
            <div class="accordion-body">
              <label
                class="input d-flex align-items-center flex-row w-100 rounded p-1 mt-2"
                >CPF:
                <span class="text-danger fs-5 fw-bolder">*</span>
                <input
                  class="input mx-4 border-0 mb-1"
                  type="text"
                  v-model="cpf"
<<<<<<< HEAD
=======
                  v-maska="'###.###.###-##'"
>>>>>>> origin/main
                  placeholder="000.000.000-00"
                />
              </label>
              <label
                class="input d-flex align-items-center flex-row w-100 rounded p-1 mt-2"
                >Data de nascimento:
                <span class="text-danger fs-5 fw-bolder">*</span>
                <input
                  class="input mx-4 border-0"
<<<<<<< HEAD
                  type="text"
=======
                  type="date"
>>>>>>> origin/main
                  v-model="dateOfBirth"
                  placeholder="DD/MM/AAAA"
                />
              </label>
              <label
                class="input d-flex align-items-center flex-row w-100 rounded p-1 mt-2"
                >Endereço:
                <input
                  class="input mx-4 border-0"
                  type="text"
                  v-model="address"
                  placeholder="Adicionar endereço"
                />
              </label>
              <label
                class="input d-flex align-items-center flex-row w-100 rounded p-1 mt-2"
                >Valor:
                <input
                  class="input mx-4 border-0 mb-1"
                  type="text"
                  v-model="buyValue"
                  placeholder="R$ 0,00"
                />
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
<<<<<<< HEAD
import { mapActions, mapGetters } from "vuex";
=======
import { mapActions, mapGetters, mapMutations } from "vuex";
>>>>>>> origin/main
import Error from "./Error.vue";
import Success from "./Success.vue";
import { useToast } from "vue-toastification";

export default {
  name: "OffCanvasContact",
  components: {
    Error,
    Success,
  },
  props: {
    funnel: {
      type: Object,
      required: true,
    },
<<<<<<< HEAD
  },
  data() {
    return {
=======
    stage_id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      position: 0,
>>>>>>> origin/main
      name: "",
      phoneNumber: "",
      email: "",
      cpf: "",
      dateOfBirth: "",
      address: "",
      buyValue: "",
<<<<<<< HEAD
      stage_id: null,
=======
      chosen_stage_id: this.stage_id,
>>>>>>> origin/main
    };
  },
  computed: {
    ...mapGetters("stages", ["getStages"]),
<<<<<<< HEAD
=======
    ...mapGetters("contacts", ["getContactsByStage"]),
>>>>>>> origin/main
  },
  async created() {
    await this.setStages(this.funnel.id);
  },
<<<<<<< HEAD
  watch: {
    stage_id(newValue) {
      this.stage_id = newValue;
    },
  },
  methods: {
    ...mapActions("contacts", ["createContact"]),
    ...mapActions("stages", ["setStages"]),
    async createNewContact() {
      console.log(this.stage_id);
      try {
        await this.createContact(this.funnel.id, {
          name: this.name,
          funnel_id: this.funnel.id,
          stage_id: this.stage_id,
          email: this.email,
          phoneNumber: this.phoneNumber,
          cpf: this.cpf,
          dateOfBirth: this.dateOfBirth,
          address: this.address,
          buyValue: this.buyValue,
        });
        this.showSuccess("Contato criado com sucesso!");
      } catch (error) {
        this.showError(error.message);
=======
  methods: {
    ...mapActions("contacts", [
      "createContact",
      "setContacts",
      "refreshContacts",
    ]),
    ...mapActions("stages", ["setStages"]),
    async createNewContact() {
      try {
        await this.createContact({
          funnel_id: this.funnel.id,
          contact: {
            position: this.getContactsByStage(this.stage_id).length + 1,
            name: this.name,
            funnel_id: this.funnel.id,
            stage_id: this.chosen_stage_id,
            email: this.email,
            phoneNumber: this.phoneNumber,
            cpf: this.cpf,
            dateOfBirth: this.dateOfBirth,
            address: this.address,
            buyValue: this.buyValue,
          },
        });
        this.$emit("updateContact");
        this.showSuccess("Contato criado com sucesso!");
        this.$refs.btnClose.click();
      } catch (error) {
        this.showError("Erro ao criar contato!");
>>>>>>> origin/main
      }
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
  },
};
</script>

<style scoped lang="scss">
* {
  font-family: "CerebriSans";
}

.accordion {
  --bs-accordion-active-bg: #fff;
  --bs-accordion-btn-focus-box-shadow: none;
  --bs-accordion-active-color: inherit;
}

::-webkit-scrollbar {
  width: 7px;
  height: 5px;
}

::-webkit-scrollbar-thumb {
  background-color: #939393;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background-color: #787878;
}

<<<<<<< HEAD
.btn-check:checked + .item {
=======
.stage-button {
  border-radius: 20px;
  width: 120px;
  height: 27px;
  background-color: #e1e9f4;
}

.stage-button.selected {
>>>>>>> origin/main
  background-color: #7036e4;
  color: #fff;
}

<<<<<<< HEAD
.item {
  border-radius: 40px;
  width: 120px;
}

.item:hover {
  background-color: #dfdfdf;
}

.button-stage {
  overflow-x: auto;
  white-space: nowrap;
  padding: 10px;
}

.offcanvas {
  --bs-offcanvas-width: 640px;


=======
.btn-check:checked + .stage-button {
  background-color: #7036e4;
  color: #fff;
}

.stage-button:hover {
  background-color: #dfdfdf;
}

.offcanvas {
  --bs-offcanvas-width: 640px;
>>>>>>> origin/main
}

.contact {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.inputAcc {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-control:focus {
  outline: none;
  box-shadow: none;
}

.input:focus {
  outline: none;
  box-shadow: none;
}
</style>
