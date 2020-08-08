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
              <table class="table table-hover table-lg" id="antrian-table">
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
                    <td>{{ index + 1 }}</td>
                    <td>
                      <span class="text-capitalize">
                        {{
                        antrian.member === undefined
                        ? "Deleted"
                        : antrian.member.name
                        }}
                      </span>
                    </td>
                    <td>
                      <h6>
                        <span class="badge badge-secondary p-2" v-if="antrian.status == 'hold'">
                          <i class="fas fa-upload mr-1"></i>
                          Hold
                        </span>
                        <span class="badge badge-info p-2" v-if="antrian.status == 'cuci'">
                          <i class="fas fa-tshirt mr-1"></i>
                          Sedang Cuci
                        </span>
                        <span class="badge badge-success p-2" v-if="antrian.status == 'selesai'">
                          <i class="fas fa-check-circle mr-1"></i>
                          Selesai Cuci
                        </span>
                      </h6>
                    </td>
                    <td>
                      Masuk :
                      <b>{{ antrian.created_at }}</b>
                      <br />Selesai :
                      <b>
                        {{
                        antrian.selesai
                        ? antrian.selesai
                        : "-"
                        }}
                      </b>
                      <br />Diambil :
                      <b>
                        {{
                        antrian.ambil
                        ? antrian.ambil
                        : "-"
                        }}
                      </b>
                    </td>
                    <td>Rp. {{ formatPrice(antrian.room.total) }}</td>
                    <td>
                      <h6>
                        <span
                          class="badge badge-warning p-2"
                          v-if="antrian.pembayaran === 'pending'"
                        >
                          <i class="fas fa-circle mr-1"></i>
                          Belum Bayar
                        </span>
                        <span class="badge badge-success p-2" v-else>
                          <i class="fas fa-circle mr-1"></i>
                          Sudah Bayar
                        </span>
                        <br />
                        <br />
                        <span class="badge badge-warning p-2" v-if="antrian.ambil === null">
                          <i class="fas fa-circle mr-1"></i>
                          Belum Diambil
                        </span>
                        <span class="badge badge-success p-2" v-else>
                          <i class="fas fa-circle mr-1"></i>
                          Sudah Diambil
                        </span>
                      </h6>
                    </td>
                    <td>
                      <button type="button" @click="detailAntrian(antrian.id)" class="btn btn-info">
                        <i class="fas fa-info-circle"></i>
                        Detail
                      </button>
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
          <form action method="POST" @submit.prevent="addAntrian">
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
    <div
      class="modal fade"
      id="modalDetail"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      v-if="detail"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Detail Antrian {{
              detail.member === undefined
              ? "Deleted"
              : detail.member.name
              }}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table border-none">
              <tr>
                <td>Pelanggan</td>
                <td>
                  {{
                  detail.member === undefined
                  ? "Deleted"
                  : detail.member.name
                  }}
                </td>
              </tr>
              <tr>
                <td>Waktu Registrasi</td>
                <td>{{ detail.created_at }}</td>
              </tr>
              <tr>
                <td>Status Cucian</td>
                <td>
                  <span v-if="detail.status === 'hold'">Hold (Sedang dalam antrian ke laundry room)</span>
                  <span
                    v-if="detail.status === 'cuci'"
                  >Sedang cuci (Cucian sedang di ke laundry room)</span>
                  <span
                    v-if="detail.status === 'selesai' && detail.ambil === null"
                  >Selesai (Cucian sudah selesai)</span>
                  <span
                    v-if="detail.status === 'selesai' && detail.ambil !== null"
                  >Selesai & Diambil (Cucian sudah selesai dan diambil oleh pelanggan)</span>
                </td>
              </tr>
              <tr>
                <td>Status Pembayaran</td>
                <td>
                  {{
                  detail.pembayaran === "pending"
                  ? "Belum"
                  : "Sudah"
                  }}
                </td>
              </tr>
              <tr>
                <td>Sudah di ambil</td>
                <td>
                  {{
                  detail.ambil === null
                  ? "Belum"
                  : "Sudah"
                  }}
                </td>
              </tr>
            </table>
          </div>
          <div class="modal-footer">
            <div style="text-align: center;">
              <button
                type="button"
                @click="bayar(detail.id)"
                class="btn btn-success btn-icon icon-left mr-2"
                :disabled="cucians == 0 || detail.pembayaran == 'selesai'"
              >
                <i class="fas fa-receipt mr-1"></i> Bayar
              </button>
              <button
                type="button"
                @click="setAmbil(detail.id)"
                class="btn btn-success btn-icon icon-left mr-2"
                :disabled="ambilLoading == true || detail.pembayaran != 'selesai' || detail.status != 'selesai' || detail.ambil !== null"
              >
                <span
                  class="spinner-border spinner-border-sm mr-1"
                  role="status"
                  aria-hidden="true"
                  v-if="ambilLoading == true"
                ></span>
                <i class="fas fa-check-circle mr-1" v-if="ambilLoading == false"></i>
                Set sudah diambil
              </button>
              <button
                type="button"
                @click="laundryRoom(detail.id)"
                class="btn btn-success btn-icon icon-left"
                :disabled="detail.status == 'selesai'"
              >
                <i class="fas fa-tshirt mr-1"></i> Ke laundry room
              </button>
              <button
                type="button"
                @click="deleteAntrian(detail.id)"
                class="btn btn-lg btn-danger btn-icon icon-left mt-3"
                :disabled="detail.pembayaran === 'selesai' || detail.ambil !== null"
              >
                <i class="fas fa-trash-alt mr-1"></i> Batalkan Cucian
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
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
      member: "",
      antrians: [],
      members: [],
      detail: {},
      cucian: 0,
      errors: [],
      addLoading: false,
      ambilLoading: false,
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
          this.member = "";
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
    detailAntrian(id) {
      axios.get(`/api/v1/antrian/${id}`).then((result) => {
        this.detail = result.data.antrian;
        this.cucian = result.data.cucian;
        $("#modalDetail").modal("show");
      });
    },
    bayar(id) {
      $("#modalDetail").modal("toggle");
      this.$router.push(`/bayar/${id}`);
    },
    setAmbil(id) {
      this.ambilLoading = true;
      const formData = new FormData();
      formData.append("antrian", id);
      axios
        .post("/api/v1/ambil", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((res) => {
          this.ambilLoading = false;
          this.errors = [];
          alertify.success("The laundry is finished!");
          $("#modalDetail").modal("toggle");
          this.displayData(this.room_id);
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
    laundryRoom(id) {
      $("#modalDetail").modal("toggle");
      this.$router.push(`/room/${id}`);
    },
    deleteAntrian(id) {
      const that = this;
      $("#modalDetail").modal("toggle");
      alertify.confirm(
        "Anda yakin ingin menghapus?",
        function (e) {
          e.preventDefault();
          axios.delete(`/api/v1/antrian/${id}`).then((res) => {
            alertify.success("Success Delete Antrian!");
            that.displayData();
          });
        },
        function (e) {
          e.preventDefault();
          alertify.error("Berhasil membatalkan");
        }
      );
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
    searchData() {
      this.displayData(1, this.search);
      window.history.replaceState(null, null, "?page=1");
    },
  },
};
</script>
<style>
.table.border-none th,
.table.border-none td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: none;
}
</style>
