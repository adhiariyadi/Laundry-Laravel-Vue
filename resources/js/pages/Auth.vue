<template>
  <div class="container mt-5">
    <div class="row align-items-center">
      <div class="col-lg-6 mx-auto">
        <div class="card mb-0">
          <div class="card-body">
            <div class="brand-logo" style="text-align:center;">
              <img src="images/logo_login.png" alt="logo" style="width:200px; " />
              <h4 class="text-muted" style="font-weight:bold;">Aplikasi Laundry</h4>
              <h6 class="text-muted" style="font-weight:light;">Harap masuk untuk melanjutkan.</h6>
            </div>
            <div class="p-2">
              <form class="form-horizontal m-t-20" @submit.prevent="login()">
                <div class="form-group row">
                  <div class="col-12">
                    <input
                      class="form-control"
                      type="text"
                      required
                      placeholder="Username"
                      v-model="auth.username"
                    />
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-12">
                    <input
                      class="form-control"
                      type="password"
                      required
                      placeholder="Password"
                      v-model="auth.password"
                    />
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-12">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck1" />
                      <label class="custom-control-label" for="customCheck1">Remember me</label>
                    </div>
                  </div>
                </div>

                <div class="form-group text-center row m-t-20">
                  <div class="col-12">
                    <button
                      class="btn btn-primary btn-block waves-effect waves-light"
                      :disabled="button_loading == true"
                      type="submit"
                    >
                      <span
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"
                        v-if="button_loading == true"
                      ></span>
                      Login
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </div>
</template>
<script>
export default {
  mounted() {},

  data() {
    return {
      auth: {
        username: "",
        password: "",
      },
      button_loading: false,
    };
  },

  methods: {
    login() {
      this.button_loading = true;
      var redirect = this.$auth.redirect();
      var app = this;
      this.$auth.login({
        data: {
          username: app.auth.username,
          password: app.auth.password,
        },
        success: function () {
          alertify.success("Success Login!");
          app.button_loading = true;
          setTimeout(() => {
            this.$router.push("/");
          }, 1000);
        },
        error: function () {
          app.button_loading = false;
          alertify.error("Username atau password salah!");
        },
        rememberMe: true,
        fetchUser: true,
      });
    },
  },
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
