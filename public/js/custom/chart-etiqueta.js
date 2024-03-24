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
