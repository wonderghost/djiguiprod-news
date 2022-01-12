<template>
  <div>
    <h1>Liste des bannières publicitaires</h1>

    <AddBanner/>

    <ListBanner :banners="banners"/>
    
  </div>
</template>

<script>
import AddBanner from "./AddBanner.vue";
import ListBanner from "./ListBanner.vue";
export default {
  components: {
    AddBanner,
    ListBanner,
  },
  data() {
    return {
      search: "",
    };
  },
  methods: {
    
  },
  mounted() {
    this.$store.dispatch("getBanners");
  },
  computed: {
    banners() {
      return this.$store.state.banners;
    }
  }
};
</script>