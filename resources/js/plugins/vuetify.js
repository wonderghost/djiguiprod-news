// src/plugins/vuetify.js

import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@fortawesome/fontawesome-free/css/all.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import '@mdi/font/css/materialdesignicons.css'

Vue.use(Vuetify)

const opts = {
    icons: {
        // iconfont: `md` || `fa`
        iconfont: `mdi`
    }
}

export default new Vuetify(opts)