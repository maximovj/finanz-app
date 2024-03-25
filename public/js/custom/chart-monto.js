
/**
 * The function `initChartMonto` initializes a line chart with two datasets and custom animations based
 * on provided initial and final data.
 * @param ctx - The `ctx` parameter in the `initChartMonto` function represents the context of the
 * chart where it will be rendered. It typically refers to the 2D rendering context of the canvas
 * element where the chart will be drawn. This context is necessary for drawing and interacting with
 * the chart within the
 * @param montos_iniciales - It looks like you were about to provide some information about the
 * `montos_iniciales` parameter. How can I assist you with that?
 * @param montos_finales - It looks like you were about to provide some information about the
 * `montos_finales` parameter, but the message got cut off. Could you please provide more details or
 * let me know if you need help with something specific related to `montos_finales`?
 * @returns The `initChartMonto` function initializes a line chart using Chart.js library with two
 * datasets (`montos_iniciales` and `montos_finales`). The chart has animations for x and y axes, with
 * easing effects and durationX specified. The chart also has options for interaction, plugins, legend,
 * title, and scales.
 */
function initChartMonto(ctx, descripciones, montos_iniciales, montos_finales)
{
    const data = montos_iniciales;
    const data2 = montos_finales;

    const helpers = Chart.helpers;
    let easingOut = helpers.easingEffects.easeOutQuart;
    let easingIn = helpers.easingEffects.easeInQuint;
    let restart = false;
    const totalDuration = 5000;
    const durationX = (ctx) => easingOut(ctx.index / data.length) * totalDuration / data.length;
    const delayX = (ctx) => easingOut(ctx.index / data.length) * totalDuration;
    const durationY = (ctx) => easingIn(ctx.index / data2.length) * totalDuration / data2.length;
    const delayY = (ctx) => easingIn(ctx.index / data2.length) * totalDuration;
    const previousY = (ctx) => ctx.index === 0 ? ctx.chart.scales.y.getPixelForValue(100) : ctx.chart.getDatasetMeta(ctx.datasetIndex).data[ctx.index - 1].getProps(['y'], true).y;
    const animation = {
        x: {
            type: 'number',
            easing: 'linear',
            duration: durationX,
            from: NaN, // the point is initially skipped
            delay(ctx) {
            if (ctx.type !== 'data' || ctx.xStarted) {
                return 0;
            }
            ctx.xStarted = true;
            return delayX(ctx);
            }
        },
        y: {
            type: 'number',
            easing: 'linear',
            duration: durationY,
            from: previousY,
            delay(ctx) {
            if (ctx.type !== 'data2' || ctx.yStarted) {
                return 0;
            }
            ctx.yStarted = true;
            return delayY(ctx);
            }
        }
    };

    new Chart(ctx, {
        type: 'line',
        data: {
          label: descripciones,
          labels: descripciones,
          datasets: [{
            borderColor: Utils.CHART_COLORS.blue,
            borderWidth: 1,
            radius: 0,
            data: montos_iniciales,
          },
          {
            borderColor: Utils.CHART_COLORS.red,
            borderWidth: 1,
            radius: 0,
            data: montos_finales ,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation,
          interaction: {
            intersect: false,
            mode: 'index',
          },
          plugins: {
            legend: false,
            title: {
              display: true,
              text: 'Gráfica de muestreo / montos'
            },
            tooltip: {
                callbacks: {
                    title: function(context){
                        const cont = context[0];
                        const labelIndex = (cont.datasetIndex * 2) + cont.dataIndex;
                        const titleText = cont.chart.data.labels[labelIndex];
                        return [titleText];
                    },
                    label: function(context) {
                        console.log(context);
                        const preLabel = (context.datasetIndex == 0) ? 'Monto inicial' : 'Monto final';
                        const labelText  = preLabel + ': ' + context.formattedValue;
                        return [labelText];
                    },
                    footer: function(context) {
                        const fecha = context[0].raw.fecha;
                        const dataset_1 = context[0].raw.y;
                        const dataset_2 = context[1].raw.y; // raw.y
                        const suma = dataset_1 + dataset_2;
                        console.log('tooltip.callbacks.footer',context)

                        return ['Monto total: ' + suma, 'Fecha: ' + fecha];
                    },
                }
            }
          },
          scales: {
            x: {
              type: 'linear'
            }
          }
        }
      });
}
