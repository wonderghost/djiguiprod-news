<template>
<v-app>
    <h1>Liste des utilisateurs</h1>

    <AddUser v-on:reloadlist="getUsers()" />

    <ListUser :users="users" />

</v-app>
</template>

<script>
import AddUser from "./AddUser.vue";
import ListUser from "./ListUser.vue";
export default {
    components: {
        AddUser,
        ListUser,
    },
    data() {
        return {
            search: "",
            users: [],
        };
    },
    methods: {
        getUsers: async function () {
            try {
                let response = await axios.get('/request/users');
                if (response.status == 200) {
                    this.users = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        }
    },
    mounted() {
        this.getUsers();
    },

    computed: {
        //
    }
};
</script>
