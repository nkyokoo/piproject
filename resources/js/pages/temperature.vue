<template>
    <div>
        <v-row>
            <v-col sm>

            </v-col>
            <v-col md>
                <v-card v-if="this.formattedData.values.length !== 0" style="width: 80vw; height: 60vh">
                    <v-card-title>
                        {{"building: " + this.temperatureData[0].building
                    + " room: "+this.temperatureData[0].room}}</v-card-title>
                    <Chart class="MonitoringChart" v-if="loaded" :chart-data="ChartData" :options="options" :loaded="this.loaded"></Chart>
                </v-card>
            </v-col>
            <v-col sm>

            </v-col>
        </v-row>
    </div>
</template>
<script>
import axios from "axios"
import Chart from "../components/chart"
import chart from "../components/chart";

export default {
    components:{
        "Chart":Chart,
    },
    data() {
        return {
            loaded:false,
            temperatureData: [],
            formattedData: {
                tempTime: [],
                values: [],

            },
            dataset: {
                labels: null,
                datasets: [ {
                    label: 'Temperature',
                    data: null,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderWidth: 1
                }]

            },
            options: {
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                precision: 0,
                            }
                        }],
                    xAxes: [
                        {
                            ticks: {
                                autoSkip: true,
                                maxTicksLimit: 20
                            }
                        }
                    ]
                },
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    methods: {
        async InitialiseChart() {
            await axios.get('api/data/temperature').then(res => {
                this.temperatureData = res.data
                this.formatData()
            }).catch(error => {
                console.error(error)
            })

        },

        formatData() {
            for (let item of this.temperatureData) {
                this.formattedData.tempTime.push(moment(item.time).format("DD-MM-YY hh:mm:ss"))
                this.formattedData.values.push(item.value)
            }
            this.dataset.labels = this.formattedData.tempTime
            this.dataset.datasets[0].data = this.formattedData.values
            this.loaded = true

        },
        async getData() {
            await axios.get('/api/data/temperature').then(res => {
                this.temperatureData = res.data
            }).catch(error => {
                alert(error)
            })
            this.formatData()

        }
    },
    watch: {},
    computed:{
      ChartData(){
          return this.dataset;
      }
    },
    created() {
        this.InitialiseChart()

    },
    mounted() {
        if(this.loaded){
            setInterval(() => {
                this.getData();
            },2000)
        }

    }
}
</script>

