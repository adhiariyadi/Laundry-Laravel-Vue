<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h4 class="page-title m-0">Antrian</h4>
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
                <h4 class="mt-0 header-title">List All Antrian</h4>
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
              <table class="table table-hover table-lg" id="Antrian-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama Member</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Total Harga</th>
                    <th>Status Pembayaran</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(antrian, index) in antrians" v-bind:key="antrian.id">
                    <td>{{ index+1 }}</td>
                    <td>
                      {{
                      antrian.member === undefined
                      ? "Deleted"
                      : antrian.member.name
                      }}
                    </td>
                    <td>
                      <h6>
                        <span class="badge badge-secondary p-2" v-if="antrian.status == 'hold'">
                          <i class="fas fa-upload"></i>
                          {{ antrian.status }}
                        </span>
                        <span class="badge badge-info p-2" v-if="antrian.status == 'cuci'">
                          <i class="fas fa-tshirt"></i>
                          {{ antrian.status }}
                        </span>
                        <span class="badge badge-success p-2" v-if="antrian.status == 'selesai'">
                          <i class="fas fa-check-circle"></i>
                          {{ antrian.status }}
                        </span>
                      </h6>
                    </td>
                    <td>
                      Masuk :
                      <b>{{ antrian.created_at }}</b>
                      <br />Selesai :
                      <b>{{ antrian.selesai ? antrian.selesai : "-" }}</b>
                      <br />Diambil :
                      <b>{{ antrian.ambil ? antrian.ambil : "-" }}</b>
                    </td>
                    <td>Rp. 0</td>
                    <td>
                      <h6>
                        <span
                          class="badge badge-warning p-2"
                          v-if="antrian.pembayaran === 'pending'"
                        >
                          <i class="fas fa-circle"></i>
                          Belum bayar
                        </span>
                        <span class="badge badge-success p-2" v-else>
                          <i class="fas fa-circle"></i>
                          Sudah bayar
                        </span>
                        <br />
                        <br />
                        <span class="badge badge-warning p-2" v-if="antrian.ambil === null">
                          <i class="fas fa-circle"></i>
                          Belum diambil
                        </span>
                        <span class="badge badge-success p-2" v-else>
                          <i class="fas fa-circle"></i>
                          Sudah diambil
                        </span>
                      </h6>
                    </td>
                    <td>
                      <router-link to="/" class="btn btn-info">
                        <i class="fas fa-info-circle"></i> Detail
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
            <h5 class="modal-title" id="exampleModalLabel">Add Antrian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action method="POST" enctype="multipart/form-data" @submit.prevent="addAntrian">
            <div class="modal-body">
              <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                  <li v-for="error in errors" v-bind:key="error.id">{{ error[0] }}</li>
                </ul>
              </div>
              <div class="form-group">
                <label for="member">Member:</label>
                <select name="member" v-model="member" class="form-control">
                  <option value selected disabled>-- Pilih Member --</option>
                  <option
                    :value="member.id"
                    v-for="member in this.members"
                    :key="member.id"
                  >{{ member.name }}</option>
                </select>
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
    <!-- Modal -->
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
      member: "",
      search: "",
      antrians: [],
      members: [],
      errors: [],
      addLoading: false,
      first_page: 1,
      page: 1,
      last_page: null,
      current_page: this.$route.query.page || 1,
      next_page_url: "",
      prev_page_url: "",
    };
  },
  methods: {
    displayData(page = 1) {
      this.$http({
        url: "/api/v1/antrian",
        method: "GET",
        params: { page: this.page },
      }).then((result) => {
        this.antrians = result.data.data.antrian.data;
        this.members = result.data.data.member;
        this.last_page = result.data.data.antrian.meta.last_page;
        this.current_page = result.data.data.antrian.meta.current_page;
        this.next_page_url = result.data.data.antrian.links.next;
        this.prev_page_url = result.data.data.antrian.links.prev;
      });
    },
    addAntrian() {
      this.addLoading = true;
      const formData = new FormData();
      formData.append("member", this.member);
      axios
        .post("/api/v1/antrian", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((res) => {
          this.addLoading = false;
          this.errors = [];
          $("#modalAdd").modal("toggle");
          alertify.success("Success Create Antrian!");
          this.displayData();
          this.name = "";
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
    searchData() {
      this.displayData(1, this.search);
      window.history.replaceState(null, null, "?page=1");
    },
  },
};
</script>
