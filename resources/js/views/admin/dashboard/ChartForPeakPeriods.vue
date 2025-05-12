<script>
export default {
    props: ['peak_periods'],
    data() {
        return {
            options: {
                series: [],
                chart: {
                    height: 380,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false,
                    style: {
                        fontSize: '20px',
                        fontWeight: 'bold',
                        colors: ['#000']
                    }
                },
                colors: ['#000'],

                stroke: {
                    curve: 'straight'
                },
                title: {
                    align: 'left'
                },
                yaxis: [
                    {
                        axisTicks: {
                            show: true
                        },
                        axisBorder: {
                            show: true,
                            color: "#000"
                        },
                        labels: {
                            style: {
                                colors: "#000"
                            }
                        },
                        title: {
                            text: this.$t('global.number_of_bookings'),
                            style: {
                                color: "#000"
                            }
                        },
                    },
                   
                ],
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: [],
                }
            }
        };
    },
    watch: {
        peak_periods: {
            handler(newV, old) {
                setTimeout(() => {
                    let data = []
                    this.peak_periods.forEach((element) => {
                        this.options.xaxis.categories.push(element.period)
                        data.push(element.count)

                    })
                      
                    this.options.series = [
                        { name: this.$t('global.number_of_bookings'), data },
                    ]
                    document.getElementById("peak-periods").innerHTML = '';
                    var chart1 = new ApexCharts(document.querySelector("#peak-periods"), this.options);
                    chart1.render();
                }, 500)
            }
        }
    }
};
</script>

<template>
   <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">{{$t('global.peak_periods')}}</div>
            </div>
            <div class="card-body">
                <div id="peak-periods"></div>
            </div>
        </div>
    </div>
</template>
