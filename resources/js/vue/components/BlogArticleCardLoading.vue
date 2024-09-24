<template>
  <div class="blog-card-loading">
    <div class="pulsate blog-card-loading__thumbnail">
      <img
        class="blog-card-loading__thumbnail-placeholder"
        :src="placeholderImage"
        alt="Placeholder"
        width="84"
        height="63"
        loading="lazy"
      />
    </div>
    <div class="blog-card-loading__body">
      <div class="blog-card-loading__tags">
        <span v-for="tag in 3" class="pulsate blog-card-loading__tag"></span>
      </div>
      <span class="pulsate blog-card-loading__date"></span>
      <h3 class="pulsate blog-card-loading__title"></h3>
      <span class="pulsate blog-card-loading__link"></span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BlogArticleCardLoading',
  data() {
    return {
      placeholderImage: `${themosis_assets}/images/placeholder_image.svg`
    }
  }
}
</script>
