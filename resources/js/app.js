/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
import VueRouter from "vue-router";
window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

import "es6-promise/auto";
import moment from "moment";
import auth from "./auth";
import VueAuth from "@websanova/vue-auth";
import VueAxios from "vue-axios";

import Home from "./pages/Home.vue";
import Antrian from "./pages/Antrian/Index.vue";
import Room from "./pages/Room/Index.vue";
import DetailRoom from "./pages/Room/Detail.vue";
import BayarRoom from "./pages/Room/Bayar.vue";
import Category from "./pages/Category/Index.vue";
import Member from "./pages/Member/Index.vue";
import Promo from "./pages/Promo/Index.vue";
import User from "./pages/User/Index.vue";
import Transaksi from "./pages/Transaksi/Index.vue";
import Riwayat from "./pages/Transaksi/History.vue";
import Invoice from "./pages/Transaksi/Invoice.vue";
import Pengeluaran from "./pages/Pengeluaran/Index.vue";
import Tahun from "./pages/Laporan/Tahun.vue";
import Bulan from "./pages/Laporan/Bulan.vue";
import Tanggal from "./pages/Laporan/Tanggal.vue";
import Detail from "./pages/Laporan/Detail.vue";
import Kas from "./pages/Laporan/Kas.vue";
import Setting from "./pages/Setting/Index.vue";

import Login from "./pages/Auth.vue";

Vue.component("app", require("./pages/App.vue").default);
Vue.component("auth-page", require("./pages/Auth.vue").default);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
moment.locale("id");
Vue.prototype.moment = moment;

const router = new VueRouter({
    mode: "history",
    routes: [
        { path: "/", component: Home, meta: { auth: true } },
        { path: "/antrian", component: Antrian, meta: { auth: true } },
        { path: "/room", component: Room, meta: { auth: true } },
        { path: "/room/:id", component: DetailRoom, meta: { auth: true } },
        { path: "/bayar/:id", component: BayarRoom, meta: { auth: true } },
        { path: "/category", component: Category, meta: { auth: true } },
        { path: "/member", component: Member, meta: { auth: true } },
        { path: "/promo", component: Promo, meta: { auth: true } },
        { path: "/user", component: User, meta: { auth: true } },
        { path: "/transaksi", component: Transaksi, meta: { auth: true } },
        {
            path: "/transaksi/riwayat",
            component: Riwayat,
            meta: { auth: true }
        },
        {
            path: "/transaksi/:invoice",
            component: Invoice,
            meta: { auth: true }
        },
        { path: "/pengeluaran", component: Pengeluaran, meta: { auth: true } },
        { path: "/laporan", component: Tahun, meta: { auth: true } },
        {
            path: "/laporan/:tahun",
            component: Bulan,
            meta: { auth: true }
        },
        {
            path: "/laporan/:tahun/:bulan",
            component: Tanggal,
            meta: { auth: true }
        },
        {
            path: "/laporan/:tahun/:bulan/:tanggal",
            component: Detail,
            meta: { auth: true }
        },
        { path: "/kas", component: Kas, meta: { auth: true } },
        { path: "/setting", component: Setting, meta: { auth: true } },
        {
            path: "/login",
            component: Login,
            meta: { auth: false, pageType: "auth" }
        }
    ]
});

Vue.router = router;

Vue.use(VueAuth, auth);

const app = new Vue({
    el: "#app",
    router
});
