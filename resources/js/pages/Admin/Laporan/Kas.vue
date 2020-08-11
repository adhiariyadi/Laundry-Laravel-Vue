<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h4 class="page-title m-0">Laporan Kas</h4>
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
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-8">
                <h4 class="mt-0 header-title">List All Laporan Kas</h4>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-lg">
                <thead>
                  <th>Invoice</th>
                  <th>Waktu</th>
                  <th>description</th>
                  <th>Ket</th>
                  <th>Total</th>
                  <th>Saldo</th>
                </thead>
                <tbody>
                  <tr v-for="data in kas" v-bind:key="data.id">
                    <td>{{ data.invoice }}</td>
                    <td>{{ data.created_at }}</td>
                    <td>{{ data.description }}</td>
                    <td>{{ data.ket }}</td>
                    <td>Rp. {{ formatPrice(data.jumlah) }}</td>
                    <td>Rp. {{ formatPrice(setting.value + data.saldo) }}</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>{{ setting.created_at }}</td>
                    <td>{{ setting.description }}</td>
                    <td>{{ setting.name }}</td>
                    <td>Rp. {{ formatPrice(setting.value) }}</td>
                    <td>Rp. {{ formatPrice(setting.value) }}</td>
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
    this.displayData();
  },
  data() {
    return {
      kas: [],
      setting: {},
    };
  },
  methods: {
    displayData() {
      axios.get(`/api/v1/kas`).then((result) => {
        this.kas = result.data.data.kas;
        this.setting = result.data.data.saldo;
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
