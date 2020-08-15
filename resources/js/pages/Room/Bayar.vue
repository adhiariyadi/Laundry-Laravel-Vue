<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h4 class="page-title m-0">Pembayaran</h4>
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
                <h4 class="mt-0 header-title">Data Cucian</h4>
              </div>
            </div>
            <div class="table-responsive mb-3">
              <table class="table border-none">
                <tr>
                  <td>Kode Transaksi</td>
                  <td>:</td>
                  <td>INV-{{ room.antrian.date }}-{{ kode }}</td>
                </tr>
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
                  <td>Level Pelanggan</td>
                  <td>:</td>
                  <td>
                    <span class="text-capitalize">
                      {{
                      room.antrian.member ===
                      undefined
                      ? "Deleted"
                      : room.antrian.member.level.name
                      }}
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>Diskon level</td>
                  <td>:</td>
                  <td>
                    {{
                    room.antrian.member ===
                    undefined
                    ? "Deleted"
                    : room.antrian.member.level.discount
                    }} %
                  </td>
                </tr>
              </table>
            </div>
            <hr />
            <div class="row mb-3 mt-4">
              <div class="col-8">
                <h4 class="mt-0 header-title">Item cucian</h4>
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
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-8">
                <h4 class="mt-0 header-title">Detail Harga</h4>
              </div>
            </div>
            <div class="table-responsive mb-3">
              <form action method="POST" @submit.prevent="addBayar">
                <table class="table border-none">
                  <tr>
                    <td>Harga</td>
                    <td>Rp. {{ formatPrice(room.total) }}</td>
                  </tr>
                  <tr>
                    <td>
                      Disc ({{
                      room.antrian.member ===
                      undefined
                      ? 0
                      : room.antrian.member.level.discount
                      }}%)
                    </td>
                    <td>
                      Rp. {{ room.antrian.member ===
                      undefined
                      ? 0
                      : formatPrice(room.total * room.antrian.member.level.discount / 100) }}
                    </td>
                  </tr>
                  <tr>
                    <td>Kode Promo</td>
                    <td>
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Kode Promo"
                          v-model="kodePromo"
                          :class="{
                          'form-control': true,
                          'is-invalid': this.errorPromo
                        }"
                          :disabled="promoInput == true"
                        />
                        <div class="input-group-append">
                          <button
                            type="button"
                            @click="cekPromo"
                            class="btn btn-success"
                            v-if="promoInput == false"
                          >
                            <span
                              class="spinner-border spinner-border-sm mr-1"
                              role="status"
                              aria-hidden="true"
                              v-if="promoLoading == true"
                            ></span> Gunakan
                          </button>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr v-html="promo"></tr>
                  <tr>
                    <td>Total</td>
                    <td>Rp. {{ formatPrice(room.total - (room.total * room.antrian.member.level.discount / 100) - ((room.total - (room.total * room.antrian.member.level.discount / 100)) * discount / 100)) }}</td>
                  </tr>
                  <tr>
                    <td>Bayar</td>
                    <td>
                      <div class="input-group">
                        <input
                          type="number"
                          placeholder="Bayar"
                          :class="{
                          'form-control': true,
                          'is-invalid': this.errorBayar
                        }"
                          v-model="bayar"
                          :disabled="bayarInput == true"
                        />
                        <div class="input-group-append">
                          <button
                            type="button"
                            @click="hitungKembalian(room.total - (room.total * room.antrian.member.level.discount / 100) - ((room.total - (room.total * room.antrian.member.level.discount / 100)) * discount / 100))"
                            class="btn btn-success"
                            v-if="bayarInput == false"
                          >
                            <span
                              class="spinner-border spinner-border-sm mr-1"
                              role="status"
                              aria-hidden="true"
                              v-if="bayarLoading == true"
                            ></span> Set
                          </button>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Kembali</td>
                    <td>Rp. {{ formatPrice(kembalian) }}</td>
                  </tr>
                </table>
                <hr />
                <div>
                  <button
                    type="submit"
                    class="btn btn-success btn-icon icon-left mr-2"
                    :disabled="addLoading == true || bayarInput == false"
                  >
                    <span
                      class="spinner-border spinner-border-sm mr-1"
                      role="status"
                      aria-hidden="true"
                      v-if="addLoading == true"
                    ></span>
                    <i class="fas fa-check-circle mr-1" v-if="addLoading == false"></i>
                    Proses pembayaran
                  </button>
                </div>
              </form>
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
    $(".modal-backdrop.fade").removed(".show");
  },
  data() {
    return {
      id: "",
      room: {},
      kode: "",
      kodePromo: "",
      promo: ``,
      discount: 0,
      promoInput: false,
      promoLoading: false,
      errorPromo: false,
      bayar: 0,
      bayarInput: false,
      bayarLoading: false,
      errorBayar: false,
      kembalian: 0,
      addLoading: false,
    };
  },
  methods: {
    displayData(id) {
      axios.get(`/api/v1/room/${id}/edit`).then((result) => {
        this.room = result.data.room;
        this.kode = result.data.kode;
      });
    },
    cekPromo() {
      this.promoLoading = true;
      const formData = new FormData();
      formData.append("kode", this.kodePromo);
      axios
        .post("/api/v1/cekPromo", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == "success") {
            this.promoLoading = false;
            this.errorPromo = false;
            alertify.success("Success Add Promo!");
            this.promo = `<td>Promo</td><td>${result.data.promo.description} - ${result.data.promo.discount}%</td>`;
            this.discount = result.data.promo.discount;
            this.promoInput = true;
            this.kodePromo = result.data.promo.kode;
          } else {
            this.promoLoading = false;
            this.errorPromo = true;
            alertify.error("Promo not found!");
            this.promo = ``;
            this.kodePromo = "";
          }
        });
    },
    hitungKembalian(id) {
      this.bayarLoading = true;
      const formData = new FormData();
      formData.append("total", id);
      formData.append("bayar", this.bayar);
      axios
        .post("/api/v1/kembali", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == "success") {
            this.bayarInput = true;
            this.bayarLoading = false;
            this.kembalian = result.data.kembali;
            this.errorBayar = false;
            alertify.success("Payment Success!");
          } else {
            this.bayarLoading = false;
            this.errorBayar = true;
            alertify.error("sorry you don't have enough money!");
          }
        });
    },
    addBayar() {
      this.addLoading = true;
      const formData = new FormData();
      formData.append("antrian", this.id);
      formData.append("kode", this.kode);
      formData.append("promo", this.kodePromo);
      formData.append("bayar", this.bayar);
      axios
        .post("/api/v1/pembayaran", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          this.addLoading = false;
          alertify.success("Transaction Success!");
          if (result.data.antrian.selesai == null) {
            this.$router.push(`/room/${result.data.antrian.id}`);
          } else {
            this.$router.push(`/antrian`);
          }
        })
        .catch((error) => {
          this.addLoading = false;
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
