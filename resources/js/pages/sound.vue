<template>
    <div>
        <v-row>
            <v-col sm>

            </v-col>
            <v-col md>
                <v-card v-if="this.formattedData.values.length !== 0" style="width: 80vw; height: 60vh">
                    <v-card-title>
                        {{
                            "building: " + this.soundData[0].building
                            + " room: " + this.soundData[0].room
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
            soundData: [],
            formattedData: {
                soundTime: [],
                values: [],

            },
            dataset: {
                labels: null,
                datasets: [ {
                    label: 'Sound',
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
            await axios.get('api/data/sound?scale=5h').then(res => {
                this.soundData = res.data
                this.formatData()
            }).catch(error => {
                console.error(error)
                alert(error)
            })
        },

        formatData() {
            for (let item of this.soundData) {
                this.formattedData.soundTime.push(moment(item.time).format("DD-MM-YY HH:mm:ss"))
                this.formattedData.values.push(item.value)
            }
            this.dataset.labels = this.formattedData.soundTime
            this.dataset.datasets[0].data = this.formattedData.values
            this.loaded = true

        },
        async getData(type) {
            this.formattedData.soundTime = []
            this.formattedData.values = []
            await axios.get(`/api/data/sound?scale=${type}`).then(res => {
                this.soundData = res.data
            }).catch(error => {
            })
            this.formatData()
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

