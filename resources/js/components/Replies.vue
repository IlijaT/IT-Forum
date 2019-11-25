<template>
  <div>
    <div v-for="(reply, index) in items" v-bind:key="reply.id">
      <reply-component :data="reply" @deleted="remove(index)"></reply-component>
    </div>
  </div>
</template>

<script>

  import replyComponent from './ReplyComponent.vue';

  export default {
    props: ['data'],
    components: {replyComponent},

    data() {
      return {
        items: this.data
      }
    },
    methods: {
      remove(index){
        this.items.splice(index,1);
        this.$emit('removed');
        flash('Your reply has been deleted!');
      }
    },
  }
</script>