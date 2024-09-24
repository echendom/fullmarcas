<template>
  <div class="step1 step5" v-if="loaded">
    <div class="step1__content">
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
      <div class="step1__form-container">
        <validation-observer ref="form" v-slot="{ invalid }" slim>
          <form class="step1__form" @submit.prevent="handleSubmit">
            <h2 class="step5__form-title">Datos del titular</h2>
            <div class="step5__types">
              <label
                :class="[
                  inputs['type'] === 'persona-natural' ? 'step5__type--selected' : 'step5__type'
                ]"
              >
                <span class="step5__type-input-circle"></span>
                Persona natural
                <input
                  class="step5__type-input-radio"
                  type="radio"
                  value="persona-natural"
                  v-model="inputs['type']"
                />
              </label>
              <label
                :class="[
                  inputs['type'] === 'empresa' ? 'step5__type--selected' : 'step5__type'
                ]"
              >
                <span class="step5__type-input-circle"></span>
                Empresa
                <input
                  class="step5__type-input-radio"
                  type="radio"
                  value="empresa"
                  v-model="inputs['type']"
                />
              </label>
            </div>
            <div class="step5__row" v-if="inputs.type === 'persona-natural'">
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
                    'form-input-field__label',
                    errors.length ? 'form-input-field__label--error' : ''
                  ]"
                >
                  Nombre
                  <input
                    class="form-input-field__input"
                    :class="errors.length ? 'form-input-field__input--error' : ''"
                    v-model="inputs['firstName']"
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
                name="lastname"
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
                  Apellido
                  <input
                    class="form-input-field__input"
                    :class="errors.length ? 'form-input-field__input--error' : ''"
                    v-model="inputs['lastname']"
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
            </div>
            <div class="step5__row--single-column" v-else>
              <validation-provider
                name="company_name"
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
                  Nombre empresa
                  <input
                    class="form-input-field__input"
                    :class="errors.length ? 'form-input-field__input--error' : ''"
                    v-model="inputs['company_name']"
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
            </div>
            <div class="step5__row--single-column" v-if="inputs.type === 'persona-natural'">
              <validation-provider
                name="rut"
                rules="required|rut"
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
                  Rut
                  <input
                    class="form-input-field__input"
                    :class="errors.length ? 'form-input-field__input--error' : ''"
                    v-model="inputs['rut']"
                    v-input-rut
                    maxlength="12"
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
                  Ejemplo: 21954132-5
                </span>
              </validation-provider>
            </div>
            <div class="step5__row" v-else>
              <validation-provider
                name="company_rut"
                rules="required|rut"
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
                  Rut empresa
                  <input
                    class="form-input-field__input"
                    :class="errors.length ? 'form-input-field__input--error' : ''"
                    v-model="inputs['company_rut']"
                    v-input-rut
                    maxlength="12"
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
                  Ejemplo: 21954132-5
                </span>
              </validation-provider>
              <validation-provider
                name="company_giro"
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
                  Giro
                  <input
                    class="form-input-field__input"
                    :class="errors.length ? 'form-input-field__input--error' : ''"
                    v-model="inputs['company_giro']"
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
            </div>
            <div class="step5__row">
              <validation-provider
                name="email_owner"
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
                  Email
                  <input
                    class="form-input-field__input"
                    :class="errors.length ? 'form-input-field__input--error' : ''"
                    v-model="inputs['email_owner']"
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
              <validation-provider
                name="phone"
                rules="required|min:11"
                :bails="true"
                tag="div"
                class="form-input-field"
                v-slot="{ errors }"
                :customMessages="{
                  min: 'Número telefónico inválido',
                }"
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
                      name="phone"
                      key="phone"
                      class="form-input-field__input--phone"
                      :class="errors.length ? 'form-input-field__input--error' : ''"
                      v-model="inputs['phone']"
                      v-mask="'# #### ####'"
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
            </div>
            <div class="step5__row">
              <validation-provider
                name="address"
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
                  Dirección
                  <input
                    class="form-input-field__input"
                    :class="errors.length ? 'form-input-field__input--error' : ''"
                    v-model="inputs['address']"
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
              </validation-provider>
            </div>
            <div class="step5__row step5__row--selects">
              <validation-provider
                name="region"
                rules="required|is_not:Selecciona"
                :bails="true"
                tag="div"
                class="form-input-field"
                v-slot="{ errors }"
              >
                <label
                  class="fake-select-container fake-select-container--full-width"
                  v-click-outside="closeSelectRegion"
                  v-if="regions && regions.length"
                >
                  <span class="fake-select-container__label">
                    Región
                  </span>
                  <span
                    :class="[
                      select_region_open ?
                      'fake-select-container__fake-select--open' :
                      'fake-select-container__fake-select',
                      region_selected ?
                      'fake-select-container__fake-select--has-selected' :
                      ''
                    ]"
                    @click.stop="handleDropdownRegion"
                  >
                    {{ inputs.region }}
                    <img
                      class="fake-select-container__chevron-down"
                      :src="`${themosis_assets}/images/icons/black_chevron-down.svg`"
                      alt="Icono flecha"
                      width="20"
                      height="20"
                      loading="lazy"
                    />
                  </span>
                  <v-select
                    :options="regions.map(data => data.region)"
                    :searchable="false"
                    v-model="inputs.region"
                    label="region"
                    :clearable="false"
                    :dropdown-should-open="() => select_region_open"
                    class="fake-select-container__real-select"
                    @input="closeSelectRegion"
                  >
                  </v-select>
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
              <validation-provider
                name="comuna"
                rules="required|is_not:Selecciona" 
                :bails="true"
                tag="div"
                class="form-input-field"
                v-slot="{ errors }"
              >
                <label
                  class="fake-select-container fake-select-container--full-width"
                  v-click-outside="closeSelectComuna"
                >
                  <span class="fake-select-container__label">
                    Comuna
                  </span>
                  <span
                    :class="[
                      select_comuna_open ?
                      'fake-select-container__fake-select--open' :
                      'fake-select-container__fake-select',
                      comuna_selected ?
                      'fake-select-container__fake-select--has-selected' :
                      ''
                    ]"
                    :disabled="!comunas || !comunas.length"
                    @click.stop="handleDropdownComuna"
                  >
                    {{ inputs.comuna }}
                    <img
                      class="fake-select-container__chevron-down"
                      :src="`${themosis_assets}/images/icons/black_chevron-down.svg`"
                      alt="Icono flecha"
                      width="20"
                      height="20"
                      loading="lazy"
                    />
                  </span>
                  <v-select
                    :options="comunas"
                    v-model="inputs.comuna"
                    :searchable="false"
                    :clearable="false"
                    :dropdown-should-open="() => select_comuna_open"
                    class="fake-select-container__real-select"
                    @input="closeSelectComuna"
                    :disabled="!comunas || !comunas.length"
                  >
                  </v-select>
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
            <div class="step5__add-owner">
              <div v-if="otherOwners.length" class="step5__other-owners">
                <h3 class="step5__other-owners-title">Otros titulares:</h3>
                <div v-for="(owner, index) in otherOwners" class="step5__other-owner">
                  <div class="step5__other-owner-data paragraph">
                    Nombre: <strong>{{ owner.name }}</strong>
                  </div>
                  <div class="step5__other-owner-data paragraph">
                    Rut: <strong>{{ owner.rut }}</strong>
                  </div>
                  <div class="step5__other-owner-data paragraph">
                    Email: <strong>{{ owner.email }}</strong>
                  </div>
                  <button
                    class="step5__other-owner-delete paragraph button--secondary-white"
                    type="button"
                    @click="deleteOwner(index)"
                  >
                    Eliminar titular
                  </button>
                </div>
              </div>

              <button
                v-if="!addingNewOwner"
                class="step5__add-owner-button"
                @click="addingNewOwner = true"
              >
                <img
                  class="step5__add-owner-plus-icon"
                  :src="plusIcon"
                  alt="Icono plus"
                  width="20"
                  height="20"
                />
                <span class="step5__add-owner-text">
                  Agregar otro titular
                </span>
              </button>
              <div
                v-else
                class="step5__add-owner-form"
              >
                <h3 class="step5__add-owner-title">
                  Ingresa los datos
                </h3>
                <div class="step5__add-owner-rows">
                  <div class="step5__row">
                    <validation-provider
                      name="other_name"
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
                        Nombre
                        <input
                          class="form-input-field__input"
                          :class="errors.length ? 'form-input-field__input--error' : ''"
                          v-model="inputs['other_owner_name']"
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
                    </validation-provider>
                    <validation-provider
                      name="other_rut"
                      rules="required|rut"
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
                        Rut
                        <input
                          class="form-input-field__input"
                          :class="errors.length ? 'form-input-field__input--error' : ''"
                          v-model="inputs['other_owner_rut']"
                          v-input-rut
                          maxlength="12"
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
                    </validation-provider>
                  </div>
                  <div class="step5__row--single-column">
                    <validation-provider
                      name="other_email"
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
                        Email
                        <input
                          class="form-input-field__input"
                          :class="errors.length ? 'form-input-field__input--error' : ''"
                          v-model="inputs['other_owner_email']"
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
                  </div>
                </div>
                <div class="step5__add-owner-actions">
                  <button class="button--primary-inverted" @click="addOwner" type="button">Agregar titular</button>
                  <button class="button--secondary-white" @click="addingNewOwner = false" type="button">Cancelar</button>
                </div>
              </div>
            </div>
            <validation-provider
              name="terms"
              :rules="{required: { allowFalse: false }}"
              :bails="true"
              tag="div"
              class="step5__consent"
              v-slot="{ errors }"
            >
              <label
                :class="[
                  'form-input-field__label--checkbox',
                  errors.length ? 'form-input-field__label--error' : ''
                ]"
              >
                <span
                  :class="inputs['accepts_terms'] ? 'form-input-field__checkmark--checked' : 'form-input-field__checkmark'"
                >
                  <img
                    v-if="inputs['accepts_terms']"
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
                  v-model="inputs['accepts_terms']"
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
            <div class="step5__payment-method-section">
              <h2 class="step5__payment-method-title" v-if="payment_title">
                {{ payment_title }}
              </h2>
              <validation-provider
                name="type"
                rules="required"
                :bails="true"
                tag="div"
                class="step5__payment-methods"
                v-slot="{ errors }"
              >
                <label
                  v-for="payment_method in payment_methods"
                  :key="payment_method['key']"
                  :class="[
                    payment_method['key'] === inputs['payment_method'] ? 'step5__payment-method--selected' : 'step5__payment-method'
                  ]"
                >
                  <div class="step5__payment-method-input">
                    <span class="step5__payment-method-input-circle"></span>
                    <span class="step5__payment-method-input-text">
                      {{ payment_method['title'] }}
                    </span>
                    <input
                      class="step5__payment-method-input-radio"
                      type="radio"
                      :value="payment_method['key']"
                      v-model="inputs['payment_method']"
                    />
                  </div>
                  <img
                    class="step5__payment-method-image"
                    :src="payment_method['logo']['url']"
                    :alt="payment_method['logo']['alt']"
                    loading="lazy"
                  />
                </label>
                <div class="step1__types-errors" v-if="errors.length">
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
          </form>
        </validation-observer>
        <h2
          v-if="orderData.total"
          class="step5__total-info"
        >
          Total a pagar: <span class="step5__total-price">{{ orderData.total }}</span>
        </h2>
      </div>
    </div>
    <img
      v-if="side_image"
      class="step1__image"
      :src="side_image['url']"
      :alt="side_image['alt']"
      width="520"
      height="550"
    />
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";
import ClickOutside from 'vue-click-outside';
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import { required, email, is_not, min } from 'vee-validate/dist/rules';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

extend('required', {
  ...required,
  message: 'Este campo es requerido'
});
extend('is_not', {
  ...is_not,
  message: 'Este campo es requerido'
});
extend('email', {
  ...email,
  message: 'Dirección de correo electrónico inválida'
});
extend('min', {
  ...min,
  message: 'Número telefónico inválido'
});
extend('rut', {
  validate: function (rut) {
    if (typeof rut !== 'string') {
      return false;
    }

    var cRut = rut.replace(/[\.-]/g, '');
    var cDv = cRut.charAt(cRut.length - 1).toUpperCase();
    var nRut = parseInt(cRut.substr(0, cRut.length - 1));
    if (isNaN(nRut)) {
      return false;
    }

    var sum = 0;
    var factor = 2;

    nRut = nRut.toString();
    for (var i = nRut.length - 1; i >= 0; i--) {
      sum = sum + nRut.charAt(i) * factor;
      factor = (factor + 1) % 8 || 2;
    }

    var computedDv = 0;

    switch (sum % 11) {
      case 1:
        computedDv = 'k';
        break;
      case 0:
        computedDv = 0;
        break;
      default:
        computedDv = 11 - sum % 11;
        break;
    }

    return computedDv.toString().toUpperCase() === cDv.toString().toUpperCase();
  },
  message: 'El RUT no es válido',
});

const defaultRegion = 'Selecciona';
const defaultComuna = 'Selecciona';

export default {
  name: 'Step5',
  directives: {
    ClickOutside
  },
  components: {
    ValidationObserver,
    ValidationProvider,
    vSelect,
  },
  props: [
    'side_image',
    'terms',
    'payment_methods',
    'payment_title',
    'regions'
  ],
  data() {
    return {
      loaded: false,
      editIcon: `${themosis_assets}/images/icons/black_edit_icon.svg`,
      white_checkmark: `${themosis_assets}/images/icons/white_checkmark.svg`,
      plusIcon: `${themosis_assets}/images/icons/black_plus.svg`,
      themosis_assets: themosis_assets,
      loading: false,
      select_region_open: false,
      select_comuna_open: false,
      select_city_open: false,
      addingNewOwner: false,
      otherOwners: [],
      inputs: {
        company_name: '',
        company_rut: '',
        company_giro: '',
        firstname: '',
        lastname: '',
        email_owner: '',
        type: 'persona-natural',
        region: defaultRegion,
        comuna:  defaultComuna,
        rut: '',
        phone: '',
        other_owner_name: '',
        other_owner_rut: '',
        other_owner_email: '',
        accepts_terms: true,
        payment_method: this.payment_methods[0].key
      }
    }
  },
  created() {
    const { step4, step3, step2, step1 } = this.globalInputs;
    if (!step4 && !step3 && !step2 && !step1) {
      this.$router.replace({name: 'informacion'});
    } else if (!step4 && !step3 && !step2) {
      this.$router.replace({name: 'categorias'});
    } else if (!step4 && !step3) {
      this.$router.replace({name: 'subcategorias'});
    } else if (!step4) {
      this.$router.replace({name: 'resultados'});
    } else {
      this.loaded = true;
    }
  },
  computed: {
    comunas() {
      const selectedRegion = this.inputs.region;
      const comunasOptions = this.regions.find(({region}) => region === selectedRegion);
      if (comunasOptions && comunasOptions.comunas) {
        return comunasOptions.comunas;
      }
      return [];
    },
    region_selected() {
      return this.inputs.region !== 'Selecciona';
    },
    comuna_selected() {
      return this.inputs.comuna !== 'Selecciona';
    },
    city_selected() {
      return this.inputs.city !== 'Selecciona';
    },
    ...mapState([
        'nextFlag',
        'prevFlag',
        'stepperTitle',
        'globalInputs',
        'orderData'
      ]
    )
  },
  beforeMount() {
    window.scrollTo({ top: 0 });
  },
  methods: {
    deleteOwner(index) {
      const result = [...this.otherOwners];
      result.splice(index, 1);
      this.otherOwners = result;
    },
    addOwner() {
      const {
        other_owner_name,
        other_owner_rut,
        other_owner_email
      } = this.inputs;
      if (!(other_owner_name && other_owner_rut && other_owner_email)) {
        return;
      }
      this.otherOwners = [
        ...this.otherOwners,
        {
          name: other_owner_name,
          rut: other_owner_rut,
          email: other_owner_email
        }
      ];
      this.inputs.other_owner_name = '';
      this.inputs.other_owner_rut = '';
      this.inputs.other_owner_email = '';
      this.addingNewOwner = false;
    },
    closeSelectRegion() {
      this.select_region_open = false;
    },
    handleDropdownRegion() {
      this.select_region_open = !this.select_region_open;
    },
    closeSelectComuna() {
      this.select_comuna_open = false;
    },
    handleDropdownComuna() {
      if (this.comunas && this.comunas.length) {
        this.select_comuna_open = !this.select_comuna_open;
      }
    },
    closeSelectCity() {
      this.select_city_open = false;
    },
    handleDropdownCity() {
      this.select_city_open = !this.select_city_open;
    },
    async submitAndNext() {
      this.updateGlobalInputs({
        step5: {
          inputs: this.inputs,
          otherOwners: this.otherOwners
        }
      });
      try {
        const response = await this.submitData({
          action: 'step-5',
          method: 'post',
          payload: {
            ...this.inputs,
            phone: '+56' + this.inputs.phone,
            other_owners: this.otherOwners
          }
        });

        const { data } = response;

        if (data.success) {
          window.location.href = data.redirect;
        }
      } catch (error) {
        console.log('error in step5 submitAndNext:', error);
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
      this.updateGlobalInputs({
        step5: {
          inputs: this.inputs,
          otherOwners: this.otherOwners
        }
      });

      this.$router.back();
    },
    goToFirstStep() {
      this.$router.go(-4);
    },
    ...mapMutations([
      'stopLoading',
      'updateGlobalInputs'
    ]),
    ...mapActions([
      'submitData'
    ])
  },
  mounted() {
    const { step5 } = this.globalInputs;
    if (!step5 || !step5.inputs) {
      return;
    }
    this.inputs = step5.inputs;
    this.otherOwners = step5.otherOwners;
  },
  watch: {
    nextFlag() {
      this.handleSubmit();
    },
    prevFlag() {
      this.handlePrev();
    }
  }
}
</script>
