<template>
  <div class="step1" v-if="loaded">
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
        <h2 v-if="title" class="step1__title" ref="top">
          {{ title }}
        </h2>
        <div v-if="description" class="step1__description paragraph" v-html="description"></div>
        <div
          class="paragraph paragraph--small form-input-field__error step3__error"
          :class="errorStep ? 'step3__error--show' : ''"
          ref="error_step"
        >
          {{ errorStep }}
        </div>
        <div class="step3__tabs" v-if="categories.length">
          <ul class="step3__tabs-selectors">
            <li
              v-for="category in categories"
              :key="slugify(category['category_key'])"
              class="step3__tab-selector"
            >
              <a
                class="step3__tab-selector-link"
                :href="`#${slugify(category['category_key'])}`"
              >
                {{ category['category_label'] }}
                <img
                  v-if="isCategoryChecked(category)"
                  :src="purlpeCheckmark"
                  alt="Icono check"
                  width="20"
                  height="20"
                />
              </a>
            </li>
          </ul>
          <div
            v-for="(category, index) in categories"
            :key="slugify(category['category_key'])"
            :id="slugify(category['category_key'])"
            class="step3__tab-content"
          >
            <label
              v-if="enableSearch[index]"
              class="step3__search-label"
            >
              Buscar por palabras
              <div class="step3__search-input-box">
                <img
                  :src="searchIcon"
                  alt="Icono lupa"
                  class="step3__search-input-icon"
                  width="20"
                  height="20"
                />
                <input
                  type="text"
                  placeholder="Buscar..."
                  :value="inputs.searchTerms[category.category_key]"
                  @input="(event) => debounceSearch(event, category.category_key, index)"
                  class="step3__search-input"
                />
              </div>
            </label>
            <div
              class="step3__subcategory-options"
              v-if="loadingCategories[index]"
            >
              <div
                v-for="index in 6"
                :key="index"
                class="step3__subcategory-option"
              >
                <div class="step3__subcategory-details">
                  <span class="step3__subcategory-title pulsate"></span>
                </div>
              </div>
            </div>
            <div class="step3__subcategory-options" v-else>
              <label
                v-for="subcategory in pageCategory(category, pages[index])"
                :key="subcategory['key']"
                :class="inputs.checkedSubcategories.includes(subcategory.key) ? 'step3__subcategory-option--selected' : 'step3__subcategory-option'"
              >
                <div class="step3__subcategory-details">
                  <span
                    v-if="subcategory['title']"
                    class="step3__subcategory-title"
                  >
                    <span>
                      {{ subcategory['title'] }} - Clase {{ subcategory['class'] }}
                    </span>
                  </span>
                  <span
                    v-else
                    class="step3__subcategory-title"
                  >
                    Clase {{ subcategory['class'] }}
                  </span>
                  <span
                    v-if="subcategory['description_highlight']"
                    class="step3__subcategory-description"
                    v-html="subcategory['description_highlight']"
                  ></span>
                </div>
                <span class="step3__input-checkmark">
                  <img
                    v-if="inputs.checkedSubcategories.includes(subcategory.key)"
                    class="step3__input-checkmark-icon"
                    :src="whiteCheckmark"
                    alt="Icono check"
                    width="12"
                    height="12"
                    role="presentation"
                  />
                </span>
                <input
                  class="step3__subcategory-input-tag"
                  type="checkbox"
                  :value="subcategory.key"
                  v-model="inputs.checkedSubcategories"
                >
              </label>
              <div v-if="category.enable_word_search" class="step3__subcategory-option--search">
                <div class="step3__subcategory-option-header">
                  <div class="step3__subcategory-title">{{ category.word_search_title }}</div>
                  <p class="step3__subcategory-description">{{ category.word_search_description }}</p>
                </div>
                <div class="step3__search-input-box">
                  <img
                    :src="searchIcon"
                    alt="Icono lupa"
                    class="step3__search-input-icon"
                    width="20"
                    height="20"
                  />
                  <input
                    type="text"
                    placeholder="Buscar..."
                    :value="inputs.searchTerms[category.category_key]"
                    @input="(event) => debounceSearch(event, category.category_key, index)"
                    class="step3__search-input"
                  />
                </div>
              </div>
            </div>
            <div
              class="step3__footer"
              v-if="category.pagination.max_page > 1"
            >
              <span class="step3__footer-label">
                Mostrando: {{ category['pagination']['per_page'] }} de {{ category['pagination']['total_items'] }} sub-categorías
              </span>
              <paginate
                v-if="category.pagination.max_page > 1"
                v-model="pages[index]"
                :page-count="category.pagination.max_page"
                :page-range="2"
                :margin-pages="category.pagination.max_page"
                :prev-text="prev_svg"
                :next-text="next_svg"
                :click-handler="handlePage"
                :container-class="'pagination'"
                :page-class="'pagination__item'"
                :page-link-class="'pagination__link'"
                :prev-class="'pagination__item--prev'"
                :prev-link-class="'pagination__link--prev'"
                :next-class="'pagination__item--next'"
                :next-link-class="'pagination__link--next'"
                :break-view-class="'pagination__item--break'"
                :break-view-link-class="'pagination__link--break'"
                :disabled-class="'pagination__item--disabled'"
                :active-class="'pagination__item--active'"
              />
            </div>
          </div>
        </div>
        <div
          v-else-if="loading"
          class="step3__loading-tabs"
        >
          <ul class="step3__tabs-selectors">
            <li
              v-for="index in globalInputs.step2.checkedCategories.length"
              :key="index"
              class="step3__tab-selector"
            >
              <span class="step3__tab-selector-link">
                <span class="step3__tab-selector-text pulsate"></span>
              </span>
            </li>
          </ul>
          <div class="step3__tab-content">
            <div class="step3__subcategory-options">
              <div
                v-for="index in 6"
                :key="index"
                class="step3__subcategory-option"
              >
                <div class="step3__subcategory-details">
                  <span class="step3__subcategory-title pulsate"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <validation-observer ref="form" v-slot="{ invalid }" slim>
        <form class="step3__form" @submit.prevent="handleSubmit">
          <validation-provider
            name="class_extra_info"
            rules="required"
            :bails="true"
            tag="div"
            class="form-input-field step3__class-description"
            v-slot="{ errors }"
          >
            <label
              :class="[
                'form-contact__label',
                'form-input-field__label',
                errors.length ? 'form-input-field__label--error' : ''
              ]"
            >
              <span class="step3__form-title" v-if="text_field_title">
                {{ text_field_title }}
              </span>
              <span class="step3__form-label paragraph--large" v-if="text_field_label">
                {{ text_field_label }}
              </span>
              <textarea
                :disabled="loading"
                ref="textarea"
                class="form-input-field__input--textarea"
                :class="errors.length ? 'form-input-field__input--error' : ''"
                @input="resizeMsgInput"
                v-model="inputs['classExtraInfo']"
                placeholder="Ingresa aquí"
                rows="3"
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
        </form>
      </validation-observer>
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
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import { required } from 'vee-validate/dist/rules';
import Paginate from "vuejs-paginate";

extend('required', {
  ...required,
  message: 'Este campo es requerido'
});

const baseUrl = '/cms/wp-admin/admin-ajax.php';

export default {
  name: 'Step3',
  components: {
    Paginate,
    ValidationProvider,
    ValidationObserver
  },
  props: ['title', 'description', 'side_image', 'text_field_title', 'text_field_label'],
  data() {
    return {
      loaded: false,
      editIcon: `${themosis_assets}/images/icons/black_edit_icon.svg`,
      whiteCheckmark: `${themosis_assets}/images/icons/white_checkmark.svg`,
      purlpeCheckmark: `${themosis_assets}/images/icons/purple_check.svg`,
      searchIcon: `${themosis_assets}/images/icons/black_magnifying-glass-icon.svg`,
      searchTimeout: null,
      enableSearch: [],
      loadingCategories: [],
      loading: false,
      categories: [],
      errorStep: '',
      globalCheckedSubcategories: {},
      pages: [],
      inputs: {
        checkedSubcategories: [],
        searchTerms: {},
        classExtraInfo: ''
      },
      prev_svg: `
        <img
          src="${themosis_assets}/images/icons/white_arrow-left.svg"
          alt="Flecha izquierda"
          width="20"
          height="20"
          loading="lazy"
        />
      `,
      next_svg: `
        <img
          src="${themosis_assets}/images/icons/white_arrow-right.svg"
          alt="Flecha izquierda"
          width="20"
          height="20"
          loading="lazy"
        />
      `
    };
  },
  created() {
    const { step2, step1 } = this.globalInputs;
    if (!step2 && !step1) {
      this.$router.replace({name: 'informacion'});
    } else if (!step2) {
      this.$router.replace({name: 'categorias'});
    } else {
      this.loaded = true;
    }
  },
  updated() {
    if (this.categories) {
      setTimeout(() => {
        $('.step3__tabs').tabs({
          hide: true,
          show: true
        });
      }, 100);
    }
  },
  methods: {
    resizeMsgInput() {
      let element = this.$refs["textarea"];

      let txtareaHeight = '70px';
      element.style.height = txtareaHeight;

      if (element.scrollHeight > 70) {
        txtareaHeight = element.scrollHeight + 'px';
      }

      element.style.height = txtareaHeight;
    },
    slugify(str) {
      const separator = '-';
      return str
        .toString()
        .normalize('NFD')                // split an accented letter in the base letter and the acent
        .replace(/[\u0300-\u036f]/g, '') // remove all previously split accents
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9 ]/g, '')      // remove all chars not letters, numbers and spaces (to be replaced)
        .replace(/\s+/g, separator);
    },
    handlePage() {
      const { top } = this.$refs;
      if (top) {
        top.scrollIntoView({ behavior: 'smooth' })
      }
    },
    pageCategory(category, currentPage) {
      const { subcategories, category_key } = category;
      let checkedSubcategories = this.globalCheckedSubcategories[category_key];
      // If there is a search term,
      // show at the beginning only the subcategories
      // in the results list that are checked.
      const searchTerm = this.inputs.searchTerms[category_key];
      if (searchTerm) {
        checkedSubcategories = subcategories.filter(subcategory => {
          return checkedSubcategories.some(_subcategory => subcategory.key == _subcategory.key);
        });
      }
      const pageSize = 12;
      const startIndex = (currentPage - 1) * pageSize;
      const endIndex = startIndex + pageSize;
      const filteredCategories = subcategories.filter(subcategory => {
        return checkedSubcategories.every(_subcategory => subcategory.key != _subcategory.key);
      });

      if (startIndex < checkedSubcategories.length) {
        checkedSubcategories = checkedSubcategories.map(item => {
          const { description } = item;
          if (searchTerm) {
            const $_tempDescription = $(`<div>${description}</div>`);
            $_tempDescription.mark(searchTerm);
            item.description_highlight = $_tempDescription.html();
          } else {
            item.description_highlight = description;
          }
          return item;
        });
      }
      
      return checkedSubcategories.concat(filteredCategories).slice(startIndex, endIndex);
    },
    debounceSearch(e, categoryKey, categoryIndex) {
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout);
      }
      this.inputs.searchTerms = {
        ...this.inputs.searchTerms,
        [categoryKey]: e.target.value
      };
      const ctx = this;
      this.searchTimeout = setTimeout(function() {
        ctx.fetchData(categoryKey, categoryIndex);
      }, 600)
    },
    allCategoriesChecked() {
      const { categories } = this;
      for (let i = 0; i < categories.length; i++) {
        const category = categories[i];
        if (!this.isCategoryChecked(category)) {
          return i;
        }
      }
      return null;
    },
    findSubcategoryFromKey(subcategoryKey) {
      const { categories, globalCheckedSubcategories } = this;
      for (let i = 0; i < categories.length; i++) {
        const category = categories[i];
        const subcategory = category.subcategories.find(({ key }) => key === subcategoryKey);
        if (subcategory) {
          return subcategory;
        }
      }
      const globalCategories = Object.values(globalCheckedSubcategories);
      for (let i = 0; i < globalCategories.length; i++) {
        const subcategories = globalCategories[i];
        const subcategory = subcategories.find(({ key }) => key === subcategoryKey);
        if (subcategory) {
          return subcategory;
        }
      }
      return null;
    },
    isCategoryChecked(category) {
      const globalCheckedSubcategories = this.globalCheckedSubcategories[category.category_key];
      return this.inputs.checkedSubcategories.some(subcategoryKey => {
        return globalCheckedSubcategories.concat(category.subcategories).some(subcategory => subcategory.key === subcategoryKey);
      });
    },
    async fetchData(categoryKey, categoryIndex) {
      this.loading = true;
      if (categoryIndex != undefined) {
        const loadingCategories = [...this.loadingCategories];
        loadingCategories[categoryIndex] = true;
        this.loadingCategories = loadingCategories;
      }
      let response;
      try {
        if (categoryKey) {
          // Store already selected classes in this page.
          const { checkedSubcategories } = this.inputs;
          const { globalCheckedSubcategories } = this;
          const subcategoriesSelected = this.categories[categoryIndex].subcategories.filter(({key}) => {
            const alreadySelected = globalCheckedSubcategories[categoryKey].some(_globalSubcategory => {
              return _globalSubcategory.key == key;
            })
            return checkedSubcategories.includes(key) && !alreadySelected;
          });
          this.globalCheckedSubcategories[categoryKey] = [
            ...this.globalCheckedSubcategories[categoryKey],
            ...subcategoriesSelected
          ];
          const searchTerm = this.inputs.searchTerms[categoryKey];
          response = await axios.get(
            baseUrl,
            {
              params: {
                action: 'subcategories-from',
                category: categoryKey,
                search: searchTerm,
                id: this.globalId,
                email: this.globalEmail,
              }
            }
          );
          const subcategories = response.data.subcategories.map(item => {
            const { description } = item;
            if (searchTerm) {
              const $_tempDescription = $(`<div>${description}</div>`);
              $_tempDescription.mark(searchTerm);
              item.description_highlight = $_tempDescription.html();
            } else {
              item.description_highlight = description;
            }
            return item;
          });
          const newCategories = [...this.categories];
          this.pages[categoryIndex] = 1;
          newCategories[categoryIndex] = {
            ...newCategories[categoryIndex],
            subcategories: subcategories,
            pagination: {
              'page': 1,
              'next_page': 2,
              'prev_page': 0,
              'max_page': Math.ceil(subcategories.length / 12),
              'per_page': 12,
              'total_items': subcategories.length,
            }
          };
          this.categories = newCategories;
          const { top } = this.$refs;
          if (top) {
            setTimeout(() => {
              top.scrollIntoView({ behavior: "smooth" });
            }, 50);
          }
        } else {
          response = await axios.get(
            baseUrl,
            {
              params: {
                action: 'subcategories',
                id: this.globalId,
                email: this.globalEmail,
              }
            }
          );
          const categories = response.data.subcategories;
          this.setGlobalSubcategories(categories);
          const { checkedCategories } = this.globalInputs.step2;
          const filteredCategories = categories.filter(category => {
            return checkedCategories.some((_category) => category.category_key === _category.key)
          });
          const ctx = this;
          filteredCategories.map(category => {
            ctx.inputs.searchTerms[category.category_key] = '';
          });
          this.categories = filteredCategories.map(category => {
            category.subcategories = category.subcategories.map(cat => {
              cat.description_highlight = cat.description;
              return cat;
            })
            return {
              ...category,
              pagination: {
                'page': 1,
                'next_page': 2,
                'prev_page': 0,
                'max_page': Math.ceil(category.subcategories.length / 12),
                'per_page': 12,
                'total_items': category.subcategories.length,
              }
            }
          });
          this.pages = filteredCategories.map(() => 1);
          let _globalCheckedSubcategories = {};
          filteredCategories.map((cat) => {
            let result = ctx.globalCheckedSubcategories[cat.category_key];
            if (!result) {
              result = [];
            }
            _globalCheckedSubcategories[cat.category_key] = result;
          });
          this.globalCheckedSubcategories = _globalCheckedSubcategories;
          this.enableSearch = this.categories.map(category => category.pagination.max_page > 1);
          this.loadingCategories = this.categories.map(() => false);
        }
      } catch(err) {
        console.log('error in step3 fetchData:', err);
      } finally {
        this.loading = false;
        if (categoryIndex != undefined) {
          const loadingCategories = [...this.loadingCategories];
          loadingCategories[categoryIndex] = false;
          this.loadingCategories = loadingCategories;
        }
      }
    },
    goToFirstStep() {
      this.$router.go(-2);
    },
    cleanupError() {
      this.errorStep = '';
    },
    async submitAndNext() {
      const { findSubcategoryFromKey } = this;
      const checkedSubcategories = this.inputs.checkedSubcategories.reduce((list, subcategoryKey) => {
        const subcategory = findSubcategoryFromKey(subcategoryKey);
        if (subcategory) {
          return list.concat(subcategory);
        }
        return list;
      }, []);

      this.updateGlobalInputs({
        step3: {
          checkedSubcategories,
          globalCheckedSubcategories: this.globalCheckedSubcategories,
          classExtraInfo: this.inputs.classExtraInfo
        }
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
            checked_subcategories: checkedSubcategories,
            mark_class_text: this.inputs.classExtraInfo
          }
        });

        const { data } = response;

        if (data.success) {
          this.updateOrderData(data);
          this.$router.push({name: 'resultados'});
        }
      } catch (error) {
        console.log('error in step3 submitAndNext:', error);
        this.stopLoading();
      }
    },
    handlePrev() {
      const { findSubcategoryFromKey } = this;
      const checkedSubcategories = this.inputs.checkedSubcategories.reduce((list, subcategoryKey) => {
        const subcategory = findSubcategoryFromKey(subcategoryKey);
        if (subcategory) {
          return list.concat(subcategory);
        }
        return list;
      }, []);

      this.updateGlobalInputs({
        step3: {
          checkedSubcategories,
          globalCheckedSubcategories: this.globalCheckedSubcategories,
          classExtraInfo: this.inputs.classExtraInfo
        }
      });
      this.$router.back();
    },
    async handleSubmit() {
      const isValid = await this.$refs.form.validate();

      if (!isValid) {
        const el = document.querySelector(".form-input-field__error:first-of-type");
        el.scrollIntoView({ behavior: "smooth", block: 'center' });
        return
      };

      const missingCategoryIndex = this.allCategoriesChecked();
      if (missingCategoryIndex === null) {
        this.submitAndNext();
        return;
      }
      $( ".step3__tabs" ).tabs( "option", "active", missingCategoryIndex );
      this.errorStep = 'Seleccione una opción de esta categoría';
      const el = this.$refs.error_step;
      if (el) {
        el.scrollIntoView({ behavior: "smooth", block: 'center' });
      }
    },
    ...mapMutations([
      'updateGlobalInputs',
      'stopLoading',
      'updateOrderData',
      'setGlobalSubcategories'
    ]),
    ...mapActions([
      'submitData'
    ])
  },
  computed: {
    ...mapState([
        'nextFlag',
        'prevFlag',
        'stepperTitle',
        'globalInputs',
        'globalId',
        'globalEmail'
      ]
    )
  },
  beforeMount() {
    window.scrollTo({ top: 0 });
  },
  mounted() {
    this.fetchData();
    const { step3 } = this.globalInputs;
    if (!step3 || !step3.checkedSubcategories) {
      return;
    }
    if (step3.globalCheckedSubcategories) {
      this.globalCheckedSubcategories = step3.globalCheckedSubcategories;
    }
    this.inputs.classExtraInfo = step3.classExtraInfo;
    this.inputs.checkedSubcategories = step3.checkedSubcategories.map(({key}) => key);
  },
  watch: {
    prevFlag() {
      this.handlePrev();
    },
    nextFlag() {
      this.handleSubmit();
    },
    'inputs.checkedSubcategories'() {
      this.cleanupError();
    },
  }
}
</script>
