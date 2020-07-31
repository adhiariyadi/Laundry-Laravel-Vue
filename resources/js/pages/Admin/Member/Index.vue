<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h4 class="page-title m-0">Member</h4>
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
                <h4 class="mt-0 header-title">List All Member</h4>
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
            <div class="row">
              <div class="offset-md-8 col-md-4 col-sm-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                      <i class="fas fa-search"></i>
                    </span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Cari Nama Member"
                    aria-label="Cari Nama Member"
                    aria-describedby="basic-addon1"
                    v-model="search"
                    @keyup="searchData"
                  />
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-lg" id="member-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Level Member</th>
                    <th>Total Cuci</th>
                    <th>Point</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(member, index) in members" v-bind:key="member.id">
                    <td>{{ index+1 }}</td>
                    <td>{{ member.name }}</td>
                    <td>
                      {{
                      member.level === undefined
                      ? "Deleted"
                      : member.level.name
                      }}
                    </td>
                    <td>0</td>
                    <td>{{ member.point }}</td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-warning"
                        @click="editMember(member.id)"
                      >Edit</button>
                      <button
                        type="button"
                        @click="deleteMember(member.id)"
                        class="btn btn-danger"
                      >Hapus</button>
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
            <h5 class="modal-title" id="exampleModalLabel">Add Member</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action method="POST" enctype="multipart/form-data" @submit.prevent="addMember">
            <div class="modal-body">
              <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                  <li v-for="error in errors" v-bind:key="error.id">{{ error[0] }}</li>
                </ul>
              </div>
              <div class="form-group">
                <label>Nama Member:</label>
                <input type="text" name="name" class="form-control" v-model="add.name" />
              </div>
              <div class="form-group">
                <label>Alamat:</label>
                <textarea name="alamat" class="form-control" v-model="add.alamat"></textarea>
              </div>
              <div class="form-group">
                <label>No. Telepon:</label>
                <input type="text" name="telp" class="form-control" v-model="add.telp" />
              </div>
              <div class="form-group">
                <label for="level">Level Member:</label>
                <select name="level" v-model="add.level" class="form-control">
                  <option value selected disabled>-- Pilih Level Member --</option>
                  <option
                    :value="level.id"
                    v-for="level in this.levels"
                    :key="level.id"
                  >{{ level.name }}</option>
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
      id="modalEdit"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Member</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action method="POST" enctype="multipart/form-data" @submit.prevent="updateMember">
            <div class="modal-body">
              <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                  <li v-for="error in errors" v-bind:key="error.id">{{ error[0] }}</li>
                </ul>
              </div>
              <div class="form-group">
                <label>Nama Member:</label>
                <input type="text" name="name" class="form-control" v-model="edit.name" />
              </div>
              <div class="form-group">
                <label>Alamat:</label>
                <textarea name="alamat" class="form-control" v-model="edit.alamat"></textarea>
              </div>
              <div class="form-group">
                <label>No. Telepon:</label>
                <input type="text" name="telp" class="form-control" v-model="edit.telp" />
              </div>
              <div class="form-group">
                <label for="level">Level Member:</label>
                <select name="level" v-model="edit.level" class="form-control">
                  <option value selected disabled>-- Pilih Level Member --</option>
                  <option
                    :value="level.id"
                    v-for="level in this.levels"
                    :key="level.id"
                  >{{ level.name }}</option>
                </select>
              </div>
              <input type="hidden" name="id" class="form-control" v-model="edit.id" />
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
                Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
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
      add: {
        name: "",
        alamat: "",
        telp: "",
        level: "",
      },
      edit: {
        id: "",
        name: "",
        alamat: "",
        telp: "",
        level: "",
      },
      search: "",
      members: [],
      levels: [],
      errors: [],
      addLoading: false,
      first_page: 1,
      page: 1,
      search: "",
      last_page: null,
      current_page: this.$route.query.page || 1,
      next_page_url: "",
      prev_page_url: "",
    };
  },
  methods: {
    displayData(page = 1, search = "") {
      this.$http({
        url: "/api/v1/member",
        method: "GET",
        params: { search: this.search, page: this.page },
      }).then((result) => {
        this.members = result.data.data.member.data;
        this.levels = result.data.data.level;
        this.last_page = result.data.data.member.meta.last_page;
        this.current_page = result.data.data.member.meta.current_page;
        this.next_page_url = result.data.data.member.links.next;
        this.prev_page_url = result.data.data.member.links.prev;
      });
    },
    addMember() {
      this.addLoading = true;
      const formData = new FormData();
      formData.append("id", "");
      formData.append("name", this.add.name);
      formData.append("alamat", this.add.alamat);
      formData.append("telp", this.add.telp);
      formData.append("level", this.add.level);
      axios
        .post("/api/v1/member", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((res) => {
          this.addLoading = false;
          this.errors = [];
          $("#modalAdd").modal("toggle");
          alertify.success("Success Create Member!");
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
    editMember(id) {
      axios.get(`/api/v1/member/${id}/edit`).then((result) => {
        this.edit.id = result.data.id;
        this.edit.name = result.data.name;
        this.edit.alamat = result.data.alamat;
        this.edit.telp = result.data.telp;
        this.edit.level = result.data.level_id;
        $("#modalEdit").modal("show");
      });
    },
    updateMember() {
      this.addLoading = true;
      const formData = new FormData();
      formData.append("id", this.edit.id);
      formData.append("name", this.edit.name);
      formData.append("alamat", this.edit.alamat);
      formData.append("telp", this.edit.telp);
      formData.append("level", this.edit.level);
      axios
        .post(`/api/v1/member/`, formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((res) => {
          this.addLoading = false;
          this.errors = [];
          $("#modalEdit").modal("toggle");
          alertify.success("Success Update Member!");
          this.displayData();
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
    deleteMember(id) {
      const that = this;
      alertify.confirm(
        "Anda yakin ingin menghapus?",
        function (e) {
          e.preventDefault();
          axios.delete(`/api/v1/member/${id}`).then((res) => {
            alertify.success("Success Delete Member!");
            that.displayData();
          });
        },
        function (e) {
          e.preventDefault();
          alertify.error("Berhasil membatalkan");
        }
      );
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
