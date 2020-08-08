<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h4 class="page-title m-0">Laundry Room</h4>
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
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-8">
                <h4 class="mt-0 header-title">Info cucian</h4>
              </div>
            </div>
            <div class="table-responsive mb-3">
              <table class="table border-none">
                <tr>
                  <td>Nama Pelanggan</td>
                  <td>:</td>
                  <td>
                    <span class="text-capitalize">
                      {{
                      room.antrian.member ===
                      undefined
                      ? "Deleted"
                      : room.antrian.member.name
                      }}
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>Waktu Masuk</td>
                  <td>:</td>
                  <td>{{ room.created_at }}</td>
                </tr>
                <tr>
                  <td>Total Item</td>
                  <td>:</td>
                  <td>{{ room.antrian.cucian.length }}</td>
                </tr>
                <tr>
                  <td>Total Harga</td>
                  <td>:</td>
                  <td>Rp. {{ formatPrice(room.total) }}</td>
                </tr>
              </table>
            </div>
            <form action method="POST" @submit.prevent="setSelesai">
              <button
                type="button"
                class="btn btn-success btn-icon icon-left mr-2 disabled"
                v-if="room.antrian.cucian.length == 0 || room.antrian.pembayaran == 'selesai'"
              >
                <i class="fas fa-receipt mr-1"></i> Bayar
              </button>
              <router-link
                :to="{ path: `/bayar/${this.id}` }"
                class="btn btn-success btn-icon icon-left mr-2"
                v-else
              >
                <i class="fas fa-receipt mr-1"></i> Bayar
              </router-link>
              <button
                type="submit"
                class="btn btn-success btn-icon icon-left"
                :disabled="selesaiLoading == true || room.antrian.cucian.length == 0 || room.status == 'selesai'"
              >
                <span
                  class="spinner-border spinner-border-sm mr-1"
                  role="status"
                  aria-hidden="true"
                  v-if="selesaiLoading == true"
                ></span>
                <i class="fas fa-check-circle mr-1" v-if="selesaiLoading == false"></i>
                Set selesai
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-8">
                <h4 class="mt-0 header-title">Tambah item cucian</h4>
              </div>
            </div>
            <form action method="POST" @submit.prevent="addCucian">
              <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                  <li v-for="error in errors" v-bind:key="error.id">{{ error[0] }}</li>
                </ul>
              </div>
              <div class="form-group">
                <label for="category">Category:</label>
                <select name="category" v-model="category" class="form-control">
                  <option value selected disabled>-- Pilih Category --</option>
                  <option
                    :value="category"
                    v-for="category in this.categories"
                    :key="category.id"
                  >{{ category.name }}</option>
                </select>
              </div>
              <div class="form-group">
                <label for="qty">Quantity:</label>
                <input type="number" class="form-control" v-model="qty" />
              </div>
              <div>
                <ul>
                  <li v-if="category.name !== undefined">
                    Produk :
                    <b>{{ category.name }}</b>
                    - ({{ category.satuan }})
                  </li>
                  <li v-else>Produk :</li>
                  <li>
                    Harga : Rp.
                    {{
                    category.harga === undefined
                    ? 0
                    : formatPrice(category.harga)
                    }}
                  </li>
                  <li>
                    Total : Rp.
                    {{
                    qty === ""
                    ? 0
                    : formatPrice(category.harga * qty)
                    }}
                  </li>
                </ul>
              </div>
              <button
                type="submit"
                class="btn btn-primary"
                :disabled="addLoading == true || room.antrian.pembayaran == 'selesai'"
              >
                <span
                  class="spinner-border spinner-border-sm mr-1"
                  role="status"
                  aria-hidden="true"
                  v-if="addLoading == true"
                ></span>
                <i class="ti-plus mr-1" v-if="addLoading == false"></i>
                Tambah
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-8">
                <h4 class="mt-0 header-title">List item cucian</h4>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-lg">
                <thead>
                  <th>Category</th>
                  <th>Qty</th>
                  <th>Total</th>
                </thead>
                <tbody>
                  <tr v-for="cucian in room.antrian.cucian" v-bind:key="cucian.id">
                    <td>{{ cucian.category.name }}</td>
                    <td>{{ cucian.quantity }} {{ cucian.category.satuan }}</td>
                    <td>Rp. {{ formatPrice(cucian.total) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
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
    this.id = this.$route.params.id;
    this.displayData(this.id);
    $("#modalDetail").modal("show");
    $(".modal-backdrop.fade").removed(".show");
  },
  data() {
    return {
      id: "",
      category: {},
      qty: "",
      room: {},
      categories: [],
      errors: [],
      addLoading: false,
      selesaiLoading: false,
    };
  },
  methods: {
    displayData(id) {
      axios.get(`/api/v1/room/${id}`).then((result) => {
        this.room = result.data.room;
        this.categories = result.data.category;
      });
    },
    addCucian() {
      this.addLoading = true;
      const formData = new FormData();
      formData.append("antrian", this.id);
      formData.append("category", this.category.id);
      formData.append("qty", this.qty);
      axios
        .post("/api/v1/room", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((res) => {
          this.addLoading = false;
          this.errors = [];
          alertify.success("Success Add Cucian!");
          this.displayData(this.id);
          this.category = {};
          this.qty = "";
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
    setSelesai() {
      this.selesaiLoading = true;
      const formData = new FormData();
      formData.append("antrian", this.id);
      axios
        .post("/api/v1/selesai", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((res) => {
          this.selesaiLoading = false;
          this.errors = [];
          alertify.success("The laundry is finished!");
          this.$router.push(`/antrian`);
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
