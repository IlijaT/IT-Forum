<template>
  <div>
    
  </div>
</template>

<script>

import favorite from './Favorite.vue';

export default {
  props: ['attributes'],
  components: {favorite},
  data() {
    return {
      editing: false,
      body: this.attributes.body
    }
  },
  methods: {
    update() {
      axios.patch('/replies/' + this.attributes.id, {
        body: this.body
      }).then(() => {

        this.editing = false;
        flash('Updated');
      });
    },
    destroy() {
      axios.delete('/replies/' + this.attributes.id).then(() => {
        $(this.$el).fadeOut(300, () => {
          flash('Your reply has been deleted!');
        })
      });
    }
  },
}
</script>
