<template>
<v-app>
   <Pub :zone="zone1" />
   <div class="my-5">
      <v-row>
         <v-col cols="12" md="9" class="mt-3">
               <template v-for="(article, index) in articles.slice(0, 1)">
                  <v-hover v-slot="{ hover }" open-delay="200" :key="index">
                     <v-card class="mx-auto mb-4" max-width="900" max-height="900" :elevation="hover ? 16 : 2" :class="{ 'on-hover': hover }" @click="openDetail(article)">
                           <v-img class="white--text align-end" height="450px" :src="'/uploads/' + article.image">
                              <template v-slot:placeholder>
                                 <v-row class="fill-height ma-0" align="center" justify="center">
                                       <v-progress-circular indeterminate color="blue darken-5"></v-progress-circular>
                                 </v-row>
                              </template>
                              <v-card-title class="text--primary">
                                 {{ article.name }}
                              </v-card-title>
                           </v-img>
                     </v-card>
                  </v-hover>
               </template>
         </v-col>

         <v-col cols="12" md="3" class="mt-3">
               <template v-for="(banner, index) in zone2.slice(0, 1)" flat>
                  <v-card class="mx-auto mb-4" max-width="600" :key="index">
                     <v-img class="white--text align-end" height="215" :src="'/uploads/' + banner.image">
                           <template v-slot:placeholder>
                              <v-row class="fill-height ma-0" align="center" justify="center">
                                 <v-progress-circular indeterminate color="blue darken-5"></v-progress-circular>
                              </v-row>
                           </template>
                     </v-img>
                  </v-card>
               </template>
               <template v-for="(banner, index) in zone3.slice(1, 2)" flat>
                  <v-card class="mx-auto mb-4" max-width="600" :key="index">
                     <v-img class="white--text align-end" height="215" :src="'/uploads/' + banner.image">
                           <template v-slot:placeholder>
                              <v-row class="fill-height ma-0" align="center" justify="center">
                                 <v-progress-circular indeterminate color="blue darken-5"></v-progress-circular>
                              </v-row>
                           </template>
                     </v-img>
                  </v-card>
               </template>
         </v-col>
      </v-row>
   </div>

   <v-row>
      <template v-for="(article, index) in articles.slice(1, 4)">
         <v-col cols="12" md="4" :key="index">
               <v-hover v-slot="{ hover }" open-delay="200">
                  <v-card class="mx-auto" max-width="400" :elevation="hover ? 16 : 2" :class="{ 'on-hover': hover }" @click="openDetail(article)">
                     <v-img class="white--text align-end" height="200px" :src="'/uploads/' + article.image">
                           <template v-slot:placeholder>
                              <v-row class="fill-height ma-0" align="center" justify="center">
                                 <v-progress-circular indeterminate color="blue darken-5"></v-progress-circular>
                              </v-row>
                           </template>
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

   <div class="my-10" v-if="articles.length > 0">
      <v-divider></v-divider>
      <h2 class="text-center display-1">Dernières publiées</h2>
      <v-divider></v-divider>
      <div class="mt-8"></div>
      <v-row>
         <template v-for="(article, index) in articles.slice(3, 9)">
               <v-col cols="12" md="6" :key="index" class="my-2">
                  <v-hover v-slot="{ hover }" open-delay="200">
                     <v-card flat :elevation="hover ? 16 : 2" :class="{ 'on-hover': hover }" @click="openDetail(article)">
                           <v-row>
                              <v-col cols="12" md="6">
                                 <v-img class="white--text align-end" height="200px" :src="'/uploads/' + article.image">
                                       <template v-slot:placeholder>
                                          <v-row class="fill-height ma-0" align="center" justify="center">
                                             <v-progress-circular indeterminate color="blue darken-5"></v-progress-circular>
                                          </v-row>
                                       </template>
                                 </v-img>
                              </v-col>
                              <v-col cols="12" md="6">
                                 <h3>{{ article.name.substr(0, 70) }}</h3>
                                 <br />
                                 <p v-html="article.description.substr(0, 80) + '...'"></p>
                              </v-col>
                           </v-row>
                     </v-card>
                  </v-hover>
               </v-col>
         </template>
      </v-row>

      <v-pagination class="my-5" v-model="page" :length="taille" circle total-visible="10"></v-pagination>

   </div>

   <div v-else>
      <h2 v-if="dialog == false" class="text-center display-2">Il n'existe pas d'article pour cette ca</h2>
   </div>

   <v-dialog v-model="dialog" hide-overlay persistent width="300">
      <v-card color="primary" dark>
         <v-card-text>
               Veuillez patienter...
               <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
         </v-card-text>
      </v-card>
   </v-dialog>
</v-app>
</template>

<script>
import Pub from './Pub.vue';
export default {
   components: {
      Pub
   },
   data() {
      return {
         articles: [],
         dialog: false,
         taille: null,
         page: 1,
         items: [{
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
      this.getArticles();
   },

   watch: {
      $route: "getCategoryByName",
      '$route.path': 'getArticles',
      'page': 'getArticles'
   },

   methods: {
      getArticles: async function () {
         this.dialog = true;
         try {
               let response = await axios.get('/request' + this.$route.path + '?page=' + this.page);
               if (response.status == 200) {
                  console.log(this.$route.path + '?page=' + this.page);
                  this.articles = response.data.data;
                  this.page = response.data.current_page;
                  this.taille = response.data.last_page;
                  this.dialog = false;
                  console.log(response.data);
               }
         } catch (error) {
               this.dialog = false;
               console.log(error);
         }
      },
      openDetail(a) {
         this.$router.push("/" + a.id_sub_category + "/" + a.slug);
      },
   },
   computed: {
      banners() {
         return this.$store.state.banners;
      },

      zone1() {
         return this.banners.filter((a) => {
               return a.name = "1";
         });
      },

      zone2() {
         return this.banners.filter(a => {
               return a.name = "2";
         });
      },

      zone3() {
         return this.banners.filter(a => {
               return a.name = "3";
         });
      }
   },
};
</script>
