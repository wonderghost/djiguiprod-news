<template>
  <div class="mb-10">
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-center"># N°</th>
            <th class="text-center">Nom complet</th>
            <th class="text-center">Contact :</th>
            <th class="text-center">Email :</th>
            <th class="text-center">Description</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(client, index) in clients" :key="index">
            <td class="text-center">{{ index + 1 }}</td>
            <td class="text-center">{{ client.name }}</td>
            <td class="text-center">{{ client.contact }}</td>
            <td class="text-center">{{ client.email }}</td>
            <td class="text-center">{{ client.description }}</td>
            <td class="text-center">
              <p>
                <v-icon
                  color="success"
                  class="mx-3"
                  @click="openEditDialog(client)"
                  >mdi-circle-edit-outline</v-icon
                >
                <v-icon color="error" @click="openDialog(client)"
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
              @click="removeClient()"
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
            <span class="text-h5 center">Modifier le client </span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-form>
                    <v-row>
                      <v-col md="6" cols="12">
                        <v-text-field
                          label="Nom du client "
                          :value="singleClient.name"
                          v-model="singleClient.name"
                          required
                          type="text"
                        >
                        </v-text-field>
                      </v-col>
                      <v-col md="6" cols="12">
                        <v-text-field
                          label="Téléphone"
                          :value="singleClient.contact"
                          v-model="singleClient.contact"
                          required
                          type="number"
                        >
                        </v-text-field>
                      </v-col>
                      <v-col md="12" cols="12">
                        <v-text-field
                          label="Adresse mail"
                          :value="singleClient.email"
                          v-model="singleClient.email"
                          required
                          type="email"
                        >
                        </v-text-field>
                      </v-col>
                       <v-col md="12" cols="12">
                        <v-textarea autocomplete="Description" 
                        label="Déscription" 
                        v-model="singleClient.description"
                        :value="singleClient.description"></v-textarea>
                      </v-col>
                    </v-row>
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
              @click="editClient()"
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
  props: ["clients"],

  data() {
    return {
      dialog: false,
      editDialog: false,
      singleClient: {},
      message: "",
      name: "",
      isLoading: false,
      snackbar: false,
      errors: {},
      form: {
        name: "",
        email: "",
        contact: "",
        description: "",
      },
    };
  },
  methods: {
    editClient: async function () {
      this.isLoading = true;
      try {
        let response = await axios.put(
          "/client/" + this.singleClient.id + "/update",
          this.singleClient
        );
        if (response.status == 200) {
          console.log(response);
          this.isLoading = false;
          this.message = response.data.message;
          this.snackbar = true;
          this.editDialog = false;
          this.$store.dispatch('getClients');
        }
      } catch (error) {
        console.log(error);
        this.isLoading = false;
        this.errors = error.response.errors;
      }
    },

    removeClient: async function () {
      this.isLoading = true;
      try {
        let respose = await axios.delete(
          "/client/" + this.singleClient.id + "/delete"
        );
        if (respose.status == 200) {
          console.log(respose);
          this.isLoading = false;
          this.message = respose.data.message;
          this.dialog = false;
          this.snackbar = true;
          this.$store.dispatch('getClients');
        }
      } catch (error) {
        console.log(error);
        this.isLoading = false;
        this.errors = error.response.errors;
      }
    },

    openDialog(client) {
      this.dialog = true;
      this.name = client.name;
      this.singleClient = client;
    },

    openEditDialog(client) {
      this.editDialog = true;
      this.singleClient = client;
    },
  },
};
</script>