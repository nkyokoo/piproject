<template>
    <div>
        <v-row>
            <v-col sm>

            </v-col>
            <v-col md>
                <v-card v-if="this.formattedData.values.length !== 0" style="width: 80vw; height: 60vh">
                    <v-card-title>
                        {{"building: " + this.temperatureData[0].building + " room: " + this.temperatureData[0].room }}
                    </v-card-title>
                    <Chart class="MonitoringChart" v-if="loaded" :chart-data="ChartData" :options="options"
                           :loaded="this.loaded"></Chart>
                    <v-card-actions>
                        <v-item-group>
                            <v-btn @click="setChartScale('2h')">
                                Past 2 hr
                            </v-btn>
                            <v-btn @click="setChartScale('1h')">
                                Past 1 hr
                            </v-btn>
                            <v-btn @click="setChartScale('30m')">
                                Past 30 min
                            </v-btn>
                            <v-btn @click="setChartScale('10m')">
                                Past 10 min
                            </v-btn>
                        </v-item-group>
                    </v-card-actions>
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
    components: {
        "Chart": Chart,
    },
    data() {
        return {
            loaded: false,
            temperatureData: [],
            formattedData: {
                tempTime: [],
                values: [],

            },
            dataset: {
                labels: null,
                datasets: [{
                    label: 'Temperature',
                    data: null,
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
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
                                suggestedMax: 50,
                                suggestedMin: -80,
                            }
                        }],
                    xAxes: [
                        {
                            ticks: {
                                maxTicksLimit: 20,
                                showXLabels: 10,
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
            await axios.get('api/data/temperature?scale=5h', ).then(res => {
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
        async getData(type) {
            this.formattedData.tempTime = []
            this.formattedData.values = []
            await axios.get(`/api/data/temperature?scale=${type}`).then(res => {
                this.temperatureData = res.data
            }).catch(error => {
                alert(error)
            })
            this.formatData()

        },
        setChartScale(type){
            this.getData(type)
        }
    },
    watch: {},
    computed: {
       ChartData() {
            return this.dataset;
        }
    },
    created() {
        this.InitialiseChart()

    },
    mounted() {

    }
}
</script>

