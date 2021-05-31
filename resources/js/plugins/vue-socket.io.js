import Vue from "vue"
import VueSocketIO from "vue-socket.io"


export default new VueSocketIO({
    debug: true,
    connection: 'ws://10.130.54.90:3000',
})
