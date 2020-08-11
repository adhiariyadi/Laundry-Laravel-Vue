<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h4 class="page-title m-0">Pengeluaran</h4>
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
                <h4 class="mt-0 header-title">List All Pengeluaran</h4>
              </div>
              <div class="col-4">
                <div class="float-right d-none d-md-block">
                  <div class="dropdown">
                    <button
                      class="btn btn-primary"
                      type="button"
                      data-toggle="modal"
                      data-target="#modalAdd"
                    >
                      <i class="ti-plus mr-1"></i> Add
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-lg" id="pengeluaran-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Waktu</th>
                    <th>Description</th>
                    <th>Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(pengeluaran, index) in pengeluarans" v-bind:key="pengeluaran.id">
                    <td>{{ index+1 }}</td>
                    <td>{{ pengeluaran.created_at }}</td>
                    <td>{{ pengeluaran.description }}</td>
                    <td>Rp. {{ formatPrice(pengeluaran.jumlah) }}</td>
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
    <!-- Modal -->
    <div
      class="modal fade"
      id="modalAdd"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Pengeluaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action method="POST" @submit.prevent="addPengeluaran">
            <div class="modal-body">
              <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                  <li v-for="error in errors" v-bind:key="error.id">{{ error[0] }}</li>
                </ul>
              </div>
              <div class="form-group">
                <label>Description:</label>
                <textarea name="description" class="form-control" v-model="add.description"></textarea>
              </div>
              <div class="form-group">
                <label>Jumlah:</label>
                <input type="number" name="jumlah" class="form-control" v-model="add.jumlah" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" :disabled="addLoading == true">
                <span
                  class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"
                  v-if="addLoading == true"
                ></span>
                Add
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- container fluid -->
</template>

<script>
export default {
  mounted() {
    this.displayData(this.page, this.search);
  },
  data() {
    return {
      add: {
        description: "",
        jumlah: "",
      },
      pengeluarans: [],
      errors: [],
      addLoading: false,
      first_page: 1,
      page: 1,
      search: "",
      last_page: null,
      current_page: this.$route.query.page || 1,
      next_page_url: "",
      prev_page_url: "",
    };
  },
  methods: {
    displayData(page = 1, search = "") {
      this.$http({
        url: "/api/v1/pengeluaran",
        method: "GET",
        params: { search: this.search, page: this.page },
      }).then((result) => {
        this.pengeluarans = result.data.data;
        this.last_page = result.data.meta.last_page;
        this.current_page = result.data.meta.current_page;
        this.next_page_url = result.data.links.next;
        this.prev_page_url = result.data.links.prev;
      });
    },
    addPengeluaran() {
      this.addLoading = true;
      const formData = new FormData();
      formData.append("description", this.add.description);
      formData.append("jumlah", this.add.jumlah);
      axios
        .post("/api/v1/pengeluaran", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((res) => {
          this.addLoading = false;
          this.errors = [];
          $("#modalAdd").modal("toggle");
          alertify.success("Success Add Pengeluaran!");
          this.displayData();
          this.add.description = "";
          this.add.jumlah = "";
        })
        .catch((error) => {
          this.addLoading = false;
          let statusCode = error.response.status;
          if (statusCode == 500) {
            this.errors = { error: "Terjadi kesalahan sistem." };
          } else if (statusCode == 400) {
            this.errors = error.response.data.errors;
          }
        });
    },
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    nextPage() {
      let nextPage = this.current_page + 1;
      window.history.replaceState(null, null, "?page=" + nextPage);
      this.displayData(this.current_page + 1, this.search);
    },
    prevPage() {
      let prevPage = this.current_page - 1;
      window.history.replaceState(null, null, "?page=" + prevPage);
      this.displayData(prevPage, this.search);
    },
  },
};
</script>
