<template>
  <div>
    <div>
      <v-breadcrumbs :items="items" class="pl-0"></v-breadcrumbs>
    </div>
    <h2 class="mb-4">Culture</h2>

    <div class="mb-4">
      <v-row>
        <v-col cols="12" md="8">
          <v-hover v-slot="{ hover }" open-delay="200">
            <v-card
              class="mx-auto mb-4"
              max-width="900"
              max-height="900"
              :elevation="hover ? 16 : 2"
              :class="{ 'on-hover': hover }"
            >
              <v-img
                class="white--text align-end"
                height="450px"
                src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
              >
                <v-card-title>Top 10 Australian beaches</v-card-title>
              </v-img>
            </v-card>
          </v-hover>
          <v-row>
            <v-col cols="12" md="6">
              <v-hover v-slot="{ hover }" open-delay="200">
                <v-card
                  class="mx-auto"
                  max-width="400"
                  :elevation="hover ? 16 : 2"
                  :class="{ 'on-hover': hover }"
                >
                  <v-img
                    class="white--text align-end"
                    height="200px"
                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                  >
                    <v-card-title>Top 10 Australian beaches</v-card-title>
                  </v-img>

                  <v-card-text class="text--primary">
                    <div>Whitehaven Beach</div>

                    <div>Whitsunday Island, Whitsunday Islands</div>
                  </v-card-text>
                </v-card>
              </v-hover>
            </v-col>

            <v-col cols="12" md="6">
              <v-hover v-slot="{ hover }" open-delay="200">
                <v-card
                  class="mx-auto"
                  max-width="400"
                  :elevation="hover ? 16 : 2"
                  :class="{ 'on-hover': hover }"
                >
                  <v-img
                    class="white--text align-end"
                    height="200px"
                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                  >
                    <v-card-title>Top 10 Australian beaches</v-card-title>
                  </v-img>

                  <v-card-text class="text--primary">
                    <div>Whitehaven Beach</div>

                    <div>Whitsunday Island, Whitsunday Islands</div>
                  </v-card-text>
                </v-card>
              </v-hover>
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12" md="4">
          <v-hover v-slot="{ hover }" open-delay="200">
            <v-card
              class="mx-auto"
              max-width="400"
              max-height="900"
              :elevation="hover ? 16 : 2"
              :class="{ 'on-hover': hover }"
              color="grey"
            >
              Publicités
            </v-card>
          </v-hover>
        </v-col>
      </v-row>
    </div>

    <div class="my-10">
      <h2 class="text-center display-2">Dernières publiées</h2>
      <v-divider></v-divider>
      <div class="mt-8"></div>
      <v-row>
        <v-col cols="12" md="6">
          <v-hover v-slot="{ hover }" open-delay="200">
            <v-card
              flat
              :elevation="hover ? 16 : 2"
              :class="{ 'on-hover': hover }"
            >
              <v-row>
                <v-col cols="12" md="6">
                  <v-img
                    class="white--text align-end"
                    height="200px"
                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                  >
                  </v-img>
                </v-col>
                <v-col cols="12" md="6"> Top 10 Australian beaches </v-col>
              </v-row>
            </v-card>
          </v-hover>
        </v-col>
        <v-col cols="12" md="6">
          <v-hover v-slot="{ hover }" open-delay="200">
            <v-card
              flat
              :elevation="hover ? 16 : 2"
              :class="{ 'on-hover': hover }"
            >
              <v-row>
                <v-col cols="12" md="6">
                  <v-img
                    class="white--text align-end"
                    height="200px"
                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                  >
                  </v-img>
                </v-col>
                <v-col cols="12" md="6"> Top 10 Australian beaches </v-col>
              </v-row>
            </v-card>
          </v-hover>
        </v-col>
        <v-col cols="12" md="6">
          <v-hover v-slot="{ hover }" open-delay="200">
            <v-card
              flat
              :elevation="hover ? 16 : 2"
              :class="{ 'on-hover': hover }"
            >
              <v-row>
                <v-col cols="12" md="6">
                  <v-img
                    class="white--text align-end"
                    height="200px"
                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                  >
                  </v-img>
                </v-col>
                <v-col cols="12" md="6"> Top 10 Australian beaches </v-col>
              </v-row>
            </v-card>
          </v-hover>
        </v-col>
        <v-col cols="12" md="6">
          <v-hover v-slot="{ hover }" open-delay="200">
            <v-card
              flat
              :elevation="hover ? 16 : 2"
              :class="{ 'on-hover': hover }"
            >
              <v-row>
                <v-col cols="12" md="6">
                  <v-img
                    class="white--text align-end"
                    height="200px"
                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                  >
                  </v-img>
                </v-col>
                <v-col cols="12" md="6"> Top 10 Australian beaches </v-col>
              </v-row>
            </v-card>
          </v-hover>
        </v-col>
      </v-row>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    items: [
      {
        text: "Accueil",
        disabled: false,
        href: "/",
      },
      {
        text: "Culture",
        disabled: true,
        href: "/culture",
      },
    ],
  }),
};
</script>