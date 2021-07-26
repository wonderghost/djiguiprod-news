<template>
    <div class="home">
        <v-app-bar flat app>

            <v-toolbar-title>
                <span class="caption">Aperçu du Dashboard</span> 
                <br> DJIGUIPROD NEWS
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-avatar size="40">
                <v-img src="https://cdn.vuetifyjs.com/images/lists/2.jpg"></v-img>
            </v-avatar>
        </v-app-bar>    
    </div>
</template>

<script>
export default {
    name: "home",
    data: () => ({
        
    })
}
</script>

<style scoped lang="sass">
// 
</style>

<style scoped>
.border {
    border-right: 1px solid grey;
}
</style>