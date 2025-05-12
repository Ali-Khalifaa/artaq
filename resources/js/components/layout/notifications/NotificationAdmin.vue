<template>


    <div class="header-element notifications-dropdown">
        <!-- Start::header-link|dropdown-toggle -->
        <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
            <i class="bx bx-bell header-link-icon"></i>
            <span v-if="count" class="badge bg-secondary rounded-pill header-icon-badge pulse pulse-secondary" id="notification-icon-badge">{{ count }}</span>
        </a>
        <!-- End::header-link|dropdown-toggle -->
        <!-- Start::main-header-dropdown -->
        <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
            <div class="p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="mb-0 fs-17 fw-semibold">{{ $t("notification.notifications")}}</p>
                    <span class="badge bg-secondary-transparent" id="notifiation-data">{{ count }} {{$t('notification.unRead')}}</span>
                </div>
            </div>
            <div class="dropdown-divider"></div>
            <template v-if="count">
                <ul class="list-unstyled mb-0 overflow-scroll" id="header-notification-scroll">
                    <li class="dropdown-item" :key="index" v-for="(notification, index) in notifications">
                        <div class="d-flex align-items-start" >
                            <div class="pe-2">
                                <span class="avatar avatar-md bg-primary-transparent avatar-rounded">
                                    <img
                                        class="avatar-img rounded-circle"
                                        :src="notification.data.image"
                                        onerror="src='/assets/images/brand-logos/toggle-white.png'"
                                    />
                                </span>
                            </div>
                            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                <div>
                                  <p class="mb-0 fw-semibold" v-if="notification.data.title">
                                        <router-link
                                            :to="{
                                                name: notification.data.page_vue_name,
                                                params: {
                                                  id: notification.data.id,
                                                },
                                              }"
                                        >
                                            {{ notification.data.title}}
                                        </router-link>
                                    </p>
                                    <p class="mb-0 fw-semibold">
                                        <router-link
                                            :to="{
                                                name: notification.data.page_vue_name,
                                                params: {
                                                  id: notification.data.id,
                                                },
                                              }"
                                        >
                                            {{notification.data.message}}
                                        </router-link>
                                    </p>
                                    <span class="text-muted fw-normal fs-12 header-notification-text">{{notification.data.timeDate}}</span>
                                </div>
                                <div>
                                    <a href="javascript:void(0);" @click.prevent="clearItem(notification.id, index)" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-16"></i></a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

            </template>

            <div v-else class="p-5 empty-item1">
                <div class="text-center">
                    <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                        <i class="ri-notification-off-line fs-2"></i>
                    </span>
                    <h6 class="fw-semibold mt-3">{{ $t("notification.NoNewNotifications") }}</h6>
                </div>
            </div>
            <div class="p-3 empty-header-item1 border-top">
                    <div class="d-grid">

                        <router-link
                            class="btn btn-primary"
                            :to="{
                                name: 'notifications',
                              }"
                        >
                            {{ $t("global.view_all_notifications") }}
                        </router-link>


                    </div>
                </div>
        </div>
        <!-- End::main-header-dropdown -->
    </div>
</template>

<script>
import { ref, onMounted, onUnmounted  } from "vue";
import adminApi from "../../../api/adminAxios";
import { useStore } from "vuex";

export default {
  name: "notification",
    created() {

    },
  setup() {
    let notifications = ref([]);
    let count = ref(0);
    const store = useStore();
    const admin = store.state?.authAdmin?.user;

    let notificationNotRead = () => {
      if (admin) {
        adminApi
          .get(`/dashboard/getNotNotRead`)
          .then((res) => {
            notifications.value = res.data.data.notifications;
            count.value = res.data.data.count;
          })
          .catch((err) => {
            console.log(err.response);
          });
      }
    };

    let clearItem = (id, index) => {
      if (admin) {
        adminApi
          .post(`/dashboard/clearItem/${id}`)
          .then((res) => {
            notifications.value.splice(index, index + 1);
            count.value -= 1;
          })
          .catch((err) => {
            console.log(err.response);
          });
      }
    };

    let clearAll = () => {
      if (admin) {
        adminApi
          .post(`/dashboard/getNotNotRead`)
          .then((res) => {
            notifications.value = [];
            count.value = 0;
          })
          .catch((err) => {
            console.log(err.response);
          });
      }
    };

    onMounted(() => {
      notificationNotRead();

      let myHeadernotification = document.getElementById("header-notification-scroll");
      if(myHeadernotification){
            new SimpleBar(myHeadernotification, { autoHide: true })
      }

    });



    return { notifications, count, clearItem, clearAll };
  },
  methods: {
        popupNotification () {
            let admin = this.$store.state?.authAdmin?.user;
            if (admin) {
                window.Echo.private(`App.Models.Admin.${admin.id}`).notification((notification) => {
                    this.notifications.unshift(notification);
                    this.count += 1;
                    VanillaToasts.create({
                        // notification title
                        title:notification.data.title?? this.$t("global.Notification"),

                        // notification message
                        text: notification.data.message ?? this.$t("global.ThereIsANewNotification"),

                        // success, info, warning, error   / optional parameter
                        type: "warning",

                        timeout: 15000,

                        // path to notification icon
                        icon: notification.data.image != "" ? notification.data.image : "/assets/images/brand-logos/toggle-white.png",

                        // topRight, topLeft, topCenter, bottomRight, bottomLeft, bottomCenter
                        positionClass: this.$i18n.locale == "en" ? "topLeft" : "topRight",

                        // auto dismiss after 5000ms
                    });
                });
            }
        }

    },
    mounted() {
        this.popupNotification();
    }
};
</script>

<style scoped>
.notifications .media > .avatar {
  margin: 0 10px !important;
}
</style>
