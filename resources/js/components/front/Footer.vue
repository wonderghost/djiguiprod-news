<template>
  <div>
    <v-footer dark padless default>
      <v-card flat tile class="white--text text-center" color="grey darken-3">
        <v-row>
          <v-col cols="12" md="6">
            <v-card-text class="white--text pt-4 text-justify">
              Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illum, et, minus, atque dolores earum ratione laboriosam dicta incidunt dolorem quam neque ex placeat consequatur eum veniam doloribus perferendis itaque optio.
            </v-card-text>
          </v-col>
          <v-col cols="12" md="6">
            <v-card-text class="text-left">
              Pour ne pas manquer à notre actualité, inscrivez-vous à la Newsletter
              <v-row>
                <v-col cols="12" md="8">
                  <v-text-field color="withe darken-2" label="Adresse mail" required ></v-text-field>
                </v-col>
                  <v-col cols="12" md="4">
                    <v-btn class="my-2" color="primary">S'abonner</v-btn>
                  </v-col>
              </v-row>

              <v-btn
                v-for="(icon, index) in icons"
                :key="index"
                class="mx-4 white--text"
                icon
                
              >
                <v-icon size="250%" :color="icon.color">
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
          color: '#00acee'
        },
        {
          icon: "mdi-twitter",
          color: '#3b5998'
        },
        {
          icon: "mdi-linkedin",
          color: '#0e76a8'
        },
    ],
  }),
};
</script>