<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h4 class="page-title m-0">Dashboard</h4>
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
      <div class="col-xl-3 col-md-6">
        <div class="card bg-warning mini-stat text-white">
          <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h6 class="text-uppercase mt-0 float-left text-white-50">Cucian</h6>
            </div>
            <div>
              <h4 class="mt-3 float-left">
                <i class="fas fa-water"></i>
              </h4>
              <h4 class="mt-3 mt-0 float-right">{{ data.cucian }}</h4>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card bg-primary mini-stat text-white">
          <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h6 class="text-uppercase mt-0 float-left text-white-50">Member</h6>
            </div>
            <div>
              <h4 class="mt-3 float-left">
                <i class="fas fa-users"></i>
              </h4>
              <h4 class="mt-3 mt-0 float-right">{{ data.pelanggan }}</h4>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card bg-info mini-stat text-white">
          <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h6 class="text-uppercase mt-0 float-left text-white-50">Transaksi Harian</h6>
            </div>
            <div>
              <h4 class="mt-3 float-left">
                <i class="fas fa-donate"></i>
              </h4>
              <h4 class="mt-3 float-right">Rp {{ formatPrice(data.harian) }}</h4>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card bg-success mini-stat text-white">
          <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h6 class="text-uppercase mt-0 float-left text-white-50">Transaksi Bulanan</h6>
            </div>
            <div>
              <h4 class="mt-3 float-left">
                <i class="fas fa-donate"></i>
              </h4>
              <h4 class="mt-3 mt-0 float-right">Rp {{ formatPrice(data.bulanan) }}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-8">
                <h4 class="mt-0 header-title">Transksi seminggu terakhir</h4>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-lg">
                <thead>
                  <th>Tanggal</th>
                  <th>Transaksi</th>
                  <th>Nominal</th>
                </thead>
                <tbody>
                  <tr v-for="data in data.mingguan" v-bind:key="data.id">
                    <td>{{ data.tanggal }}</td>
                    <td>{{ data.transaksi }}</td>
                    <td>Rp. {{ formatPrice(data.nominal) }}</td>
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
                <h4 class="mt-0 header-title">Ranking Pelanggan</h4>
              </div>
            </div>
            <hr />
            <ul class="list-unstyled list-unstyled-border">
              <li class="media" v-for="data in data.member" v-bind:key="data.id">
                <img
                  width="50"
                  src="images/users/avatar-1.png"
                  alt="avatar"
                  class="mr-3 rounded-circle"
                />
                <div class="media-body">
                  <div class="float-right">{{ data.level.name }}</div>
                  <h6 class="media-title">{{ data.name }}</h6>
                  <div class="text-small text-muted">
                    {{ data.antrian.length }} Total Cuci
                    <div class="bullet"></div>
                    <span class="text-success">{{ data.point }} Poin</span>
                  </div>
                </div>
              </li>
            </ul>
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
      data: {},
    };
  },
  methods: {
    displayData() {
      axios.get(`/api/v1/home`).then((result) => {
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
.list-unstyled {
  padding-left: 0;
  list-style: none;
}
.list-unstyled-border li {
  border-bottom: 1px solid #f9f9f9;
  padding-bottom: 15px;
  margin-bottom: 15px;
}
.media {
  display: flex;
  align-items: flex-start;
}
.media-body {
  flex: 1;
}
.media .media-title {
  margin-top: 0;
  margin-bottom: 5px;
  font-weight: 600;
  font-size: 15px;
  color: #34395e;
}
</style>
