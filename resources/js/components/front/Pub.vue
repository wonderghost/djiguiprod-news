<template>
<div>
    <template v-for="(banner, index) in zone.slice(0, 1)">
        <v-card :key="index" flat>
            <v-img class="white--text align-end" height="100" :src="'/uploads/' + banner.image">
                <template v-slot:placeholder>
                    <v-row class="fill-height ma-0" align="center" justify="center">
                        <v-progress-circular indeterminate color="blue darken-5"></v-progress-circular>
                    </v-row>
                </template>
            </v-img>
        </v-card>
    </template>
</div>
</template>

<script>
export default {
    props: ["zone"],
};
</script>
