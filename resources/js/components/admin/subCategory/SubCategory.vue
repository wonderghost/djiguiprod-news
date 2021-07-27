<template>
  <div>
    <h1>Liste des sous catégories</h1>

    <add-sub-category :categories="categories" v-on:reloadlist="getSubCategories()" />

    <list-sub-category :subCategories="subCategories" :categories="categories" v-on:reloadlist="getSubCategories()" />
  </div>
</template>

<script>
import AddSubCategory from './AddSubCategory.vue';
import ListSubCategory from './ListSubCategory.vue';
export default {
  components: {
    AddSubCategory,
    ListSubCategory,
  },
  data() {
    return {
      search: "",
      subCategories: [],
      isLoading: false,
      snackbar: false,
      categories: [],
      errors: {},
    };
  },
  methods: {
    getSubCategories() {
      axios
        .get("/sub-category")
        .then((res) => {
          console.log(res.data);
          this.subCategories = res.data;
        })
        .catch((err) => {
          console.error(err);
        });
    },

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
  created() {
    this.getSubCategories();
    this.getCategories();
  },
};
</script>