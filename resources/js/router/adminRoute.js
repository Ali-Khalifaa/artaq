import {createRouter, createWebHistory} from 'vue-router';
import middlewarePipeline from "./middlewarePipeline";
import AuthLayout from "../layouts/Auth.vue";
import DashboardLayout from "../layouts/Dashboard.vue";
import Login from "../views/admin/auth/Login.vue";
import Page404 from "../views/admin/errors/Page404.vue";
import store from "../store/admin.js";
import auth from "../middleware/admin/auth.js";
import guest from "../middleware/admin/guest";
import admin from "./adminRoute/admin.js";

import banner from "./adminRoute/banner.js";
import country from "./adminRoute/country.js";
import city from "./adminRoute/city.js";
import nationality from "./adminRoute/nationality.js";
import joinUs from "./adminRoute/joinUs.js";
import backup from "./adminRoute/backup.js";
import memorizationAmount from "./adminRoute/memorizationAmount.js";
import memorizationType from "./adminRoute/memorizationType.js";
import setting from "./adminRoute/setting.js";
import level from "./adminRoute/level.js";
import levelTask from "./adminRoute/levelTask.js";
import digitalBadge from "./adminRoute/digitalBadge.js";
import teacherBadge from "./adminRoute/teacherBadge.js";
import student from "./adminRoute/student.js";
import circleTypes from "./adminRoute/circleTypes.js";
import circles from "./adminRoute/circles.js";
import quran from "./adminRoute/quran.js";
import track from "./adminRoute/track.js";

import role from "./adminRoute/role.js";
import Notification from '../views/admin/notification/notification.vue';
import profile from '../views/admin/profile/index.vue';

const routes = [
    {
        path: '/',
        redirect: { name: 'login' },
    },
    {
        path: '/',
        component: DashboardLayout,
        meta: { middleware: [auth] },
        children:[
            {
                path: '',
                redirect: { name: 'Page404' },
            },
            {path: `dashboard`, name: `dashboard`, component: () => import('../views/admin/dashboard/index.vue')},
            {
                path: 'notifications',
                name: 'notifications',
                component: Notification
            },
            {
                path: 'profile',
                name: 'profile',
                component: profile
            },
            ...admin,
            ...role,
            ...country,
            ...city,
            ...banner,
            ...joinUs,
            ...backup,
            ...memorizationAmount,
            ...memorizationType,
            ...setting,
            ...level,
            ...levelTask,
            ...digitalBadge,
            ...teacherBadge,
            ...nationality,
            ...student,
            ...circleTypes,
            ...circles,
            ...quran,
            ...track,
        ]
    },
    {
        path: '/login',
        component: AuthLayout,
        children:[
            {
                path: '',
                name: 'login',
                component: Login,
                meta: {middleware: [guest]}
            },
        ]
    },

    // {
    //     path: 'forget-password',
    //     name: 'forgetPassword',
    //     component: forgetPassword,
    //     meta: {
    //         middleware: [guest]
    //     }
    // },
    // {
    //     path: 'reset-password',
    //     name: 'resetPassword',
    //     component: resetPassword,
    //     meta: {
    //         middleware: [guest]
    //     }
    // },

    {
        path: '/:pathMatch(.*)*',
        name: 'Page404',
        component: Page404
    },
];

const router = createRouter({
    history: createWebHistory(),
    linkExactActiveClass: 'active',
    routes
});


router.beforeEach((to, from, next) => {

    if (!to.meta.middleware) return next();
    const middleware = to.meta.middleware;
    const context = {
        to,
        from,
        next,
        store
    };
    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1)
    });
});

export default router;
