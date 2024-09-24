<template>
  <div class="steps-indicator">
    <div class="steps-indicator__container container">
      <button
        :class="[
          'steps-indicator__prev-button',
          'steps-indicator__prev-button--desktop',
          'button--stepper-secondary',
          isFirstStep ? 'steps-indicator__prev-button--hidden' : ''
        ]"
        @click="onPrev"
        :disabled="loading"
      >
        {{ backButton }}
      </button>
      <div class="steps-indicator__list">
        <span
          v-for="(step, index) in visibleSteps"
          class="steps-indicator__step"
        >
          <img
            v-if="isStepCompleted(index)"
            class="steps-indicator__step-index--completed"
            :src="step_completed_icon"
            alt="Icon check"
            width="32"
            height="32"
          />
          <span v-else class="steps-indicator__step-index">
            {{ index + 1 }}
          </span>
          <span
            :class="[
              'steps-indicator__step-label',
              isCurrentStep(index) ? 'steps-indicator__step-label--active' : '',
              isStepCompleted(index) ? 'steps-indicator__step-label--completed' : '',
            ]"
          >
            {{ step['label'] }}
          </span>
          <picture v-if="index < visibleSteps.length - 1" class="steps-indicator__dashed-line-picture">
            <source
              media="(min-width: 1024px)"
              :srcset="dashed_line_mobile"
            />
            <img
              class="steps-indicator__dashed-line"
              :src="dashed_line"
              width="50"
              height="1"
              alt="Línea de seguimiento"
            />
          </picture>
        </span>
      </div>
      <button
        class="steps-indicator__prev-button steps-indicator__prev-button--desktop button--stepper"
        @click="onNext"
        :disabled="loading"
      >
        {{ buttonText }}
      </button>
    </div>
    <div class="steps-indicator__mobile-controls">
      <button
        v-if="!isFirstStep"
        :class="[
          'steps-indicator__prev-button',
          'steps-indicator__prev-button--mobile',
          'button--stepper-secondary',
        ]"
        @click="onPrev"
        :disabled="loading"
      >
        {{ backButton }}
      </button>
      <button
        class="steps-indicator__prev-button steps-indicator__prev-button--mobile button--stepper"
        @click="onNext"
        :disabled="loading"
      >
        {{ buttonText }}
      </button>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";

export default {
  name: 'StepsIndicator',
  props: ['steps', 'backButton', 'continueButton'],
  data() {
    return {
      step_completed_icon: `${themosis_assets}/images/icons/step_completed.svg`,
      dashed_line: `${themosis_assets}/images/dashed_line.svg`,
      dashed_line_mobile: `${themosis_assets}/images/dashed_line_mobile.svg`,
    };
  },
  methods: {
    ...mapMutations([
      'onNext',
      'onPrev'
    ]),
    isCurrentStep(step) {
      return step === this.currentVisibleStep;
    },
    isStepCompleted(step) {
      if (
        ((this.currentStepIndex === 1) || ((this.currentStepIndex === 2))) &&
        (step === 0)
      ) {
        return true;
      }
      return (step < (this.currentStepIndex - 1));
    }
  },
  computed: {
    buttonText() {
      return this.currentStepIndex === 4 ? 'Pagar' : this.continueButton;
    },
    currentVisibleStep() {
      const hiddenStepIndex = this.steps.findIndex(step => step.hidden);
      if (this.currentStepIndex >= hiddenStepIndex) {
        return this.currentStepIndex - 1;
      }
      return this.currentStepIndex;
    },
    visibleSteps() {
      return this.steps.filter(step => !step.hidden)
    },
    currentStepIndex() {
      const { name } = this.$route;
      for (let i = 0; i < this.steps.length; i++) {
        const step = this.steps[i];
        if (step.name === name) {
          return i;
        }
      }
      return 0;
    },
    isFirstStep() {
      return this.currentStepIndex === 0;
    },
    ...mapState(['loading'])
  }
}
</script>
