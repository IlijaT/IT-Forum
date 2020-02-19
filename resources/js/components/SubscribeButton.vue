<template>
  <div>
    <button :class="classes" @click="subscribe">Subscribe</button>
  </div>
</template>

<script>
  export default {

     
    props: ['active'],

    data() {
      return {
        isSubscribed: this.active,
      }
    },

    computed: {
      classes() {
        return this.isSubscribed ? "btn btn-primary" : "btn btn-danger";
      }
    },

    methods: {
      subscribe() {
        axios[
            (this.isSubscribed ? 'delete' : 'post')
        ](location.pathname + '/subscriptions');
        this.isSubscribed = ! this.isSubscribed;
      }
    },
  }
</script>