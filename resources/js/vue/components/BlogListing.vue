<template>
  <section class="blog-listing" ref="top">
    <div class="blog-listing__container container">
      <Loader :loading="loading" />
      <div class="blog-listing__header">
        <form class="blog-listing__filters" @submit.prevent="getData(false)">
          <div
            class="blog-listing__filter"
            v-click-outside="closeSelect"
            v-if="categories && categories.length"
          >
            <span class="blog-listing__filter-label fake-select-container__label">
              Categorías
            </span>
            <div class="blog-listing__dropdown-container">
              <button
                :class="[
                  select_open ?
                  'blog-listing__dropdown-button--open' :
                  'blog-listing__dropdown-button'
                ]"
                type="button"
                @click.stop="toggleDropdown"
              >
                <span class="blog-listing__selected-options" v-if="checkedCategories.length">
                  {{ checkedCategories.join(', ') }}
                </span>
                <span class="blog-listing__dropdown-placeholder" v-else>
                  Selecciona
                </span>
                <img
                  class="blog-listing__chevron-down"
                  :src="chevronDown"
                  alt="Icono flecha"
                  width="20"
                  height="20"
                  loading="lazy"
                />
              </button>
              <div
                :class="[
                  'blog-listing__dropdown',
                  select_open ? 'blog-listing__dropdown--open' : ''
                ]"
              >
                <label
                  v-for="category in categories"
                  :key="category['slug']"
                  :class="[
                    'blog-listing__dropdown-option',
                    checkedCategories.includes(category.label) ? 'blog-listing__dropdown-option--selected' : ''
                  ]
                  "
                >
                  <span class="'blog-listing__dropdown-option-label">
                    {{ category['label'] }}
                  </span>
                  <span class="blog-listing__input-checkmark">
                    <img
                      v-if="checkedCategories.includes(category.label)"
                      class="blog-listing__input-checkmark-icon"
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
                    :value="category.label"
                    v-model="checkedCategories"
                  >
                </label>
              </div>
            </div>
          </div>
          <label class="blog-listing__filter">
            <span class="blog-listing__filter-label">
              Buscar por palabras
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
                v-model="query"
                placeholder="Buscar..."
              />
            </span>
          </label>
          <div class="blog-listing__buttons">
            <button
              type="submit"
              class="blog-listing__button-apply button--primary-inverted"
            >
              Aplicar filtros
            </button>
            <button
              type="button"
              class="blog-listing__button-clear button--secondary-white"
              v-show="displayClearButton"
              @click="handleClearFilters"
            >
              Borrar filtros
            </button>
          </div>
        </form>
      </div>
      <div
        v-if="loading && !(items && (items.length > 0))"
        class="blog-listing__preloading-list"
      >
        <BlogArticleCardLoading v-for="index in 3" :key="index" />
      </div>
      <div v-if="items && (items.length > 0)">
        <div class="blog-listing__grid">
          <div
            v-for="(item, index) in items"
            :key="index"
            class="blog-listing__article"
          >
            <BlogArticleCard v-bind="item" />
          </div>
        </div>
        <div class="blog-listing__footer">
          <paginate
            v-if="pagination.max_pages > 1"
            v-model="page"
            :page-count="pagination.max_pages"
            :page-range="2"
            :margin-pages="pagination.max_pages"
            :click-handler="handlePage"
            :prev-text="prev_svg"
            :next-text="next_svg"
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
            :active-class="'pagination__item--active'" />
        </div>
      </div>
      <EmptyState
        v-if="!loading && !(items && (items.length > 0))"
        v-bind="emptystate"
      ></EmptyState>
    </div>
  </section>
</template>

<script>
import Paginate from "vuejs-paginate";
import Loader from './Loader.vue';
import EmptyState from './EmptyState.vue';
import BlogArticleCardLoading from './BlogArticleCardLoading.vue';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import BlogArticleCard from "./BlogArticleCard.vue";
import ClickOutside from 'vue-click-outside';

const defaultCategory = {
  label: 'Selecciona',
  slug: 'all'
};
const allCategories = {
  label: 'Todas',
  slug: 'all'
};

export default {
  name: 'BlogListing',
  props: ['categories', 'emptystate', 'action'],
  directives: {
    ClickOutside
  },
  components: {
    Paginate,
    Loader,
    EmptyState,
    BlogArticleCard,
    BlogArticleCardLoading,
    vSelect
  },
  data() {
    return  {
      whiteCheckmark: `${themosis_assets}/images/icons/white_checkmark.svg`,
      magnifyingGlass: `${themosis_assets}/images/icons/black_magnifying-glass-icon.svg`,
      chevronDown: `${themosis_assets}/images/icons/black_chevron-down.svg`,
      themosis_assets: themosis_assets,
      items: [],
      category: defaultCategory,
      checkedCategories: [],
      categoriesFilter: [
        allCategories,
        ...this.categories
      ],
      displayClearButton: false,
      query: '',
      changedPage: false,
      select_open: false,
      page: 1,
      pagination: {
        next_page: 0,
        prev_page: 0,
        max_pages: 0,
        per_page: 0,
        total_items: 0,
      },
      loading: true
    };
  },
  created() {
    this.getData();
  },
  computed: {
    category_selected() {
      return this.category.slug !== defaultCategory.slug;
    },
    prev_svg() {
      return `
        <img
          src="${themosis_assets}/images/icons/white_arrow-left.svg"
          alt="Flecha izquierda"
          width="20"
          height="20"
          loading="lazy"
        />
      `;
    },
    next_svg() {
      return `
        <img
          src="${themosis_assets}/images/icons/white_arrow-right.svg"
          alt="Flecha izquierda"
          width="20"
          height="20"
          loading="lazy"
        />
      `;
    }
  },
  methods: {
    handleClearFilters() {
      this.query = '';
      this.checkedCategories = [];
      this.getData();
    },
    closeSelect() {
      this.select_open = false;
    },
    toggleDropdown() {
      this.select_open = !this.select_open;
    },
    handlePage(page) {
      this.changedPage = true;
      this.page = page;
      this.getNextPage();
    },
    getNextPage() {
      this.getData(true);
    },
    async getData(nextPage = false) {
      this.loading = true;
      const action = this.action || 'blog';
      let page = this.page;

      if (!nextPage) {
        page = 1;
      }

      const categories = this.checkedCategories;
      const search = this.query;

      this.displayClearButton = search || categories.length;

      try {
        let response = await axios.get('/cms/wp-admin/admin-ajax.php', {
          params: {
            search: search,
            categories: categories,
            action: action,
            page: page,
            per_page: 12,
          },
        });

        const { data } = response;
        const { pagination } = data;

        this.items = data.data;
        this.filters = data.filters;

        if (!nextPage) {
          this.pagination = {
            ...this.pagination,
            ...pagination
          };
          this.page = pagination.page;
        }
        if (this.changedPage) {
          const { top } = this.$refs;
          if (top) {
            top.scrollIntoView({ behavior: "smooth" });
          }
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>
