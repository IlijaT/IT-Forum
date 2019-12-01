<template>
  <div>
    <div v-for="(reply, index) in items" v-bind:key="reply.id">
      <reply-component :data="reply" @deleted="remove(index)"></reply-component>
    </div>
    <paginator :dataSet="dataSet" @changed="fetch"></paginator>
    <new-reply @created="add"></new-reply>
  </div>
</template>

<script>

  import replyComponent from './ReplyComponent.vue';
  import newReply from './NewReply.vue';
  import collection from '../mixins/collection';


  export default {
    components: {replyComponent, newReply},
    mixins: [collection],

    data() {
      return {
        dataSet: false,
      }
    },
    created() {
      this.fetch();
    },
    methods: {
      fetch(page) {
        axios.get(this.url(page)).then(this.refresh);
      },
      refresh({data}) {
        this.dataSet = data;
        this.items = data.data;
        
      },
      url(page){
        if (! page) {
          let query = location.search.match(/page=(\d+)/);
          page = query ? query[1] : 1;
        }

        return `${location.pathname}/replies?page=${page}`;
      },

    },
  }
</script>