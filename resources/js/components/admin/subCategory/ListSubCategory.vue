<template>
  <div>
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
                <v-icon color="success" @click="openEditDialog(subCategory)"
                  >mdi-circle-edit-outline</v-icon
                >
                <v-icon color="error" @click="openDialog(subCategory)"
                  >mdi-delete</v-icon
                >
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
      <v-dialog
        v-model="dialog"
        persistent
        max-width="350"
        transition="dialog-bottom-transition"
      >
        <v-card>
          <v-card-title class="text-h5">
            Confirmer la suppression
          </v-card-title>
          <v-card-text
            >Êtes-vous sûre de vouloir supprimer
            <strong class="deep-purple--text">{{ name }}</strong> ?</v-card-text
          >
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
                    <v-text-field
                      label="Nom de la sous catégorie"
                      :value="singleEditSubCategory.name"
                      v-model="singleEditSubCategory.name"
                      required
                    >
                    </v-text-field>
                    <v-select
                      v-model="select"
                      :hint="`${select.name}, ${select.id}`"
                      :items="categories"
                      item-text="name"
                      item-value="id"
                      label="Choisir une catégorie"
                      persistent-hint
                      return-object
                      single-line
                    ></v-select>
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
            <v-btn
              color="blue darken-1"
              text
              @click="editCategory()"
              :loading="isLoading"
            >
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
  </div>
</template>

<script>
export default {
  props: ["subCategories", 'categories'],

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
      form: {
        name: "",
      },
      select: { name: "Cétégorie", id: "0" },
    };
  },
  methods: {
    editCategory() {
      axios
        .put(
          "/sub-category/" + this.singleEditSubCategory.slug + "/update",
          this.singleEditSubCategory
        )
        .then((res) => {
          console.log(res);
          this.message = res.data.message;
          this.snackbar = true;
          this.editDialog = false;
          this.$emit("reloadlist");
        })
        .catch((err) => {
          console.error(err);
        });
    },

    removeSubCategory() {
      axios
        .delete("/sub-category/" + this.singleEditSubCategory.slug + "/delete")
        .then((res) => {
          console.log(res);
          this.dialog = false;
          this.snackbar = true;
          this.message = res.data.message;
          this.$emit("reloadlist");
          this.$store.dispatch("getCategories");
        })
        .catch((err) => {
          console.error(err);
        });
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