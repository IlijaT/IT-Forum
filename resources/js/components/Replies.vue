<template>
  <div>
    <div v-for="(reply, index) in items" v-bind:key="reply.id">
      <reply-component :data="reply" @deleted="remove(index)"></reply-component>
    </div>
    <new-reply :endpoint="endpoint" @created="add"></new-reply>
  </div>
</template>

<script>

  import replyComponent from './ReplyComponent.vue';
  import newReply from './NewReply.vue';


  export default {
    props: ['data'],
    components: {replyComponent, newReply},

    data() {
      return {
        items: this.data,
        endpoint: location.pathname + '/replies',
      }
    },
    methods: {
      add(reply) {
        this.items.push(reply);
        this.$emit('added');
      },
      remove(index){
        this.items.splice(index,1);
        this.$emit('removed');
        flash('Your reply has been deleted!');
      }
    },
  }
</script>