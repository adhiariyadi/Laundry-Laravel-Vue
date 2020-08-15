<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box d-print-none">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h4 class="page-title m-0">Transaksi Invoice</h4>
            </div>
          </div>
          <!-- end row -->
        </div>
        <!-- end page-title-box -->
      </div>
    </div>
    <!-- end page title -->
    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="invoice-title">
                  <h4 class="float-right font-16">
                    <strong>Order #{{ data.antrian.bayar.invoice }}</strong>
                  </h4>
                  <h3 class="m-t-0">
                    <img src="/images/logo.png" alt="logo" height="40" />
                  </h3>
                </div>
                <hr />
                <div class="row">
                  <div class="col-6">
                    <address>
                      <strong>Billed To:</strong>
                      <br />
                      {{ data.antrian.member.name }}
                      <br />
                      {{ data.antrian.member.alamat }}
                      <br />
                      {{ data.antrian.member.telp }}
                    </address>
                  </div>
                  <div class="col-6 text-right">
                    <address>
                      <strong>Shipped To:</strong>
                      <br />
                      {{ data.setting.name }}
                      <br />
                      {{ data.setting.alamat }}, {{ data.setting.kelurahan }}
                      <br />
                      {{ data.setting.kecamatan }}, {{ data.setting.kode_pos }}
                      <br />
                      {{ data.setting.kabupaten }}, {{ data.setting.provinsi }}
                    </address>
                  </div>
                </div>
                <div class="row">
                  <div class="col-6 m-t-30">
                    <address>
                      <strong>Metode Pembayaran:</strong>
                      <br />Uang Cash
                      <br />
                    </address>
                  </div>
                  <div class="col-6 m-t-30 text-right">
                    <address>
                      <strong>Tanggal Pesanan:</strong>
                      <br />
                      {{ moment(data.antrian.bayar.created_at).format('DD MMMM YYYY') }}
                    </address>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="panel panel-default">
                  <div class="p-2">
                    <h3 class="panel-title font-20">
                      <strong>Ringkasan Pesanan</strong>
                    </h3>
                  </div>
                  <div class>
                    <div class="table-responsive table-hover table-lg" id="invoice-table">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Category</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-right">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="cucian in data.antrian.cucian" v-bind:key="cucian.id">
                            <td>{{ cucian.category.name }}</td>
                            <td class="text-center">Rp {{ cucian.category.harga }}</td>
                            <td
                              class="text-center"
                            >{{ cucian.quantity }} {{ cucian.category.satuan }}</td>
                            <td class="text-right">Rp. {{ formatPrice(cucian.total) }}</td>
                          </tr>
                        </tbody>
                        <br />
                        <tfoot>
                          <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line text-center">
                              <strong>Subtotal</strong>
                            </td>
                            <td class="no-line text-right">
                              <h5 class="m-0">Rp {{ formatPrice(data.antrian.bayar.harga) }}</h5>
                            </td>
                          </tr>
                          <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line text-center">
                              <strong>Discount</strong>
                            </td>
                            <td class="no-line text-right">
                              <h5 class="m-0">Rp {{ formatPrice(data.antrian.bayar.discount) }}</h5>
                            </td>
                          </tr>
                          <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line text-center">
                              <strong>Total</strong>
                            </td>
                            <td class="no-line text-right">
                              <h5 class="m-0">Rp {{ formatPrice(data.antrian.bayar.total) }}</h5>
                            </td>
                          </tr>
                          <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line text-center">
                              <strong>Bayar</strong>
                            </td>
                            <td class="no-line text-right">
                              <h5 class="m-0">Rp {{ formatPrice(data.antrian.bayar.bayar) }}</h5>
                            </td>
                          </tr>
                          <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line text-center">
                              <strong>Kembali</strong>
                            </td>
                            <td class="no-line text-right">
                              <h5 class="m-0">Rp {{ formatPrice(data.antrian.bayar.kembali) }}</h5>
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <hr />
                    <div class="d-print-none mt-3">
                      <div class="float-right">
                        <a
                          href="javascript:window.print()"
                          class="btn btn-success waves-effect waves-light"
                        >
                          <i class="fa fa-print"></i> Print
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end row -->
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
  <!-- container fluid -->
</template>
<script>
export default {
  mounted() {
    $(
      ".button-menu-mobile.open-left.waves-effect:not(.button-menu-mobile-topbar)"
    ).click();
    this.invoice = this.$route.params.invoice;
    this.displayData(this.invoice);
  },
  data() {
    return {
      invoice: "",
      data: {},
    };
  },
  methods: {
    displayData(invoice) {
      axios.get(`/api/v1/pembayaran/${invoice}`).then((result) => {
        this.data = result.data.data;
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
.table tfoot td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: none;
}
</style>