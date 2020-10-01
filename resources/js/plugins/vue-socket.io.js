import Vue from "vue"
import VueSocketIO from "vue-socket.io"


export default new VueSocketIO({
    debug: true,
    connection: 'ws://192.168.1.12:3000',
})
