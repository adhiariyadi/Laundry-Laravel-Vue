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
        <div class="card bg-primary mini-stat text-white">
          <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h6 class="text-uppercase mt-0 float-left text-white-50">Orders</h6>
              <h4 class="mb-3 mt-0 float-right">{{ numberFormat(5000) }}</h4>
            </div>
            <div>
              <span class="badge badge-light text-info">{{ 5000 }}</span>
              <span class="ml-2">Dari bulan lalu</span>
            </div>
          </div>
          <div class="p-3">
            <div class="float-right">
              <a href="#" class="text-white-50">
                <i class="mdi mdi-cube-outline h5"></i>
              </a>
            </div>
            <p class="font-14 m-0">Bulan lalu : {{ 5000 }}</p>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card bg-info mini-stat text-white">
          <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h6 class="text-uppercase mt-0 float-left text-white-50">Pendapatan</h6>
              <h4 class="mb-3 mt-0 float-right">Rp {{ numberFormat(5000) }}</h4>
            </div>
            <div>
              <span class="badge badge-light text-danger">{{ 5000 }}</span>
              <span class="ml-2">Dari bulan lalu</span>
            </div>
          </div>
          <div class="p-3">
            <div class="float-right">
              <a href="#" class="text-white-50">
                <i class="mdi mdi-buffer h5"></i>
              </a>
            </div>
            <p class="font-14 m-0">
              Bulan lalu : Rp
              {{ numberFormat(5000) }}
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card bg-pink mini-stat text-white">
          <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h6 class="text-uppercase mt-0 float-left text-white-50">Harga Rata-rata</h6>
              <h4 class="mb-3 mt-0 float-right">Rp {{ numberFormat(5000) }}</h4>
            </div>
            <div>
              <span class="badge badge-light text-primary">0%</span>
              <span class="ml-2">From previous period</span>
            </div>
          </div>
          <div class="p-3">
            <div class="float-right">
              <a href="#" class="text-white-50">
                <i class="mdi mdi-tag-text-outline h5"></i>
              </a>
            </div>
            <p class="font-14 m-0">Last : 15.8</p>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card bg-success mini-stat text-white">
          <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h6 class="text-uppercase mt-0 float-left text-white-50">Produk Terjual</h6>
              <h4 class="mb-3 mt-0 float-right">{{ 5000 }}</h4>
            </div>
            <div>
              <span class="badge badge-light text-info">+89%</span>
              <span class="ml-2">From previous period</span>
            </div>
          </div>
          <div class="p-3">
            <div class="float-right">
              <a href="#" class="text-white-50">
                <i class="mdi mdi-briefcase-check h5"></i>
              </a>
            </div>
            <p class="font-14 m-0">Bulan lalu : {{ 5000 }}</p>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </div>
  <!-- container fluid -->
</template>
