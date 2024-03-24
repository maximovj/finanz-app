const Utils = ChartUtils.init();

const DATA_COUNT = 7;
const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};

const labels = Utils.months({count: DATA_COUNT});
const data = {
  labels: labels,
  datasets: [
    {
      label: 'Dataset 1',
      data: Utils.numbers(NUMBER_CFG),
      borderColor: Utils.CHART_COLORS.red,
      backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
      tension: 0.4,
    },
    {
      label: 'Dataset 2',
      data: Utils.numbers(NUMBER_CFG),
      borderColor: Utils.CHART_COLORS.blue,
      backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
      tension: 0.2,
    }
  ]
};

const configChart = {
    type: 'line',
    data: data,
    options: {
      animations: {
        radius: {
          duration: 400,
          easing: 'linear',
          loop: (context) => context.active
        }
      },
      hoverRadius: 12,
      hoverBackgroundColor: 'yellow',
      interaction: {
        mode: 'nearest',
        intersect: false,
        axis: 'x'
      },
      plugins: {
        tooltip: {
          enabled: false
        }
      }
    },
  };
