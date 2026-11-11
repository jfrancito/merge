<template>
   <div>
     <apexchart type=area height=350 :options="chartOptions" :series="oserie" />
   </div>
</template>


<script>
export default {

    props: ["oserie"],
    data: function() {
      return {
        chartOptions: {
          chart: {
            id: 'vuechart-example'
          },
          dataLabels: {
            enabled: true
          },
           stroke: {
            curve: 'smooth'
          },
          legend: {
                    position: 'top',
                    horizontalAlign: 'left'
          },
          xaxis: {
                      type: 'string',
                      categories: ["MT", "0-30", "31-90", "90-180", ">180"],                
          }
        },
        series: this.oserie
      }
    },
}
</script>