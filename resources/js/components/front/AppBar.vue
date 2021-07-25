<template>
   <div class="mb-16">
      <v-app-bar flat app color="grey darken-3">
         <v-toolbar-title>
            <router-link to="/">
               <v-img
                  style="margin-left: 80px"
                  max-height="35"
                  max-width="60"
                  src="https://cdn.pixabay.com/photo/2015/12/01/20/28/road-1072823__340.jpg">
               </v-img>
            </router-link>
         </v-toolbar-title>

         <v-spacer></v-spacer>
         <div style="margin-right: 80px">
            <template v-for="(category, index) in categories">
               <router-link
                  :key="index"
                  :to="'/categorie/' + category.slug"
                  class="white--text mx-2 text-decoration-none">
                  {{ category.name }}
               </router-link>
            </template>
         </div>
      </v-app-bar>
   </div>
</template>
<script>
export default {
   data() {
      return {
         categories: [],
      };
   },

   mounted() {
      this.initCategory();
   },

   methods: {
      initCategory: async function () {
         try {
            let response = await axios.get("/category");
            if (response.status == 200) {
               console.log(response.data);
               this.categories = response.data;
            }
         } catch (error) {
            console.log(error);
         }
      },
   },
};
</script>
