<template>
   <v-footer padless dark>
      <v-card flat tile class="white--text " color="grey darken-3">
         <v-row>
            <v-col cols="12" md="4">
               <v-card-text class="text-left ">
                  
               </v-card-text>
            </v-col>
            <v-col cols="12" md="4">
               <v-card-text class="text-left mb-3">
                  Pour ne pas manquer à notre actualité, inscrivez-vous à la
                  Newsletter
                  <v-form @submit.prevent="onNewsletter()">
                        <v-row>
                           <v-col cols="12">
                              <v-text-field outlined dense prepend-inner-icon="mdi-email" @click:append="onNewsletter()" append-icon="mdi-send" v-model="newsletter.email" color="withe darken-2" label="Adresse mail" required>
                              </v-text-field>
                           </v-col>
                              <!-- <v-btn class="my-2" color="primary" type="submit" :loading="isLoading">S'abonner</v-btn> -->
                        </v-row>
                  </v-form>
               </v-card-text>
            </v-col>

            <v-col cols="12" md="4">
               <v-card-text >
                  <v-row dense>
                        <v-col cols="12" md="12">
                           <v-icon left>mdi-google-maps</v-icon>
                           Sans Fil , Kaloum , Conakry Guinee
                        </v-col>
                        <v-col cols="12" md="12">
                           <v-icon left>mdi-phone</v-icon>
                           666 000 000
                        </v-col>
                        <v-col cols="12" md="12">
                           <v-icon left>mdi-email</v-icon>
                           contact@djiguiprod.com
                        </v-col>
                  </v-row>

                  <v-btn v-for="(icon, index) in icons" :key="index" class="ma-1" fab color="white" small @click="openLink(icon.link)">
                        <v-icon :color="icon.color">
                           {{ icon.icon }}
                        </v-icon>
                  </v-btn>
               </v-card-text>
            </v-col>
         </v-row>

         <v-dialog v-model="isLoading" hide-overlay persistent width="300">
                <v-card color="primary" dark>
                    <v-card-text>
                        Veuillez patienter...
                        <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-dialog>

         <v-divider></v-divider>

         <v-card-text class="white--text text-center">
            {{ new Date().getFullYear() }} — <strong>Djiguiprod New</strong> &copy; Powered by <span>SMARTECH</span>
         </v-card-text>
      </v-card>

      <v-row justify="center">
            <v-dialog v-model="dialog" persistent max-width="350">
                <v-card>
                    <v-card-title class="text-h5">
                        Abonnement au newsletter 
                    </v-card-title>
                    <v-card-text>{{ message }}</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="dialog = false">
                            Fermer
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
   </v-footer>
</template>

<script>
export default {
   data: () => ({
   icons: [{
            icon: "mdi-facebook",
            color: "#3b5998",
            link: "https://www.facebook.com/Newsdjiguiprodcom-101551088915221"
      },
      {
            icon: "mdi-twitter",
            color: "#00acee",
            link: ""
      },
      {
            icon: "mdi-linkedin",
            color: "#0e76a8",
            link: ""
      },
   ],
   isLoading: false,
   dialog: false,
   message: "",
   newsletter: {
      email: "",
      _token: null,
   },
   }),

   methods: {
      openLink(link) {
         window.open(link, '_blank');
         console.log(link)
      },
      onNewsletter: async function () {
         try {
               this.isLoading = true;
               this.newsletter._token = this._token;
               let response = await axios.post('/request/newsletter', this.newsletter);
               if (response.status === 200) {
                  this.isLoading = false;
                  this.dialog = true;
                  this.message = response.data.message;
                  this.newsletter.email = ""
               }
         } catch (error) {
               console.log(error);
               this.isLoading = false;
         }
      },
   },
   computed: {
      _token() {
         return this.$store.state._token;
      }
   }
};
</script>
