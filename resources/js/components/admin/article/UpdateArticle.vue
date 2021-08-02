<template>
  <div>
    <h1 class="text-center my-4">Modifier l'article "{{ article.name }}"</h1>
    <v-form>
      <v-text-field label="Titre" v-model="form.name" required ></v-text-field>
      <v-row>
        <v-col cols="12" md="6">
          <v-autocomplete
            v-model="form.id_sub_category"
            :items="subCategories"
            label="Sous categorie"
            item-text="name"
            item-value="slug"
          ></v-autocomplete>
        </v-col>
        <v-col cols="12" md="6">
          <v-file-input
            @change="updloadFile"
            accept="image/*"
            label="Image de couverture"
            :v-model="form.image"
          ></v-file-input>
        </v-col>
      </v-row>
      <quill-editor
        ref="myTextEditor"
        v-model="form.description"
        label="Description"
        :config="editorOption"
      >
      </quill-editor>

      <div style="text-align: center" class="my-4">
        <v-btn
          rounded
          dark
          color="primary"
          class="mb-5"
          @click="editArticle()"
          :loading="isLoading"
        >
          <v-icon>mdi-circle-edit-outline</v-icon>
          Modifier
        </v-btn>
      </div>
    </v-form>
  </div>
</template>

<script>
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
export default {
  components: {
    quillEditor,
  },

  data() {
    return {
      select: null,
      isLoading: false,
      article: {},
      form: {
        name: "",
        description: "",
        image: "",
        author: "",
        id_sub_category: null,
        _token: null,
      },
      editorOption: {},
      subCategories: [],
    };
  },

  methods: {

    getArticle: async function () {
      try {
        let response = await axios.get(
          "/article/" + this.$route.params.slug + "/show"
        );
        if (response.status == 200) {
          this.article = response.data;
        }
      } catch (error) {
        console.log(error);
      }
    },

    updloadFile(e) {
      console.log(e.target);
      this.form.image = e;
    },

    editArticle: async function () {
      try {
        this.form._token = this.token;
        this.form.author = this.user.id;

        let formData = new FormData();
        formData.append("image", this.form.image);
        formData.append("name", this.form.name);
        formData.append("description", this.form.description);
        formData.append("author", this.form.author);
        formData.append("id_sub_category", this.form.id_sub_category);
        formData.append("_token", this.form._token);

        let response = await axios.put("/article/" + this.$route.params.slug + "/update", formData, {
          Headers: {
            "Content-type": "multipart/form-data",
          },
        });
        if (response.status == 200) {
          console.log(response);
          this.$router.push('/articles')
        }
      } catch (error) {
        console.log(error);
      }
    },

    getSubCategories: async function () {
      try {
        let response = await axios.get("/sub-category");
        if (response.status == 200) {
          this.subCategories = response.data;
        }
      } catch (error) {
        console.log(error);
        this.errors = error.response.errors;
      }
    },
  },

  mounted() {
    this.getArticle();
    console.log(this.article);
    this.getSubCategories();
    this.$store.dispatch("actifUser");
  },

  computed: {
    user() {
      return this.$store.state.user;
    },
    token() {
      return this.$store.state._token;
    },
    singleArticle() {
        this.form.name = this.article.name
        this.form.description = this.article.description
        this.form.image = this.article.image
        return this.form;
    }
  },
};
</script>