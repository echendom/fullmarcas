<template>
  <div class="details-modal-button">
    <!-- <button
      class="step4__summary-details-button"
      @click="openDetailsModal"
    >
      Ver detalle
    </button> -->
    <transition name="fade" appear>
      <div
        v-if="showDetailsModal"
        class="modal-overlay"
        @click="hideDetailsModal"
      ></div>
    </transition>
    <transition name="pop" appear>
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
            {{ title }}
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
            v-html="content"
          ></div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  name: 'DetailsModalButton',
  props: ['title', 'content'],
  data() {
    return {
      showDetailsModal: false,
      info_icon: `${themosis_assets}/images/icons/skyblue_info_icon.svg`,
      closeModalIcon: `${themosis_assets}/images/icons/black_delete_file_icon.svg`
    }
  },
  methods: {
    openDetailsModal() {
      this.showDetailsModal = true;
    },
    hideDetailsModal() {
      this.showDetailsModal = false;
    },
  }
}
</script>
