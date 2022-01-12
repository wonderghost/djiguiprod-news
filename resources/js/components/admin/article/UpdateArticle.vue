<template>
<v-app>
   <h1 class="text-center my-4">Modifier l'article "{{ article.name }}"</h1>
   <v-form @submit.prevent="editArticle()">
      <v-text-field label="Titre" v-model="article.name" required></v-text-field>
      <v-row>
         <v-col cols="12" md="6">
               <v-autocomplete v-model="article.id_sub_category" :items="subCategories" label="Sous categorie" item-text="name" item-value="slug"></v-autocomplete>
         </v-col>
         <v-col cols="12" md="6">
               <v-file-input @change="updloadFile" accept="image/*" label="Image de couverture"></v-file-input>
         </v-col>
      </v-row>
      <quill-editor ref="myTextEditor" v-model="article.description" label="Description" :config="editorOption">
      </quill-editor>

      <div style="text-align: center" class="my-4">
         <v-btn rounded dark color="primary" class="mb-5" type="submit" :loading="isLoading">
               <v-icon>mdi-circle-edit-outline</v-icon>
               Modifier
         </v-btn>
      </div>
   </v-form>
</v-app>
</template>

<script>
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import {
    quillEditor
} from "vue-quill-editor";
export default {
   components: {
      quillEditor,
   },

   data() {
      return {
         select: null,
         isLoading: false,
         article: {},
         editorOption: {},
         subCategories: [],
      };
   },

   methods: {

      getArticle: async function () {
         try {
               let response = await axios.get(
                  "/request/article/" + this.$route.params.slug + "/show"
               );
               if (response.status == 200) {
                  this.article = response.data;
               }
         } catch (error) {
               console.log(error);
         }
      },

      updloadFile(e) {
         this.article.image = e;
      },

      editArticle: async function () {
         try {
               this.article._token = this.token;
               this.article.author = this.user.id;

               console.log(this.article);

               let formData = new FormData();
               formData.append("image", this.article.image);
               formData.append("name", this.article.name);
               formData.append("description", this.article.description);
               formData.append("author", this.article.author);
               formData.append("id_sub_category", this.article.id_sub_category);
               formData.append("_token", this.article._token);

               let response = await axios.post("/request/article/" + this.$route.params.slug + "/update", formData, {
                  Headers: {
                     "Content-type": "multipart/form-data",
                  },
               });
               if (response.status == 200) {
                  this.$router.push('/admin/articles/list')
               }
         } catch (error) {
               console.log(error);
         }
      },

      getSubCategories: async function () {
         try {
               let response = await axios.get("/request/sub-category");
               if (response.status == 200) {
                  this.subCategories = response.data;
               }
         } catch (error) {
               console.log(error);
               this.errors = error.response.errors;
         }
      },
   },

   mounted() {
      this.getArticle();
      this.getSubCategories();
      this.$store.dispatch("actifUser");
   },

   computed: {
      user() {
         return this.$store.state.user;
      },
      token() {
         return this.$store.state._token;
      }
   },
};
</script>
