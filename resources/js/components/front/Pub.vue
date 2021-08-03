<template>
  <div>
    <template v-for="(banner, index) in zone.slice(0, 1)">
      <v-card max-height="100" max-width="5000" :key="index" flat>
        <v-img
          class="white--text align-end"
          height="100"
          :src="'/uploads/' + banner.image"
        >
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