<template></template>

<script>
import { mapMutations } from "vuex";

export default {
  name: 'ClearStorage',
  data() {
    return {}
  },
  mounted() {
    this.finishRegister();
  },
  methods: {
    ...mapMutations([
      'finishRegister'
    ]),
  }
}
</script>