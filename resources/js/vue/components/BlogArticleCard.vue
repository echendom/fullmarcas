<template>
  <article class="card--blog">
    <a :href="url" class="card__thumbnail-link">
      <img
        v-if="thumbnail && thumbnail['url']"
        class="card__thumbnail"
        :src="thumbnail['url']"
        :alt="thumbnail['alt']"
        width="470"
        height="310"
        loading="lazy"
      />
      <img
        v-else
        class="card__thumbnail-off"
        :src="thumbnail_off"
        alt="Imagen por defecto"
        role="presentation"
        width="80"
        height="80"
        loading="lazy"
      />
    </a>
    <div class="card__body">
      <div class="card__tags" v-if="tags && (tags.length > 0)">
        <span v-for="tag in tags" class="card__tag" :style="{background: tag['color']}">
          {{ tag['text'] }}
        </span>
      </div>
      <span class="card__date" v-if="date">
        Fecha de publicación: {{ date }}
      </span>
      <h3 class="card__title" v-if="title">
        <a :href="url" class="card__title-link">
          {{ title }}
        </a>
      </h3>
      <a :href="url" class="card__link" v-if="url">
        Leer más
      </a>
    </div>
  </article>
</template>

<script>
export default {
  name: 'BlogArticleCard',
  props: ['thumbnail', 'tags', 'date', 'title', 'url'],
  data() {
    return {
      thumbnail_off: `${themosis_assets}/images/white_photo-off.svg`
    }
  }
}
</script>
