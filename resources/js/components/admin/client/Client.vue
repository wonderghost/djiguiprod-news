<template>
  <div>
    <h1>Liste des clients</h1>

    <AddClient v-on:reloadlist="getClients()" />

    <ListClient :clients="clients" v-on:reloadlist="getClients()"/>
    
  </div>
</template>

<script>
import AddClient from "./AddClient.vue";
import ListClient from "./ListClient.vue";
export default {
  components: {
    AddClient,
    ListClient,
  },
  data() {
    return {
      search: "",
      clients: []
    };
  },
  methods: {
    getClients: async function() {
        try
        {
            let response = await axios.get('/client');
            if(response.status == 200) {
                this.clients = response.data;
                console.log(this.clients);
            }
        } 
        catch(error) {
            console.log(error);
        }
    }
  },
  mounted() {
    this.getClients();
  },
  computed: {
      //
  }
};
</script>