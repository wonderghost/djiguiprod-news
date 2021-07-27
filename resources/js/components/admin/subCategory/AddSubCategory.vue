<template>
  <div >
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
                :hint="`${select.name}, ${select.slug}`"
                :items="categories"
                item-text="name"
                item-value="slug"
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
        id_category: "",
      },
      errors: {},
      isLoading: false,
      snackbar: false,
      message: "",
      select: { name: "Cétégorie", slug: 'default' },
    };
  },

  methods: {
    addSubCategory: async function() {
      this.isLoading = true;
      this.form.id_category = this.select.slug;
      try
      {
        let response = await axios.post("/sub-category/store", this.form);
        if(response.status == 200) {
          console.log(response);
          this.message = response.data.message;
          this.snackbar = true;
          this.isLoading = false;
          this.$refs.form.reset();
          this.$refs.form.resetValidation();
          this.$emit("reloadlist");
        }
      } catch(error) {
        console.log(error);
        this.isLoading = false;
        this.errors = error.response.errors;
      }
    },
  },
};
</script>