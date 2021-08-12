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
      class="d-none d-lg-block"
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
        <v-btn v-if="showScroll" @click="$vuetify.goTo(0)" class="d-none d-lg-block" color="primary" dark fixed z-index="1" small bottom right style="bottom: 10%"
        fab>
          <v-icon>mdi-arrow-up-bold-circle</v-icon>
        </v-btn>

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
  data() {
    return {
      showScroll: false
    }
  },

  mounted() {
    this.$store.dispatch("actifUser");
    var scroll = this
    window.addEventListener('scroll', function(event) {
      if(window.scrollY > 100) {
        scroll.showScroll = true
      } else {
        scroll.showScroll = false
      }
    })
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
    },
  },

  methods: {
    toTop() {
      let onTop = window;
      onTop.scrollTo(0, 0);
    }
  }
};
</script>
