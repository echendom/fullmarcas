<template>
  <validation-observer ref="form" v-slot="{ invalid }" slim>
    <form class="form-hero" @submit.prevent="handleSubmit">
      <validation-provider
        name="trademark-name"
        rules="required"
        :bails="true"
        tag="div"
        class="form-input-field"
        v-slot="{ errors }"
      >
        <label
          :class="[
            'form-input-field__label',
            errors.length ? 'form-input-field__label--error' : ''
          ]"
        >
          ¿Cómo se llama tu marca?
          <input
            class="form-input-field__input"
            :class="errors.length ? 'form-input-field__input--error' : ''"
            v-model="inputs['trademarkName']"
            type="text"
            placeholder="Ingresa aquí"
          />
        </label>
        <div class="form-input-field__errors" v-if="errors.length">
          <span
            class="paragraph paragraph--small form-input-field__error"
            v-for="(error, index) in errors"
            :key="index"
          >
            {{ error }}
          </span>
        </div>
        <span class="paragraph paragraph--small form-input-field__hint" v-else>
          Puede incluir letras, números y símbolos
        </span>
      </validation-provider>
      <validation-provider
        name="email"
        rules="required|email"
        :bails="true"
        tag="div"
        class="form-input-field"
        v-slot="{ errors }"
      >
        <label
          :class="[
            'form-input-field__label',
            errors.length ? 'form-input-field__label--error' : ''
          ]"
        >
          ¿A qué correo te enviamos la información?
          <input
            class="form-input-field__input"
            :class="errors.length ? 'form-input-field__input--error' : ''"
            v-model="inputs['email']"
            type="email"
            placeholder="Ingresa aquí"
          />
        </label>
        <div class="form-input-field__errors" v-if="errors.length">
          <span
            class="paragraph paragraph--small form-input-field__error"
            v-for="(error, index) in errors"
            :key="index"
          >
            {{ error }}
          </span>
        </div>
        <span class="paragraph paragraph--small form-input-field__hint" v-else>
          Ejemplo: mail@mail.com
        </span>
      </validation-provider>
      <!-- Phone -->
      <validation-provider
        name="phone"
        rules="required|numeric|min:11|max:11"
        :bails="true"
        tag="div"
        class="form-input-field"
        v-slot="{ errors }"
      >
        <label
          :class="[
            'form-input-field__label',
            errors.length ? 'form-input-field__label--error' : ''
          ]"
        >
          ¿Cuál es tu número de teléfono?
          <input
            class="form-input-field__input"
            :class="errors.length ? 'form-input-field__input--error' : ''"
            v-model="inputs['phone']"
            type="tel"
            maxlength="11"
            placeholder="56 976543210"
          />
        </label>
        <div class="form-input-field__errors" v-if="errors.length">
          <span
            class="paragraph paragraph--small form-input-field__error"
            v-for="(error, index) in errors"
            :key="index"
          >
            {{ error }}
          </span>
        </div>
        <span class="paragraph paragraph--small form-input-field__hint" v-else>
          Ejemplo: 55 1234 5678
        </span>
      </validation-provider>
      <button type="submit" class="button button--primary">
        {{ registration_link['title'] }}
      </button>
    </form>
  </validation-observer>
</template>

<script>
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import { gsap } from "gsap";
import { required, email, numeric, min, max } from 'vee-validate/dist/rules';
import { mapMutations } from "vuex";

extend('required', {
  ...required,
  message: 'Este campo es requerido'
});
extend('email', {
  ...email,
  message: 'Dirección de correo electrónico inválida'
});
extend('numeric', {
  ...numeric,
  message: 'Este campo debe ser numérico'
});
extend('max', {
  ...max,
  message: 'Este campo debe tener {length} caracteres'
});

export default {
  name: 'FormHero',
  props: ['registration_link'],
  components: {
    ValidationObserver,
    ValidationProvider
  },
  data() {
    return {
      inputs: {
        trademarkName: '',
        email: '',
        phone: ''
      }
    }
  },
  mounted() {
    const tl = gsap.timeline();
    const delay = 0.5;
    tl.fromTo(
      '.form-hero',
      { opacity: 0, y: 5 },
      { opacity: 1, y: 0, duration: 0.8 },
      delay
    );
  },
  methods: {
    async handleSubmit() {
      const isValid = await this.$refs.form.validate();

      if (!isValid) return;

      this.updateGlobalInputs({
        step1: this.inputs
      });
      window.location.href = this.registration_link['url'];
    },
    ...mapMutations([
      'updateGlobalInputs'
    ]),
  }
}
</script>
