<template>
  <v-app>
    
    
  </v-app>
</template>
<script>
// import SideBar from "./SideBar.vue";
// import AppBar from "./AppBar.vue";
export default {
//   components: {
//     SideBar,
//     AppBar,
//   },
  data() {
    return {
      selectedItem: 0,
      drawer: null,
      items: [
        { icon: "mdi-view-dashboard", text: "Dashboard", route: "/dashboard" },
        { icon: "mdi-file", text: "Articles", route: "/article" },
        { icon: "mdi-shop", text: "Catégories", route: "category" },
        { icon: "subtitles", text: "Sous Catégories", route: "/sub-category" },
        { icon: "people", text: "Redacteurs", route: "/article" },
      ],
    };
  },

  mounted() {},
};
</script>
