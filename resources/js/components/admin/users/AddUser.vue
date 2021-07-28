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
      },
      errors: {},
      isLoading: false,
      snackbar: false,
      message: "",
    };
  },

  methods: {
    addUser: async function () {
      this.isLoading = true;
      try {
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
        this.errors = error.response.errors;
      }
    },
  },
};
</script>