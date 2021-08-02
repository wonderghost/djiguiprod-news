<template>
  <div class="mb-10">
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-center"># N°</th>
            <th class="text-center">Nom (catégorie)</th>
            <th class="text-center">Ajouté le :</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(category, index) in categories" :key="index">
            <td class="text-center">{{ index + 1 }}</td>
            <td class="text-center">{{ category.name }}</td>
            <td class="text-center">{{ category.created_at | formatDate }}</td>
            <td class="text-center">
              <p>
                <v-icon color="success" class="mx-3" @click="openEditDialog(category)"
                  >mdi-circle-edit-outline</v-icon
                >
                <v-icon color="error" @click="openDialog(category)"
                  >mdi-delete</v-icon
                >
              </p>
            </td>
          </tr>
        </tbody>
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
            <v-btn color="green darken-1" text @click="removeCategory()" :loading="isLoading">
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
            <span class="text-h5">Modifier la catégorie</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-form>
                    <v-text-field
                      label="Nom de la catégorie"
                      :value="singleEditCategory.name"
                      v-model="singleEditCategory.name"
                      required
                    >
                    </v-text-field>
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
  props: ["categories"],

  data() {
    return {
      dialog: false,
      editDialog: false,
      singleEditCategory: {},
      singleCategory: {},
      message: "",
      name: "",
      isLoading: false,
      snackbar: false,
      errors: {},
      form: {
        name: "",
        _token: "",
      },
    };
  },
  methods: {
    editCategory: async function() {
      this.isLoading = true;
      try {
        this.form._token = this.token
        let response = await axios.put("/category/" + this.singleEditCategory.slug + "/update",
          this.singleEditCategory);
        if(response.status == 200) {
          console.log(response);
          this.isLoading = false
          this.message = response.data.message;
          this.snackbar = true;
          this.editDialog = false;
          this.$store.dispatch('getCategories');
        }
      } catch(error) {
        console.log(error);
        this.isLoading = false;
        this.errors = error.response.errors;
      }
    },

    removeCategory: async function() {
      this.isLoading = true;
      try {
        let respose = await axios.delete("/category/" + this.singleCategory.slug + "/delete");
        if(respose.status == 200) {
          console.log(respose);
          this.isLoading = false
          this.message = respose.data.message;
          this.dialog = false;
          this.snackbar = true;
          this.$store.dispatch('getCategories');
        }
      } catch(error) {
        console.log(error);
        this.isLoading = false
        this.errors = error.response.errors;
      }
    },

    openDialog(category) {
      this.dialog = true;
      this.name = category.name;
      this.singleCategory = category;
    },

    openEditDialog(category) {
      this.editDialog = true;
      this.singleEditCategory = category;
    },
  },

  computed: {
    token() {
      return this.$store.state._token
    }
  }
};
</script>