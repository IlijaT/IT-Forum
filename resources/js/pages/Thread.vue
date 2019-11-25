<script>

import replies from '../components/Replies.vue';

export default {
  components: {replies},
  props: ['initialRepliesCount'],

  data() {
    return {
      repliesCount: this.initialRepliesCount
    }
  },
}
</script>