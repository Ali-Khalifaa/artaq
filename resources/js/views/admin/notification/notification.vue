<template>
    <div class="container-fluid" @scroll="handleScroll">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.notifications') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{ name: 'dashboard' }">{{ $t('global.home')
                                }}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.notifications') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row" @scroll="handleScroll">
            <div class="col-12" @scroll="handleScroll">
                <div class="card" @scroll="handleScroll">
                    <div class="card-body" @scroll="handleScroll">

                        <div class="row justify-content-center align-items-center mt-2 mb-2 px-1"
                            @scroll="handleScroll">
                            <div class="col-md-8">
                                <div class="notify position-relative">
                                    <!--       start loader       -->
                                    <loader size="large" v-if="loading" />
                                    <!--       end loader       -->
                                    <p class=" p-3 my-5">
                                    <h5 class="m-0 d-flex justify-content-between">


                                        {{ $t("global.notifications") }}
                                        <button class="btn btn-danger btn-sm" @click.prevent="clearAll"> {{
                                            $t("global.clear_all_notifications") }}</button>
                                    </h5>
                                    </p>

                                    <template v-for="(notification, index) in notifications" :key="index">
                                        <router-link
                                            :to="{ name: notification.data.page_vue_name, params: { id: notification.data.id, notification_data: notification.data.data } }"
                                            :class="['dropdown-item', 'notify-item', !notification.read_at ? 'not_readed mb-1' : '']">
                                            <div class="d-flex" @click="clearItem(notification.id, index)">
                                                <div class="notify-icon bg-soft-primary text-primary mx-2">
                                                    <div class="pe-2">
                                                        <span
                                                            class="avatar avatar-md bg-primary-transparent avatar-rounded">
                                                            <img class="avatar-img rounded-circle"
                                                                :src="notification.data.image"
                                                                onerror="src='/assets/images/brand-logos/toggle-white.png'" />
                                                        </span>
                                                    </div>
                                                </div>

                                                <p class="notify-details pt-2 text-start">
                                                    <span  v-if="notification.data.title">
                                                        {{ notification.data.title }}
                                                    </span>
                                                    <br />
                                                    <span >
                                                        {{  notification.data.message }}
                                                    </span>

                                                    <br />

                                                    <small class="text-muted">{{
                                                        notification.data.timeDate
                                                        }}
                                                    </small>
                                                </p>
                                            </div>
                                        </router-link>
                                    </template>

                                    <div id="scrollToMe" class="d-none"></div>
                                </div>
                                <loader size="small" v-if="isLoading" />

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import adminApi from "../../../api/adminAxios";
export default {
    name: "notification",
    data() {
        return {
            notifications: [],
            count: 0,
            skip: 0,
            loadingMore: true,
            loading: false,
            isLoading: false,
            observerOptions: {
                root: null,
                rootMargin: '0px',
                threshold: 0.5,
            },
        }
    },
    // updated() {
    //     this.notificationNotReadScroll();
    // },
    mounted() {
        this.notificationNotRead();
        let obj = this
        $(window).scroll(function () {
            if (parseInt($(window).scrollTop()) + 2 >= parseInt($(document).height() - $(window).height()) && obj.loadingMore && obj.isLoading == false) {
                obj.notificationNotReadScroll();
            }
        });

    },
    methods: {
        notificationNotReadScroll() {
            this.isLoading = true;

            adminApi.get(`/dashboard/getAllNot?skip=${this.skip}`)
                .then((res) => {
                    if (res.data.data.notifications.length > 0) {
                        res.data.data.notifications.forEach(el => {
                            this.notifications.push(el);
                        });
                        this.skip += this.skip;
                    } else {
                        this.loadingMore = false;
                    }

                })
                .catch((err) => {
                    console.log(err.response);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        clearItem(id) {
            adminApi.post(`/dashboard/clearItem/${id}`)
                .then((res) => {
                })
                .catch((err) => {
                    console.log(err.response);
                })
        },
        clearAll() {
            this.loading = true;
            adminApi.post(`/dashboard/getNotNotRead`)
                .then((res) => {
                    this.notificationNotRead();
                    // this.$store.commit('auth/editNotification',!this.$store.state.auth.notification);
                })
                .catch((err) => {
                    console.log(err.response);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        notificationNotRead() {
            this.loading = true;
            if (this.$store.state?.authAdmin?.user) {
                adminApi.get(`/dashboard/getAllNot`)
                    .then((res) => {
                        this.notifications = res.data.data.notifications;
                        this.count = res.data.data.count;
                        this.skip = 15;
                    })
                    .catch((err) => {
                        console.log(err.response);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            }
        },



        handleScroll(event) {
            const element = event.target;

            if (parseInt(element.scrollHeight - element.scrollTop) <= parseInt(element.clientHeight)) {

                this.notificationNotReadScroll();

            }
        },
    }
}
</script>

<style scoped>
.notify {
    padding: 5px 10px 10px;
    box-shadow: 0 0 8px 0 rgb(154 161 171 / 30%);
    margin: 0.125rem 0 0;
    font-size: 0.9rem;
    color: #6c757d;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 0 solid #e7eef1;
    border-radius: 0.25rem;
}

.notify-item {
    padding: 15px 20px;
    display: block;
    width: 100%;
    clear: both;
    font-weight: 400;
    color: #6c757d;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
}

.notify-item.active {
    color: #272e37;
    text-decoration: none;
    background-color: #f1f5f7;
}

.notify-item .notify-icon {
    height: 36px;
    width: 36px;
    font-size: 18px;
    line-height: 38px;
    text-align: center;
    margin-right: 10px;
    border-radius: 50%;
    color: #fff;
}

.notify-item .notify-details {
    margin-bottom: 5px;
    overflow: hidden;
    margin-left: 45px;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #343a40;
}

.notify-item:hover,
.notify-item:focus {
    color: #272e37;
    text-decoration: none;
    background-color: #f1f5f7;
}




.rtl .notify {
    padding: 5px 10px 10px;
    box-shadow: 0 0 8px 0 rgb(154 161 171 / 30%);
    margin: 0.125rem 0 0;
    font-size: 0.9rem;
    color: #6c757d;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 0 solid #e7eef1;
    border-radius: 0.25rem;
}

.rtl .notify-item {
    padding: 15px 20px;
    display: block;
    width: 100%;
    clear: both;
    font-weight: 400;
    color: #6c757d;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
}

.rtl .notify-item.active {
    color: #272e37;
    text-decoration: none;
    background-color: #f1f5f7;
}

.rtl .notify-item .notify-icon {
    height: 36px;
    width: 36px;
    font-size: 18px;
    line-height: 38px;
    text-align: center;
    margin-left: 10px;
    border-radius: 50%;
    color: #fff;
}

.rtl .notify-item .notify-details {
    margin-bottom: 5px;
    overflow: hidden;
    margin-right: 45px;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #343a40;
}

.rtl .notify-item:hover,
.notify-item:focus {
    color: #272e37;
    text-decoration: none;
    background-color: #f1f5f7;
}

.not_readed {
    color: #272e37;
    text-decoration: none;
    background-color: #f1f5f7;
    border-radius: 12px
}
</style>
