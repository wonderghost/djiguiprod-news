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
            :src="'/uploads/' + article.image"
          >
          </v-img>
          <v-card-text>
            <div class="d-flex justify-space-between">
              <p class="text-left">
                <v-icon>mdi-account</v-icon> Autheur: {{ article.userName }}
              </p>
              <p class="mr-16 text--grey">
                <v-icon>mdi-clock</v-icon>
                {{ article.created_at | formatDate}}
              </p>
            </div>
          </v-card-text>
          <v-card-text class="text-center">
            <v-btn
              small
              fab
              v-for="(icon, index) in socialMedia"
              :key="index"
              class="mx-2"
              :href="icon.href + encodeURI(loc)"
            >
            <v-icon :color="icon.color" size="250%">{{ icon.icon }}</v-icon>
            </v-btn>
          </v-card-text>
        </v-card>

        <p v-html="article.description"></p>
      </v-col>
      <v-col cols="12" md="2"></v-col>
    </v-row>

    <v-dialog v-model="dialog" hide-overlay persistent width="300">
      <v-card color="primary" dark>
        <v-card-text>
          Veuillez patienter...
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      article: {},
      errors: {},
      dialog: false,
      socialMedia: [
        {
          icon: "mdi-facebook",
          network: "facebook",
          href: 'https://www.facebook.com/share.php?u=',
          color: '#3b5998' 
        },
        {
          icon: "mdi-twitter",
          network: "Twitter",
          href: 'https://twitter.com/intent/tweet?url=',
          color: '#00acee'
        },
        {
          icon: "mdi-linkedin",
          network: "linkedIn",
          href: 'https://www.linkedin.com/shareArticle/?url',
          color: '#0e76a8'
        },
      ],
      loc : location.href
    };
  },
  methods: {
    getArticle: async function () {
      this.dialog = true;
      try {
        let response = await axios.get(
          "/article/" + this.$route.params.slug + "/show"
        );
        if (response.status == 200) {
          this.article = response.data;
          this.dialog = false;
        }
      } catch (error) {
        console.log(error);
        this.dialog = false;
      }
    },
  },
  mounted() {
    this.getArticle();
  }
};
</script>