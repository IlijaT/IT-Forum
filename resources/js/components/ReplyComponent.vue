<template>
  <div :id="'reply-'+id" class="card mb-2">
      <div class="card-header" :class="isBest ? 'bg-success' : ''">
        <div class="d-flex align-items-center">
            <h5 class="flex-fill">
              <a :href="'/profiles/'+ reply.owner.name" v-text="reply.owner.name"></a>
                <span v-text="ago"></span>
            </h5>
          
            <div v-if="signedIn">
              <favorite :reply="reply"></favorite>
            </div>
           
        </div>

      </div>
     
      <div class="card-body">
          <div v-if="editing">
            <form @submit.prevent="update">     
              <div class="form-group">
                <wysiwyg v-model="body"></wysiwyg>
              </div>
              <button class="btn btn-xs btn-primary" type="submit">Update</button>
              <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </form>
        

          </div>
          <div v-else v-html="body"></div>
      </div>

       <!-- @can ('update', $reply) -->
        <div class="card-footer d-flex" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
          <div v-if="authorize('owns', reply)">
            <button @click="editing = true" class="btn btn-default btn-secondary mr-1">Edit</button>
            <button type="submit" class="btn btn-danger btn-xs" @click="destroy">Delete</button>
          </div>
            <button type="submit" class="btn btn-secondary btn-xs ml-auto" v-if="authorize('owns', reply.thread)" @click="markBestReply">Best reply?</button>
        </div>
      <!-- @endcan   -->

  </div>
</template>

<script>

import favorite from './Favorite.vue';
import moment from 'moment';

export default {

  props: ['reply'],

  components: {favorite},
  data() {
    return {
      editing: false,
      id: this.reply.id,
      body: this.reply.body,
      isBest: this.reply.isBest,
    }
  },

  created() {
    
    window.events.$on('best-reply-selected', id => {
      this.isBest = (id == this.id)
    });
  },
  methods: {
    update() {
      axios.patch('/replies/' + this.reply.id, {
        body: this.body
      }).then(() => {

        this.editing = false;
        flash('Updated');
      })
      .catch(error => flash(error.response.data, 'danger'));
    },
    destroy() {
      axios.delete('/replies/' + this.reply.id).then(() => {
        this.$emit('deleted', this.reply.id);
      
      });
    },

    markBestReply() {
      axios.post('/replies/' + this.reply.id + '/best');
      window.events.$emit('best-reply-selected', this.reply.id);

    }
  },
  computed: {
    ago() {
      return moment(this.reply.created_at).fromNow() + '...';
    },
  },
}
</script>
