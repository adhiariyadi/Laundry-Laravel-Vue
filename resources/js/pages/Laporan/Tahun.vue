<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h4 class="page-title m-0">Laporan Transaksi</h4>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
        <!-- end page-title-box -->
      </div>
    </div>
    <!-- end page title -->

    <div class="row">
      <div class="col-xl-12">
        <div class="card m-b-30">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-8">
                <h4 class="mt-0 header-title">List All Laporan Transaksi</h4>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-lg" id="promo-table">
                <thead>
                  <tr>
                    <th>Tahun</th>
                    <th>Transaksi Masuk</th>
                    <th>Transaksi Keluar</th>
                    <th>Pendapatan</th>
                    <th>Pengeluaran</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="year in years" v-bind:key="year.id">
                    <td>{{ year.value }}</td>
                    <td>{{ year.masuk }}</td>
                    <td>{{ year.keluar }}</td>
                    <td>Rp. {{ formatPrice(year.pendapatan) }}</td>
                    <td>Rp. {{ formatPrice(year.pengeluaran) }}</td>
                    <td>
                      <router-link
                        :to="{path: `/laporan/${year.value}`}"
                        class="btn btn-info btn-sm btn-icon icon-left"
                      >
                        <i class="fas fa-search-plus mr-1"></i>
                        Detail
                      </router-link>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <nav aria-label="Page navigation example" class="float-right">
              <ul class="pagination">
                <li class="page-item">
                  <button
                    class="page-link"
                    href="#"
                    v-if="this.current_page !== this.first_page"
                    @click="prevPage"
                  >Previous</button>
                </li>
                <li class="page-item">
                  <button class="page-link" href="#">{{ this.current_page }}</button>
                </li>
                <li class="page-item">
                  <button
                    class="page-link"
                    href="#"
                    @click="nextPage"
                    v-if="this.current_page !== this.last_page"
                  >Next</button>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </div>
  <!-- container fluid -->
</template>

<script>
export default {
  mounted() {
    this.displayData(this.page);
  },
  data() {
    return {
      years: [],
      first_page: 1,
      page: 1,
      last_page: null,
      current_page: this.$route.query.page || 1,
      next_page_url: "",
      prev_page_url: "",
    };
  },
  methods: {
    displayData(page) {
      this.$http({
        url: "/api/v1/tahun",
        method: "GET",
        params: { page: page },
      }).then((result) => {
        this.years = result.data.data;
        this.last_page = result.data.meta.last_page;
        this.current_page = result.data.meta.current_page;
        this.next_page_url = result.data.links.next;
        this.prev_page_url = result.data.links.prev;
      });
    },
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    nextPage() {
      let nextPage = this.current_page + 1;
      window.history.replaceState(null, null, "?page=" + nextPage);
      this.displayData(thinextPage, this.search);
    },
    prevPage() {
      let prevPage = this.current_page - 1;
      window.history.replaceState(null, null, "?page=" + prevPage);
      this.displayData(prevPage, this.search);
    },
  },
};
</script>
