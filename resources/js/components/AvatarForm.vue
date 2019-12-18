 <template>
   <div>
      <h4 v-text="user.name"></h4>

      <form v-if="canUpdate"  method="POST" enctype="multipart/form-data">
          
          <input type="file" name="avatar">
          <div class="mt-1">

            <button type="submit" class="btn btn-primary">Add Avatar</button>
          </div>
        </form>
      <img :src="avatar" alt="avatar" width="80" height="80">
   </div>
 </template>

 <script>
 export default {
   props: ['user'],

   data() {
     return {
       avatar: ''
     }
   },
   computed: {
     canUpdate() {
       return this.autorize(user => user.id === this.user.id);
     }
   },
 }
 </script>