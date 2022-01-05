<template>
<v-app>
    <h1>Liste des catégories</h1>

    <add-category />

    <list-category :categories="categories" />

</v-app>
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
        };
    },
    methods: {

    },
    mounted() {
        this.$store.dispatch("getCategories");
        console.log(this.categories)
    },
    computed: {
        categories() {
            return this.$store.state.categories;
        }
    }
};
</script>
