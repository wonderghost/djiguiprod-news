<template>
  <div>
    <v-form ref="form">
      <v-container>
        <div class="text-right" id="form">
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                label="Nom Complet"
                required
                type="text"
                color="blue darken-2"
                :error-messages="errors.name"
                v-model="form.name"
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field
                label="Adresse mail"
                required
                type="text"
                color="blue darken-2"
                :error-messages="errors.email"
                v-model="form.email"
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="5">
              <v-text-field
                label="Téléphone"
                required
                type="text"
                color="blue darken-2"
                :error-messages="errors.phone"
                v-model="form.phone"
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="5">
              <v-select :items="roles" label="Role" v-model="form.role"></v-select>
            </v-col>

            <v-col cols="12" md="2">
              <v-btn
                rounded
                dark
                color="primary"
                class="mb-5"
                @click="addUser()"
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
  data() {
    return {
      roles: ['admin', 'redacteur'],
      form: {
        name: "",
        email: "",
        role: "",
        phone: "",
        _token: ""
      },
      errors: {},
      error: false,
      isLoading: false,
      snackbar: false,
      message: "",
    };
  },

  methods: {
    addUser: async function () {
      this.isLoading = true;
      try {
        this.form._token = this.token;
        let response = await axios.post("/create-user", this.form);
        if (response.status == 200) {
          console.log(response);
          this.message = response.data.message;
          this.snackbar = true;
          this.isLoading = false;
          this.$refs.form.reset();
          this.$refs.form.resetValidation();
          this.$emit('reloadlist');
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
  },

  computed: {
    token() {
      return this.$store.state._token
    }
  }
};
</script>