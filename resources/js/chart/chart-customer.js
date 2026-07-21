import ApexCharts from "apexcharts";

const chartCustomer = () => {
  const options = {
    series: [{
      name: "Customers",
      data: typeof customerChartData !== 'undefined' ? customerChartData : [],
    }],
    colors: ["#1d4ed8"], 
    chart: {
      fontFamily: "Outfit, sans-serif",
      type: "bar",
      height: 180,
      toolbar: { show: false },
      offsetX: 20,
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "39%",
        borderRadius: 5,
        borderRadiusApplication: "end",
      },
    },
    dataLabels: { enabled: false },
    stroke: {
      show: true,
      width: 4,
      colors: ["transparent"],
    },
    xaxis: {
      categories: [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
      ],
      title: {
        text: "Bulan", // ← label sumbu X
        style: {
          fontSize: "14px",
          fontWeight: 500,
          color: "#374151",
        },
      },
      axisBorder: {
        show: { show: true, color: "#E5E7EB" },
      },
      axisTicks: {
        show: { show: true, color: "#E5E7EB" },
      },
    },
    legend: {
      show: true,
      position: "top",
      horizontalAlign: "left",
      fontFamily: "Outfit",
      markers: { radius: 99 },
    },
    yaxis: {
      title: {
        text: "Total Customer", // ← label sumbu Y
        style: {
          fontSize: "14px",
          fontWeight: 500,
          color: "#374151",
        },
      },
    },
    grid: {
      yaxis: { lines: { show: true } },
    },
    fill: { opacity: 1 },
    tooltip: {
      enabled: true,
      custom: function({ series, seriesIndex, dataPointIndex, w }) {
        const value = series[seriesIndex][dataPointIndex];
        const category = w.globals.labels[dataPointIndex]; // nama bulan
        return `
          <div style="padding:10px; background:#60A5FA; color:white; border-radius:5px;">
            <strong>${category}</strong><br/>
            Customer: ${value.toLocaleString('id-ID')}
          </div>
        `;
      }
    },
  };

  const chartEl = document.querySelector("#chartCustomer");

  if (chartEl) {
    const chart = new ApexCharts(chartEl, options);
    chart.render();
  }
};

export default chartCustomer;
