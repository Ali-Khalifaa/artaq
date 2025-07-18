/* Target Incomplete Chart */
var options = {
    chart: {
        height: 127,
        width: 100,
        type: "radialBar",
    },

    series: [48],
    colors: ["rgba(255,255,255,0.9)"],
    plotOptions: {
        radialBar: {
            hollow: {
                margin: 0,
                size: "55%",
                background: "#fff"
            },
            dataLabels: {
                name: {
                    offsetY: -10,
                    color: "#4b9bfa",
                    fontSize: ".625rem",
                    show: false
                },
                value: {
                    offsetY: 5,
                    color: "#4b9bfa",
                    fontSize: ".875rem",
                    show: true,
                    fontWeight: 600
                }
            }
        }
    },
    stroke: {
        lineCap: "round"
    },
    labels: ["Status"]
};
// document.querySelector("#crm-main").innerHTML = ""
// var chart = new ApexCharts(document.querySelector("#crm-main"), options);
// chart.render();
/* Target Incomplete Chart */

/* Total Customers chart */
var crm1 = {
    chart: {
        type: 'line',
        height: 40,
        width: 100,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        show: true,
        curve: 'smooth',
        lineCap: 'butt',
        colors: undefined,
        width: 1.5,
        dashArray: 0,
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.9,
            opacityTo: 0.9,
            stops: [0, 98],
        }
    },
    series: [{
        name: 'Value',
        data: [20, 14, 19, 10, 23, 20, 22, 9, 12]
    }],
    yaxis: {
        min: 0,
        show: false,
        axisBorder: {
            show: false
        },
    },
    xaxis: {
        show: false,
        axisBorder: {
            show: false
        },
    },
    tooltip: {
        enabled: false,
    },
    colors: ["rgb(132, 90, 223)"],
}
document.getElementById('crm-total-customers').innerHTML = '';
var crm1 = new ApexCharts(document.querySelector("#crm-total-customers"), crm1);
crm1.render();

function crmtotalCustomers() {
    crm1.updateOptions({
        colors: ["rgb(" + myVarVal + ")"],
    });
}
/* Total Customers chart */

/* Total revenue chart */
var crm2 = {
    chart: {
        type: 'line',
        height: 40,
        width: 100,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        show: true,
        curve: 'smooth',
        lineCap: 'butt',
        colors: undefined,
        width: 1.5,
        dashArray: 0,
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.9,
            opacityTo: 0.9,
            stops: [0, 98],
        }
    },
    series: [{
        name: 'Value',
        data: [20, 14, 20, 22, 9, 12, 19, 10, 25]
    }],
    yaxis: {
        min: 0,
        show: false,
        axisBorder: {
            show: false
        },
    },
    xaxis: {
        show: false,
        axisBorder: {
            show: false
        },
    },
    tooltip: {
        enabled: false,
    },
    colors: ["rgb(35, 183, 229)"],

}
document.getElementById('crm-total-revenue').innerHTML = '';
var crm2 = new ApexCharts(document.querySelector("#crm-total-revenue"), crm2);
crm2.render();
/* Total revenue chart */

/* Conversion ratio Chart */
var crm3 = {
    chart: {
        type: 'line',
        height: 40,
        width: 100,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        show: true,
        curve: 'smooth',
        lineCap: 'butt',
        colors: undefined,
        width: 1.5,
        dashArray: 0,
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.9,
            opacityTo: 0.9,
            stops: [0, 98],
        }
    },
    series: [{
        name: 'Value',
        data: [20, 20, 22, 9, 14, 19, 10, 25, 12]
    }],
    yaxis: {
        min: 0,
        show: false,
        axisBorder: {
            show: false
        },
    },
    xaxis: {
        show: false,
        axisBorder: {
            show: false
        },
    },
    tooltip: {
        enabled: false,
    },
    colors: ["rgb(38, 191, 148)"],

}
document.getElementById('crm-conversion-ratio').innerHTML = '';
var crm3 = new ApexCharts(document.querySelector("#crm-conversion-ratio"), crm3);
crm3.render();
/* Conversion ratio Chart */

/* Total Deals Chart */
var crm4 = {
    chart: {
        type: 'line',
        height: 40,
        width: 100,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        show: true,
        curve: 'smooth',
        lineCap: 'butt',
        colors: undefined,
        width: 1.5,
        dashArray: 0,
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.9,
            opacityTo: 0.9,
            stops: [0, 98],
        }
    },
    series: [{
        name: 'Value',
        data: [20, 20, 22, 9, 12, 14, 19, 10, 25]
    }],
    yaxis: {
        min: 0,
        show: false,
        axisBorder: {
            show: false
        },
    },
    xaxis: {
        show: false,
        axisBorder: {
            show: false
        },
    },
    tooltip: {
        enabled: false,
    },
    colors: ["rgb(245, 184, 73)"],

}
// document.getElementById('crm-total-deals').innerHTML = '';
// var crm4 = new ApexCharts(document.querySelector("#crm-total-deals"), crm4);
// crm4.render();
/* Total Deals Chart */

/* Revenue Analytics Chart */
var options = {
    series: [
        {
            type: 'line',
            name: 'أرباح',
            data: [
                {
                    x: 'يناير',
                    y: 100
                },
                {
                    x: 'فبراير',
                    y: 210
                },
                {
                    x: 'مارس',
                    y: 180
                },
                {
                    x: 'ابريل',
                    y: 454
                },
                {
                    x: 'مايو',
                    y: 230
                },
                {
                    x: 'يونيو',
                    y: 320
                },
                {
                    x: 'يوليو',
                    y: 656
                },
                {
                    x: 'أغسطس',
                    y: 830
                },
                {
                    x: 'سبتمبر',
                    y: 350
                },
                {
                    x: 'أكتوبر',
                    y: 350
                },
                {
                    x: 'نوفمبر',
                    y: 210
                },
                {
                    x: 'ديسمبر',
                    y: 410
                }
            ]
        },
        {
            type: 'line',
            name: 'ايرادات',
            chart: {
                dropShadow: {
                    enabled: true,
                    enabledOnSeries: undefined,
                    top: 5,
                    left: 0,
                    blur: 3,
                    color: '#000',
                    opacity: 0.1
                }
            },
            data: [
                {
                    x: 'يناير',
                    y: 180
                },
                {
                    x: 'فبراير',
                    y: 620
                },
                {
                    x: 'مارس',
                    y: 476
                },
                {
                    x: 'ابريل',
                    y: 220
                },
                {
                    x: 'مايو',
                    y: 520
                },
                {
                    x: 'يونيو',
                    y: 780
                },
                {
                    x: 'يوليو',
                    y: 435
                },
                {
                    x: 'أغسطس',
                    y: 515
                },
                {
                    x: 'سبتمبر',
                    y: 738
                },
                {
                    x: 'أكتوبر',
                    y: 454
                },
                {
                    x: 'نوفمبر',
                    y: 525
                },
                {
                    x: 'ديسمبر',
                    y: 230
                }
            ]
        },
        {
            type: 'area',
            name: 'مبيعات',
            chart: {
                dropShadow: {
                    enabled: true,
                    enabledOnSeries: undefined,
                    top: 5,
                    left: 0,
                    blur: 3,
                    color: '#000',
                    opacity: 0.1
                }
            },
            data: [
                {
                    x: 'يناير',
                    y: 200
                },
                {
                    x: 'فبراير',
                    y: 530
                },
                {
                    x: 'مارس',
                    y: 110
                },
                {
                    x: 'ابريل',
                    y: 130
                },
                {
                    x: 'مايو',
                    y: 480
                },
                {
                    x: 'يونيو',
                    y: 520
                },
                {
                    x: 'يوليو',
                    y: 780
                },
                {
                    x: 'أغسطس',
                    y: 435
                },
                {
                    x: 'سبتمبر',
                    y: 475
                },
                {
                    x: 'أكتوبر',
                    y: 738
                },
                {
                    x: 'نوفمبر',
                    y: 454
                },
                {
                    x: 'ديسمبر',
                    y: 480
                }
            ]
        }
    ],
    chart: {
        height: 350,
        animations: {
            speed: 500
        },
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 8,
            left: 0,
            blur: 3,
            color: '#000',
            opacity: 0.1
        },
    },
    colors: ["rgb(132, 90, 223)", "rgba(35, 183, 229, 0.85)", "rgba(119, 119, 142, 0.05)"],
    dataLabels: {
        enabled: false
    },
    grid: {
        borderColor: '#f1f1f1',
        strokeDashArray: 3
    },
    stroke: {
        curve: 'smooth',
        width: [2, 2, 0],
        dashArray: [0, 5, 0],
    },
    xaxis: {
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        labels: {
            formatter: function (value) {
                return " ر.س " + value;
            }
        },
    },
    tooltip: {
        y: [{
            formatter: function(e) {
                return void 0 !== e ? " ر.س " + e.toFixed(0) : e
            }
        }, {
            formatter: function(e) {
                return void 0 !== e ? " ر.س " + e.toFixed(0) : e
            }
        }, {
            formatter: function(e) {
                return void 0 !== e ? e.toFixed(0) : e
            }
        }]
    },
    legend: {
        show: true,
        customLegendItems: ['أرباح', 'ايرادات', 'مبيعات'],
        inverseOrder: true
    },
    title: {
        text: 'تحليلات الإيرادات مع المبيعات والأرباح (بالريال السعودى)',
        align: 'left',
        style: {
            fontSize: '.8125rem',
            fontWeight: 'semibold',
            color: '#8c9097'
        },
    },
    markers: {
        hover: {
            sizeOffset: 5
        }
    }
};
document.getElementById('crm-revenue-analytics').innerHTML = '';
var chart = new ApexCharts(document.querySelector("#crm-revenue-analytics"), options);
chart.render();

function revenueAnalytics() {
    chart.updateOptions({
        colors: ["rgba(" + myVarVal + ", 1)", "rgba(35, 183, 229, 0.85)", "rgba(119, 119, 142, 0.05)"],
    });
}
/* Revenue Analytics Chart */

/* Profits Earned Chart */
var options1 = {
    series: [{
        name: 'Profit Earned',
        data: [44, 42, 57, 86, 58, 55, 70],
    }, {
        name: 'Total Sales',
        data: [34, 22, 37, 56, 21, 35, 60],
    }],
    chart: {
        type: 'bar',
        height: 180,
        toolbar: {
            show: false,
        }
    },
    grid: {
        borderColor: '#f1f1f1',
        strokeDashArray: 3
    },
    colors: ["rgb(132, 90, 223)", "#e4e7ed"],
    plotOptions: {
        bar: {
            colors: {
                ranges: [{
                    from: -100,
                    to: -46,
                    color: '#ebeff5'
                }, {
                    from: -45,
                    to: 0,
                    color: '#ebeff5'
                }]
            },
            columnWidth: '60%',
            borderRadius: 5,
        }
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        show: true,
        width: 2,
        colors: undefined,
    },
    legend: {
        show: false,
        position: 'top',
    },
    yaxis: {
        title: {
            style: {
                color: '#adb5be',
                fontSize: '13px',
                fontFamily: 'poppins, sans-serif',
                fontWeight: 600,
                cssClass: 'apexcharts-yaxis-label',
            },
        },
        labels: {
            formatter: function (y) {
                return y.toFixed(0) + "";
            }
        }
    },
    xaxis: {
        type: 'week',
        categories: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
        axisBorder: {
            show: true,
            color: 'rgba(119, 119, 142, 0.05)',
            offsetX: 0,
            offsetY: 0,
        },
        axisTicks: {
            show: true,
            borderType: 'solid',
            color: 'rgba(119, 119, 142, 0.05)',
            width: 6,
            offsetX: 0,
            offsetY: 0
        },
        labels: {
            rotate: -90
        }
    }
};
// document.getElementById('crm-profits-earned').innerHTML = '';
// var chart1 = new ApexCharts(document.querySelector("#crm-profits-earned"), options1);
// chart1.render();

function crmProfitsearned() {
    chart1.updateOptions({
        colors: ["rgba(" + myVarVal + ", 1)", "#ededed"],
    });
}
/* Profits Earned Chart */

/* Leads By Source Chart */
Chart.defaults.elements.arc.borderWidth = 0;
Chart.defaults.datasets.doughnut.cutout = '85%';
var chartInstance = new Chart(document.getElementById("leads-source"), {
    type: 'doughnut',
    data: {
        datasets: [{
            label: 'My First Dataset',
            data: [32, 27, 25, 16],
            backgroundColor: [
                'rgb(132, 90, 223)',
                'rgb(35, 183, 229)',
                'rgb(38, 191, 148)',
                'rgb(245, 184, 73)',
            ]
        }]
    },
    plugins: [{
        afterUpdate: function (chart) {
            const arcs = chart.getDatasetMeta(0).data;

            arcs.forEach(function (arc) {
                arc.round = {
                    x: (chart.chartArea.left + chart.chartArea.right) / 2,
                    y: (chart.chartArea.top + chart.chartArea.bottom) / 2,
                    radius: (arc.outerRadius + arc.innerRadius) / 2,
                    thickness: (arc.outerRadius - arc.innerRadius) / 2,
                    backgroundColor: arc.options.backgroundColor
                }
            });
        },
        afterDraw: (chart) => {
            const {
                ctx,
                canvas
            } = chart;

            chart.getDatasetMeta(0).data.forEach(arc => {
                const startAngle = Math.PI / 2 - arc.startAngle;
                const endAngle = Math.PI / 2 - arc.endAngle;

                ctx.save();
                ctx.translate(arc.round.x, arc.round.y);
                ctx.fillStyle = arc.options.backgroundColor;
                ctx.beginPath();
                ctx.arc(arc.round.radius * Math.sin(endAngle), arc.round.radius * Math.cos(endAngle), arc.round.thickness, 0, 2 * Math.PI);
                ctx.closePath();
                ctx.fill();
                ctx.restore();
            });
        }
    }]
});

function leads(myVarVal) {

    chartInstance.data.datasets[0] = {
        label: 'My First Dataset',
        data: [32, 27, 25, 16],
        backgroundColor: [
            `rgb(${myVarVal})`,
            'rgb(35, 183, 229)',
            'rgb(245, 184, 73)',
            'rgb(38, 191, 148)',
        ]
    }
    chartInstance.update();

}
/* Leads By Source Chart */


