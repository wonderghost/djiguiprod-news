<template>
    <v-app>
        <SideBar/>
        <AppBar/>
        
        <v-container>
            <router-view></router-view>
        </v-container>
    </v-app>
</template>
<script>
    import SideBar from './SideBar.vue';
    import AppBar from './AppBar.vue';
    export default {
        components: {
            SideBar,
            AppBar
        },
        mounted() {}
    }
</script>
