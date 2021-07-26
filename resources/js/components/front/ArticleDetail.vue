<template>
  <div>
    <v-row>
      <v-col cols="12" md="2"></v-col>
      <v-col cols="12" md="8">
        <h1 class="text-center">{{ article.name }}</h1>
        <v-card class="mx-auto my-5" max-width="900" max-height="900" flat>
          <v-img
            class="white--text align-end"
            height="450px"
            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
          >
          </v-img>
          <v-card-text class="text--primary">
            <div class="d-flex justify-space-between">
              <p class="text-left">
                <v-icon>person</v-icon> Autheur: {{ article.author }}
              </p>
              <p class="mr-16 text--grey">
                <v-icon>access_time</v-icon>
                {{ article.created_at }}
              </p>
            </div>
          </v-card-text>
          <v-card-text>
            <v-btn
              v-for="(icon, index) in socialMedia"
              :key="index"
              class="mx-4 black--text"
              icon
            >
              <ShareNetwork
                :network="icon.network"
                url="http://localhost:8000/#/cultures/fode-baro-sest-marie-ce-week-end"
                :title="article.name"
                :description="article.description"
              >
                <v-icon size="200%">{{ icon.icon }}</v-icon>
              </ShareNetwork>
            </v-btn>
          </v-card-text>
        </v-card>

        <p v-html="article.description"></p>
      </v-col>
      <v-col cols="12" md="2"></v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      article: {},
      errors: {},
      socialMedia: [
        {
          icon: "mdi-facebook",
          network: "facebook",
        },
        {
          icon: "mdi-twitter",
          network: "Twitter",
        },
        {
          icon: "mdi-linkedin",
          network: "linkedIn",
        },
      ],
    };
  },
  methods: {
    getArticle: async function () {
      try {
        let response = await axios.get(
          "/article/" + this.$route.params.slug + "/show"
        );
        if (response.status == 200) {
          this.article = response.data;
        }
      } catch (error) {
        console.log(error);
      }
    },
  },
  created() {
    this.getArticle();
    console.log(this.article.description);
  },
};
</script>