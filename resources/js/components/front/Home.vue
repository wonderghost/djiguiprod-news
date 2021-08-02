<template>
  <v-app>
    <v-row>
      <v-col cols="12" md="9" class="mt-6">
        <v-carousel cycle hide-delimiter-background show-arrows-on-hover>
          <v-carousel-item
            v-for="(article, index) in articles.slice(0, 5)"
            :key="index"
          >
            <v-hover v-slot="{ hover }" open-delay="200">
              <v-card
                class="mx-auto"
                max-width="900"
                max-height="900"
                :elevation="hover ? 16 : 2"
                :class="{ 'on-hover': hover }"
                @click="openDetail(article)"
              >
                <v-img
                  class="white--text align-end"
                  height="450px"
                  :src="'/uploads/' + article.image"
                >
                  <v-card-title class="text--primary">{{
                    article.name
                  }}</v-card-title>
                </v-img>
              </v-card>
            </v-hover>
          </v-carousel-item>
        </v-carousel>

        <div class="mt-1">
          <v-row>
            <template v-for="(article, index) in articles.slice(1, 3)">
              <v-col cols="12" md="6" :key="index">
                <v-hover v-slot="{ hover }" open-delay="200">
                  <v-card
                    class="mx-auto"
                    max-width="400"
                    :elevation="hover ? 16 : 2"
                    :class="{ 'on-hover': hover }"
                  >
                    <v-img
                      class="white--text align-end"
                      height="200px"
                      :src="'/uploads/' + article.image"
                    >
                      <v-card-title>{{ article.name }}</v-card-title>
                    </v-img>

                    <v-card-text class="text--primary">
                      <div
                        v-html="article.description.substr(0, 100) + '...'"
                      ></div>
                    </v-card-text>
                  </v-card>
                </v-hover>
              </v-col>
            </template>
          </v-row>
        </div>
      </v-col>

      <v-col cols="12" md="3" class="mt-6">
        <template v-for="(banner, index) in zone2.slice(0, 2)">
          <v-card class="mx-auto mb-4" max-width="600" :key="index">
            <v-img
              class="white--text align-end"
              height="215"
              :src="'/uploads/' + banner.image"
            >
            </v-img>
          </v-card>
        </template>
      </v-col>
    </v-row>

    <h1 class="mt-2">
      <router-link
        to="/categorie/sports"
        class="black--text text-decoration-none"
        >Sports</router-link
      >
    </h1>
    <v-divider></v-divider>
    <div class="my-4">
      <v-row>
        <template v-for="(sport, index) in sports.slice(0, 6)">
          <v-col cols="12" md="4" :key="index">
            <ArticleCard :article="sport" />
          </v-col>
        </template>
      </v-row>
    </div>

    <h1 class="mt-5">
      <router-link
        to="/categorie/cultures"
        class="black--text text-decoration-none"
        >Cultures</router-link
      >
    </h1>
    <v-divider></v-divider>
    <div class="my-4">
      <v-row>
        <template v-for="(culture, index) in cultures.slice(0, 6)">
          <v-col cols="12" md="4" :key="index">
            <ArticleCard :article="culture" />
          </v-col>
        </template>
      </v-row>
    </div>
  </v-app>
</template>

<script>
import ArticleCard from "./ArticleCard.vue";
export default {
  components: {
    ArticleCard,
  },
  data() {
    return {
      articles: [],
    };
  },

  mounted() {
    this.getArticles();
    this.$store.dispatch("getBanners");
  },

  methods: {
    getArticles: async function () {
      try {
        let response = await axios.get("/article");
        if (response.status == 200) {
          this.articles = response.data;
        }
      } catch (error) {
        console.log(error);
      }
    },

    openDetail(a) {
      this.$router.push(a.category.slug + "/" + a.slug);
    },
  },
  computed: {
    cultures() {
      return this.articles.filter((culture) => {
        return culture.category.slug == "cultures";
      });
    },

    sports() {
      return this.articles.filter((sport) => {
        return sport.category.slug == "sports";
      });
    },

    banners() {
      return this.$store.state.banners;
    },

    zone2() {
      return this.banners.filter(a => {
        return a.name == "2";
      })
    }
  },
};
</script>
