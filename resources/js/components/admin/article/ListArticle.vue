<template>
  <div class="mb-10">
    
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
              <v-img
                max-height="80"
                max-width="80"
                :src="'/uploads/' + article.image"
              ></v-img>
            </td>
            <td class="text-center">{{ article.deleted }}</td>
            <td class="text-center">{{ article.created_at | formatDate }}</td>
            <td class="text-center">
              <p>
                <v-icon
                  color="success"
                  class="mx-3"
                  @click="updateArticle(article)"
                  >mdi-circle-edit-outline</v-icon
                >
                <v-icon color="error" @click="openDialog(article)"
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
            <v-btn
              color="green darken-1"
              text
              @click="removeArticle()"
              :loading="isLoading"
            >
              Oui, supprimer
            </v-btn>
            <v-btn color="error darken-1" text @click="dialog = false">
              Annuler
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
  props: ["articles"],

  data() {
    return {
      dialog: false,
      singleArticle: {},
      message: "",
      name: "",
      isLoading: false,
      snackbar: false,
    };
  },
  methods: {
    updateArticle(article) {
      return this.$router.push("articles/update/" + article.slug);
    },

    editCategory: async function () {
      this.isLoading = true;
      try {
        let response = await axios.put(
          "/category/" + this.singleEditCategory.slug + "/update",
          this.singleEditCategory
        );
        if (response.status == 200) {
          console.log(response);
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
          "/article/" + this.singleArticle.slug + "/delete"
        );
        if (respose.status == 200) {
          console.log(respose);
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
};
</script>