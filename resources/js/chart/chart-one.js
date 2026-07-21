import ApexCharts from "apexcharts";

// ===== chartOne
const chart01 = () => {
  const chartOneOptions = {
    series: [
      {
        name: "Income",
        data: typeof incomeChartData !== 'undefined' ? incomeChartData : [],
      },
    ],
    colors: ["#1d4ed8"],
    chart: {
      fontFamily: "Outfit, sans-serif",
      type: "area",
      height: "100%",
      maxWidth: "100%",
      toolbar: {
        show: false,
      },
      offsetX: 20,
      offsetY: 20,
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "39%",
        borderRadius: 5,
        borderRadiusApplication: "end",
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 4,
      colors: ["transparent"],
    },
    xaxis: {
      categories: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
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

      markers: {
        radius: 99,
      },
    },
    yaxis: {
      title: {
        text: "Total Pendapatan", // ← label sumbu Y
        style: {
          fontSize: "14px",
          fontWeight: 500,
          color: "#374151",
        },
      },
      labels: {
        formatter: (val) => `Rp ${val.toLocaleString('id-ID')}`,
      },
    },
    grid: {
      borderColor: "#E5E7EB",
      strokeDashArray: 4,
      yaxis: { lines: { show: true } },
      padding: {
        top: 10,
        left: 30, // tambah ruang di kiri agar label Y tidak terpotong
        right: 10,
      },
    },
    
    fill: {
      opacity: 1,
    },

    tooltip: {
      enabled: true,
      custom: function({ series, seriesIndex, dataPointIndex, w }) {
        const value = series[seriesIndex][dataPointIndex];
        const monthNames = [
          "Jan", "Feb", "Mar", "Apr", "May", "Jun",
          "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];
        const category = monthNames[dataPointIndex]; // nama bulan
        return `
          <div style="padding:10px; background:#60A5FA; color:white; border-radius:5px;">
            <strong>${category}</strong><br/>
            Income: Rp ${value.toLocaleString('id-ID')}
          </div>
        `;
      }
    },
  };

  const chartSelector = document.querySelector("#chartOne");

  if (chartSelector) {
    const chart = new ApexCharts(chartSelector, chartOneOptions);
    chart.render();
}
};

export default chart01;
