<template>
    <v-app>
        <AppBar/>

        <v-container>
            <router-view></router-view>
        </v-container>

        <Footer/>
    </v-app>
</template>
<script>
    import AppBar from './front/AppBar.vue';
    import Footer from './front/Footer.vue';
    import Home from './front/Home.vue';
    export default {
        components: {
            AppBar,
            Footer,
            Home
        },
        mounted() {}
    }
</script>
