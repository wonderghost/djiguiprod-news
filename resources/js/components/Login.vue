<template>
<v-app>
   <v-main>
      <v-container class="fill-height">
         <v-dialog v-model="loader" width="300" persistent overlay-opacity="0.8">
               <v-progress-linear indeterminate color="#fff" stream buffer-value="0"></v-progress-linear>
         </v-dialog>
         <v-card class="center" width="500">
               <v-card-title>Authentification </v-card-title>
               <v-form @submit.prevent="logIn()">
                  <v-row>
                     <v-col cols="12">
                           <v-text-field v-model="form.email" label="Email" prepend-icon="mdi-mail"></v-text-field>
                     </v-col>
                     <v-col cols="12">
                           <v-text-field v-model="form.password" label="Mot de passe" prepend-icon="mdi-lock" type="password"></v-text-field>
                     </v-col>
                  </v-row>
                  <v-btn color="blue" type="submit" text block>Login</v-btn>
               </v-form>
         </v-card>
         <!-- ERRORS DIALOG -->
         <v-dialog width="400" v-model="error" persistent>
               <v-card style="padding: 4%">
                  <v-card-title>Erreur(s)</v-card-title>
                  <template v-for="(err, index) in errors">
                     <v-alert type="error" dense :key="index">{{ err }}</v-alert>
                  </template>
                  <v-card-actions>
                     <v-spacer></v-spacer>
                     <v-btn color="blue" text block @click="
               () => {
                  error = false;
               }
               ">Fermer</v-btn>
                  </v-card-actions>
               </v-card>
         </v-dialog>
      </v-container>
   </v-main>
</v-app>
</template>

<script>
export default {
   data: () => {
      return {
         form: {
               _token: "",
               email: "",
               password: "",
         },
         errors: [],
         error: false,
      };
   },
   mounted() {},
   methods: {
      logIn: async function () {
         try {
               this.form._token = this._token;
               let response = await axios.post("/login", this.form);
               if (response.status == 200) {
                  location.reload()
               }
         } catch (error) {
               this.$store.commit("loading", false);
               let theErrors = [];
               if (error.response.data.errors) {
                  let errorTab = error.response.data.errors;
                  for (var prop in errorTab) {
                     theErrors.push(errorTab[prop][0]);
                  }
               } else {
                  theErrors.push(error.response.data);
               }

               this.errors = theErrors;
               this.error = true;
         }
      },
   },
   computed: {
      _token() {
         return this.$store.state._token;
      },
      loader() {
         return this.$store.state.loader;
      },
   },
};
</script>
