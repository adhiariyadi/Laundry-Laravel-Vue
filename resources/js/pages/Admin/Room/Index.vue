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
      <div class="col-xl-12">
        <div class="card m-b-30">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-8">
                <h4 class="mt-0 header-title">List All Antrian in Laundry Room</h4>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-lg" id="room-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Pelanggan</th>
                    <th>Waktu Masuk</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(room, index) in rooms" v-bind:key="room.id">
                    <td>{{ index + 1 }}</td>
                    <td>
                      <span class="text-capitalize">
                        {{
                        room.antrian.member === undefined
                        ? "Deleted"
                        : room.antrian.member.name
                        }}
                      </span>
                    </td>
                    <td>{{ room.created_at }}</td>
                    <td>0</td>
                    <td>Rp. {{ room.total }}</td>
                    <td>
                      <h6>
                        <span class="badge badge-warning p-2" v-if="room.status === 'ready'">
                          <i class="fas fa-circle mr-1"></i>
                          Ready
                        </span>
                        <span class="badge badge-success p-2" v-else>
                          <i class="fas fa-circle mr-1"></i>
                          sedang Cuci
                        </span>
                      </h6>
                    </td>
                    <td>
                      <router-link :to="{path: `/room/${room.id}`}" class="btn btn-info">
                        <i class="fas fa-info-circle mr-1"></i>
                        Detail
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
      rooms: [],
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
        url: "/api/v1/room",
        method: "GET",
        params: { page: this.page },
      }).then((result) => {
        this.rooms = result.data.data;
        this.last_page = result.data.meta.last_page;
        this.current_page = result.data.meta.current_page;
        this.next_page_url = result.data.links.next;
        this.prev_page_url = result.data.links.prev;
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
