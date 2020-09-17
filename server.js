const net = require("net")
const Influx = require('influx');
const influx = new Influx.InfluxDB({
    host: 'localhost',
    database: 'piproject',
    schema: [
        {
            measurement: 'temperature',
            fields: {
                value: Influx.FieldType.FLOAT,
            },
            tags: [
                'mbed_controller_id'
            ]
        }
    ]
})

const server = net.createServer((socket) => {
    socket.setEncoding('utf8');
    socket.write('SERVER: Hello! This is server speaking.');
    socket.on("data", (data) => {
        console.log(data)
        let parsedData = {}
        try {
           parsedData  = JSON.parse(data)

        }catch (e){
        }
  /*      try{
            influx.writePoints([
                {
                    measurement: 'temperature',
                    tags: { mbed_controller_id:parsedData.mbed_controller_id },
                    fields: { value:parsedData.value },

                }
            ])
        }catch (e){
            console.log(e)
        }*/

    })

}).on('error', (err) => {
    console.error(err);
})

server.listen({
    host: '192.168.1.15',
    port: 2080},() => {
    console.log('opened server on', server.address());
})
