<template>
  <div class="step2" v-if="loaded">
    <div class="step2__header">
      <h1 class="step2__stepper-title">
        {{ stepperTitle }}
      </h1>
      <div class="step2__prev-state">
        <div class="step2__trademark-details">
          <span class="step2__email">
            {{ globalInputs.step1['email'] }}
          </span>
          <span class="step2__details-separator"></span>
          <span class="step2__trademark-name">
            {{ globalInputs.step1['trademarkName'] }}
          </span>
        </div>
        <button class="step2__edit-button" @click="goToFirstStep">
          <img
            class="step2__edit-icon"
            :src="editIcon"
            alt="Icono editar"
            width="20"
            height="20"
            role="presentation"
          />
          <span class="step2__edit-button-text">
            Editar
          </span>
        </button>
      </div>
    </div>
    <div class="step2__content">
      <h2 class="step2__title" v-if="title">
        {{ title }}
      </h2>
      <div class="step2__description paragraph" v-if="description" v-html="description"></div>
      <validation-observer ref="form" v-slot="{ invalid }" slim>
        <form class="step2__categories-form" @submit.prevent="handleSubmit">
          <validation-provider
            name="categories"
            rules="required"
            :bails="true"
            tag="div"
            class="step2__categories-container"
            v-slot="{ errors }"
          >
            <div class="step2__categories">
              <label
                v-for="(category, index) in globalCategories"
                :key="category.key"
                :class="[
                  inputs.checkedCategories.includes(category.key) ? 'step2__category--selected' : 'step2__category'
                ]"
              >
                <input
                  class="step2__category-input-tag"
                  type="checkbox"
                  :value="category.key"
                  v-model="inputs.checkedCategories"
                >
                <div class="step2__category-header">
                  <span
                    v-if="category['icon'] && category['icon']['url']"
                    class="step2__category-icon-block"
                    :style="{ backgroundColor: category['color'] }"
                  >
                    <img
                      class="step2__category-icon"
                      :src="category['icon']['url']"
                      :alt="category['icon']['alt']"
                      width="30"
                      height="30"
                    />
                  </span>
                  <span class="step2__category-input">
                    Seleccionar
                    <span class="step2__input-checkmark">
                      <img
                        v-if="inputs.checkedCategories.includes(category.key)"
                        class="step2__input-checkmark-icon"
                        :src="whiteCheckmark"
                        alt="Icono check"
                        width="12"
                        height="12"
                        role="presentation"
                      >
                    </span>
                  </span>
                </div>
                <div class="step2__category-details">
                  <h3 class="step2__category-title">{{ category['title'] }}</h3>
                  <div
                    v-if="category['description']"
                    v-html="category['description']"
                    class="step2__category-description paragraph"
                  ></div>
                </div>
              </label>
            </div>
            <div class="step2__categories-errors" v-if="errors.length">
              <span
                class="paragraph paragraph--small form-input-field__error"
                v-for="(error, index) in errors"
                :key="index"
              >
                {{ error }}
              </span>
            </div>
          </validation-provider>
        </form>
      </validation-observer>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import { required } from 'vee-validate/dist/rules';

extend('required', {
  ...required,
  message: 'Este campo es requerido'
});

export default {
  name: 'Step2',
  components: {
    ValidationObserver,
    ValidationProvider,
},
  props: ['title', 'description'],
  data() {
    return {
      loaded: false,
      editIcon: `${themosis_assets}/images/icons/black_edit_icon.svg`,
      whiteCheckmark: `${themosis_assets}/images/icons/white_checkmark.svg`,
      inputs: {
        checkedCategories: [],
      }
    };
  },
  created() {
    if (!this.globalInputs.step1) {
      this.$router.replace({name: 'informacion'});
    } else {
      this.loaded = true;
    }
  },
  methods: {
    goToFirstStep() {
      this.$router.back();
    },
    async submitAndNext() {
      const { globalCategories } = this;
      const checkedCategories = this.inputs.checkedCategories.map(categoryKey => {
        return globalCategories.find(cat => cat.key === categoryKey);
      })
      this.updateGlobalInputs({
        step2: {
          checkedCategories
        }
      });
      try {
        const response = await this.submitData({
          action: 'step-2',
          method: 'post',
          payload: {
            checked_categories: this.inputs.checkedCategories
          }
        });

        const { data } = response;

        if (data.success) {
          this.$router.push({name: 'subcategorias'});
        }
      } catch (error) {
        console.log('error in step2 submitAndNext:', error);
        this.stopLoading();
      }
    },
    async handleSubmit() {
      const isValid = await this.$refs.form.validate();

      if (!isValid) {
        const el = document.querySelector(".form-input-field__error:first-of-type");
        el.scrollIntoView({ behavior: "smooth", block: 'center' });
        return
      };

      this.submitAndNext();
    },
    handlePrev() {
      const { globalCategories } = this;
      const checkedCategories = this.inputs.checkedCategories.map(categoryKey => {
        return globalCategories.find(cat => cat.key === categoryKey);
      })
      this.updateGlobalInputs({
        step2: {
          checkedCategories
        }
      });
      this.$router.back();
    },
    ...mapMutations([
      'updateGlobalInputs',
      'stopLoading'
    ]),
    ...mapActions([
      'submitData'
    ])
  },
  computed: {
    ...mapState([
        'prevFlag',
        'nextFlag',
        'stepperTitle',
        'globalInputs',
        'globalCategories'
      ]
    )
  },
  beforeMount() {
    window.scrollTo({ top: 0 });
  },
  mounted() {
    const { step2 } = this.globalInputs;
    if (!step2 || !step2.checkedCategories) {
      return;
    }
    this.inputs.checkedCategories = step2.checkedCategories.map(category => category.key);
  },
  watch: {
    nextFlag() {
      this.handleSubmit();
    },
    prevFlag() {
      this.handlePrev();
    },
  }
}
</script>
