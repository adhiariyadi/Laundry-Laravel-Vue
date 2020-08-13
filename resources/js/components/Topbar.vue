<template>
  <div class="topbar">
    <div class="topbar-left d-none d-lg-block">
      <div class="text-center">
        <a href="/admin" class="logo">
          <img src="/images/logo.png" height="40" alt="logo" />
        </a>
      </div>
    </div>
    <nav class="navbar-custom">
      <ul class="list-inline float-right mb-0">
        <li class="list-inline-item dropdown notification-list nav-user">
          <a
            class="nav-link dropdown-toggle arrow-none waves-effect"
            data-toggle="dropdown"
            href="#"
            role="button"
            aria-haspopup="false"
            aria-expanded="false"
          >
            <img :src="`${$auth.user().image}`" alt="user" class="rounded-circle object-fit-cover" />
            <span class="d-none d-md-inline-block ml-1">
              {{ $auth.user().name }}
              <i class="mdi mdi-chevron-down"></i>
            </span>
          </a>
          <div
            class="dropdown-menu dropdown-menu-right shadow dropdown-menu-animated profile-dropdown"
          >
            <a class="dropdown-item text-danger" href="#" @click.prevent="logout()">
              <i class="dripicons-exit"></i> Logout
            </a>
          </div>
        </li>
      </ul>
      <ul class="list-inline menu-left mb-0">
        <li class="list-inline-item">
          <button type="button" class="button-menu-mobile open-left waves-effect">
            <i class="mdi mdi-menu"></i>
          </button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  mounted() {},

  methods: {
    logout() {
      alertify.success("Success Logout!");
      this.$auth.logout();
    },
  },
};
</script>

<style>
.object-fit-cover {
  object-fit: cover;
}
</style>
