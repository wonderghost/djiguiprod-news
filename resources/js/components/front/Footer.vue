<template>
  <div>
    <v-footer dark padless default>
      <v-card flat tile class="white--text text-center" color="grey darken-3">
        <v-row>
          <v-col cols="12" md="4">
            <v-card-text class="text-left pt-4 ml-10">
              Depuis Mars 2018, Djigui Production accompagne des acteurs
              culturels dans les domaines Culturel, Artistique et
              l'événementiel. Si votre objectif est de vous produire sur scène
              ou d’organiser des événements, sachez que nous apportons des
              solutions pour développer votre modèle économique, votre talent
              artistique et rendre efficient votre personne afin de vous
              réaliser pleinement.
            </v-card-text>
          </v-col>
          <v-col cols="12" md="4">
            <v-card-text class="text-left">
              Pour ne pas manquer à notre actualité, inscrivez-vous à la
              Newsletter
              <v-row>
                <v-col cols="12" md="8">
                  <v-text-field
                    color="withe darken-2"
                    label="Adresse mail"
                    required>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-btn class="my-2" color="primary">S'abonner</v-btn>
                </v-col>
              </v-row>
            </v-card-text>
          </v-col>

          <v-col cols="12" md="4">
            <v-card-text class="text-left">
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

              <v-btn
                v-for="(icon, index) in icons"
                :key="index"
                class="ma-1"
                fab
                color="white"
                small
              >
                <v-icon :color="icon.color">
                  {{ icon.icon }}
                </v-icon>
              </v-btn>
            </v-card-text>
          </v-col>
        </v-row>

        <v-divider></v-divider>

        <v-card-text class="white--text">
          {{ new Date().getFullYear() }} — <strong>Djiguiprod NEWS</strong>
        </v-card-text>
      </v-card>
    </v-footer>
  </div>
</template>

<script>
export default {
  data: () => ({
    icons: [
      {
        icon: "mdi-facebook",
        color: "#3b5998",
      },
      {
        icon: "mdi-twitter",
        color: "#00acee",
      },
      {
        icon: "mdi-linkedin",
        color: "#0e76a8",
      },
    ],
  }),
};
</script>