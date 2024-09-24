<template>
  <transition name="fade" mode="out-in" appear>
    <div
      v-if="loading"
      class="loader"
    >
      <img
        :src="loader"
        alt="Animacion de carga"
      />
    </div>
  </transition>
</template>

<script>
export default {
  name: 'Loader',
  props: ['loading'],
  data() {
    return {
      loader: `${themosis_assets}/images/animations/loader.svg`
    }
  }
}
</script>
