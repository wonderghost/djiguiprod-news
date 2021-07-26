<template>
  <v-app>
    <AppBar />

    <v-btn
        v-if="user"
        style="position: fixed; right: 1%; bottom: 1%; z-index: 1"
        fab
        dark
        small
        color="primary"
        @click="
            () => {
            $store.commit('setDrawer', !drawer);
            }
        "
    >
      <v-icon dark> {{ menuIcon }} </v-icon>
    </v-btn>

    <v-main>
      <v-container>
        <router-view></router-view>
      </v-container>

      <Footer />
    </v-main>
  </v-app>
</template>
<script>
import AppBar from "./front/AppBar.vue";
import Footer from "./front/Footer.vue";
import Home from "./front/Home.vue";
export default {
  components: {
    AppBar,
    Footer,
    Home,
  },
  mounted() {
    this.$store.dispatch('actifUser')
  },

  computed: {
    drawer() {
      return this.$store.state.drawer;
    },
    menuIcon() {
      let data = this.drawer ? "mdi-close" : "mdi-menu";
      return data;
    },
    user() {
        return this.$store.state.user;
    }
  },
};
</script>
