
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
 * easing effects and duration specified. The chart also has options for interaction, plugins, legend,
 * title, and scales.
 */
function initChartMonto(ctx, montos_iniciales, montos_finales)
{
    const data = montos_iniciales;
    const data2 = montos_finales;

    const helpers = Chart.helpers;
    let easing = helpers.easingEffects.easeInQuart;
    let restart = false;
    const totalDuration = 5000;
    const duration = (ctx) => easing(ctx.index / data.length) * totalDuration / data.length;
    const delay = (ctx) => easing(ctx.index / data.length) * totalDuration;
    const previousY = (ctx) => ctx.index === 0 ? ctx.chart.scales.y.getPixelForValue(100) : ctx.chart.getDatasetMeta(ctx.datasetIndex).data[ctx.index - 1].getProps(['y'], true).y;
    const animation = {
        x: {
            type: 'number',
            easing: 'linear',
            duration: duration,
            from: NaN, // the point is initially skipped
            delay(ctx) {
            if (ctx.type !== 'data' || ctx.xStarted) {
                return 0;
            }
            ctx.xStarted = true;
            return delay(ctx);
            }
        },
        y: {
            type: 'number',
            easing: 'linear',
            duration: duration,
            from: previousY,
            delay(ctx) {
            if (ctx.type !== 'data' || ctx.yStarted) {
                return 0;
            }
            ctx.yStarted = true;
            return delay(ctx);
            }
        }
    };

    new Chart(ctx, {
        type: 'line',
        data: {
          datasets: [{
            borderColor: Utils.CHART_COLORS.red,
            borderWidth: 1,
            radius: 0,
            data: data,
          },
          {
            borderColor: Utils.CHART_COLORS.blue,
            borderWidth: 1,
            radius: 0,
            data: data2,
          }]
        },
        options: {
          animation,
          interaction: {
            intersect: false
          },
          plugins: {
            legend: false,
            title: {
              display: true,
              text: () => easing.name
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
