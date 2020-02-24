<script>

import replies from '../components/Replies.vue';
import SubscribeButton from '../components/SubscribeButton.vue';


export default {
  components: {replies, SubscribeButton},
  props: ['thread'],

  data() {
    return {
      repliesCount: this.thread.replies_count,
      locked: this.thread.locked,
      editing: false
    }
  },
  methods: {
    toggleLock() {

      axios[
        this.locked ? 'delete' : 'post'
      ]('/locked-threads/' + this.thread.slug);

      this.locked = ! this.locked;

    }
  },
}
</script>