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

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import "es6-promise/auto";
import moment from "moment";
import auth from "./auth";
import VueAuth from "@websanova/vue-auth";
import VueAxios from "vue-axios";

import Home from "./pages/Admin/Home.vue";
import Antrian from "./pages/Admin/Antrian/Index.vue";
import Room from "./pages/Admin/Room/Index.vue";
import DetailRoom from "./pages/Admin/Room/Detail.vue";
import Category from "./pages/Admin/Category/Index.vue";
import Member from "./pages/Admin/Member/Index.vue";
import Promo from "./pages/Admin/Promo/Index.vue";

import Login from "./pages/Auth.vue";

Vue.component("app", require("./pages/App.vue").default);
Vue.component("auth-page", require("./pages/Auth.vue").default);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
moment.locale("id");
let numberFormat = function(value) {
    let val = (value / 1).toFixed(0).replace(".", ",");
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};
Vue.prototype.moment = moment;
Vue.prototype.numberFormat = numberFormat;

const router = new VueRouter({
    mode: "history",
    routes: [
        { path: "/", component: Home, meta: { auth: true } },
        { path: "/antrian", component: Antrian, meta: { auth: true } },
        { path: "/room", component: Room, meta: { auth: true } },
        { path: "/room/:room_id", component: DetailRoom, meta: { auth: true } },
        { path: "/category", component: Category, meta: { auth: true } },
        { path: "/member", component: Member, meta: { auth: true } },
        { path: "/promo", component: Promo, meta: { auth: true } },
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
