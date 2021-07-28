<template>
  <div>
    <v-form>
      <v-text-field v-model="form.name" label="Titre" required></v-text-field>
      <quill-editor
        ref="myTextEditor"
        v-model="form.description"
        label="Description"
        :config="editorOption"
      >
      </quill-editor>
      <v-file-input
        @change="updloadFile"
        accept="image/*"
        label="Image de couverture"
      ></v-file-input>
      <v-autocomplete
        v-model="form.id_sub_category"
        :items="subCategories"
        label="Sous categorie"
        item-text="name"
        item-value="slug"
      ></v-autocomplete>

      <v-btn @click="saveArticle">Valider</v-btn>
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
      form: {
        name: "",
        description: "",
        image: "",
        author: "",
        id_sub_category: null,
        _token: null
      },
      editorOption: {},
      subCategories: [],
    };
  },

  methods: {
    updloadFile(e) {
      console.log(e.target);
      this.form.image = e
    },

    saveArticle: async function() {
        try
        {
            this.form._token = this.token
            this.form.author = this.user.id;

            let formData = new FormData;
            formData.append('image', this.form.image);
            formData.append('name', this.form.name);
            formData.append('description', this.form.description);
            formData.append('author', this.form.author);
            formData.append('id_sub_category', this.form.id_sub_category);
            formData.append('_token', this.form._token);

            let response = await axios.post('/article/store', formData, {
                Headers: {
                    'Content-type': 'multipart/form-data'
                }
            });
            if(response.status == 200) {
                console.log(response);
            }
        } catch(error) {
            console.log(error);
        }
    },

    getSubCategories: async function () {
      try {
        let response = await axios.get("/sub-category");
        if (response.status == 200) {
          console.log(response.data);
          this.subCategories = response.data;
        }
      } catch (error) {
        console.log(error);
        this.errors = error.response.errors;
      }
    },
  },

  mounted() {
    this.getSubCategories();
    this.$store.dispatch('actifUser')
  },

  computed: {
      user() {
          return this.$store.state.user
      },
      token() {
          return this.$store.state._token
      }
  }
};
</script>