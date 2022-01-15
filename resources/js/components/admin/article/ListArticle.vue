<template>
<v-app class="mb-10">

   <v-simple-table>
      <template v-slot:default>
         <thead>
               <tr>
                  <th class="text-center"># N°</th>
                  <th class="text-center">Titre</th>
                  <th class="text-center">Image</th>
                  <th class="text-center">Ajouté par :</th>
                  <th class="text-center">Ajouté le :</th>
                  <th class="text-center">Actions</th>
               </tr>
         </thead>
         <tbody>
               <tr v-for="(article, index) in articles" :key="index">
                  <td class="text-center">{{ index + 1 }}</td>
                  <td class="text-center">{{ article.name }}</td>
                  <td class="text-center">
                     <v-img max-height="80" max-width="80" :src="'/uploads/' + article.image"></v-img>
                  </td>
                  <td class="text-center">{{ article.deleted }}</td>
                  <td class="text-center">{{ article.created_at | formatDate }}</td>
                  <td class="text-center">
                     <p>
                           <v-icon color="success" class="mx-3" @click="updateArticle(article)">mdi-circle-edit-outline</v-icon>
                           <v-icon color="error" @click="openDialog(article)">mdi-delete</v-icon>
                     </p>
                  </td>
               </tr>
         </tbody>
      </template>
   </v-simple-table>

   <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="350" transition="dialog-bottom-transition">
         <v-card>
               <v-card-title class="text-h5">
                  Confirmer la suppression
               </v-card-title>
               <v-card-text>Êtes-vous sûre de vouloir supprimer
                  <strong class="deep-purple--text">{{ name }}</strong> ?</v-card-text>
               <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="green darken-1" text @click="removeArticle()" :loading="isLoading">
                     Oui, supprimer
                  </v-btn>
                  <v-btn color="error darken-1" text @click="dialog = false">
                     Annuler
                  </v-btn>
               </v-card-actions>
         </v-card>
      </v-dialog>
   </v-row>

   <v-row justify="center">
      <v-dialog v-model="editDialog" persistent>
         <v-card>
               <v-card-title>
                  <span class="text-h5">Modifier l'article "{{ editArticle.name }}"</span>
               </v-card-title>
               <v-card-text>
                  <v-container>
                     <v-form @submit.prevent="updateArticle()">
                           <v-text-field label="Titre" v-model="editArticle.name" :value="editArticle.name" required></v-text-field>
                           <v-row>
                              <v-col cols="12" md="6">
                                 <v-autocomplete v-model="editArticle.id_sub_category" :items="subCategories" label="Sous categorie" item-text="name" item-value="slug"></v-autocomplete>
                              </v-col>
                              <v-col cols="12" md="6">
                                 <v-file-input @change="updloadFile" accept="image/*" label="Image de couverture"></v-file-input>
                              </v-col>
                           </v-row>
                           <v-text-field label="Resumé" counter="150" required></v-text-field>
                           <quill-editor ref="myTextEditor" v-model="editArticle.description" label="Description" :config="editorOption">
                           </quill-editor>

                           <div style="text-align: center" class="my-4">
                              <v-btn rounded dark color="primary" class="mb-5" type="submit" :loading="isLoading">
                                 <v-icon>mdi-circle-edit-outline</v-icon>
                                 Modifier
                              </v-btn>
                           </div>
                     </v-form>
                  </v-container>
               </v-card-text>
         </v-card>
      </v-dialog>
   </v-row>

   <v-snackbar v-model="snackbar" right top color="success">
      {{ message }}
      <template v-slot:action="{ attrs }">
         <v-btn color="primary" text v-bind="attrs" @click="snackbar = false">
               Ok
         </v-btn>
      </template>
   </v-snackbar>
</v-app>
</template>

<script>
import UpdateArticle from '../article/UpdateArticle.vue';
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import {
   quillEditor
} from "vue-quill-editor";
export default {
   components: {
      UpdateArticle,
      quillEditor
   },
   props: ["articles"],

   data() {
      return {
         dialog: false,
         singleArticle: {},
         editArticle: {},
         message: "",
         name: "",
         isLoading: false,
         snackbar: false,
         subCategories: [],
         editorOption: {},
      };
   },
   methods: {
      updateArticle(article) {
         this.editArticle = article;
         return this.$store.commit('setEditDialog', true);
      },

      updloadFile(e) {
         this.editArticle.image = e;
      },

      editCategory: async function () {
         this.isLoading = true;
         try {
               let response = await axios.put(
                  "/request/category/" + this.singleEditCategory.slug + "/update",
                  this.singleEditCategory
               );
               if (response.status == 200) {
                  this.isLoading = false;
                  this.message = response.data.message;
                  this.snackbar = true;
                  this.editDialog = false;
                  this.editCategory = false;
                  this.$store.dispatch("getCategories");
               }
         } catch (error) {
               console.log(error);
               this.isLoading = false;
               this.errors = error.response.errors;
         }
      },

      removeArticle: async function () {
         this.isLoading = true;
         try {
               let respose = await axios.delete(
                  "/request/article/" + this.singleArticle.slug + "/delete"
               );
               if (respose.status == 200) {
                  this.isLoading = false;
                  this.message = respose.data.message;
                  this.dialog = false;
                  this.snackbar = true;
                  this.$store.dispatch("getArticles");
               }
         } catch (error) {
               console.log(error);
               this.isLoading = false;
               this.errors = error.response.errors;
         }
      },

      updateArticle: async function () {
         try {
               this.editArticle._token = this.token;
               this.editArticle.author = this.user.id;

               console.log(this.editArticle);

               let formData = new FormData();
               formData.append("image", this.editArticle.image);
               formData.append("name", this.editArticle.name);
               formData.append("description", this.editArticle.description);
               formData.append("author", this.editArticle.author);
               formData.append("id_sub_category", this.editArticle.id_sub_category);
               formData.append("_token", this.editArticle._token);

               let response = await axios.post("/request/article/" + editArticle.slug + "/update", formData, {
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

      openDialog(category) {
         this.dialog = true;
         this.name = category.name;
         this.singleArticle = category;
      },

      openEditDialog(category) {
         this.editDialog = true;
         this.singleEditCategory = category;
      },
   },

   mounted() {
      this.getSubCategories();
      this.$store.dispatch("actifUser");
   },

   computed: {
      editDialog() {
         return this.$store.state.editDialog;
      },
      user() {
         return this.$store.state.user;
      },
      token() {
         return this.$store.state._token;
      }
   }
};
</script>
