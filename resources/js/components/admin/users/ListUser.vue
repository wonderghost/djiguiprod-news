<template>
  <div class="mb-10">
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-center"># N°</th>
            <th class="text-center">Nom</th>
            <th class="text-center">Email</th>
            <th class="text-center">Status</th>
            <th class="text-center">Role</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users" :key="index">
            <td class="text-center">{{ index + 1 }}</td>
            <td class="text-center">{{ user.name }}</td>
            <td class="text-center">{{ user.email }}</td>
            <td class="text-center">{{ user.state }}</td>
            <td class="text-center">{{ user.role }}</td>
            <td class="text-center">
              <p>
                <v-icon color="success" class="mx-3"
                  >mdi-circle-edit-outline</v-icon
                >
                <v-icon color="error"
                  >mdi-delete</v-icon
                >
              </p>
            </td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
  </div>
</template>

<script>
export default {
  props: ["users"],

  data() {
    return {
      //
    };
  },
  methods: {
    //
  },

  computed: {
    //    
  }
};
</script>