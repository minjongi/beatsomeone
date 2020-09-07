<template>
    <div>
        <LineChart ref="chart" :chartdata="chartdata" :options="options" :styles="{'height':'320px'}" />
    </div>
</template>

<script>
    import LineChart from "./LineChart";
    export default {
        name: "SaleChart",
        components: { LineChart },
        props: ['data'],
        data: function () {
            return {
                chartdata: {
                    datasets: [
                        {
                            borderColor: '#4890FF',
                            borderWidth: 2,
                            pointBorderColor: '#4890FF',
                            pointBackgroundColor: '#4890FF',
                            lineTension: 0.1,
                            fill: false,
                            showLine: true,
                        },
                    ]
                },
                options: {
                    tooltips: {
                        position : 'custom',
                        backgroundColor: 'rgba(60, 60, 60, 1)',
                        titleAlign: 'center',
                        bodyAlign: 'center',
                        footerAlign: 'center',

                        callbacks: {
                            label: function(tooltipItem, data) {
                                var label = data.datasets[tooltipItem.datasetIndex].label || '';

                                if (label) {
                                    label += ': ';
                                }
                                label += '￦ '+tooltipItem.yLabel.toLocaleString();
                                // var label = '￦ '+tooltipItem.yLabel.toLocaleString();
                                return label;
                            },
                            // afterLabel: function(tooltipItem, data) {
                            //     var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            //     return label + ' Amount';
                            // }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: { display: false },
                    scales: {
                        xAxes: [{
                            type: 'category',
                            gridLines: {
                                zeroLineColor: 'rgba(255, 255, 255, 0.8)',
                                drawBorder: true,
                                drawTicks: false,
                                tickMarkLength: 10,
                            },
                            ticks: {
                                fontColor: 'rgba(255, 255, 255, 0.8)',
                                padding: 10,
                            }
                        }],
                        yAxes: [{

                            gridLines: {

                                display: true,
                                color: 'rgba(255, 255, 255, 0.3)',
                                //color: ['rgba(255, 255, 255, 0.8)','rgba(255, 255, 255, 0.3)','rgba(255, 255, 255, 0.3)','rgba(255, 255, 255, 0.3)'],
                                zeroLineColor: 'rgba(255, 255, 255, 0.8)',
                                borderDash: [2, 2],
                                drawOnChartArea: true,
                                //drawBorder: true,
                                drawTicks: false,
                                tickMarkLength: 10,
                                offsetGridLines: false,
                            },
                            ticks: {
                                fontColor: 'rgba(255, 255, 255, 0.8)',
                                padding: 20,

                                callback: function(value, index, values) {
                                    return value.toLocaleString();
                                }
                            }
                        }]
                    }
                },
            }
        },
        watch: {
            data: {
                // This will let Vue know to look inside the array
                deep: true,

                // We have to move our method to a handler field
                handler() {
                    log.debug('WATCH DATA');
                    this.parseData();
                },

            }
        },
        created() {

        },
        mounted() {
            this.parseData();
        },
        methods: {
            parseData() {
                // Parse Labels
                const labels = _.sortBy(_.union(Object.keys(this.data[0].data)));
                this.chartdata.labels = labels;

                // Estimated settlement
                const l1 = _.map(labels,r => { return this.data[0].data[r] | 0});
                this.chartdata.datasets[0].label = this.data[0].category;
                this.chartdata.datasets[0].data = l1;
                console.log(l1);

                // log
                log.debug({
                    'LABLES': labels,
                    'L1': l1,
                });

                // reload
                this.$refs.chart.reload();
            },
        },
    }
</script>

<style scoped>

</style>