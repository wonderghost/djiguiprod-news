<template>
    <v-navigation-drawer v-model="drawer" permanent color="#F4F5F9" app>
        <v-list-item class="px-2 py-5">
            <v-list-item-title class="text-capitalize" align="center">
                <v-icon x-large>mdi-view-dashboard</v-icon> DJIGUIPROD
            </v-list-item-title>
        </v-list-item>
        <v-list nav dense>
            <v-list-item-group v-model="selectedItem" color="deep-purple">
                <v-list-item v-for="(item, i) in items" :key="i" :to="item.route">
                    <v-list-item-icon >
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
                    <v-badge borderd bottom color="green" dot offset-x="10" offset-y="10" class="mb-8">
                        <v-avatar size="40">
                            <v-img src="https://cdn.vuetifyjs.com/images/lists/2.jpg"></v-img>
                        </v-avatar>
                    </v-badge>
                    <h4 class="grey--text">Administrateur</h4>
                    <p></p>
                    <v-btn color="deep-purple white--text">
                        <!-- <v-icon left>logout</v-icon> -->
                        Déconnexion
                    </v-btn>
                </v-card>        
            </div>
        </template>
    </v-navigation-drawer> 
</template>

<script>
export default {
    data: () => ({
        selectedItem: 0,
        drawer: null,
        items: [
            {icon: 'mdi-view-dashboard', text: 'Dashboard', route: '/dashboard'},
            {icon: 'mdi-file', text: 'Articles', route: '/article'},
            {icon: 'mdi-shop', text: 'Catégories', route: 'category'},
            {icon: 'subtitles', text: 'Sous Catégories', route: '/sub-category'},
            {icon: 'people', text: 'Redacteurs', route: '/article'},
        ]
    }),
    methods: {
        
    }
}
</script>

<style scoped>
div  >>> .v-list a {
    text-decoration: none;

}
</style>