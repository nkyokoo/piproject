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
                soundTime: [],
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
            await axios.get('api/data/light').then(res => {
                this.lightData = res.data
                this.formatData()
            }).catch(error => {
                console.error(error)

            })
        },

        formatData() {
            for (let item of this.lightData) {
                this.formattedData.soundTime.push(moment(item.time).format("DD-MM-YY HH:mm:ss"))
                this.formattedData.values.push(item.value)
            }
            this.dataset.labels = this.formattedData.soundTime
            this.dataset.datasets[0].data = this.formattedData.values
            this.loaded = true

        },
        async getData() {
            await axios.get('/api/data/light').then(res => {
                this.lightData = res.data
            }).catch(error => {
                alert(error)
            })
            this.formatData()
        }
    },
    watch: {},
    created() {
        this.InitialiseChart()

    }
}
</script>

