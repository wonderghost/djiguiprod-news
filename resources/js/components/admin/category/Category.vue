<template>
  <div>
    <h1>Liste des catégories</h1>

    <add-category v-on:reloadlist="getCategories()" />

    <list-category :categories="categories" v-on:reloadlist="getCategories()" />
    
  </div>
</template>

<script>
import AddCategory from "./AddCategory.vue";
import ListCategory from "./ListCategory.vue";
export default {
  components: {
    AddCategory,
    ListCategory,
  },
  data() {
    return {
      search: "",
      categories: [],
      isLoading: false,
      snackbar: false,
      errors: {},
    };
  },
  methods: {
    getCategories() {
      axios
        .get("/category")
        .then((res) => {
          console.log(res.data);
          this.categories = res.data;
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
  mounted() {
    this.getCategories();
  },
};
</script>