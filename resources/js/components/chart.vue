<script>
import { Line, mixins } from 'vue-chartjs'

export default {
    extends: Line,
    name:"chart",
    props: ["chartData","options"],
    computed:{
        dataLength(){
            return this.chartData.datasets[0].data.length;
        }
    },
    watch:{
      dataLength(){
          this.$data._chart.update()
      }
    },
    mounted () {
        this.renderChart(this.chartData, this.options)
    }
}
</script>

<style scoped>

</style>
