<template>
  <div class="help-banner" v-if="bannerData">
    <div class="help-banner__content">
      <h2 class="help-banner__title">
        {{ bannerData['title'] }}
      </h2>
      <div
        v-if="bannerData['description']"
        v-html="bannerData['description']"
        class="help-banner__description paragraph"
      ></div>
    </div>
    <a
      class="help-banner__link button button--primary-inverted"
      :href="bannerData['link']['url']"
      :target="bannerData['link']['target'] || '_self'"
    >
      {{ bannerData['link']['title'] }}
    </a>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  name: 'HelpBanner',
  data() {
    return {};
  },
  computed: {
    ...mapState([
      'bannerData'
    ])
  }
}
</script>
