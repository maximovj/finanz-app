const Utils = ChartUtils.init();

const NUM_POINTS = 100000;
Utils.srand(10);

// parseISODate returns a luxon date object to work with in the samples
// We will create points every 30s starting from this point in time
const start = Utils.parseISODate('2021-04-01T00:00:00Z').toMillis();
const pointData = [];

for (let i = 0; i < NUM_POINTS; ++i) {
  // Most data will be in the range [0, 20) but some rare data will be in the range [0, 100)
  const max = Math.random() < 0.001 ? 100 : 20;
  pointData.push({x: start + (i * 30000), y: Utils.rand(0, max)});
}

const data = {
  datasets: [{
    borderColor: Utils.CHART_COLORS.red,
    borderWidth: 1,
    data: pointData,
    label: 'Large Dataset',
    radius: 0,
  }]
};

const decimation = {
    enabled: false,
    algorithm: 'min-max',
};

const configChart = {
    type: 'line',
    data: data,
    options: {
      // Turn off animations and data parsing for performance
      animation: false,
      parsing: false,

      interaction: {
        mode: 'nearest',
        axis: 'x',
        intersect: false
      },
      plugins: {
        decimation: decimation,
      },
      scales: {
        x: {
          type: 'time',
          ticks: {
            source: 'auto',
            // Disabled rotation for performance
            maxRotation: 0,
            autoSkip: true,
          }
        }
      }
    }
};

