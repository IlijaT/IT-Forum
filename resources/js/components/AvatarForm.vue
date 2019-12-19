 <template>
   <div>
      <h4 v-text="user.name"></h4>

      <form v-if="canUpdate"  method="POST" enctype="multipart/form-data">
          
          <input type="file" name="avatar" accept="image/*" @change="onChange">
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
   methods: {
     onChange(e) {
       if(! e.target.files.length) return
       let avatar = e.target.files[0];
       let reader = new FileReader();

       reader.readAsDataURL(avatar);

       reader.onload = e => {
         this.avatar = e.target.result;
       };

      // persist to the server
      this.persist(avatar);

     },

     persist(avatar) {
        let data = new FormData();
        data.append('avatar', avatar);
        axios.post(`/api/users/${this.user.name}/avatars`, data)
          .then(() => flash('Avatar is uploaded!'));
     }
   },
   computed: {
     canUpdate() {
       return this.autorize(user => user.id === this.user.id);
     }
   },
 }
 </script>