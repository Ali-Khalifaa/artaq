<template>
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">{{title}}</div>
                
            </div>
            <div class="card-body py-0 ps-0">
                <div :id="id"></div>
            </div>
        </div>
    </div>
</template>


<script>

export default {
    name: "current_month_and_last_month_devided_weeks",
    props: ['currentMonth','lastMonth','id','title'],
    data() {
        return {
            option:{
                series: [],
                chart: {
                    type: 'bar',
                    height: 300,
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
                    categories: [this.$t("global.first_week"), this.$t('global.second_week'), this.$t('global.third_week'), this.$t('global.fourth_week'), this.$t('global.fifth_week')],
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
            }
        };
    },


    watch: {
        currentMonth: {
            handler(newV, old) {
               
                setTimeout(() => {
                    let weeks = ['First Week', 'Second Week', 'Third Week', 'Fourth Week', 'Fifth Week'];
                    let current = []
                    let last = []
                    weeks.forEach((week) => {
                        let check_exists = 0
                        this.currentMonth.forEach(element => {
                            if (element.week == week) {
                                check_exists = 1
                                current.push(element.number)
                            }
                        });
                        if (check_exists == 0)
                            current.push(0)
                        check_exists = 0

                        this.lastMonth.forEach(element => {
                            if (element.week == week) {
                                check_exists = 1
                                last.push(element.number)
                            }
                        });
                        if (check_exists == 0)
                            last.push(0)

                    })
                    this.option.series = [
                        { data: current, name: this.$t("global.current_month"), },
                        { data: last, name: this.$t("global.last_month") }
                    ]

                    document.getElementById(this.id).innerHTML = '';
                    var chart1 = new ApexCharts(document.querySelector("#"+this.id), this.option);
                    chart1.render();


                }, 500)
            }
        }
    }
}

</script>