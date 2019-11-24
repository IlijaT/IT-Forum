<template>
  <div>
    <button type="submit" :class="classes" @click="toggle">
      <i class="fa fa-heart"></i>
      <span v-text="count"></span>
    </button>
  </div>
</template>

<script>
export default {
  props:['reply'],
  data() {
    return {
      count: this.reply.favoritesCount,
      active: this.reply.isFavorited
    }
  },
  computed: {
   classes()  {
     return ['btn', this.active ? 'btn-success' : 'btn-info'];
   },
   endpoint(){
     return '/replies/' + this.reply.id + '/favorites';
   }
  },
  methods: {
    toggle() {
     this.active ? this.destroy() : this.create();
    },
    destroy(){
      axios.delete(this.endpoint);
      this.count--;
      this.active = false;
      flash('You unfavorited reply!');
    },
    create(){
      axios.post(this.endpoint);
      this.count ++;
      this.active = true;
      flash('You favorited reply!');

    }
  },
}
</script>