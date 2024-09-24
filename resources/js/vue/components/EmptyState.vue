<template>
  <div class="emptystate">
    <img
      :src="icon['url']"
      :alt="icon['alt']"
      class="emptystate__icon image-no-touch"
      width="80"
      height="80"
      loading="lazy"
    />
    <div class="emptystate__heading">
      {{ heading }}
    </div>
    <div class="emptystate__description paragraph--large" v-html="description"></div>
  </div>
</template>

<script>
export default {
  props: ['heading', 'description', 'image'],
  data() {
    let icon = {
      url: `${themosis_assets}/images/skyblue_folder-search.svg`,
      alt: 'Icono de carpeta con lupa'
    };
    if (this.image && this.image.url) {
      icon = this.image;
    }
    return {
      icon: icon
    }
  }
}
</script>
