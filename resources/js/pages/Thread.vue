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
      editing: false,
      title: this.thread.title,
      body: this.thread.body,
      form: {
        title: this.thread.title,
        body: this.thread.body
      }
    }
  },
  methods: {
    toggleLock() {

      axios[
        this.locked ? 'delete' : 'post'
      ]('/locked-threads/' + this.thread.slug);

      this.locked = ! this.locked;

    },

    update() {
      let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;

      axios.patch(uri, this.form)
        .then(() => {
          this.title = this.form.title;
          this.body = this.form.body;
          this.editing = false;
          flash('You thread has been updated!');
      });
      
    },

    resetForm() {
        this.editing = false;
        this.form = {
          title:  this.thread.title,
          body: this.thread.body
        }
    }

  },
}
</script>