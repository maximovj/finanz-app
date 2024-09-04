/**
 * The function `initChartCategoria` creates a pie chart using Chart.js library with customizable
 * colors, labels, and tooltips.
 * @param ctx - The `ctx` parameter in the `initChartCategoria` function is the 2D rendering context of
 * the canvas where the chart will be drawn. It is typically obtained by calling `getContext('2d')` on
 * a canvas element. This context is used by Chart.js to render the chart graphics
 * @param labels - Labels are the categories or names for each data point in the chart. They are
 * typically displayed along the x-axis or as part of the chart legend. In the provided code, the
 * `labels` parameter is an array containing the labels for each data point in the chart. These labels
 * will be used to
 * @param saldos - The `saldos` parameter in the `initChartCategoria` function is an array of arrays.
 * Each inner array represents the data for a specific dataset in the chart. The inner arrays contain
 * the numerical values that will be displayed in the chart slices.
 * @returns The `initChartCategoria` function is setting up a pie chart using Chart.js library. It
 * takes in a canvas context `ctx`, an array of `labels`, and an array of `saldos` (which seems to be
 * an array of arrays representing the data for each dataset).
 */
function initChartCategoria(ctx, labels, saldos)
{
    const data = {
    labels: labels,
    datasets: [
        {
            backgroundColor: ['#AAA', '#777'],
            data: saldos[0]
        },
        {
            backgroundColor: ['hsl(0, 100%, 60%)', 'hsl(0, 100%, 35%)'],
            data: saldos[1]
        },
        {
            backgroundColor: ['hsl(100, 100%, 60%)', 'hsl(100, 100%, 35%)'],
            data: saldos[2]
        },
        {
            backgroundColor: ['hsl(180, 100%, 60%)', 'hsl(180, 100%, 35%)'],
            data: saldos[3]
        }
    ]};

    new Chart(ctx, {
        type: 'pie',
        data: data,
        options: {
          responsive: true,
          plugins: {
            title: {
                display: true,
                text: 'Gráfica de muestreo / categoría',
            },
            legend: {
              labels: {
                generateLabels: function(chart) {
                  // Get the default label list
                  const original = Chart.overrides.pie.plugins.legend.labels.generateLabels;
                  const labelsOriginal = original.call(this, chart);

                  // Build an array of colors used in the datasets of the chart
                  let datasetColors = chart.data.datasets.map(function(e) {
                    return e.backgroundColor;
                  });
                  datasetColors = datasetColors.flat();

                  // Modify the color and hide state of each label
                  labelsOriginal.forEach(label => {
                    // There are twice as many labels as there are datasets. This converts the label index into the corresponding dataset index
                    label.datasetIndex = (label.index - label.index % 2) / 2;

                    // The hidden state must match the dataset's hidden state
                    label.hidden = !chart.isDatasetVisible(label.datasetIndex);

                    // Change the color to match the dataset
                    label.fillStyle = datasetColors[label.index];
                  });

                  return labelsOriginal;
                }
              },
              onClick: function(mouseEvent, legendItem, legend) {
                // toggle the visibility of the dataset from what it currently is
                legend.chart.getDatasetMeta(
                  legendItem.datasetIndex
                ).hidden = legend.chart.isDatasetVisible(legendItem.datasetIndex);
                legend.chart.update();
              }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  const labelIndex = (context.datasetIndex * 2) + context.dataIndex;
                  return context.chart.data.labels[labelIndex] + ': ' + context.formattedValue;
                },
                footer: function(tooltipItems) {
                    let suma = 0;

                    tooltipItems.forEach(function(tooltipItem) {
                        suma += tooltipItem.dataset.data[0]  + tooltipItem.dataset.data[1];
                    });

                    return ['Monto total: ' + suma.toLocaleString()];
                },
              }
            }
          }
        },
      });
}
