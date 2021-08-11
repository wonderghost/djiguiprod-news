<template>
   <div>
      <v-hover v-slot="{ hover }" open-delay="200">
         <v-card
            class="mx-auto mb-4"
            max-width="600"
            :elevation="hover ? 16 : 2"
            :class="{ 'on-hover': hover }"
            @click="openDetail(article)">
            <v-img
               class="white--text align-end"
               height="215"
               :src="'/uploads/' + article.image">
               <v-card-title>{{ article.name }}</v-card-title>
            </v-img>
         </v-card>
      </v-hover> 
   </div>
</template>

<script>
export default {
   props: ['article'],

   methods: {
      openDetail(a) {
         this.$router.push('/' + a.slug);
      }
   }
}
</script>
