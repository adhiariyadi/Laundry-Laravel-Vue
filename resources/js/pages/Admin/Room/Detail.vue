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
              <table class="table">
                <tr>
                  <td>Nama Pelanggan</td>
                  <td>:</td>
                  <td>
                    <span class="text-capitalize">
                      {{
                      room.antrian.member === undefined
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
                  <td>{{ cucians.length }}</td>
                </tr>
                <tr>
                  <td>Total Harga</td>
                  <td>:</td>
                  <td>Rp. {{ room.total }}</td>
                </tr>
              </table>
            </div>
            <button
              type="button"
              class="btn btn-success btn-icon icon-left mr-2"
              :disabled="bayarLoading == true || cucians.length == 0"
            >
              <span
                class="spinner-border spinner-border-sm mr-1"
                role="status"
                aria-hidden="true"
                v-if="bayarLoading == true"
              ></span>
              <i class="fas fa-receipt mr-1" v-if="bayarLoading == false"></i> Bayar
            </button>
            <button
              type="button"
              class="btn btn-success btn-icon icon-left"
              :disabled="selesaiLoading == true || cucians.length == 0"
            >
              <span
                class="spinner-border spinner-border-sm mr-1"
                role="status"
                aria-hidden="true"
                v-if="selesaiLoading == true"
              ></span>
              <i class="fas fa-check-circle mr-1" v-if="selesaiLoading == false"></i> Set selesai
            </button>
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
                  <li>Harga : Rp. {{ category.harga === undefined ? 0 : category.harga }}</li>
                  <li>Total : Rp. {{ qty === "" ? 0 : category.harga * qty }}</li>
                </ul>
              </div>
              <button type="submit" class="btn btn-primary" :disabled="addLoading == true">
                <span
                  class="spinner-border spinner-border-sm mr-1"
                  role="status"
                  aria-hidden="true"
                  v-if="addLoading == true"
                ></span>
                <i class="ti-plus mr-1" v-if="addLoading == false"></i> Tambah
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
              <table class="table">
                <thead>
                  <th>Category</th>
                  <th>Qty</th>
                  <th>Total</th>
                </thead>
                <tbody>
                  <tr v-for="cucian in cucians" v-bind:key="cucian.id">
                    <td>{{ cucian.category.name }}</td>
                    <td>{{ cucian.quantity }}</td>
                    <td>{{ cucian.total }}</td>
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
    this.room_id = this.$route.params.room_id;
    this.displayData(this.room_id);
  },
  data() {
    return {
      room_id: "",
      category: {},
      qty: "",
      room: {},
      categories: [],
      cucians: [],
      errors: [],
      addLoading: false,
      bayarLoading: false,
      selesaiLoading: false,
    };
  },
  methods: {
    displayData(room_id) {
      axios.get(`/api/v1/room/${room_id}`).then((result) => {
        this.room = result.data.room;
        this.categories = result.data.category;
        this.cucians = result.data.cucian;
      });
    },
    addCucian() {
      this.addLoading = true;
      const formData = new FormData();
      formData.append("antrian", this.room_id);
      formData.append("category", this.category.id);
      formData.append("qty", this.qty);
      axios
        .post("/api/v1/room", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((res) => {
          this.addLoading = false;
          this.errors = [];
          alertify.success("Success Create Antrian!");
          this.displayData(this.room_id);
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
  },
};
</script>
