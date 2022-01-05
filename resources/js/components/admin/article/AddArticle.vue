<template>
<v-app>
   <h1 class="text-center my-4">Ajouter un article</h1>
   <v-form>
      <v-text-field v-model="form.name" label="Titre" required></v-text-field>
      <v-row>
         <v-col cols="12" md="6">
               <v-autocomplete v-model="form.id_sub_category" :items="subCategories" label="Sous categorie" item-text="name" item-value="slug"></v-autocomplete>
         </v-col>
         <v-col cols="12" md="6">
               <v-file-input @change="updloadFile" accept="image/*" label="Image de couverture"></v-file-input>
         </v-col>
      </v-row>
      <quill-editor ref="myTextEditor" v-model="form.description" label="Description" :config="editorOption">
      </quill-editor>

      <div style="text-align: center" class="my-4">
         <v-btn rounded dark color="primary" class="mb-5" @click="saveArticle()" :loading="isLoading">
               <v-icon>mdi-plus</v-icon>
               Ajouter
         </v-btn>
      </div>
   </v-form>

   <v-dialog width="400" v-model="error" persistent>
      <v-card style="padding: 4%">
         <v-card-title>Erreur(s)</v-card-title>
         <template v-for="(err, index) in errors">
               <v-alert type="error" dense :key="index">{{ err }}</v-alert>
         </template>
         <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn color="blue" text block @click="
            () => {
               error = false;
            }
         ">Fermer</v-btn>
         </v-card-actions>
      </v-card>
   </v-dialog>
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
         form: {
               name: "",
               description: "",
               image: "",
               author: "",
               id_sub_category: null,
               _token: null,
         },
         editorOption: {},
         subCategories: [],
         errors: {},
         error: false
      };
   },

   methods: {
      updloadFile(e) {
         console.log(e);
         this.form.image = e;
      },

      saveArticle: async function () {
         this.isLoading = true
         try {
               this.form._token = this.token;
               this.form.author = this.user.id;

               let formData = new FormData();
               formData.append("image", this.form.image);
               formData.append("name", this.form.name);
               formData.append("description", this.form.description);
               formData.append("author", this.form.author);
               formData.append("id_sub_category", this.form.id_sub_category);
               formData.append("_token", this.form._token);

               let response = await axios.post("/request/article/store", formData, {
                  Headers: {
                     "Content-type": "multipart/form-data",
                  },
               });
               if (response.status == 200) {
                  console.log(response);
                  this.isLoading = false
                  this.$router.push('/admin/articles/list')
               }
         } catch (error) {
               console.log(error);
               this.isLoading = false;
               let theErrors = [];
               if (error.response.data.errors) {
                  let errorTab = error.response.data.errors;
                  for (var prop in errorTab) {
                     theErrors.push(errorTab[prop][0]);
                  }
               } else {
                  theErrors.push(error.response.data);
               }

               this.errors = theErrors;
               this.error = true;
         }
      },

      getSubCategories: async function () {
         try {
               let response = await axios.get("/request/sub-category");
               if (response.status == 200) {
                  console.log(response.data);
                  this.subCategories = response.data;
               }
         } catch (error) {
               console.log(error);
               this.errors = error.response.errors;
         }
      },
   },

   mounted() {
      this.getSubCategories();
      this.$store.dispatch("actifUser");
   },

   computed: {
      user() {
         return this.$store.state.user;
      },
      token() {
         return this.$store.state._token;
      },
   },
};
</script>
