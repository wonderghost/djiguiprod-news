<template>
  <div>
    <v-form ref="form">
      <v-container>
        <div class="text-right" id="form">
          <v-row>
            <v-col cols="12" md="4">
              <v-text-field
                label="Nom complet"
                name="name"
                required
                type="text"
                color="blue darken-2"
                v-model="form.name"
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="4">
              <v-text-field
                label="Adresse Email"
                name="email"
                required
                type="email"
                color="blue darken-2"
                v-model="form.email"
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="4">
              <v-text-field
                label="Numéro de téléphone"
                name="contact"
                required
                type="number"
                color="blue darken-2"
                v-model="form.contact"
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="10">
              <v-textarea autocomplete="Description" label="Déscription" v-model="form.description"></v-textarea>
            </v-col>

            <v-col cols="12" md="2">
              <v-btn
                rounded
                dark
                color="primary"
                class="mb-5"
                @click="addClient()"
                :loading="isLoading"
              >
                <v-icon>mdi-plus</v-icon>
                Ajouter
              </v-btn>
            </v-col>
          </v-row>
        </div>
      </v-container>
    </v-form>

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
  data() {
    return {
      form: {
        name: "",
        email: "",
        contact: "",
        description: ""
      },
      errors: {},
      isLoading: false,
      snackbar: false,
      message: "",
    };
  },

  methods: {
    addClient: async function () {
      this.isLoading = true;
      try {
        let response = await axios.post("/client/store", this.form);
        if (response.status == 200) {
          console.log(response);
          this.message = response.data.message;
          this.snackbar = true;
          this.isLoading = false;
          this.$refs.form.reset();
          this.$refs.form.resetValidation();
          this.$store.dispatch('getClients');
        }
      } catch (error) {
        console.log(error);
        this.isLoading = false;
        this.errors = error.response.errors;
      }
    },
  },
};
</script>