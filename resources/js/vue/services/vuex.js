import Vue from "vue";
import Vuex from "vuex";
import VuexPersistence from "vuex-persist";

Vue.use(Vuex);

const vuexLocal = new VuexPersistence({
  storage: window.localStorage
});

const baseUrl = "/cms/wp-admin/admin-ajax.php";

const store = new Vuex.Store({
  plugins: [vuexLocal.plugin],
  state: {
    stepperTitle: '',
    bannerData: {},
    loading: false,
    globalInputs: {
      step1: null,
      step2: null,
      step3: null,
      step4: null,
      step5: null,
    },
    submitError: '',
    lastSaved: null,
    fromHome: true,
    orderData: {},
    globalId: null,
    globalEmail: null,
    globalSubcategories: [],
    globalCategories: [],
    nextFlag: 0, // Components will watch this flag; when it changes, they'll validate and try to submit.
    prevFlag: 0
  },
  mutations: {
    finishRegister(state) {
      state.loading = false;
      state.globalInputs = {
        step1: null,
        step2: null,
        step3: null,
        step4: null,
        step5: null,
      };
      state.globalEmail = '';
      state.globalId = null;
      state.orderData = {};
    },
    startLoading(state) {
      state.loading = true;
    },
    setFromHome(state, payload) {
      state.fromHome = payload;
    },
    setSubmitError(state, error) {
      state.submitError = error;
    },
    stopLoading(state) {
      state.loading = false;
    },
    init(state, payload) {
      const { stepperTitle, bannerData } = payload;
      if (stepperTitle) {
        state.stepperTitle = stepperTitle;
      }
      if (bannerData) {
        state.bannerData = bannerData;
      }
      state.loading = false;
    },
    setGlobalId(state, payload) {
      state.globalId = payload;
    },
    setGlobalEmail(state, payload) {
      state.globalEmail = payload;
    },
    setGlobalSubcategories(state, payload) {
      state.globalSubcategories = payload;
    },
    setGlobalCategories(state, payload) {
      state.globalCategories = payload;
    },
    setStepperTitle(state, payload) {
      state.stepperTitle = payload;
    },
    onNext(state) {
      state.nextFlag++;
    },
    onPrev(state) {
      state.prevFlag++;
    },
    updateGlobalInputs(state, inputs) {
      state.lastSaved = new Date();
      state.globalInputs = {
        ...state.globalInputs,
        ...inputs
      }
    },
    updateOrderData(state, data) {
      state.orderData = {
        ...state.orderData,
        ...data
      };
    },
  },
  actions: {
    async submitData({ commit, state }, params) {
      commit('startLoading');
      const { action, payload, method } = params;
      if (state.globalId) {
        payload['id'] = state.globalId;
      }
      if (state.globalEmail) {
        payload['email'] = state.globalEmail;
      }
      if(state.globalInputs) {
        payload['local_storage'] = state.globalInputs;
      }
      let response;
      try {
        response = await axios[method](`${baseUrl}?action=${action}`, payload);
      } catch(err) {
        commit('setSubmitError', err.toString());
        throw err;
      } finally {
        commit('stopLoading');
      }
      return response;
    }
  }
})

export default store;
