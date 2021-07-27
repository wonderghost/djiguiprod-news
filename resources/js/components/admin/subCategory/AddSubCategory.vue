<template>
  <div>
    <v-form ref="form">
      <v-container>
        <div class="text-right" id="form">
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                label="Nom de la sous-catégorie"
                name="name"
                required
                type="text"
                color="blue darken-2"
                v-model="form.name"
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="4">
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
            </v-col>

            <v-col cols="12" md="2">
              <v-btn
                rounded
                dark
                color="primary"
                class="mb-5"
                @click="addSubCategory()"
                :loading="isLoading"
              >
                <v-icon>mdi-add</v-icon>
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
  props:['categories'],
  data() {
    return {
      form: {
        name: "",
        id_category: null,
      },
      errors: {},
      isLoading: false,
      snackbar: false,
      message: "",
      select: { name: "Cétégorie", id: "0" },
    };
  },

  methods: {
    addSubCategory() {
      this.isLoading = true;
      this.form.id_category = this.select.id;

      // if (this.form.name == "") {
      //   return;
      // }

      axios
        .post("/sub-category/store", this.form)
        .then((res) => {
          this.form.id_category = null;
          console.log(res);
          this.message = res.data.message;
          this.snackbar = true;
          this.$emit("reloadlist");
          this.$refs.form.reset();
          this.$refs.form.resetValidation();
          this.$emit("reloadlist");
        })
        .catch((err) => {
          console.log(err);
          if (err.status == 422) {
            console.log("errors......");
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