<template>
  <div class="trademark-registration">
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
        v-if="submitError"
        class="modal-overlay"
        @click="hideErrorModal"
      ></div>
    </transition>
    <transition name="pop" appear>
      <div
        v-if="submitError"
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
            {{ submitError }}
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
    <div class="trademark-registration__container container">
      <transition name="fade" mode="out-in" appear>
        <RouterView v-slot="{ Component }">
          <component :is="Component" />
        </RouterView>
      </transition>

      <StepsIndicator
        :steps="stepsList"
        :backButton="back_button"
        :continueButton="continue_button"
      />
    </div>
  </div>
</template>

<script>
import { mapMutations, mapState } from "vuex";
import StepsIndicator from "./StepsIndicator.vue";
import { RouterView } from "vue-router";
import Step1 from "./Step1.vue";
import Step2 from "./Step2.vue";
import Step3 from "./Step3.vue";
import Step4 from "./Step4.vue";
import Step5 from "./Step5.vue";

export default {
  name: 'TrademarkRegistration',
  components: {
    StepsIndicator,
    RouterView
  },
  props: [
    'title',
    'step_1_label',
    'step_2_label',
    'step_3_label',
    'step_4_label',
    'back_button',
    'continue_button',
    'step_1_props',
    'step_2_props',
    'step_3_props',
    'step_4_props',
    'step_5_props'
  ],
  async created() {
    const routes = [
      {
        path: '/registra-tu-marca/',
        name: 'informacion',
        component: Step1,
        props: this.step_1_props
      },
      {
        path: '/registra-tu-marca/categorias',
        name: 'categorias',
        component: Step2,
        props: this.step_2_props
      },
      {
        path: '/registra-tu-marca/subcategorias',
        name: 'subcategorias',
        component: Step3,
        props: this.step_3_props
      },
      {
        path: '/registra-tu-marca/resultados',
        name: 'resultados',
        component: Step4,
        props: this.step_4_props
      },
      {
        path: '/registra-tu-marca/facturacion',
        name: 'facturacion',
        component: Step5,
        props: this.step_5_props
      }
    ];
    for (let i = 0; i < routes.length; i++) {
      const route = routes[i];
      this.$router.addRoute(route);
    }
    const { email, id, step } = this.$route.query;
    const resumeRegister = email && id && step;
    if (resumeRegister) {
      const baseUrl = '/cms/wp-admin/admin-ajax.php';
      this.startLoading();
      try {
        const response = await axios.get(baseUrl, {
          params: {
            action: 'get-steps',
            id: id,
            email: email,
          }
        });

        const { steps, order_data } = response.data;

        this.updateGlobalInputs(steps);
        this.setGlobalId(id);
        this.setGlobalEmail(email);
        if (order_data) {
          this.updateOrderData(order_data);
        }
      } catch (error) {
        console.log('error in TrademarkRegistration get-step:', error);
      } finally {
        this.stopLoading();
      }
    }
    const { lastSaved } = this;
    let hoursDiff = 0;
    if (lastSaved) {
      const lastSavedDate = Date.parse(lastSaved);
      const now = new Date();
      hoursDiff = Math.abs(now - lastSavedDate) / 36e5;
    }
    if (resumeRegister) {
      // Try to recover from stored state
      const { step4, step3, step2, step1 } = this.globalInputs;
      if (step4) {
        // push to step 5
        this.$router.push({name: 'categorias'}); // step 2
        this.$router.push({name: 'subcategorias'}); // step 3
        this.$router.push({name: 'resultados'}); // step 4
        this.$router.push({name: 'facturacion'}); // step 5
      } else if (step3) {
        // push to step 3
        this.$router.push({name: 'categorias'}); // step 2
        this.$router.push({name: 'subcategorias'}); // step 3
        this.$router.push({name: 'resultados'}); // step 4
      } else if (step2) {
        // push to step 3
        this.$router.push({name: 'categorias'}); // step 2
        this.$router.push({name: 'subcategorias'}); // step 3
      } else if (step1) {
        // push to step 2
        this.$router.push({name: 'categorias'}); // step 2
      }
    } else if(hoursDiff >= 1) {
      this.finishRegister();
    }
    this.setFromHome(false);
  },
  data() {
    return {
      loader: `${themosis_assets}/images/animations/loader.svg`,
      alertIcon: `${themosis_assets}/images/icons/skyblue_alert_icon.svg`,
      stepsList: [
        {
          name: 'informacion',
          label: this.step_1_label
        },
        {
          name: 'categorias',
          label: this.step_2_label
        },
        {
          name: 'subcategorias',
          label: this.step_2_label,
          hidden: true
        },
        {
          name: 'resultados',
          label: this.step_3_label
        },
        {
          name: 'facturacion',
          label: this.step_4_label
        }
      ]
    }
  },
  computed: {
    ...mapState(['globalInputs', 'fromHome', 'loading', 'lastSaved', 'submitError'])
  },
  mounted() {
    this.init({
      stepperTitle: this.title,
      bannerData: this.step_4_props.help_banner
    });
  },
  methods: {
    hideErrorModal() {
      this.setSubmitError('');
    },
    ...mapMutations([
      'init',
      'setSubmitError',
      'setFromHome',
      'setGlobalId',
      'setGlobalEmail',
      'startLoading',
      'stopLoading',
      'updateGlobalInputs',
      'updateOrderData',
      'finishRegister'
    ])
  }
}
</script>
