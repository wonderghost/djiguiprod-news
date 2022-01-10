<template>
  <div class="mb-10">
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-center"># N°</th>
            <th class="text-center">Nom (de la bannière)</th>
            <th class="text-center">Pour le client</th>
            <th class="text-center">Image</th>
            <th class="text-center">Ajouté le :</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(banner, index) in banners" :key="index">
            <td class="text-center">{{ index + 1 }}</td>
            <td class="text-center">{{ banner.name }}</td>
            <td class="text-center">{{ banner.id_client }}</td>
            <td class="text-center">
              <v-img
                max-height="80"
                max-width="80"
                :src="'/uploads/' + banner.image"
              ></v-img>
            </td>
            <td class="text-center">{{ banner.created_at | formatDate }}</td>
            <td class="text-center">
              <p>
                <v-icon
                  color="success"
                  class="mx-3"
                  @click="openEditDialog(banner)"
                  >mdi-circle-edit-outline</v-icon
                >
                <v-icon color="error" @click="openDialog(banner)"
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
            <strong class="deep-purple--text">{{singleBanner.name }}</strong> ?</v-card-text
          >
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="green darken-1"
              text
              @click="removeBanner()"
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

    <v-row justify="center">
      <v-dialog v-model="editDialog" persistent max-width="650">
        <v-card>
          <v-card-title>
            <span class="text-h5">Modifier la bannière </span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-form>
                    
                    <v-text-field
                      label="Nom de la bannière"
                      name="name"
                      required
                      type="text"
                      color="blue darken-2"
                      v-model="singleBanner.name"
                      :value="singleBanner.name"
                    ></v-text-field>

                    <v-autocomplete
                      v-model="singleBanner.id_client"
                      :items="clients"
                      label="Selectionner le client"
                      item-text="name"
                      item-value="id"
                      :value="singleBanner.id_client"
                    ></v-autocomplete>

                    <v-file-input
                      @change="updloadFile"
                      accept="image/*"
                      label="Image de bannière"
                      :value="singleBanner.image"
                    ></v-file-input>
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

    <v-dialog width="400" v-model="error" persistent>
      <v-card style="padding: 4%">
        <v-card-title>Erreur(s)</v-card-title>
        <template v-for="(err, index) in errors">
          <v-alert type="error" dense :key="index">{{ err }}</v-alert>
        </template>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue"
            text
            block
            @click="
              () => {
                error = false;
              }
            "
            >Fermer</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>

  </div>
</template>

<script>
export default {
  props: ["banners"],

  data() {
    return {
      dialog: false,
      editDialog: false,
      singleBanner: {},
      message: "",
      isLoading: false,
      snackbar: false,
      errors: {},
      form: {
        name: "",
        id_client: null,
        image: "",
        _token: "",
      },
    };
  },
  methods: {
    updloadFile(e) {
      console.log(e);
      this.singleBanner.image = e;
    },

    editCategory: async function () {
      this.isLoading = true;
      try {
        this.form._token = this.token;

        let formData = new FormData;
        formData.append("name", this.singleBanner.name)
        formData.append("id_client", this.singleBanner.id_client)
        formData.append("image", this.singleBanner.image)
        formData.append("_token", this.form._token)

        let response = await axios.post(
          "/request/banner/" + this.singleBanner.id + "/update",
          formData
        );
        if (response.status == 200) {
          console.log(response);
          this.isLoading = false;
          this.message = response.data.message;
          this.snackbar = true;
          this.editDialog = false;
          this.dialog = false;
          this.$store.dispatch("getBanners");
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

    removeBanner: async function () {
      this.isLoading = true;
      try {
        let respose = await axios.delete(
          "/request/banner/" + this.singleBanner.id + "/delete"
        );
        if (respose.status == 200) {
          console.log(respose);
          this.isLoading = false;
          this.message = respose.data.message;
          this.dialog = false;
          this.snackbar = true;
          this.$store.dispatch("getBanners");
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

    openDialog(banner) {
      this.dialog = true;
      this.singleBanner = banner;
    },

    openEditDialog(banner) {
      this.editDialog = true;
      this.singleBanner = banner;
    },
  },

  mounted() {
    this.$store.dispatch("getClients");
  },

  computed: {
    clients() {
      return this.$store.state.clients;
    },

    token() {
      return this.$store.state._token;
    }
  },
};
</script>