/**
 * The function `initChartEtiqueta` creates a polar area chart with labels and total balances.
 * @param ctx - The `ctx` parameter in the `initChartEtiqueta` function is the 2D rendering context of
 * the canvas where the chart will be drawn. It is typically obtained by calling `getContext('2d')` on
 * a canvas element.
 * @param labels - The `labels` parameter in the `initChartEtiqueta` function represents an array of
 * labels that will be displayed on the chart. These labels are typically used to identify the data
 * points or categories being represented in the chart. For example, if you are creating a chart to
 * display sales data for different
 * @param saldos_totales - The `saldos_totales` parameter in the `initChartEtiqueta` function
 * represents the total balances corresponding to each label in the chart. These values will be used to
 * populate the data for the polar area chart. Each balance value will be associated with a specific
 * label in the chart.
 */
function initChartEtiqueta(ctx, labels, saldos_totales)
{
    const data = {
    labels: labels,
    datasets: [
        {
            label: 'Etiquetas',
            data: saldos_totales,
            backgroundColor: [
                Utils.transparentize(Utils.CHART_COLORS.red, 0),
                Utils.transparentize(Utils.CHART_COLORS.orange, 0),
                Utils.transparentize(Utils.CHART_COLORS.yellow, 0),
                Utils.transparentize(Utils.CHART_COLORS.green, 0),
                Utils.transparentize(Utils.CHART_COLORS.blue, 0),
            ]
        }
    ]};

    new Chart(ctx, {
        type: 'polarArea',
        data: data,
        options: {
          responsive: true,
          scales: {
            r: {
              pointLabels: {
                display: true,
                centerPointLabels: true,
                font: {
                  size: 18
                }
              }
            }
          },
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Gráfica de muestreo / etiqueta'
            }
          }
        },
      });

}
