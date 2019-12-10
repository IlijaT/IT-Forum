<template>
  <div :id="'reply-'+id" class="card mb-2">
      <div class="card-header">
        <div class="d-flex align-items-center">
            <h5 class="flex-fill">
              <a :href="'/profiles/'+ data.owner.name" v-text="data.owner.name"></a>
                <span v-text="ago"></span>
            </h5>

          
              <div v-if="signedIn">
                <favorite :reply="data"></favorite>
              </div>
           
        </div>

      </div>
     
      <div class="card-body">
          <div v-if="editing">
              <div class="form-group">
                <textarea class="form-control" rows="5" v-model="body"></textarea>
              </div>
              <button class="btn btn-xs btn-primary"  @click="update">Update</button>
              <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>

          </div>
          <div v-else v-text="body"></div>
      </div>

       <!-- @can ('update', $reply) -->
        <div class="card-footer d-flex" v-if="canUpdate">
          <button @click="editing = true" class="btn btn-default btn-secondary mr-1">Edit</button>
          <button type="submit" class="btn btn-danger btn-xs" @click="destroy">Delete</button>
        </div>
      <!-- @endcan   -->

  </div>
</template>

<script>

import favorite from './Favorite.vue';
import moment from 'moment';

export default {
  props: ['data'],
  components: {favorite},
  data() {
    return {
      id: this.data.id,
      editing: false,
      body: this.data.body
    }
  },
  methods: {
    update() {
      axios.patch('/replies/' + this.data.id, {
        body: this.body
      }).then(() => {

        this.editing = false;
        flash('Updated');
      })
      .catch(error => flash(error.response.data, 'danger'));
    },
    destroy() {
      axios.delete('/replies/' + this.data.id).then(() => {
        this.$emit('deleted', this.data.id);
        // $(this.$el).fadeOut(300, () => {
        //   flash('Your reply has been deleted!');
        // })
      });
    }
  },
  computed: {
    ago() {
      return moment(this.data.created_at).fromNow() + '...';
    },
    signedIn() {
      return window.App.signedIn;
    },
    canUpdate() {
      return this.autorize(user => this.data.user_id == window.App.user.id);
      //return this.data.user_id == window.App.user.id;
    }
  },
}
</script>
