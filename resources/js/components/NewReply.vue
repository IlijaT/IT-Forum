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
  import 'jquery.caret';
  import 'at.js';

  export default {
    data() {
      return {
        body: '',
      }
    },
    mounted() {
      $('#body').atwho({
          at: "@",
          delay: 750,
          callbacks: {
              remoteFilter: function(query, callback) {
                  $.getJSON("/api/users", {name: query}, function(usernames) {
                      callback(usernames)
                  });
              }
          }
      });
    },

    methods: {
      adReply() {
        axios.post(location.pathname + '/replies', {body: this.body})
          .then(data => {
            this.body = '';
            
            flash('Your reply has been posted!');
            
            this.$emit('created', data.data);
          })
          .catch(error => flash(error.response.data, 'danger'));
          

      }
    },
  }
</script>