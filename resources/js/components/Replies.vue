<template>
  <div>
    <div v-for="(reply, index) in items" v-bind:key="reply.id">
      <reply-component :reply="reply" @deleted="remove(index)"></reply-component>
    </div>
    <paginator :dataSet="dataSet" @changed="fetch"></paginator>
    <p v-if="$parent.locked">
      This thread has been locked. No more replies are allowed.
    </p>
    <new-reply @created="add" v-else></new-reply>
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

        window.scrollTo(0,0);
        
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