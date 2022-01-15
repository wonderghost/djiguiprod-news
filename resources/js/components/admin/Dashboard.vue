<template>
<v-app>
    <AppBar />

    <v-main>
        <v-tabs v-model="tabs" centered>
            <v-tab :href="'#' + item.value" v-for="(item,i) in items" :key="i">
                {{ item.text }}
            </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tabs">
           <v-container>
              <v-tab-item value="article">
                <Article />
            </v-tab-item>
            <v-tab-item value="category">
                <Category />
            </v-tab-item>
            <v-tab-item value="subCategory">
                <SubCategory />
            </v-tab-item>
            <v-tab-item value="redacteur">
                <Users />
            </v-tab-item>
            <v-tab-item value="clients">
                <Client />
            </v-tab-item>
            <v-tab-item value="banniere">
                <Banner />
            </v-tab-item>
           </v-container>
        </v-tabs-items>
    </v-main>
</v-app>
</template>

<script>
import AppBar from '../front/AppBar.vue';
import Article from '../admin/article/Article.vue';
import Banner from '../admin/banner/Banner.vue';
import Category from '../admin/category/Category.vue';
import Client from '../admin/client/Client.vue';
import SubCategory from '../admin/subCategory/SubCategory.vue';
import Users from '../admin/users/User.vue';
export default {
    components: {
        AppBar,
        Article,
        Banner,
        Category,
        Client,
        SubCategory,
        Users
    },
    data() {
        return {
            selectedItem: 0,
            tabs: null,
            drawer: null,
            items: [
                {
                    icon: "mdi-file",
                    text: "Articles",
                    value: "article",
                },
                {
                    icon: "mdi-briefcase-variant",
                    text: "Catégories",
                    value: "category",
                },
                {
                    icon: "mdi-subtitles",
                    text: "Sous Catégories",
                    value: "subCategory",
                },
                {
                    icon: "mdi-account-supervisor-circle",
                    text: "Redacteurs",
                    value: "redacteur",
                },
                {
                    icon: "mdi-account-supervisor",
                    text: "Clients",
                    value: "clients",
                },
                {
                    icon: "mdi-publish",
                    text: "Banniere pub",
                    value: "banniere",
                },
            ],
        };
    },
    mounted() {},
};
</script>
