<template>
<v-app>
   <h1>Liste des articles</h1>

   <div style="text-align: right">
      <v-btn rounded dark color="primary" class="mb-5" @click="openDialog()">
         <v-icon>mdi-plus</v-icon>
         Ajouter
      </v-btn>
   </div>
   
   <v-dialog v-model="dialog">
       <AddArticle />
   </v-dialog>

   <ListArticle :articles="articles" />

</v-app>
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
        openDialog() {
            this.$store.commit('setDialog', true);
        }
    },
    mounted() {
        this.$store.dispatch("getArticles");
    },
    computed: {
        articles() {
            return this.$store.state.articles;
        },
        dialog() {
            return this.$store.state.dialog;
        }
    }
};
</script>
