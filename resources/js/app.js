import Vue from 'vue'
import Vuetify from "vuetify";
import store from '~/store'
import router from '~/router'
import App from '~/components/App'
import vuetify from "./plugins/vuetify";
import VueSocketIO from "./plugins/vue-socket.io";


import '~/plugins'
import '~/components'

Vue.use(Vuetify)
Vue.use(VueSocketIO)

/* eslint-disable no-new */
new Vue({
    store,
    router,
    ...App,
    vuetify: vuetify,
    VueSocketIO,

})
