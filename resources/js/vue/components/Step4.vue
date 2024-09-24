<template>
  <div class="step4" v-if="loaded">
    <div class="step4__content">
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
        <h2 v-if="title" class="step4__title">
          {{ title }}
        </h2>
        <p
          v-if="globalInputs.step1.trademarkName"
          class="step1__description step2__trademark-name step2__trademark-name--highlight paragraph"
        >
          {{ globalInputs.step1.trademarkName }}
        </p>
        <div class="step4__overview">
          <img
            class="step4__lock-image"
            :src="lockImages[orderData.risk.level]"
            alt="Candado rojo"
            width="80"
            height="130"
          />
          <div class="step4__overview-content">
            <div class="step4__overview-header-container">
              <div class="step4__overview-header">
                <div class="step4__overview-details">
                  <h3 class="step4__overview-risk-title">
                    {{ orderData.risk.title }}
                  </h3>
                  <p class="step4__overview-risk-description paragraph">
                    {{ orderData.risk.description }}
                  </p>
                </div>
                <button
                  v-if="orderData.risk.level !== 'low'"
                  class="step4__overview-modal-button"
                  @click="openOptionsModal"
                >
                  <img
                    class="step4__overview-modal-icon"
                    :src="info_icon"
                    alt="Icono informacion"
                    width="30"
                    height="30"
                  />
                  {{ options_button }}
                </button>
              </div>
              <div
                v-if="showSimilarity"
                class="step4__similarities-container"
              >
                <h3 class="step4__similarities-heading">Resultados</h3>
                <div class="paragraph">
                  <ul class="step4__similarities-list">
                    <li class="step4__similarity" v-for="similarity in orderData.similarity">
                      <div class="step4__similarity-description paragraph">
                        {{ similarity['denomination'] }}
                        -
                        Clase {{ similarity['classes'] }}
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="step4__overview-body">
              <div class="step4__domain-details">
                <div class="step4__domain-availability">
                  <h3 class="step4__availability-title">Disponibilidad en NIC</h3>
                  <span
                    class="step4__availability-status"
                    :class="[
                      orderData.available_domain ?
                      'step4__availability-status--available' :
                      'step4__availability-status--not-available'
                    ]"
                  >
                    {{
                      orderData.available_domain ?
                      'Disponible' : 'No disponible'
                    }}
                    <img
                      :src="orderData.available_domain ? checkmark : closeModalIcon"
                      class="step4__availability-icon"
                      alt="Icono check"
                      width="20"
                      height="20"
                    />
                  </span>
                </div>
                <div class="step4__domain-data" v-if="orderData.available_domain">
                  <span class="step4__domain-name">
                    {{ orderData.suggested_domain }}
                  </span>
                  <label class="step4__add-domain form-input-field__label--checkbox">
                    <span class="form-input-field__checkbox-text">
                      Agregar servicio
                    </span>
                    <span
                      :class="inputs.addDomainService ? 'form-input-field__checkmark--checked' : 'form-input-field__checkmark'"
                    >
                      <img
                        v-if="inputs.addDomainService"
                        class="form-input-field__checkmark-icon"
                        :src="whiteCheckmark"
                        alt="Icono check"
                        width="12"
                        height="12"
                        loading="lazy"
                        role="presentation"
                      >
                    </span>
                    <input
                      class="form-input-field__input--checkbox"
                      type="checkbox"
                      v-model="inputs.addDomainService"
                    />
                  </label>
                </div>
              </div>
              <div
                class="step4__overview-disclaimer paragraph--small"
                v-html="orderData.disclaimer"
              ></div>
            </div>
          </div>
        </div>
        <div class="step4__selected-classes">
          <h2 class="step4__selected-classes-title">
            Clases seleccionadas ({{inputs.selectedClassesKeys.length}})
            <img
              class="step4__selected-classes-title-icon"
              :src="accordionIcon"
              alt="Icono acordeon"
              width="30"
              height="30"
              loading="lazy"
            />
          </h2>
          <div class="step4__selected-classes-container">
            <p
              v-if="inputs.selectedClassesKeys.length === 0"
              class="step4__selected-classes-error paragraph--small form-input-field__error"
            >
              Seleccione al menos una clase
            </p>
            <div class="step4__subcategories-options">
              <label
                v-for="subcategoryClass in inputs.selectedClasses"
                :key="subcategoryClass['key']"
                :class="inputs.selectedClassesKeys.includes(subcategoryClass.key) ?
                'step3__subcategory-option--selected' : 'step3__subcategory-option'"
              >
                <div class="step3__subcategory-details">
                  <span
                    class="step3__subcategory-title"
                  >
                    Clase {{ subcategoryClass['key'] }}
                  </span>
                  <span
                    v-if="subcategoryClass['title']"
                    class="step3__subcategory-description"
                    v-html="subcategoryClass['title']"
                  ></span>
                </div>
                <span class="step3__input-checkmark">
                  <img
                    v-if="inputs.selectedClassesKeys.includes(subcategoryClass.key)"
                    class="step3__input-checkmark-icon"
                    :src="whiteCheckmark"
                    alt="Icono check"
                    width="12"
                    height="12"
                    role="presentation"
                  >
                </span>
                <input
                  class="step3__subcategory-input-tag"
                  type="checkbox"
                  :value="subcategoryClass.key"
                  @change="recordLastClassChecked"
                  v-model="inputs.selectedClassesKeys"
                >
              </label>
            </div>
            <div class="step4__add-class-section">
              <button
                v-if="!addingNewClass"
                class="step4__add-class-button button-add"
                @click="openAddForm"
              >
                <img
                  class="button-add__icon"
                  :src="plusIcon"
                  alt="Icono plus"
                  width="20"
                  height="20"
                />
                <span class="button-add__text">
                  Agregar nueva clase
                </span>
              </button>
              <div v-else class="step4__add-class-form">
                <div class="step4__add-class-inputs">
                  <label
                    class="fake-select-container"
                    v-click-outside="closeCategorySelect"
                    v-if="categories && categories.length"
                  >
                    <span class="fake-select-container__label">
                      Tus Categorías
                    </span>
                    <span
                      :class="[
                        select_category_open ?
                        'fake-select-container__fake-select--open' :
                        'fake-select-container__fake-select',
                        inputs.newClassCategory['key'] !== 'default-category' ?
                        'fake-select-container__fake-select--has-selected' :
                        ''
                      ]"
                      @click.stop="handleDropdownCategory"
                    >
                      {{ inputs.newClassCategory['title'] || 'Selecciona' }}
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
                      :options="categories"
                      v-model="inputs.newClassCategory"
                      label="title"
                      :clearable="false"
                      :dropdown-should-open="() => select_category_open"
                      class="fake-select-container__real-select"
                      @input="inputCategorySelect"
                    >
                    </v-select>
                    <p v-if="missingCategoryError" class="paragraph--small form-input-field__error">
                      Seleccione una categoría
                    </p>
                  </label>
                  <label
                    class="blog-listing__filter fake-select-container"
                    v-click-outside="closeSubcategorySelect"
                  >
                    <span class="blog-listing__filter-label">
                      Sub-categoría
                    </span>
                    <span class="blog-listing__search-field">
                      <img
                        class="blog-listing__search-icon"
                        :src="magnifyingGlass"
                        alt="Lupa"
                        width="20"
                        height="20"
                        loading="lazy"
                      />
                      <input
                        class="blog-listing__search-input"
                        type="text"
                        :disabled="inputs.newClassCategory['key'] === 'default-category'"
                        v-model="inputs.newClassQuery"
                        @input="debounceSearchSubcategories"
                        @focus="handleDropdownSubcategory"
                        placeholder="Buscar..."
                      />
                    </span>
                    <v-select
                      :options="subcategories"
                      v-model="inputs.newClassSubcategory"
                      label="title"
                      :clearable="false"
                      :dropdown-should-open="() => select_subcategory_open"
                      class="fake-select-container__real-select"
                      @input="inputSubcategorySelect"
                    >
                      <template #option="{ title, description }">
                        <div
                          class="h4 fake-select-container__option-title"
                          v-if="title"
                        >{{ title }}</div>
                        <div
                          class="paragraph--small fake-select-container__option-description"
                          v-if="description"
                          v-html="description"
                        ></div>
                      </template>
                      <template v-slot:no-options="{ search, searching }">
                        <em v-if="loadingSubcategories" style="opacity: 0.5">Busca una categoría</em>
                        <template v-else>
                          Sin resultados.
                        </template>
                      </template>
                    </v-select>
                    <p v-if="missingSubcategoryError" class="paragraph--small form-input-field__error">
                      Seleccione una subcategoría
                    </p>
                  </label>
                </div>
                <div class="step4__add-class-footer">
                  <button class="button--primary-inverted" @click="addNewClass">
                    Agregar clase
                  </button>
                  <button class="button--secondary-white" @click="hideAddForm">
                    Cancelar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="step4__services-section">
          <h2 class="step4__services-title">
            Detalles del servicio
            <img
              class="step4__services-title-icon"
              :src="accordionIcon"
              alt="Icono acordeon"
              width="30"
              height="30"
              loading="lazy"
            />
          </h2>
          <div class="step4__services">
            <div
              class="step4__service"
              v-for="(service, index) in computedSelectedServices"
              :key="`${service['key']}-${index}`"
            >
              <span class="step4__service-icon-container">
                <img
                  class="step4__service-icon"
                  :src="checkmark_2"
                  alt="Icono check"
                  width="20"
                  height="20"
                  loading="lazy"
                />
              </span>
              <span class="step4__service-title paragraph--large">
                {{ service['title'] }}
              </span>
            </div>
          </div>
        </div>

        <div
          v-if="orderData.summary"
          class="step4__summary step4__summary--mobile"
        >
          <h2 class="step4__summary-title">
            Tu cotización para
            <strong>{{ globalInputs.step1.trademarkName }}</strong>
          </h2>
          <div class="step4__summary-services">
            <div
              v-for="(service, index) in computedSelectedServices"
              :key="`${service['key']}-${index}`"
              class="step4__summary-service"
            >
              <h3 class="step4__summary-service-title">
                {{ service['title'] }}
              </h3>
              <div class="step4__summary-service-details">
                <div class="step4__summary-service-detail-container">
                  <div
                    v-if="service['discount_perc'] && (+service['discount_perc'] > 0)"
                    class="step4__summary-service-discount-data"
                  >
                    <div class="step4__summary-service-discount-row">
                      <h4 class="step4__summary-service-discount-row-title">
                        Precio:
                      </h4>
                      <span class="step4__summary-service-discount-row-price">
                        {{ service['net_price'] }}
                      </span>
                    </div>
                    <div class="step4__summary-service-discount-row">
                      <h4 class="step4__summary-service-discount-row-title">
                        Porcentaje de DESCUENTO:
                      </h4>
                      <span class="step4__summary-service-discount-row-price">
                        {{ service['discount_perc'] }}%
                      </span>
                    </div>
                    <div class="step4__summary-service-discount-row">
                      <h4 class="step4__summary-service-discount-row-title">
                        DESCUENTO:
                      </h4>
                      <span class="step4__summary-service-discount-row-price">
                        {{ service['discount_value'] }}
                      </span>
                    </div>
                  </div>
                  <div class="step4__summary-service-detail">
                    <h4 class="step4__summary-service-detail-title">
                      Total:
                    </h4>
                    <span class="step4__summary-service-detail-price">
                      {{ service['price'] }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="step4__summary-footer">
            <div class="step4__summary-total">
              <span>Total</span>
              <span>{{ computedOrderTotal }}</span>
            </div>
            <p class="paragraph">
              Tasas finales no incluidas.
            </p>
            <!-- <button
              v-if="orderData.summary.details_modal"
              class="step4__summary-details-button"
              @click="openDetailsModal"
            >
              Ver detalle
            </button> -->
          </div>

          <div class="step4__summary-discount">
            <label for="discountCode" class="step4__summary-service-title">Código de descuento</label>
            <div class="step4__summary-discount__content">
              <input id="discountCode" v-model="discountCode" class="form-input-field__input" type="text" />
              <button
                type="button"
                class="button button--primary-inverted"
                @click="applyDiscountCode"
                :disabled="!discountCode"
              >
                Aplicar
              </button>
            </div>

            <p v-if="discountCouponMessage" class="form-input field__error paragraph--small">
                {{ discountCouponMessage }}
              </p>
          </div>
        </div>

        <div class="step4__faq-section" v-if="faq">
          <div class="step4__faq-header">
            <h2 class="step4__faq-title" v-if="faq['title']">{{ faq['title'] }}</h2>
            <div class="step4__faq-description paragraph" v-html="faq['description']"></div>
          </div>
          <div class="step4__faq-items">
            <template v-for="(item, index) in faq['items']">
              <h3 class="step4__faq-item-title">
                {{ item['title'] }}
                <span class="step4__faq-cross"></span>
              </h3>
              <div class="step4__faq-item-content paragraph" v-html="item['content']"></div>
            </template>
          </div>
        </div>
      </div>
    </div>
    <div
      v-if="orderData.summary"
      class="step4__summary step4__summary--desktop"
    >
      <h2 class="step4__summary-title">
        Tu cotización para
        <strong>{{ globalInputs.step1.trademarkName }}</strong>
      </h2>
      <div class="step4__summary-services">
        <div
          v-for="(service, index) in computedSelectedServices"
          :key="`${service['key']}-${index}`"
          class="step4__summary-service"
        >
          <h3 class="step4__summary-service-title">
            {{ service['title'] }}
          </h3>
          <div class="step4__summary-service-details">
            <div class="step4__summary-service-detail-container">
              <div
                v-if="service['discount_perc'] && (+service['discount_perc'] > 0)"
                class="step4__summary-service-discount-data"
              >
                <div class="step4__summary-service-discount-row">
                  <h4 class="step4__summary-service-discount-row-title">
                    Precio:
                  </h4>
                  <span class="step4__summary-service-discount-row-price">
                    {{ service['net_price'] }}
                  </span>
                </div>
                <div class="step4__summary-service-discount-row">
                  <h4 class="step4__summary-service-discount-row-title">
                    Porcentaje de DESCUENTO:
                  </h4>
                  <span class="step4__summary-service-discount-row-price">
                    {{ service['discount_perc'] }}%
                  </span>
                </div>
                <div class="step4__summary-service-discount-row">
                  <h4 class="step4__summary-service-discount-row-title">
                    DESCUENTO:
                  </h4>
                  <span class="step4__summary-service-discount-row-price">
                    {{ service['discount_value'] }}
                  </span>
                </div>
              </div>
              <div class="step4__summary-service-detail">
                <h4 class="step4__summary-service-detail-title">
                  Total:
                </h4>
                <span class="step4__summary-service-detail-price">
                  {{ service['price'] }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="step4__summary-footer">
        <div class="step4__summary-total">
          <span>Total</span>
          <span>{{ computedOrderTotal }}</span>
        </div>
        <p class="paragraph">
          Tasas finales no incluidas.
        </p>
        <!-- <button
          v-if="orderData.summary.details_modal"
          class="step4__summary-details-button"
          @click="openDetailsModal"
        >
          Ver detalle
        </button> -->
      </div>

      
      <div class="step4__summary-discount">
        <label for="discountCode" class="step4__summary-service-title">Código de descuento</label>
        <div class="step4__summary-discount__content">
          <input id="discountCode" v-model="discountCode" class="form-input-field__input" type="text" />
          <button
            type="button"
            class="button button--primary-inverted"
            @click="applyDiscountCode"
            :disabled="!discountCode"
          >
            Aplicar
          </button>
        </div>

        <p v-if="discountCouponMessage" class="form-input field__error paragraph--small">
            {{ discountCouponMessage }}
          </p>
      </div>
    </div>

    <transition name="fade" appear>
      <div
        v-if="showOptionsModal"
        class="modal-overlay"
        @click="hideOptionsModal"
      ></div>
    </transition>
    <transition name="pop" appear>
      <div
        v-if="showOptionsModal"
        class="modal"
        role="dialog"
      >
        <div class="step4__options-modal">
          <h2 class="step4__options-label">
            <img
              class="step4__options-label-icon"
              :src="info_icon"
              alt="Icono informacion"
              width="30"
              height="30"
              loading="lazy"
            />
            {{ options_label }}
            <button @click="hideOptionsModal" class="step4__close-modal-button">
              <img
                class="step4__close-modal-icon"
                :src="closeModalIcon"
                alt="Icono cerrar modal"
                loading="lazy"
                width="24"
                height="24"
              />
            </button>
          </h2>
          <div class="step4__option">
            <h3 class="step4__option-title">
              {{ option_continue_title }}
            </h3>
            <div class="step4__option-content paragraph" v-html="option_continue_content"></div>
            <button @click="hideOptionsModal" class="button--primary-inverted">{{ option_continue_button }}</button>
          </div>
          <div class="step4__option">
            <h3 class="step4__option-title">
              {{ option_rename_title }}
            </h3>
            <div class="step4__option-content paragraph" v-html="option_rename_content"></div>
            <button @click="goToFirstStep" class="button--primary-inverted">{{ option_rename_button }}</button>
          </div>
        </div>
      </div>
    </transition>
    <transition name="fade" appear v-if="orderData.summary.details_modal">
      <div
        v-if="showDetailsModal"
        class="modal-overlay"
        @click="hideDetailsModal"
      ></div>
    </transition>
    <transition name="pop" appear v-if="orderData.summary.details_modal">
      <div
        v-if="showDetailsModal"
        class="modal modal--details"
        role="dialog"
      >
        <div class="step4__details-modal">
          <h2 class="step4__details-label">
            <img
              class="step4__details-label-icon"
              :src="info_icon"
              alt="Icono informacion"
              width="30"
              height="30"
              loading="lazy"
            />
            {{ orderData.summary.details_modal['title'] }}
            <button @click="hideDetailsModal" class="step4__close-modal-button">
              <img
                class="step4__close-modal-icon"
                :src="closeModalIcon"
                alt="Icono cerrar modal"
                loading="lazy"
                width="24"
                height="24"
              />
            </button>
          </h2>
          <div
            class="step4__details-modal-content paragraph"
            v-html="orderData.summary.details_modal['content']"
          ></div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import ClickOutside from 'vue-click-outside';

const baseUrl = '/cms/wp-admin/admin-ajax.php';

const defaultNewClassCategory = {
  title: 'Selecciona',
  key: 'default-category'
};
const defaultNewClassSubcategory = {
  title: 'Selecciona',
  key: 'default-subcategory'
};

export default {
  name: 'Step4',
  directives: {
    ClickOutside
  },
  components: {
    vSelect,
},
  props: [
    'title',
    'faq',
    'help_banner',
    'options_button',
    'options_label',
    'option_continue_title',
    'option_continue_content',
    'option_continue_button',
    'option_rename_title',
    'option_rename_content',
    'option_rename_button'
  ],
  data() {
    const lockImages = {
      low: `${themosis_assets}/images/animations/lock_green.svg`,
      warning: `${themosis_assets}/images/animations/lock_yellow.svg`,
      high: `${themosis_assets}/images/animations/lock_red.svg`,
    };
    return {
      loaded: false,
      editIcon: `${themosis_assets}/images/icons/black_edit_icon.svg`,
      whiteCheckmark: `${themosis_assets}/images/icons/white_checkmark.svg`,
      checkmark: `${themosis_assets}/images/icons/black_check_1.svg`,
      checkmark_2: `${themosis_assets}/images/icons/black_checkmark.svg`,
      info_icon: `${themosis_assets}/images/icons/skyblue_info_icon.svg`,
      plusIcon: `${themosis_assets}/images/icons/black_plus.svg`,
      redLock: `${themosis_assets}/images/animate_red_lock.svg`,
      magnifyingGlass: `${themosis_assets}/images/icons/black_magnifying-glass-icon.svg`,
      closeModalIcon: `${themosis_assets}/images/icons/black_delete_file_icon.svg`,
      accordionIcon: `${themosis_assets}/images/icons/black_chevron-down.svg`,
      lockImages,
      select_category_open: false,
      select_subcategory_open: false,
      addingNewClass: false,
      missingCategoryError: false,
      missingSubcategoryError: false,
      showOptionsModal: false,
      showDetailsModal: false,
      loading: false,
      loadingSubcategories: true,
      initializedTabs: false,
      categories: [],
      subcategories: [],
      themosis_assets: themosis_assets,
      searchTimeout: null,
      discountCode: '',
      couponState: '',
      discountCouponMessage: '',
      inputs: {
        checkedSubcategories: [],
        checkedSubcategoriesKeys: [],
        selectedClasses: [],
        selectedClassesKeys: [],
        addDomainService: true,
        newClassCategory: defaultNewClassCategory,
        newClassSubcategory: defaultNewClassSubcategory,
        newClassQuery: '',
        lastClassChecked: ''
      }
    };
  },
  created() {
    const { step3, step2, step1 } = this.globalInputs;
    if (!step3 && !step2 && !step1) {
      this.$router.replace({name: 'informacion'});
    } else if (!step3 && !step2) {
      this.$router.replace({name: 'categorias'});
    } else if (!step3) {
      this.$router.replace({name: 'subcategorias'});
    } else {
      this.loaded = true;
    }
  },
  methods: {
    async applyDiscountCode() {
      this.couponState = '';
      this.discountCouponMessage = '';

      this.updateGlobalInputs({
        step3: {
          ...this.globalInputs.step3,
          checkedSubcategories: this.inputs.checkedSubcategories
        },
        step4: {
          addDomainService: this.inputs.addDomainService
        }
      });
      try {
        const { selectedClassesKeys } = this.inputs;
        const response = await this.submitData({
          action: 'step-4',
          method: 'post',
          payload: {
            cupon_de_descuento: this.discountCode,
            selected_classes: this.inputs.selectedClasses.filter(({key}) => selectedClassesKeys.includes(key)),
            selected_services: this.computedSelectedServices
          }
        });

        const { data } = response;

        if (data.success) {
          this.updateOrderData(data);
          this.discountCouponMessage = data.cupon_de_descuento_mensaje;
          // this.$router.push({name: 'facturacion'});
        }
      } catch (error) {
        console.log('error in step4 submitAndNext:', error);
        this.stopLoading();
      }
    },
    recordLastClassChecked(event) {
      this.inputs.lastClassChecked = event.target.value;
    },
    refreshClassAccordion() {
      const $selectedClassesAccordion = $('.step4__selected-classes');
      setTimeout(() => {
        if ($selectedClassesAccordion.length) {
          $selectedClassesAccordion.accordion('refresh');
        }
      }, 100);
    },
    openAddForm() {
      this.addingNewClass = true;
      this.refreshClassAccordion();
    },
    hideAddForm() {
      this.addingNewClass = false;
      this.missingSubcategoryError = false;
      this.missingCategoryError = false;
      this.inputs.newClassQuery = '';
      this.inputs.newClassCategory = defaultNewClassCategory;
      this.inputs.newClassSubcategory = defaultNewClassSubcategory;
      this.refreshClassAccordion();
    },
    async fetchSubcategories(value) {
      try {
        const response = await axios.get(
          baseUrl,
          {
            params: {
              action: 'subcategories-from',
              category: this.inputs.newClassCategory['key'],
              search: value,
              id: this.globalId,
              email: this.globalEmail,
            }
          }
        );
        const { data } = response;
        this.subcategories = data.subcategories;
        this.select_subcategory_open = true;
      } catch(err) {
        console.log('error in step4 fetchSubcategories:', err);
      } finally {
        this.loading = false;
        this.loadingSubcategories = false;
      }
    },
    debounceSearchSubcategories(e) {
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout);
      }
      this.inputs.newClassSubcategory = defaultNewClassSubcategory;
      this.loadingSubcategories = true;
      this.missingSubcategoryError = false;
      const ctx = this;
      this.searchTimeout = setTimeout(function() {
        ctx.fetchSubcategories(e.target.value);
      }, 600)
    },
    handleDropdownSubcategory() {
      this.select_subcategory_open = true;
    },
    handleDropdownCategory() {
      this.select_category_open = !this.select_category_open;
    },
    closeCategorySelect() {
      this.select_category_open = false;
    },
    inputCategorySelect(value) {
      this.subcategories = value.subcategories.filter((subcategory) => {
        return !this.inputs.checkedSubcategories.some(_subcategory => subcategory.key === _subcategory.key);
      });
      this.inputs.newClassQuery = '';
      this.missingCategoryError = false;
      this.missingSubcategoryError = false;
      this.closeCategorySelect();
    },
    closeSubcategorySelect() {
      this.select_subcategory_open = false;
    },
    inputSubcategorySelect() {
      this.closeSubcategorySelect();
      this.missingSubcategoryError = false;
      const { newClassSubcategory } = this.inputs;
      if (newClassSubcategory.title) {
        this.inputs.newClassQuery = newClassSubcategory.title;
      } else if(newClassSubcategory.description) {
        this.inputs.newClassQuery = newClassSubcategory.description.replace(/<\/?[^>]+>/ig, " ");
      } else {
        this.inputs.newClassQuery = newClassSubcategory.key;
      }
    },
    addNewClass() {
      const { newClassSubcategory, newClassCategory } = this.inputs;
      if (newClassCategory.key === defaultNewClassCategory.key) {
        this.missingCategoryError = true;
        return;
      }
      if (newClassSubcategory.key === defaultNewClassSubcategory.key) {
        this.missingSubcategoryError = true;
        return;
      }
      this.inputs.checkedSubcategories = this.inputs.checkedSubcategories.concat(newClassSubcategory);
      this.inputs.checkedSubcategoriesKeys = this.inputs.checkedSubcategoriesKeys.concat(newClassSubcategory.key);
      this.inputs.newClassCategory = defaultNewClassCategory;
      this.inputs.newClassSubcategory = defaultNewClassSubcategory;
      this.inputs.newClassQuery = '';
      this.addingNewClass = false;
      this.refreshClassAccordion();
    },
    openOptionsModal() {
      this.showOptionsModal = true;
    },
    hideOptionsModal() {
      this.showOptionsModal = false;
    },
    openDetailsModal() {
      this.showDetailsModal = true;
    },
    hideDetailsModal() {
      this.showDetailsModal = false;
    },
    goToFirstStep() {
      this.$router.go(-3);
    },
    async submitAndNext() {
      this.updateGlobalInputs({
        step3: {
          ...this.globalInputs.step3,
          checkedSubcategories: this.inputs.checkedSubcategories
        },
        step4: {
          addDomainService: this.inputs.addDomainService
        }
      });
      try {
        const { selectedClassesKeys } = this.inputs;
        const response = await this.submitData({
          action: 'step-4',
          method: 'post',
          payload: {
            selected_classes: this.inputs.selectedClasses.filter(({key}) => selectedClassesKeys.includes(key)),
            selected_services: this.computedSelectedServices
          }
        });

        const { data } = response;

        if (data.success) {
          this.updateOrderData(data);
          this.$router.push({name: 'facturacion'});
        }
      } catch (error) {
        console.log('error in step4 submitAndNext:', error);
        this.stopLoading();
      }
    },
    async handleSubmit() {
      const el = document.querySelector(".form-input-field__error:first-of-type");
      if (el) {
        el.scrollIntoView({ behavior: "smooth", block: 'center' });
        return;
      }

      this.submitAndNext();
    },
    handlePrev() {
      this.updateGlobalInputs({
        step3: {
          ...this.globalInputs.step3,
          checkedSubcategories: this.inputs.checkedSubcategories
        },
        step4: {
          addDomainService: this.inputs.addDomainService
        }
      });
      this.$router.back();
    },
    formatPrice(numero) {
      // Convierte el número a una cadena
      let numeroCadena = numero.toString();

      // Separa la cadena en partes antes y después del punto decimal (si existe)
      let partes = numeroCadena.split('.');

      // Agrega separadores de puntos a la parte antes del punto decimal
      partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

      // Une las partes de nuevo con el punto decimal
      let resultado = partes.join('.');

      return resultado;
    },
    async subcategoriesWatcher(_keys) {
      const keys = JSON.parse(JSON.stringify(_keys));
      const subcategories = this.inputs.checkedSubcategories.filter(category => {
        return keys.includes(category.key);
      });
      try {
        const response = await this.submitData({
          action: 'step-3',
          method: 'post',
          payload: {
            trademark_name: this.globalInputs.step1['trademarkName'],
            email: this.globalInputs.step1['email'],
            type: this.globalInputs.step1['type'],
            stored_filename: this.globalInputs.step1['storedFilename'],
            checked_categories: this.globalInputs.step2.checkedCategories.map(category => category.key),
            checked_subcategories: JSON.parse(JSON.stringify(subcategories))
          }
        });

        const { data } = response;

        if (data.success) {
          this.updateOrderData(data);
          if (data.selected_classes.length >= this.inputs.selectedClasses.length) {
            this.inputs.selectedClasses = data.selected_classes;
            this.inputs.selectedClassesKeys = data.selected_classes.map(({key}) => key);
          }
        } else {
          if (data.message && data.message.extra_info) {
            this.setSubmitError(data.message.extra_info);
          }
          if (
            !this.inputs.selectedClassesKeys.length &&
            this.inputs.lastClassChecked
          ) {
            this.inputs.selectedClassesKeys = [this.inputs.lastClassChecked];
          }
        }
      } catch (error) {
        console.log('error in step4 submitAndNext [step-3]:', error);
        this.stopLoading();
      }
    },
    ...mapMutations([
      'updateGlobalInputs',
      'stopLoading',
      'updateOrderData',
      'setSubmitError'
    ]),
    ...mapActions([
      'submitData'
    ])
  },
  computed: {
    showSimilarity() {
      return (this.orderData.risk.level !== 'low') && (this.orderData.similarity && this.orderData.similarity.length);
    },
    computedOrderTotal() {
      let total = 0;
      this.computedSelectedServices.map((service) => {
        const servicePrice = +service.price.replace(/[\$\.]/g, '');
        total += servicePrice;
      });
      return `$${this.formatPrice(total)}`;
    },
    computedSelectedServices() {
      const { addDomainService } = this.inputs;
      const { services_response } = this.orderData;
      if (addDomainService) {
        return services_response;
      }
      return services_response.filter(service => service.group != 'Dominio');
    },
    ...mapState([
        'nextFlag',
        'prevFlag',
        'stepperTitle',
        'globalInputs',
        'orderData',
        'globalId',
        'globalEmail',
        'globalSubcategories'
      ]
    )
  },
  beforeMount() {
    window.scrollTo({ top: 0 });
  },
  mounted() {
    const data = this.globalSubcategories;
    this.categories = data.map((data) => {
      return {
        ...data,
        title: data.category_label,
        key: data.category_key
      }
    });
    const { step3, step4 } = this.globalInputs;
    if (!step3 || !step3.checkedSubcategories) {
      return;
    }
    if (step4 && (step4.addDomainService !== undefined)) {
      this.inputs.addDomainService = step4.addDomainService;
    }
    this.inputs.checkedSubcategories = step3.checkedSubcategories;
    this.inputs.checkedSubcategoriesKeys = step3.checkedSubcategories.map(({key}) => key);

    this.inputs.selectedClasses = this.orderData.selected_classes;
    this.inputs.selectedClassesKeys = this.orderData.selected_classes.map(({key}) => key);

    this.$watch('inputs.checkedSubcategoriesKeys', this.subcategoriesWatcher);

    const $faqAccordions = $('.step4__faq-items');
    if ($faqAccordions.length) {
      $faqAccordions.accordion({
        icons: false,
        heightStyle: 'content',
        collapsible: true
      });
    }
    const $selectedClassesAccordion = $('.step4__selected-classes');
    const $servicesAccordion = $('.step4__services-section');
    // Wait 100 ms for v-for to complete and allow accordion to calculate it's height
    setTimeout(() => {
      if ($selectedClassesAccordion.length) {
        const isDesktop = $(window).width() >= 768;
        const isMobile = !isDesktop;
        $selectedClassesAccordion.accordion({
          icons: false,
          collapsible: true,
          disabled: isDesktop,
          active: isMobile ? false : 0,
          heightStyle: 'content'
        });
        function disableAccordion() {
          $selectedClassesAccordion.accordion('option', 'active', 0);
          $selectedClassesAccordion.accordion('disable');
        }
        function enableAccordion() {
          $selectedClassesAccordion.accordion('option', 'active', false);
          $selectedClassesAccordion.accordion('enable');
        }

        window.addEventListener('resize', function() {
          if ($(window).width() >= 768) {
            disableAccordion();
          } else {
            enableAccordion();
          }
        }, true);
      }
      if ($servicesAccordion) {
        const isDesktop = $(window).width() >= 768;
        const isMobile = !isDesktop;
        $servicesAccordion.accordion({
          icons: false,
          collapsible: true,
          disabled: isDesktop,
          active: isMobile ? false : 0,
          heightStyle: 'content'
        });
        function disableAccordion() {
          $servicesAccordion.accordion('option', 'active', 0);
          $servicesAccordion.accordion('disable');
        }
        function enableAccordion() {
          $servicesAccordion.accordion('option', 'active', false);
          $servicesAccordion.accordion('enable');
        }

        window.addEventListener('resize', function() {
          if ($(window).width() >= 768) {
            disableAccordion();
          } else {
            enableAccordion();
          }
        }, true);
      }
    }, 100);
  },
  watch: {
    nextFlag() {
      this.handleSubmit();
    },
    prevFlag() {
      this.handlePrev();
    },
    'inputs.selectedClassesKeys': function (_keys) {
      const checkedSubcategories = this.inputs.checkedSubcategories.filter(subcategory => {
        return _keys.some(key => +key == subcategory.class);
      });

      const _checkedSubcategoriesKeys = checkedSubcategories.map(({key}) => key);
      const _checkedSubcategoriesKeysStr = JSON.stringify(_checkedSubcategoriesKeys);
      const checkedSubcategoriesKeysStr = JSON.stringify(this.inputs.checkedSubcategoriesKeys);

      if (_checkedSubcategoriesKeysStr !== checkedSubcategoriesKeysStr) {
        this.inputs.checkedSubcategoriesKeys = _checkedSubcategoriesKeys;
      }
    },
  }
}
</script>
