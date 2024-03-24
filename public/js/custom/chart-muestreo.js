
/**
 * The function `chartMuestreo` creates a combined bar and line chart using Chart.js to display
 * financial data with labels, total balances, and assets.
 * @param ctx - The `ctx` parameter in the `chartMuestreo` function is the 2D drawing context of the
 * canvas element where the chart will be rendered. It is typically obtained by calling
 * `getContext('2d')` on a canvas element.
 * @param labels - Labels are the categories or groups that will be displayed on the x-axis of the
 * chart. They could represent different time periods, products, or any other relevant categories for
 * your data. For example, if you are creating a financial report, the labels could be months or
 * quarters.
 * @param saldos_totales - The `saldos_totales` parameter represents an array of numerical values that
 * correspond to the total balances. These values will be used to create a bar chart in the financial
 * sampling chart alongside the `activos` values.
 * @param activos - The `activos` parameter in the `chartMuestreo` function represents an array of data
 * points for the "Activos" dataset in the chart. These data points correspond to the values you want
 * to display for the "Activos" dataset on the chart. Each data point will be plotted
 */
function chartMuestreo(ctx, labels, saldos_totales, activos)
{
    const data = {
        labels: labels,
        datasets:
        [
            {
            label: 'Monto final',
            data: saldos_totales,
            borderColor: Utils.CHART_COLORS.red,
            backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
            stack: 'combined',
            type: 'bar'
            },
            {
            label: 'Monto inicial',
            data: activos,
            borderColor: Utils.CHART_COLORS.blue,
            backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
            stack: 'combined'
            }
        ]
    };

    new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
        plugins: {
            title: {
            display: true,
            text: 'Gráfica de muestreo / Informe financiero'
            }
        },
        scales: {
            y: {
            stacked: true
            }
        }
        },
    });
}
