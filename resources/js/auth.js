import bearer from "@websanova/vue-auth/drivers/auth/bearer";
import axios from "@websanova/vue-auth/drivers/http/axios.1.x";
import router from "@websanova/vue-auth/drivers/router/vue-router.2.x";
/**
 * Authentication configuration, some of the options can be override in method calls
 */
const config = {
    auth: bearer,
    http: axios,
    router: router,
    tokenDefaultName: "laravel-jwt-auth",
    tokenStore: ["localStorage"],
    rolesVar: "level",

    // API endpoints used in Vue Auth.
    loginData: {
        url: "/api/v1/login",
        method: "POST",
        redirect: "",
        fetchUser: true
    },
    logoutData: {
        url: "/api/v1/logout",
        method: "POST",
        redirect: "/login",
        makeRequest: true
    },
    fetchData: {
        url: "/api/v1/user",
        method: "GET",
        enabled: true
    }
};
export default config;
