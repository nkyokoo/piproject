const app = require('express')();
const http = require('http').createServer(app);
const io = require('socket.io')(http);

io.on('connection', (socket) => {
    console.log('a user connected');
    socket.on('NEW_DATA', (msg) => {
        console.log("received data")
        socket.emit("NEW_DATA_RECEIVED");
    });

})

http.listen(3000, "0.0.0.0", () => {
    console.log(http.address());
});
