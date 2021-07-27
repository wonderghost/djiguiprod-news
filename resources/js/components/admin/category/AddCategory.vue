<template>
  <div>
    <v-form ref="form">
      <v-container>
        <div class="text-right" id="form">
          <v-row>
            <v-col cols="12" md="6"> </v-col>

            <v-col cols="12" md="4">
              <v-text-field
                label="Nom de la catégorie"
                name="name"
                required
                type="text"
                color="blue darken-2"
                :error-messages="errors.name"
                v-model="form.name"
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="2">
              <v-btn
                rounded
                dark
                color="primary"
                class="mb-5"
                @click="addCategory()"
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
      },
      errors: {},
      isLoading: false,
      snackbar: false,
      message: ''
    };
  },

  methods: {
    addCategory() {
      this.isLoading = true;
      if (this.form.name == "") {
        return;
      }
      axios
        .post("/category/store", this.form)
        .then((res) => {
          console.log(res);
          this.message = res.data.message;
          this.snackbar = true;
          this.$emit("reloadlist");
          this.$refs.form.reset();
          this.$refs.form.resetValidation();
          this.$emit('reloadlist');
        })
        .catch((err) => {
          console.error(err);
          if(err.status == 422) {
              console.log("errors......")
          }
          this.errors = error.response.errors;
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
  },
};
</script>