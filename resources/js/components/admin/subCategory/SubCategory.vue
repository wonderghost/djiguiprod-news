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
      errors: {},
    };
  },
  methods: {
    getSubCategories: async function() {
      try {
        let response = await axios.get('/sub-category');
        if(response.status == 200) {
          console.log(response);
          this.subCategories = response.data;
        }
      } catch(error) {
        console.log(error);
        this.errors = error.response.errors;
      }
    },
  },

  mounted() {
    this.getSubCategories();
    this.$store.dispatch('getCategories');
  },

  computed: {
    categories() {
      return this.$store.state.categories;
    }
  }
};
</script>