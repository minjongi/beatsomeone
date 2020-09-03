<script>
    import Chart from 'chart.js'
    import { generateChart } from 'vue-chartjs';

    Chart.Tooltip.positioners.custom = function(elements, eventPosition) {
        var tooltip = this;
        // log.debug(elements);
        return {
            x : eventPosition.x,
            y: eventPosition.y,
        };
    }



    Chart.defaults.LineWithLine = Chart.defaults.line;
    Chart.controllers.LineWithLine = Chart.controllers.line.extend({
        draw: function(ease) {


            if (this.chart.tooltip._active && this.chart.tooltip._active.length) {
                var activePoint = this.chart.tooltip._active[0],
                    ctx = this.chart.ctx,
                    x = activePoint.tooltipPosition().x,
                    topY = this.chart.scales['y-axis-0'].top,
                    bottomY = this.chart.scales['y-axis-0'].bottom;

                // draw line
                ctx.save();
                ctx.beginPath();
                ctx.moveTo(x, topY);
                ctx.lineTo(x, bottomY);
                ctx.lineWidth = 1.5;
                ctx.strokeStyle = '#7F6D15';
                ctx.shadowBlur = 0.5;
                ctx.stroke();
                ctx.restore();
            }

            Chart.controllers.line.prototype.draw.call(this, ease);
        }
    });

    const CustomLine = generateChart('custom-line', 'LineWithLine')

    export default {
        extends: CustomLine,
        props: ['chartdata', 'options'],
        mounted () {
            this.renderChart(this.chartdata, this.options);
        },
        methods: {
            reload() {
                this.renderChart(this.chartdata, this.options);
            }
        }
    }
</script>