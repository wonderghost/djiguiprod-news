<template>
<v-app>
    <AppBar />
    <v-main class="d-flex justify-center align-center">
        <v-container>
            <Pub :zone="zone1" />
            <v-row>
                <v-col cols="12" md="9" class="mt-3">
                    <v-carousel cycle hide-delimiter-background show-arrows-on-hover>
                        <v-carousel-item v-for="(article, index) in articles.slice(0, 5)" :key="index">
                            <v-hover v-slot="{ hover }" open-delay="200">
                                <v-card class="mx-auto" max-width="900" max-height="900" :elevation="hover ? 16 : 2" :class="{ 'on-hover': hover }" href="/categorie">
                                    <v-img class="white--text align-end" height="450px" :lazy-src="'/uploads/' + article.image" :src="'/uploads/' + article.image">
                                        <template v-slot:placeholder>
                                            <v-row class="fill-height ma-0" align="center" justify="center">
                                                <v-progress-circular indeterminate color="blue darken-5"></v-progress-circular>
                                            </v-row>
                                        </template>
                                        <v-card-title>
                                            <v-card flat id="cardColor">
                                                <v-card-title class="white--text">{{ article.name }}</v-card-title>
                                            </v-card>
                                        </v-card-title>
                                    </v-img>
                                </v-card>
                            </v-hover>
                        </v-carousel-item>
                    </v-carousel>

                </v-col>

                <v-col cols="12" md="3" class="mt-3">
                    <template v-for="(banner, index) in zone2.slice(0, 1)" flat>
                        <v-card class="mx-auto mb-4" max-width="600" :key="index">
                            <v-img class="white--text align-end" :src="'/uploads/' + banner.image" contain>
                                <template v-slot:placeholder>
                                    <v-row class="fill-height ma-0" align="center" justify="center">
                                        <v-progress-circular indeterminate color="blue darken-5"></v-progress-circular>
                                    </v-row>
                                </template>
                            </v-img>
                        </v-card>
                    </template>
                    <template v-for="(banner, index) in zone3.slice(1, 2)" flat>
                        <v-card class="mx-auto mb-4" max-width="600" :key="index">
                            <v-img contain class="white--text align-end" :src="'/uploads/' + banner.image" max-height="215">
                                <template v-slot:placeholder>
                                    <v-row class="fill-height ma-0" align="center" justify="center">
                                        <v-progress-circular indeterminate color="blue darken-5"></v-progress-circular>
                                    </v-row>
                                </template>
                            </v-img>
                        </v-card>
                    </template>
                </v-col>
            </v-row>

            <div class="mt-1">
                <v-row>
                    <template v-for="(article, index) in articles.slice(1, 4)">
                        <v-col cols="12" md="4" :key="index">
                            <v-hover v-slot="{ hover }" open-delay="200">
                                <v-card class="mx-auto" max-width="400" :elevation="hover ? 16 : 2" :class="{ 'on-hover': hover }" @click="openDetail(article)">
                                    <v-img class="white--text align-end" height="200px" :src="'/uploads/' + article.image">
                                        <template v-slot:placeholder>
                                            <v-row class="fill-height ma-0" align="center" justify="center">
                                                <v-progress-circular indeterminate color="blue darken-5"></v-progress-circular>
                                            </v-row>
                                        </template>
                                        <v-card-title>
                                            <v-card flat id="cardColor">
                                                <v-card-title class="white--text">{{ article.name }}</v-card-title>
                                            </v-card>
                                        </v-card-title>
                                    </v-img>

                                    <v-card-text class="text--primary" v-if="article.resume === null">
                                        <div v-text="article.name.substr(0, 100) + '...'"></div>
                                    </v-card-text>

                                    <v-card-text class="text--primary" v-if="article.resume != null">
                                        <div v-text="article.resume.substr(0, 100) + '...'"></div>
                                    </v-card-text>
                                </v-card>
                            </v-hover>
                        </v-col>
                    </template>
                </v-row>
            </div>

            <h1 class="mt-2">
                <router-link to="/categorie/sports" class="black--text text-decoration-none">Sports</router-link>
            </h1>
            <v-divider></v-divider>

            <Pub :zone="zone4" />

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
                <router-link to="/categorie/cultures" class="black--text text-decoration-none">Cultures</router-link>
            </h1>
            <v-divider></v-divider>

            <Pub :zone="zone5" />

            <div class="my-4">
                <v-row>
                    <template v-for="(culture, index) in cultures.slice(0, 6)">
                        <v-col cols="12" md="4" :key="index">
                            <ArticleCard :article="culture" />
                        </v-col>
                    </template>
                </v-row>
            </div>

            <v-dialog v-model="dialog" hide-overlay persistent width="300">
                <v-card color="primary" dark>
                    <v-card-text>
                        Veuillez patienter...
                        <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-container>
        <v-btn v-if="showScroll" @click="$vuetify.goTo(0)" class="d-none d-lg-block" color="primary" dark fixed z-index="1" small bottom right style="bottom: 10%" fab>
            <v-icon>mdi-arrow-up-bold-circle</v-icon>
        </v-btn>
    </v-main>

    

    <Footer />
</v-app>
</template>

<script>
import AppBar from './AppBar.vue';
import Footer from './Footer.vue';
import ArticleCard from "./ArticleCard.vue";
import Pub from "./Pub.vue";
export default {
    components: {
        ArticleCard,
        Footer,
        Pub,
        AppBar
    },

    metaInfo: {
        title: "Djiguiprod"
    },
    data() {
        return {
            articles: [],
            dialog: true
        };
    },

    mounted() {
        this.getArticles();
        this.$store.dispatch("getBanners");
    },

    methods: {
        getArticles: async function () {
            try {
                let response = await axios.get("/request/article");
                if (response.status == 200) {
                    this.dialog = false;
                    this.articles = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },

        openDetail(a) {
            this.$router.push("/" + a.id_sub_category + "/" + a.slug);
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

        zone1() {
            return this.banners.filter((a) => {
                return a.name == "1";
            });
        },

        zone2() {
            return this.banners.filter((a) => {
                return a.name == "2";
            });
        },

        zone3() {
            return this.banners.filter((a) => {
                return a.name == "3";
            });
        },

        zone4() {
            return this.banners.filter((a) => {
                return a.name == "4";
            });
        },

        zone5() {
            return this.banners.filter((a) => {
                return a.name == "5";
            });
        },
    },
};
</script>

<style scoped>
#cardColor {
    background-color: rgba(0, 0, 0, 0.5) !important;
    border-color: white !important;
}
</style>
