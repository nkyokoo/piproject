const net = require("net")
const Influx = require('influx');
const influx = new Influx.InfluxDB({
    host: 'localhost',
    database: 'piproject',
    schema: [
        {
            measurement: 'temperature',
            fields: {
                value: Influx.FieldType.STRING,
            },
            tags: [
                'mbed_controller_id'
            ]
        }
    ]
})

const server = net.createServer((socket) => {
    socket.setEncoding('utf8');
    socket.write('SERVER: Hello! This is server speaking.<br>');
    socket.pipe(socket);
    socket.on("data", (data) => {
         const parsedData = JSON.parse(data)
        influx.writePoints([
            {
                measurement: 'temperature',
                tags: { mbed_controller_id:parsedData.mbed_controller_id },
                fields: { value:parsedData.value },

            }
        ])
    })

}).on('error', (err) => {
    console.error(err);
})

server.listen({
    host: '10.130.54.33',
    port: 2080},() => {
    console.log('opened server on', server.address());
})
