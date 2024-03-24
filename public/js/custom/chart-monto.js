
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
