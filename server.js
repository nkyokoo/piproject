const net = require("net")
const Influx = require('influx');
const io = require('socket.io-client')

const ws = io("ws://localhost:3000")// connect to websocket

// connect to influxdb with options and create schema
const influx = new Influx.InfluxDB({
    host: 'localhost',
    database: 'piproject',
    schema: [
        {
            measurement: 'temperature',
            fields: {
                value: Influx.FieldType.INTEGER,
            },
            tags: [
                'mbed_controller_id',
                'room',
                'building'
            ]
        },
        {
            measurement: 'light',
            fields: {
                value: Influx.FieldType.FLOAT,
            },
            tags: [
                'mbed_controller_id',
                'room',
                'building'
            ]
        },
        {
            measurement: 'sound',
            fields: {
                value: Influx.FieldType.INTEGER,
            },
            tags: [
                'mbed_controller_id',
                'room',
                'building'
            ]
        }
    ]
})

const server = net.createServer((socket) => {
    socket.setEncoding('utf8'); // set encoding to be utf8 so the server can read data properly
    socket.write('SERVER: Hello! This is server speaking.');
    socket.on("data", (data) => { // listen to data
        console.log(data)
        let parsedData = {}
        try {
           parsedData  = JSON.parse(data)

        }catch (e){
            console.log(e)
        }
     try{
            //write data to measurement based on type
            switch (parsedData.type){
                case 'temp':
                    influx.writePoints([
                        {
                            measurement: 'temperature',
                            tags: { mbed_controller_id:parsedData.mbed_controller_id,room:parsedData.room, building:parsedData.building},
                            fields: { value:parsedData.value },

                        }
                    ])
                    break;
                case 'light':
                    influx.writePoints([
                        {
                            measurement: 'light',
                            tags: { mbed_controller_id:parsedData.mbed_controller_id,room:parsedData.room, building:parsedData.building},
                            fields: { value:parsedData.value },

                        }
                    ])
                    break;
                case 'sound':
                    influx.writePoints([
                        {
                            measurement: 'sound',
                            tags: { mbed_controller_id:parsedData.mbed_controller_id,room:parsedData.room, building:parsedData.building},
                            fields: { value:parsedData.value },

                        }
                    ])
                    break;
            }

         ws.on("connection", (socket) => {
             socket.emit('NEW_DATA', {'newdata':"newdata"});
             console.log("connected client")
         })

        }catch (e){
            console.log(e)
        }

    })

}).on('error', (err) => {
    console.error(err);
})

server.listen({ port: 2080 },() => {
    console.log('opened server on', server.address());
}) // open server on 2080
