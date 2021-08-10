<template>
  <div class="">
    <template v-if="user">
      <v-navigation-drawer v-model="drawer" color="#F4F5F9" app>
        <v-list-item class="px-2 py-5">
          <v-list-item-title class="text-capitalize" align="center">
            <v-icon x-large>mdi-view-dashboard</v-icon> DJIGUIPROD
          </v-list-item-title>
        </v-list-item>
        <v-list nav dense>
          <v-list-item-group v-model="selectedItem" color="primary">
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
              <v-btn color="primary white--text"> Déconnexion </v-btn>
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
        <v-icon color="white" size="20" @click="goHome">mdi-home</v-icon>
        <template v-for="(category, index) in categories">
          <router-link
            :key="index"
            :to="'/categorie/' + category.slug"
            class="white--text mx-2 text-decoration-none"
          >
            {{ category.name }}
          </router-link>
        </template>
        <v-icon color="white" size="40" @click="openSearch">mdi-card-search</v-icon>
      </div>
    </v-app-bar>

    <v-parallax
      class="mt-16"
      dark
      height="80"
      v-if="isSearching"
    >
      <v-container fluid>
        <v-layout justify-center row wrap>
          <v-flex xs12 class="center mt-10">
            <v-layout justify-center row wrap>
              <v-flex xs6>
                <v-form>
                  <v-text-field
                    outlined
                    v-model="search"
                    label="Rechercher..."
                    append-icon="mdi-card-search"
                    autofocus
                  ></v-text-field>
                </v-form>
              </v-flex>
            </v-layout>
          </v-flex>
        </v-layout>
      </v-container>
    </v-parallax>

    <v-container fluid v-if="search != ''">
      <v-layout justify-center row wrap>
        <v-flex xs12 class="center mt-10">
          <v-layout justify-center row wrap>
            <v-flex xs6>
              <v-list three-line >
                <template v-for="(item, index) in filterArticle">
                  <v-list-item :key="index" @click="openDetail(item)">
                    <v-list-item-avatar>
                      <v-img :src="'/uploads/' + item.image"></v-img>
                    </v-list-item-avatar>

                    <v-list-item-content>
                      <v-list-item-title v-html="item.name"></v-list-item-title>
                      <v-list-item-subtitle
                        v-html="item.description.substr(0, 100) + '...'"
                      ></v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>
                  <v-divider :key="index"></v-divider>
                </template>
              </v-list>
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>
<script>
export default {
  data() {
    return {
      isSearching: false,
      selectedItem: 0,
      search: "",
      items: [
        { icon: "mdi-view-dashboard", text: "Dashboard", route: "/dashboard" },
        { icon: "mdi-file", text: "Articles", route: "/admin/articles" },
        {
          icon: "mdi-briefcase-variant",
          text: "Catégories",
          route: "/admin/category",
        },
        {
          icon: "mdi-subtitles",
          text: "Sous Catégories",
          route: "/admin/sous-categorie",
        },
        {
          icon: "mdi-account-supervisor-circle",
          text: "Redacteurs",
          route: "/admin/users",
        },
        {
          icon: "mdi-account-supervisor",
          text: "Clients",
          route: "/admin/clients",
        },
        {
          icon: "mdi-publish",
          text: "Banniere pub",
          route: "/admin/banner",
        },
      ],
    };
  },

  mounted() {
    this.$store.dispatch("actifUser");
    this.$store.dispatch("getCategories");
    this.$store.dispatch("getArticles");
  },

  methods: {
    openDetail(a) {
      this.search = "";
      this.isSearching = false;
      this.$router.push('/' + a.category.slug + '/' + a.slug);
    },
    openSearch() {
      return this.isSearching = !this.isSearching;
    },
    goHome() {
      this.$router.push('/');
    }
  },

  computed: {
    user() {
      return this.$store.state.user;
    },
    drawer() {
      return this.$store.state.drawer;
    },
    categories() {
      return this.$store.state.categories;
    },
    articles() {
      return this.$store.state.articles;
    },
    filterArticle() {
      return this.articles.filter((article) => {
        return article.name.match(this.search);
      });
    },
  },
};
</script>
