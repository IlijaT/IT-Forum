<template>
  <div>
     <div v-if="signedIn">
        <div class="form-group">
          <textarea class="form-control" 
                    id="body" 
                    name="body" 
                    placeholder="Have something to say?" 
                    rows="5"
                    v-model="body"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" @click="adReply">Post</button>
     </div>
 
      <p class="text-center" v-else>Please <a href="/login">sign in </a>to participate in this discusion</p>
     
  </div>
</template>

<script>
  export default {
    props: ['endpoint'],
    data() {
      return {
        body: '',
      }
    },
    computed: {
      signedIn() {
        return window.App.signedIn;
      }
    },
    methods: {
      adReply() {
        axios.post(this.endpoint, {body: this.body})
          .then(data => {
            this.body = '';
            
            flash('Your reply has been posted!');
            
            this.$emit('created', data.data);
          });

      }
    },
  }
</script>