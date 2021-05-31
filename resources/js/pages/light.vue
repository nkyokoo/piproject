<template>
    <div>
        <v-row>
            <v-col sm>

            </v-col>
            <v-col md>
                <v-card v-if="this.formattedData.values.length !== 0" style="width: 80vw; height: 60vh">
                    <v-card-title>
                        {{
                            "building: " + this.lightData[0].building
                            + " room: " + this.lightData[0].room
                        }}</v-card-title>
                    <Chart class="MonitoringChart" v-if="loaded" :chart-data="dataset" :options="options" :loaded="this.loaded"></Chart>
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

export default {
    components:{
        "Chart":Chart,
    },
    data() {
        return {
            loaded:false,
            lightData: [],
            formattedData: {
                lightTime: [],
                values: [],

            },
            dataset: {
                labels: null,
                datasets: [ {
                    label: 'Light',
                    data: null,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
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
            await axios.get('api/data/light?scale=5h').then(res => {
                this.lightData = res.data
                this.formatData()
            }).catch(error => {
                console.error(error)

            })
        },

        formatData() {
            for (let item of this.lightData) {
                this.formattedData.lightTime.push(moment(item.time).format("DD-MM-YY HH:mm:ss"))
                this.formattedData.values.push(item.value)
            }
            this.dataset.labels = this.formattedData.lightTime
            this.dataset.datasets[0].data = this.formattedData.values
            this.loaded = true

        },
        async getData(type) {
            this.formattedData.lightTime = []
            this.formattedData.values = []
            await axios.get(`/api/data/light?scale=${type}`).then(res => {
                this.formatData.lightTime = []
                this.formatData.values = []
                this.lightData = res.data
                this.formatData()
            }).catch(error => {
                alert(error)
            })
        },
        setChartScale(type){
            this.getData(type)
        }
    },
    watch: {},
    created() {
        this.InitialiseChart()

    }
}
</script>

