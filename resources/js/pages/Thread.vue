<script>

import replies from '../components/Replies.vue';
import SubscribeButton from '../components/SubscribeButton.vue';


export default {
  components: {replies, SubscribeButton},
  props: ['dataRepliesCount', 'dataLocked'],

  data() {
    return {
      repliesCount: this.dataRepliesCount,
      locked: this.dataLocked
    }
  },
}
</script>