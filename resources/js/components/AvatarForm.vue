 <template>
   <div>

      <div class="d-flex mb-1 align-items-end">
        <img :src="avatar" alt="avatar" width="80" height="80" class="mr-1">
        <h4 v-text="user.name"></h4>
      </div>

      <form v-if="canUpdate"  method="POST" enctype="multipart/form-data">
          <image-upload name="avatar" @loaded="onLoad"></image-upload>
          <!-- <input type="file" name="avatar" accept="image/*" @change="onChange"> -->
        </form>
   </div>
 </template>

 <script>

 import ImageUpload from './ImageUpload.vue';

 export default {

   components: {ImageUpload},
   props: ['user'],

   created() {
     console.log(this.user.avatar_path);
     
   },

   data() {
     return {
       avatar: this.user.avatar_path
     }
   },
   methods: {
    onLoad(avatar){
      this.avatar = avatar.src;
      this.persist(avatar.file);
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