<template>
  <validation-observer ref="form" v-slot="{ invalid }" slim>
    <transition name="fade" mode="out-in" appear>
      <div
        v-if="loading"
        class="trademark-registration__loading-veil"
      >
        <img
          :src="loader"
          alt="Animacion de carga"
        />
      </div>
    </transition>
    <transition name="fade" appear>
      <div
        v-if="error"
        class="modal-overlay"
        @click="hideErrorModal"
      ></div>
    </transition>
    <transition name="pop" appear>
      <div
        v-if="error"
        class="modal modal--details"
        role="dialog"
      >
        <div class="trademark-registration__error-modal">
          <img
            class="trademark-registration__alert-icon"
            :src="alertIcon"
            alt="Icono de alerta"
            width="50"
            height="50"
            loading="lazy"
          />
          <h2 class="trademark-registration__error-title">
            Algo salió mal
          </h2>
          <p class="trademark-registration__error-content paragraph">
            {{ error }}
          </p>
          <button
            class="trademark-registration__error-button button--primary-inverted"
            type="button"
            @click="hideErrorModal"
          >
            Volver a intentar
          </button>
        </div>
      </div>
    </transition>
    <form class="form-contact" @submit.prevent="handleSubmit">
      <div class="form-contact__row">
        <validation-provider
          name="firstname"
          rules="required"
          :bails="true"
          tag="div"
          class="form-input-field"
          v-slot="{ errors }"
        >
          <label
            :class="[
              'form-contact__label',
              'form-input-field__label',
              errors.length ? 'form-input-field__label--error' : ''
            ]"
          >
            Nombre
            <input
              @focus="hideFloatingCta"
              @blur="showFloatingCta"
              :disabled="loading"
              class="form-input-field__input"
              :class="errors.length ? 'form-input-field__input--error' : ''"
              v-model="firstname"
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
            Ingresa tu primer nombre
          </span>
        </validation-provider>

        <validation-provider
          name="lastname"
          rules="required"
          :bails="true"
          tag="div"
          class="form-input-field"
          v-slot="{ errors }"
        >
          <label
            :class="[
              'form-contact__label',
              'form-input-field__label',
              errors.length ? 'form-input-field__label--error' : ''
            ]"
          >
            Apellido
            <input
              @focus="hideFloatingCta"
              @blur="showFloatingCta"
              :disabled="loading"
              class="form-input-field__input"
              :class="errors.length ? 'form-input-field__input--error' : ''"
              v-model="lastname"
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
            Ingresa tu apellido
          </span>
        </validation-provider>
      </div>

      <div class="form-contact__row">
        <validation-provider
          name="phone"
          rules="required|min:11"
          :bails="true"
          tag="div"
          class="form-input-field"
          v-slot="{ errors }"
        >
          <label
            :class="[
              'form-contact__label',
              'form-input-field__label',
              errors.length ? 'form-input-field__label--error' : ''
            ]"
          >
            Teléfono
            <span class="form-input-field__input-container--phone">
              <input
                @focus="hideFloatingCta"
                @blur="showFloatingCta"
                :disabled="loading"
                class="form-input-field__input--phone"
                :class="errors.length ? 'form-input-field__input--error' : ''"
                v-model="phone"
                v-mask="'# #### ####'"
                name="phone"
                key="phone"
                minlength="11"
                type="text"
                placeholder="0 0000 0000"
                autocomplete="off"
              />
            </span>
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
            Ingresa tu teléfono
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
              'form-contact__label',
              'form-input-field__label',
              errors.length ? 'form-input-field__label--error' : ''
            ]"
          >
            Email
            <input
              @focus="hideFloatingCta"
              @blur="showFloatingCta"
              :disabled="loading"
              class="form-input-field__input"
              :class="errors.length ? 'form-input-field__input--error' : ''"
              v-model="email"
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
            Ingresa tu correo electrónico
          </span>
        </validation-provider>
      </div>
      <div class="form-contact__row--single-column">
        <validation-provider
          name="message"
          rules="required"
          :bails="true"
          tag="div"
          class="form-input-field"
          v-slot="{ errors }"
        >
          <label
            :class="[
              'form-contact__label',
              'form-input-field__label',
              errors.length ? 'form-input-field__label--error' : ''
            ]"
          >
            Mensaje
            <textarea
              @focus="hideFloatingCta"
              @blur="showFloatingCta"
              :disabled="loading"
              class="form-input-field__input--textarea"
              :class="errors.length ? 'form-input-field__input--error' : ''"
              v-model="message"
              placeholder="Ingresa aquí"
              rows="7"
            ></textarea>
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
        </validation-provider>
      </div>
      <div class="form-contact__row--single-column">
        <validation-provider
          name="terms"
          :rules="{required: { allowFalse: false }}"
          :bails="true"
          tag="div"
          class="form-input-field"
          v-slot="{ errors }"
        >
          <label
            :class="[
              'form-contact__label--checkbox',
              'form-input-field__label--checkbox',
              errors.length ? 'form-input-field__label--error' : ''
            ]"
          >
            <span
              :class="accepts_terms ? 'form-input-field__checkmark--checked' : 'form-input-field__checkmark'"
            >
              <img
                v-if="accepts_terms"
                class="form-input-field__checkmark-icon"
                :src="white_checkmark"
                alt="Icono check"
                width="12"
                height="12"
                loading="lazy"
                role="presentation"
              >
            </span>
            <span class="form-input-field__checkbox-text" v-if="terms && terms['url']">
              Acepto los <a :href="terms['url']" target="_blank" rel="noopener noreferrer">términos y condiciones</a>.
            </span>
            <span class="form-input-field__checkbox-text" v-else>
              Acepto los términos y condiciones.
            </span>
            <input
              :disabled="loading"
              class="form-input-field__input--checkbox"
              type="checkbox"
              v-model="accepts_terms"
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
        </validation-provider>
      </div>
      <button
        class="form-contact__submit button--primary-inverted"
        :disabled="loading"
      >
        {{ button }}
      </button>
      <vue-recaptcha
        ref="recaptcha"
        size="invisible"
        loadRecaptchaScript
        @verify="onVerify"
        @expired="onExpired"
        @error="onError"
        :sitekey="recaptchaKey"
      ></vue-recaptcha>
    </form>
  </validation-observer>
</template>

<script>
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import { required, email, alpha_spaces, min } from 'vee-validate/dist/rules';
import VueRecaptcha from 'vue-recaptcha';

extend('required', {
  ...required,
  message: 'Este campo es requerido'
});
extend('email', {
  ...email,
  message: 'Dirección de correo electrónico inválida'
});
extend('alpha_spaces', {
  ...alpha_spaces,
  message: 'Solo se pueden ingresar caracteres alfabéticos'
});
extend('min', {
  ...min,
  message: 'Número telefónico inválido'
});

export default {
  name: 'ContactForm',
  props: ['terms', 'info', 'button', 'typ'],
  components: {
    VueRecaptcha,
    ValidationProvider,
    ValidationObserver
  },
  data() {
    return {
      loader: `${themosis_assets}/images/animations/loader.svg`,
      alertIcon: `${themosis_assets}/images/icons/skyblue_alert_icon.svg`,
      error: '',
      action: 'contact',
      loading: false,
      accepts_terms: true,
      firstname: '',
      lastname: '',
      phone: '',
      email: '',
      message: '',
      recaptchaResponse: '',
      white_checkmark: `${themosis_assets}/images/icons/white_checkmark.svg`,
      recaptchaKey: process.env.MIX_RECAPTCHA_PUBLIC_KEY,
    }
  },
  methods: {
    hideErrorModal() {
      this.error = '';
    },
    hideFloatingCta() {
      const $mobileFixedCta = $('.header__cta-button--mobile');
      if (!$mobileFixedCta.length) {
        return;
      }
      $mobileFixedCta.toggleClass('hidden', true);
    },
    showFloatingCta() {
      const $mobileFixedCta = $('.header__cta-button--mobile');
      if (!$mobileFixedCta.length) {
        return;
      }
      $mobileFixedCta.toggleClass('hidden', false);
    },
    onVerify(response) {
      this.recaptchaResponse = response;
      this.submitForm();
    },
    onExpired() {
      this.resetRecaptcha();
    },
    onError() {
      this.resetRecaptcha();
    },
    resetRecaptcha() {
      this.recaptchaResponse = '';
      this.$refs.recaptcha.reset();
    },
    async submitForm() {
      this.loading = true;
      try {
        let response = await axios.post(`/cms/wp-admin/admin-ajax.php?action=${this.action}`, {
          firstname: this.firstname,
          lastname: this.lastname,
          email: this.email,
          phone: '+56' + this.phone,
          accepts_terms: this.accepts_terms,
          message: this.message,
          recaptchaResponse: this.recaptchaResponse
        });

        const { data } = response;

        if (data.success) {
          window.location.href = this.typ;
        }
      } catch (error) {
        console.error(error);
        this.error = error.toString();
      } finally {
        this.loading = false;
      }
    },
    async handleSubmit() {
      const isValid = await this.$refs.form.validate();

      if (!isValid) return;

      this.$refs.recaptcha.execute();
    }
  }
}
</script>
