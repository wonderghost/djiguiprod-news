<template>
<div>
   <template v-for="(banner, index) in zone.slice(0, 1)">
      <v-card :key="index" flat>
         <v-img class="white--text align-end" height="100" :src="'/uploads/' + banner.image">
         </v-img>
      </v-card>
   </template>
</div>
</template>

<script>
export default {
   props: ["zone"],
};
</script>
