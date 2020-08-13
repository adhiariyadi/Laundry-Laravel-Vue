<template>
  <div id="wrapper">
    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu" v-if="$route.meta.pageType != 'auth'">
      <button
        type="button"
        class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect"
      >
        <i class="mdi mdi-close"></i>
      </button>
      <div class="left-side-logo d-block d-lg-none">
        <div class="text-center">
          <router-link to="/admin" class="logo">
            <img src="/images/logo.png" height="40" alt="logo" />
          </router-link>
        </div>
      </div>
      <div class="sidebar-inner slimscrollleft">
        <div id="sidebar-menu">
          <ul>
            <li v-if="$auth.check('Admin')">
              <router-link to="/" class="waves-effect">
                <i class="dripicons-home"></i>
                <span>Dashboard</span>
              </router-link>
            </li>
            <li v-if="$auth.check('Admin')">
              <router-link to="/antrian" class="waves-effect">
                <i class="dripicons-clipboard"></i>
                <span>Antrian</span>
              </router-link>
            </li>
            <li v-if="$auth.check('Admin')">
              <router-link to="/room" class="waves-effect">
                <i class="dripicons-store"></i>
                <span>Laundry Room</span>
              </router-link>
            </li>
            <li v-if="$auth.check('Admin')">
              <router-link to="/transaksi/riwayat" class="waves-effect">
                <i class="dripicons-article"></i>
                <span>Riwayat Transaksi</span>
              </router-link>
            </li>
            <li v-if="$auth.check('Admin')">
              <router-link to="/transaksi" class="waves-effect">
                <i class="dripicons-article"></i>
                <span>Semua Transaksi</span>
              </router-link>
            </li>
            <li v-if="$auth.check('Admin')">
              <router-link to="/category" class="waves-effect">
                <i class="dripicons-archive"></i>
                <span>Category</span>
              </router-link>
            </li>
            <li v-if="$auth.check('Admin')">
              <router-link to="/member" class="waves-effect">
                <i class="dripicons-user"></i>
                <span>Member</span>
              </router-link>
            </li>
            <li v-if="$auth.check('Admin')">
              <router-link to="/promo" class="waves-effect">
                <i class="dripicons-tags"></i>
                <span>Promo</span>
              </router-link>
            </li>
            <li v-if="$auth.check('Admin')">
              <router-link to="/pengeluaran" class="waves-effect">
                <i class="dripicons-cart"></i>
                <span>Pengeluaran</span>
              </router-link>
            </li>
            <li v-if="$auth.check('Admin')">
              <router-link to="/laporan" class="waves-effect">
                <i class="dripicons-to-do"></i>
                <span>Laporan Transaksi</span>
              </router-link>
            </li>
            <li v-if="$auth.check('Admin')">
              <router-link to="/kas" class="waves-effect">
                <i class="dripicons-to-do"></i>
                <span>Laporan Kas</span>
              </router-link>
            </li>
            <li v-if="$auth.check('Admin')">
              <router-link to="/setting" class="waves-effect">
                <i class="dripicons-gear"></i>
                <span>Setting</span>
              </router-link>
            </li>
          </ul>
        </div>
        <div class="clearfix"></div>
      </div>
      <!-- end sidebarinner -->
    </div>
    <!-- Left Sidebar End -->
    <!-- Start right Content here -->
    <div :class="$route.meta.pageType == 'auth' ? '' : `content-page`">
      <!-- Start content -->
      <div class="content">
        <!-- Top Bar Start -->
        <Topbar v-if="$route.meta.pageType != 'auth'"></Topbar>
        <!-- Top Bar End -->
        <div
          :class="$route.meta.pageType == 'auth' ? 'vh-100 page-content-wrapper' : 'page-content-wrapper'"
        >
          <transition name="slide-fade">
            <router-view></router-view>
          </transition>
        </div>
        <!-- Page content Wrapper -->
      </div>
      <!-- content -->
      <footer class="footer" v-if="$route.meta.pageType != 'auth'">
        Copyright &copy; 2020
        <div class="bullet"></div>Design By
        <a href="https://github.com/adhiariyadi/">Adhi Ariyadi</a>
      </footer>
    </div>
  </div>
</template>

<script>
import Topbar from "./../components/Topbar";
export default {
  components: {
    Topbar,
  },
};
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.5s ease;
}
.slide-fade-leave-active {
  transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
