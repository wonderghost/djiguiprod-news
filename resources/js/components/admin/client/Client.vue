<template>
  <div>
    <h1>Liste des clients</h1>

    <AddClient/>

    <ListClient :clients="clients"/>
    
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
    };
  },
  methods: {
    //
  },
  mounted() {
    this.$store.dispatch('getClients');
  },
  computed: {
      clients() {
        return this.$store.state.clients;
      }
  }
};
</script>