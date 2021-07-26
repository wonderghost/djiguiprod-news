<template>
   <div v-if="articlesByCategory.length > 0">
      <div>
         <v-breadcrumbs :items="items" class="pl-0 my-n4"></v-breadcrumbs>
      </div>

      <h2 class="my-4">{{ categoryName }}</h2>

      <div class="mb-4">
         <v-row>
         <v-col cols="12" md="8">
            <template v-for="(article, index) in articlesByCategory.slice(0, 1)">
               <v-hover v-slot="{ hover }" open-delay="200" :key="index">
               <v-card
                  class="mx-auto mb-4"
                  max-width="900"
                  max-height="900"
                  :elevation="hover ? 16 : 2"
                  :class="{ 'on-hover': hover }"
                  @click="openDetail(article)">
                  <v-img
                     class="white--text align-end"
                     height="450px"
                     src="https://cdn.vuetifyjs.com/images/cards/docks.jpg">
                     <v-card-title>{{ article.name }}</v-card-title>
                  </v-img>
               </v-card>
               </v-hover>
            </template>

            <v-row>
               <template v-for="(article, index) in articlesByCategory.slice(1, 3)">
                  <v-col cols="12" md="6" :key="index">
                     <v-hover v-slot="{ hover }" open-delay="200">
                        <v-card
                           class="mx-auto"
                           max-width="400"
                           :elevation="hover ? 16 : 2"
                           :class="{ 'on-hover': hover }"
                           @click="openDetail(article)">
                           <v-img
                              class="white--text align-end"
                              height="200px"
                              src="https://cdn.vuetifyjs.com/images/cards/docks.jpg">
                              <v-card-title>{{ article.name }}</v-card-title>
                           </v-img>
                           <v-card-text class="text--primary">
                              <div v-html="article.description.substr(0, 100) + '...'"></div>
                           </v-card-text>
                        </v-card>
                     </v-hover>
                  </v-col>
               </template>
            </v-row>
         </v-col>

         <v-col cols="12" md="4">
            <v-hover v-slot="{ hover }" open-delay="200">
               <v-card
                  class="mx-auto"
                  max-width="400"
                  max-height="900"
                  :elevation="hover ? 16 : 2"
                  :class="{ 'on-hover': hover }"
                  color="grey">
               Publicités
               </v-card>
            </v-hover>
         </v-col>
         </v-row>
      </div>

      <div class="my-10">
         <h2 class="text-center display-2">Dernières publiées</h2>
         <v-divider></v-divider>
         <div class="mt-8"></div>
         <v-row>
            <template v-for="(article, index) in articlesByCategory.slice(3, 9)">
               <v-col cols="12" md="6" :key="index" class="my-2">
                  <v-hover v-slot="{ hover }" open-delay="200">
                     <v-card
                        flat
                        :elevation="hover ? 16 : 2"
                        :class="{ 'on-hover': hover }"
                        @click="openDetail(article)">
                        <v-row>
                           <v-col cols="12" md="6">
                              <v-img
                              class="white--text align-end"
                              height="200px"
                              src="https://cdn.vuetifyjs.com/images/cards/docks.jpg">
                              </v-img>
                           </v-col>
                           <v-col cols="12" md="6">
                              <h3>{{article.name.substr(0, 70)}}</h3> <br>
                              <p v-html="article.description.substr(0, 80) + '...'"></p>
                           </v-col>
                        </v-row>
                     </v-card>
                  </v-hover>
               </v-col>
            </template>
         </v-row>
      </div>
   </div>
   <div v-else class="my-16">
      <h3 class="text-center">Il y ' a aucun article pour cette categorie</h3>
   </div>
</template>

<script>
export default {
   data() {
      return {
         articles: [],
         categoryName: null,
         items: [
            {
               text: "Accueil",
               disabled: false,
               href: "/",
            },
            {
               text: "Culture",
               disabled: true,
               href: "/culture",
            },
         ],
      };
   },

   mounted() {
      this.getCategoryByName();
      this.getArticles();
   },

   watch: {
      $route: "getCategoryByName",
   },

   methods: {
      getArticles: async function () {
         try {
         let response = await axios.get("/article");
         if (response.status == 200) {
            this.articles = response.data;
            console.log(this.articles);
         }
         } catch (error) {
         console.log(error);
         }
      },
      getCategoryByName: async function () {
         try {
         let response = await axios.get(
            "/category/" + this.$route.params.slug + "/show"
         );
         if (response.status == 200) {
            this.categoryName = response.data.name;
            console.log(this.categoryName);
         }
         } catch (error) {
         console.log(error);
         }
      },
      openDetail(a) {
         this.$router.push('/' + a.category.slug + '/' + a.slug);
      },
   },
   computed: {
      articlesByCategory() {
         return this.articles.filter((cat) => {
         return cat.category.slug == this.$route.params.slug;
         });
      } 
   },
};
</script>