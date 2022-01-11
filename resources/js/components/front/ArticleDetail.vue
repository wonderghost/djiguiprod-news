<template>
<v-app>
   <!-- <meta property="og:url" :content="encodeURI(loc)" />
   <meta property="og:type" content="website" />
   <meta property="og:title" content="Djiguiprod News" />
   <meta property="og:description" content="Magazine culturelle" />
   <meta property="og:image" :content="'/uploads/' + article.image" /> -->

   <meta property="og:url"           content="https://www.your-domain.com/your-page.html" />
   <meta property="og:type"          content="website" />
   <meta property="og:title"         content="Your Website Title" />
   <meta property="og:description"   content="Your description" />
   <meta property="og:image"         content="https://www.your-domain.com/path/image.jpg" />


   <v-row>
      <v-col cols="12" md="2"></v-col>
      <v-col cols="12" md="8">
         <h1 class="text-center">{{ article.name }}</h1>
         <v-card class="mx-auto my-5" max-width="900" max-height="900" flat>
               <v-img class="white--text align-end" height="450px" :src="'/uploads/' + article.image">
               </v-img>
               <v-card-text>
                  <div class="d-flex justify-space-between">
                     <p class="text-left">
                           <v-icon>mdi-account</v-icon> Autheur: {{ article.userName }}
                     </p>
                     <p class="mr-16 text--grey">
                           <v-icon>mdi-clock</v-icon>
                           {{ article.created_at | formatDate}}
                     </p>
                  </div>
               </v-card-text>
               <v-card-text class="text-center">
                  <!-- <v-btn
            small
            fab
            v-for="(icon, index) in socialMedia"
            :key="index"
            class="mx-2"
            :href="icon.href + encodeURI(loc)"
         >
         <v-icon :color="icon.color" size="250%">{{ icon.icon }}</v-icon>
         </v-btn> -->
                  <div class="fb-share-button" :data-href="encodeURI(loc)" data-layout="button_count">
                  </div>
               </v-card-text>
         </v-card>

         <p v-html="article.description"></p>
      </v-col>
      <v-col cols="12" md="2"></v-col>
   </v-row>

   <div class="my-10" v-if="articles.length > 0">
      <v-divider></v-divider>
      <h3 class="text-center">Articles qui pourraient vous interesser.</h3>
      <v-divider></v-divider>
      <div class="my-8"></div>
      <v-row>
         <template v-for="(article, index) in articles.slice(0, 5)">
               <v-col cols="12" md="6" :key="index" class="my-2">
                  <v-hover v-slot="{ hover }" open-delay="200">
                     <v-card flat :elevation="hover ? 16 : 2" :class="{ 'on-hover': hover }" @click="openDetail(article)">
                           <v-row>
                              <v-col cols="12" md="6">
                                 <v-img class="white--text align-end" height="200px" :src="'/uploads/' + article.image">
                                 </v-img>
                              </v-col>
                              <v-col cols="12" md="6">
                                 <h3>{{ article.name.substr(0, 70) }}</h3>
                                 <br />
                                 <p v-if="article.resume != null" v-text="article.resume.substr(0, 80) + '...'"></p>
                                 <p v-if="article.resume === null" v-text="article.name.substr(0, 80) + '...'"></p>
                              </v-col>
                           </v-row>
                     </v-card>
                  </v-hover>
               </v-col>
         </template>
      </v-row>
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
export default {
   data() {
      return {
         article: {},
         articles: [],
         errors: {},
         dialog: false,
         socialMedia: [{
                  icon: "mdi-facebook",
                  network: "facebook",
                  href: 'https://www.facebook.com/share.php?u=',
                  color: '#3b5998'
               },
               {
                  icon: "mdi-twitter",
                  network: "Twitter",
                  href: 'https://twitter.com/intent/tweet?url=',
                  color: '#00acee'
               },
               {
                  icon: "mdi-linkedin",
                  network: "linkedIn",
                  href: 'https://www.linkedin.com/shareArticle/?url',
                  color: '#0e76a8'
               },
         ],
         loc: location.href
      };
   },

   watch: {
      '$route.path': function () {
         this.getArticle(),
               this.getArticleBySubCategory(),
               this.$vuetify.goTo(0)
      },
   },
   methods: {
      getArticle: async function () {
         this.dialog = true;
         try {
               let response = await axios.get(
                  "/request/article/" + this.$route.params.slug + "/show"
               );
               if (response.status == 200) {
                  this.article = response.data;
                  this.dialog = false;
               }
         } catch (error) {
               console.log(error);
               this.dialog = false;
         }
      },

      getArticleBySubCategory: async function () {
         try {
               let response = await axios.get("/request/articles/" + this.$route.params.subcategory);

               if (response.status == 200) {
                  console.log(response);
                  this.articles = response.data;
               }
         } catch (error) {
               console.log(error);
               this.dialog = false;
         }
      },

      openDetail(a) {
         console.log("/" + a.id_sub_category + '/' + a.slug);
         return this.$router.push("/" + a.id_sub_category + '/' + a.slug);
      },
   },
   mounted() {
      this.getArticle();
      this.getArticleBySubCategory();

      (function (d, s, id) {
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) return;
         js = d.createElement(s);
         js.id = id;
         js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
         fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
   }
};
</script>
