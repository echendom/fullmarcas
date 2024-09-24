<template>
  <a
    class="button--primary button--large"
    @click="onClick"
    :href="url"
    :target="target ? target : '_self'"
  >
    {{ title }}
  </a>
</template>

<script>
import { mapMutations } from 'vuex';

export default {
  name: 'CtaButton',
  props: ['url', 'target', 'title'],
  data() {
    return {}
  },
  methods: {
    onClick() {
      this.setFromHome(true);
    },
    ...mapMutations(['setFromHome'])
  }
}
</script>
