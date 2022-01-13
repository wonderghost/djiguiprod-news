<template>
<div>
    <v-navigation-drawer height="100%" disable-resize-watcher v-model="drawer" color="#F4F5F9" app>
        <v-list-item to="/" style="background-color: #424242" class="py-1">
            <v-img max-height="100" max-width="150" src="/images/logo-djigui.png">
            </v-img>
        </v-list-item>

        <v-list-item class="d-flex d-md-none" v-for="item in categories" :key="item.title" :to="'/categorie/' + item.slug">
            <v-list-item-content>
                <v-list-item-title>{{ item.name }}</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list nav dense v-if="user">
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
        <template v-slot:append v-if="user">
            <div class="pa-2">
                <v-card align="center" class="pa-3">
                    <v-badge borderd bottom color="green" dot offset-x="10" offset-y="10" class="mb-8">
                        <v-avatar size="40">
                            <v-icon>mdi-account</v-icon>
                        </v-avatar>
                    </v-badge>
                    <h4 class="grey--text">{{ user.name }}</h4>
                    <p>{{ user.email }}</p>
                    <v-btn color="primary white--text" @click="logout">
                        Déconnexion
                    </v-btn>
                </v-card>
            </div>
        </template>
    </v-navigation-drawer>

    <v-app-bar flat app color="grey darken-3">
        <v-app-bar-nav-icon class="d-flex d-md-none" color="white" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title>
                <v-img href="/" max-height="80" max-width="150" src="/images/logo-djigui.png">
                </v-img>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <div class="d-none d-md-flex">
            <v-btn icon href="/">
                <v-icon  color="white" size="30">mdi-home</v-icon>
            </v-btn>
            <v-btn v-for="(category, index) in categories" :key="index" text style="text-transform: none" class="white--text mt-2" :href="'/categorie/' + category.slug" >
                {{ category.name }}
            </v-btn>
            <v-btn icon>
                <v-icon color="white" size="35" @click="openSearch">mdi-card-search</v-icon>
            </v-btn>
        </div>
    </v-app-bar>

    <v-parallax class="mt-16" dark height="80" v-if="isSearching">
        <v-container fluid>
            <v-layout justify-center row wrap>
                <v-flex xs12 class="center mt-10">
                    <v-layout justify-center row wrap>
                        <v-flex xs6>
                            <v-form>
                                <v-text-field outlined v-model="search" label="Rechercher..." append-icon="mdi-card-search" autofocus></v-text-field>
                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-container>
    </v-parallax>

    <v-container fluid v-if="search != ''">
        <v-layout justify-center row wrap>
            <v-flex xs12 class="center">
                <v-layout justify-center row wrap>
                    <v-flex xs6>
                        <v-list three-line>
                            <template v-for="(item, index) in searchResponse">
                                <v-list-item :key="index" id="search" :href="'/articles/' + item.slug">
                                    <v-list-item-avatar>
                                        <v-img :src="'/uploads/' + item.image"></v-img>
                                    </v-list-item-avatar>

                                    <v-list-item-content color="white">
                                        <v-list-item-title v-html="item.name"></v-list-item-title>
                                        <v-list-item-subtitle v-html="item.description.substr(0, 100) + '...'"></v-list-item-subtitle>
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

    <v-btn v-if="user" style="position: fixed; right: 1%; bottom: 1%; z-index: 1" fab dark small color="primary" class="d-none d-lg-block" @click.stop="drawer = !drawer">
        <v-icon dark> {{ menuIcon }} </v-icon>
    </v-btn>

</div>
</template>

<script>
export default {
    data() {
        return {
            showScroll: false,
            dialog: false,
            message: "",
            isLoading: false,
            drawer: false,
            group: null,
            isSearching: false,
            selectedItem: 0,
            searchResponse: [],
            search: "",
            newsletter: {
                email: "",
                _token: null,
            },
            items: [{
                    icon: "mdi-view-dashboard",
                    text: "Dashboard",
                    route: "/admin/dashboard/list"
                },
                {
                    icon: "mdi-file",
                    text: "Articles",
                    route: "/admin/articles/list"
                },
                {
                    icon: "mdi-briefcase-variant",
                    text: "Catégories",
                    route: "/admin/category/list",
                },
                {
                    icon: "mdi-subtitles",
                    text: "Sous Catégories",
                    route: "/admin/sous-categorie/list",
                },
                {
                    icon: "mdi-account-supervisor-circle",
                    text: "Redacteurs",
                    route: "/admin/users/list",
                },
                {
                    icon: "mdi-account-supervisor",
                    text: "Clients",
                    route: "/admin/clients/list",
                },
                {
                    icon: "mdi-publish",
                    text: "Banniere pub",
                    route: "/admin/banner/list",
                },
            ],
            icons: [{
                    icon: "mdi-facebook",
                    color: "#3b5998",
                    link: "https://www.facebook.com/Newsdjiguiprodcom-101551088915221"
                },
                {
                    icon: "mdi-twitter",
                    color: "#00acee",
                    link: ""
                },
                {
                    icon: "mdi-linkedin",
                    color: "#0e76a8",
                    link: ""
                },
            ],
        }
    },

    watch: {
        search: 'onSearch'
    },

    mounted() {
        this.$store.dispatch("actifUser");
        this.$store.dispatch("getCategories");
        this.$store.dispatch("getArticles");
        this.$store.dispatch("actifUser");
        var scroll = this
        window.addEventListener('scroll', function (event) {
            if (window.scrollY > 100) {
                scroll.showScroll = true
            } else {
                scroll.showScroll = false
            }
        })
    },

    computed: {
        menuIcon() {
            let data = this.drawer ? "mdi-close" : "mdi-menu";
            return data;
        },
        user() {
            return this.$store.state.user;
        },
        categories() {
            return this.$store.state.categories;
        },
        articles() {
            return this.$store.state.articles;
        },
        _token() {
            return this.$store.state._token;
        }
    },
    methods: {
        openSearch() {
            return (this.isSearching = !this.isSearching);
        },

        onSearch: async function () {
            try {
                let response = await axios.get('/request/search?text=' + this.search);
                if (response.status == 200) {

                    this.searchResponse = response.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        onNewsletter: async function () {
            try {
                this.isLoading = true;
                this.newsletter._token = this._token;
                let response = await axios.post('/request/newsletter', this.newsletter);
                if(response.status === 200) {
                    this.isLoading = false;
                    this.dialog = true;
                    this.message = response.data.message;
                    this.newsletter.email = ""
                }
            } catch (error) {
                console.log(error);
                this.isLoading = false;
            }
        },

        toTop() {
            let onTop = window;
            onTop.scrollTo(0, 0);
        },

        logout: async function () {
            try {
                let response = await axios.post("request/logout");

                if (response.status == 200) {
                    location.reload();
                }
            } catch (error) {
                console.log(error);
            }
        },
        openLink(link) {
            window.open(link, '_blank');
            console.log(link)
        }
    },
};
</script>
