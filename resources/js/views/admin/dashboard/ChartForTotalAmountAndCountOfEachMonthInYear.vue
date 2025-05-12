<script>
export default {
    props: ['total_amount_for_each_month_in_year','total_count_for_each_month_in_year'],
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
                        colors: ['#1421b9']
                    }
                },
                colors: ['#1421b9', '#FF1654'],

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
                            color: "#1421b9"
                        },
                        labels: {
                            style: {
                                colors: "#1421b9"
                            }
                        },
                        title: {
                            text: this.$t('global.amount'),
                            style: {
                                color: "#1421b9"
                            }
                        },
                    },
                    {
                        opposite: true,
                        axisTicks: {
                            show: true
                        },
                        axisBorder: {
                            show: true,
                            color: "#FF1654"
                        },
                        labels: {
                            style: {
                                colors: "#FF1654"
                            }
                        },
                        title: {
                            text: this.$t('global.number_of_bookings'),
                            style: {
                                color: "#FF1654"
                            }
                        },
                    }
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
        total_amount_for_each_month_in_year: {
            handler(newV, old) {
                setTimeout(() => {
                    let monthTrans= [this.$t('global.january'), this.$t('global.february'), this.$t('global.march'), this.$t('global.april'), this.$t('global.may'), this.$t('global.june'), this.$t('global.july'), this.$t('global.august'), this.$t('global.september'), this.$t('global.october'), this.$t('global.november'), this.$t('global.december')];
                    monthTrans.forEach((elemnt) => {
                        this.options.xaxis.categories.push(elemnt)
                    })
                    let monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    let data_amount = []
                    let data_bookings = []
                    monthNames.forEach((month) => {
                        let check_exists = 0
                        this.total_amount_for_each_month_in_year.forEach(element => {
                            if (element.month.trim() == month) {
                                check_exists = 1
                                data_amount.push(element.total_amount + " " + this.$t('global.sar'))
                            }
                        });
                        if (check_exists == 0)
                            data_amount.push(0)
                        check_exists = 0


                        this.total_count_for_each_month_in_year.forEach(element => {
                            if (element.month.trim() == month) {
                                check_exists = 1
                                data_bookings.push(element.total_count)
                            }
                        });
                        if (check_exists == 0)
                            data_bookings.push(0)
                        check_exists = 0


                    })
                    this.options.series = [
                        { name: this.$t('global.amount'), data: data_amount },
                        { name: this.$t('global.number_of_bookings'), data: data_bookings },
                    ]


                    document.getElementById("total-amount-for-each-month-in-the-year").innerHTML = '';
                    var chart1 = new ApexCharts(document.querySelector("#total-amount-for-each-month-in-the-year"), this.options);
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
                <div class="card-title">{{$t('global.total_revenue_and_count_of_bookings_for_each_month_in_the_year')}}</div>
            </div>
            <div class="card-body">
                <div id="total-amount-for-each-month-in-the-year"></div>
            </div>
        </div>
    </div>
</template>
