<template>
  <div>
    <h1>Liste des articles</h1>

    <div style="text-align: right">
      <v-btn rounded dark color="primary" class="mb-5"
        @click="addArticle()">
        <v-icon>mdi-plus</v-icon>
        Ajouter
      </v-btn>
    </div>

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
    addArticle() {
      return this.$router.push('/add-article');
    },
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