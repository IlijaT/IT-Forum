<template>
  <div>
      <input id="trix" type="hidden" :name="name" :value="value">
      <trix-editor ref="trix" input="trix" :placeholder="placeholder"></trix-editor>
  </div>
</template>

<script>

import trix from 'trix';

export default {

  props: ['name', 'value', 'placeholder', 'shouldClear'],

  mounted() {
    this.$refs.trix.addEventListener('trix-change', e => {
      this.$emit('input', e.target.innerHTML);
    });

    this.$watch('shouldClear', () => this.$refs.trix.value = ''); 
  },
  
}
</script>