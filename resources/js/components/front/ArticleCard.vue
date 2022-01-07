<template>
<div>
    <v-hover v-slot="{ hover }" open-delay="200">
        <v-card class="mx-auto mb-4" max-width="600" :elevation="hover ? 16 : 2" :class="{ 'on-hover': hover }" @click="openDetail(article)">
            <v-img class="white--text align-end" :lazy-src="'/uploads/' + article.image" height="215" :src="'/uploads/' + article.image">
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
</div>
</template>

<script>
export default {
    props: ['article'],

    methods: {
        openDetail(a) {
            this.$router.push('/' + a.id_sub_category + '/' + a.slug);
        }
    }
}
</script>

<style scoped>
#cardColor {
    background-color: rgba(0, 0, 0, 0.5) !important;
    border-color: white !important;
}
</style>
