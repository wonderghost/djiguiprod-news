<template>
<div class="mb-10">
   <v-simple-table>
      <template v-slot:default>
         <thead>
               <tr>
                  <th class="text-center"># N°</th>
                  <th class="text-center">Sous Catégorie</th>
                  <th class="text-center">Catégorie</th>
                  <th class="text-center">Ajouté le :</th>
                  <th class="text-center">Actions</th>
               </tr>
         </thead>
         <tbody v-if="subCategories.length > 0">
               <tr v-for="(subCategory, index) in subCategories" :key="index">
                  <td class="text-center">{{ index + 1 }}</td>
                  <td class="text-center">{{ subCategory.name }}</td>
                  <td class="text-center">{{ subCategory.id_category }}</td>
                  <td class="text-center">
                     {{ subCategory.created_at | formatDate }}
                  </td>
                  <td class="text-center">
                     <p>
                           <v-icon color="success" class="mx-3" @click="openEditDialog(subCategory)">mdi-circle-edit-outline</v-icon>
                           <v-icon color="error" @click="openDialog(subCategory)">mdi-delete</v-icon>
                     </p>
                  </td>
               </tr>
         </tbody>
         <div v-if="subCategories.length == 0">
               Il n'y a aucune sous catégorie
         </div>
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
                  <v-btn color="green darken-1" text @click="removeSubCategory()">
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
      <v-dialog v-model="editDialog" persistent max-width="350">
         <v-card>
               <v-card-title>
                  <span class="text-h5">Modifier la sous catégorie</span>
               </v-card-title>
               <v-card-text>
                  <v-container>
                     <v-row>
                           <v-col cols="12">
                              <v-form>
                                 <v-text-field label="Nom de la sous catégorie" :value="singleEditSubCategory.name" v-model="singleEditSubCategory.name" required>
                                 </v-text-field>
                                 <v-autocomplete v-model="singleEditSubCategory.id_category" :items="categories" label="Categorie" item-text="name" item-value="slug"></v-autocomplete>
                              </v-form>
                           </v-col>
                     </v-row>
                  </v-container>
               </v-card-text>
               <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="red darken-1" text @click="editDialog = false">
                     Fermer
                  </v-btn>
                  <v-btn color="blue darken-1" text @click="aditSubCategory()" :loading="isLoading">
                     Modifier
                  </v-btn>
               </v-card-actions>
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
</div>
</template>

<script>
export default {
   props: ["subCategories", "categories"],

   data() {
      return {
         dialog: false,
         editDialog: false,
         singleEditSubCategory: {},
         singleSubCategory: {},
         message: "",
         name: "",
         isLoading: false,
         snackbar: false,
         errors: {},
         error: false,
         form: {
               name: "",
               id_category: "",
         },
         select: {
               name: "Cétégorie",
               id: "0"
         },
      };
   },
   methods: {
      aditSubCategory: async function () {
         try {
               this.form.id_category = this.select.slug;
               let response = await axios.put(
                  "/request/sub-category/" + this.singleEditSubCategory.slug + "/update",
                  this.singleEditSubCategory
               );
               if (response.status == 200) {
                  this.message = response.data.message;
                  this.snackbar = true;
                  this.editDialog = false;
                  this.$emit("reloadlist");
               }
         } catch (error) {
               console.log(error);
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

      removeSubCategory: async function () {
         try {
               let response = await axios.delete(
                  "/request/sub-category/" + this.singleEditSubCategory.slug + "/delete"
               );
               if (response.status == 200) {
                  console.log(response);
                  this.dialog = false;
                  this.snackbar = true;
                  this.message = response.data.message;
                  this.$emit("reloadlist");
               }
         } catch (error) {
               console.log(error);
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

      openDialog(subCategory) {
         this.dialog = true;
         this.name = subCategory.name;
         this.singleEditSubCategory = subCategory;
      },

      openEditDialog(subCategory) {
         this.editDialog = true;
         this.singleEditSubCategory = subCategory;
      },
   },
};
</script>
