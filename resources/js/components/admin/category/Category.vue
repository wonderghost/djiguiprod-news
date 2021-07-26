<template>
  <div>
    <h1>Liste des catégories</h1>

    <AddCategory/>

    <ListCategory/>
  </div>
</template>

<script>
import AddCategory from "./AddCategory.vue"
import ListCategory from "./ListCategory.vue"
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
  }
};
</script>