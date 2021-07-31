<template>
  <div>
    <h1>Liste des articles</h1>

    <!-- <AddArticle/> -->

    <ListArticle :articles="articles"/>
    
  </div>
</template>

<script>
import AddArticle from "./AddArticle.vue";
import ListArticle from "./ListArticle.vue";
export default {
  components: {
    AddArticle,
    ListArticle,
  },
  data() {
    return {
      search: "",
    };
  },
  methods: {
    
  },
  mounted() {
    this.$store.dispatch("getArticles");
    console.log(this.articles)
  },
  computed: {
    articles() {
      return this.$store.state.articles;
    }
  }
};
</script>