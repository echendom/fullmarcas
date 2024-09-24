import Vue from "vue";

import FormHero from "./components/FormHero.vue";
import BlogListing from "./components/BlogListing.vue";
import ContactForm from "./components/ContactForm.vue";
import TrademarkRegistration from "./components/TrademarkRegistration.vue";
import CtaButton from "./components/CtaButton.vue";
import DetailsModalButton from "./components/DetailsModalButton.vue";
import ClearStorage from "./components/ClearStorage.vue";
import store from "./services/vuex";
import VueMask from "v-mask";
import vRut from 'v-rut';

Vue.use(VueMask);
Vue.use(vRut, {
  inject: true
})

Vue.directive('input-rut', {
  bind: function (el) {
    el.value = format(el.value);
  },
  update: function (el) {
    if (el.value < 3) return false;
    el.value = format(el.value);
  }
})

Vue.prototype.rutFormatDefault = rut => {
  rut = rut.replace(/^0+|[^0-9kK]+/g, '').toLowerCase();
  return rut;
}

function format(val) {
  if (val.length < 2) return val;
  return clean(val).slice(0, -1).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + '-' + clean(val).slice(-1);
}

function clean(val) {
  return val.replace(/[^[0-9kK]/g, '');
}

import VueRouter from 'vue-router';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history'
})

const app = new Vue({
  el: "#app",
  store,
  router,
  components: {
    'v-form-hero': FormHero,
    'v-blog-listing': BlogListing,
    'v-contact-form': ContactForm,
    'v-trademark-registration': TrademarkRegistration,
    'v-cta-button': CtaButton,
    'v-details-modal-button': DetailsModalButton,
    'v-clear-storage': ClearStorage
  }
});
