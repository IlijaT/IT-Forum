<script>

import replies from '../components/Replies.vue';
import SubscribeButton from '../components/SubscribeButton.vue';


export default {
  components: {replies, SubscribeButton},
  props: ['initialRepliesCount'],

  data() {
    return {
      repliesCount: this.initialRepliesCount
    }
  },
}
</script>