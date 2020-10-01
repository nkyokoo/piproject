<script>
import { Line, mixins } from 'vue-chartjs'
const { reactiveProp } = mixins

export default {
    extends: Line,
    name:"chart",
    mixins: [reactiveProp],
    props: ['data', "options", "loaded"],
    data(){
        return {

        }
    },
    mounted () {
        if(this.loaded){
            console.info(this.options)
            this.renderChart(this.chartData, this.options)
        }
    }
}
</script>

<style scoped>

</style>
