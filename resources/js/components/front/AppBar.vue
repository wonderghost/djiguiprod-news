<template>
  <div class="mb-16">
    <template v-if="user">
      <v-navigation-drawer v-model="drawer" color="#F4F5F9" app>
        <v-list-item class="px-2 py-5">
          <v-list-item-title class="text-capitalize" align="center">
            <v-icon x-large>mdi-view-dashboard</v-icon> DJIGUIPROD
          </v-list-item-title>
        </v-list-item>
        <v-list nav dense>
          <v-list-item-group v-model="selectedItem" color="deep-purple">
            <v-list-item v-for="(item, i) in items" :key="i" :to="item.route">
              <v-list-item-icon>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="item.text"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-item-group>
        </v-list>
        <template v-slot:append>
          <div class="pa-2">
            <v-card align="center" class="pa-3">
              <v-badge
                borderd
                bottom
                color="green"
                dot
                offset-x="10"
                offset-y="10"
                class="mb-8"
              >
                <v-avatar size="40">
                  <v-icon>mdi-account</v-icon>
                </v-avatar>
              </v-badge>
              <h4 class="grey--text">{{ user.name }}</h4>
              <p>{{ user.email }}</p>
              <v-btn color="deep-purple white--text"> Déconnexion </v-btn>
            </v-card>
          </div>
        </template>
      </v-navigation-drawer>
    </template>

    <v-app-bar flat app color="grey darken-3">
      <v-toolbar-title>
        <router-link to="/">
          <v-img
            style="margin-left: 80px"
            max-height="80"
            max-width="150"
            src="images/logo-djigui.png"
          >
          </v-img>
        </router-link>
      </v-toolbar-title>

      <v-spacer></v-spacer>
      <div style="margin-right: 80px">
        <template v-for="(category, index) in categories">
          <router-link
            :key="index"
            :to="'/categorie/' + category.slug"
            class="white--text mx-2 text-decoration-none"
          >
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
    this.$store.dispatch("actifUser");
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

  computed: {
    user() {
      return this.$store.state.user;
    },
    drawer() {
      return this.$store.state.drawer;
    },
  },
};
</script>
