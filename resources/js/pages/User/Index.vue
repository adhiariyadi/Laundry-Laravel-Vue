<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h4 class="page-title m-0">User</h4>
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
                <h4 class="mt-0 header-title">List All User</h4>
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
                    placeholder="Cari Nama User"
                    aria-label="Cari Nama User"
                    aria-describedby="basic-addon1"
                    v-model="search"
                    @keyup="searchData"
                  />
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-lg" id="user-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Level User</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(user, index) in users" v-bind:key="user.id">
                    <td>{{ index+1 }}</td>
                    <td>
                      <img :src="`${user.image}`" class="image-table-users" />
                      {{ user.name }}
                    </td>
                    <td>{{ user.email }}</td>
                    <td>
                      <span
                        class="badge badge-primary p-2"
                        v-if="user.level == 'Admin'"
                      >{{ user.level }}</span>
                      <span class="badge badge-secondary p-2" v-else>{{ user.level }}</span>
                    </td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-warning btn-sm"
                        @click="editUser(user.id)"
                      >
                        <i class="fas fa-edit mr-1"></i> Edit
                      </button>
                      <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        @click="deleteUser(user.id)"
                      >
                        <i class="fas fa-trash-alt mr-1"></i> Hapus
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
            <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action method="POST" enctype="multipart/form-data" @submit.prevent="addUser">
            <div class="modal-body">
              <div class="alert alert-danger" v-if="errors != ''">
                <ul>
                  <li v-for="error in errors" v-bind:key="error.id">{{ error[0] }}</li>
                </ul>
              </div>
              <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" name="name" class="form-control" v-model="add.name" />
              </div>
              <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" class="form-control" v-model="add.username" />
              </div>
              <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" v-model="add.email" />
              </div>
              <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" v-model="add.password" />
              </div>
              <div class="form-group">
                <label>Level User:</label>
                <select name="level" v-model="add.level" class="form-control">
                  <option value>Pilih salah satu..</option>
                  <option value="Admin">Admin</option>
                  <option value="Operator">Operator</option>
                </select>
              </div>
              <div class="form-group">
                <label>Foto:</label>
                <input
                  type="file"
                  name="file"
                  class="form-control-file"
                  accept="image/*"
                  @change="onChangePhotoAdd"
                />
                <img :src="`${add.image}`" class="image-table" id="add-user-image" />
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
            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action method="POST" enctype="multipart/form-data" @submit.prevent="updateUser">
            <div class="modal-body">
              <div class="alert alert-danger" v-if="errors != ''">
                <ul>
                  <li v-for="error in errors" v-bind:key="error.id">{{ error[0] }}</li>
                </ul>
              </div>
              <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" name="name" class="form-control" v-model="edit.name" />
              </div>
              <div class="form-group">
                <label>Username:</label>
                <input
                  type="text"
                  name="username"
                  class="form-control"
                  v-model="edit.username"
                  readonly
                />
              </div>
              <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" v-model="edit.email" readonly />
              </div>
              <div class="form-group">
                <label>Password:</label>
                <input
                  type="password"
                  name="password"
                  class="form-control"
                  v-model="edit.password"
                  placeholder="ISI JIKA INGIN DIUBAH"
                />
              </div>
              <div class="form-group">
                <label>Level User:</label>
                <select name="level" v-model="edit.level" class="form-control">
                  <option value>Pilih salah satu..</option>
                  <option value="Admin">Admin</option>
                  <option value="Operator">Operator</option>
                </select>
              </div>
              <div class="form-group">
                <label>Foto:</label>
                <input
                  type="file"
                  name="file"
                  class="form-control-file"
                  accept="image/*"
                  @change="onChangePhotoEdit"
                />
                <img :src="`${edit.image}`" class="image-table" id="edit-user-image" />
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
        username: "",
        email: "",
        level: "",
        password: "",
        image: "",
      },
      edit: {
        id: "",
        name: "",
        username: "",
        email: "",
        level: "",
        password: "",
        image: "",
      },
      search: "",
      users: [],
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
    displayData(page, search) {
      this.$http({
        url: "/api/v1/akun",
        method: "GET",
        params: { search: search, page: page },
      }).then((result) => {
        this.users = result.data.data;
        this.last_page = result.data.meta.last_page;
        this.current_page = result.data.meta.current_page;
        this.next_page_url = result.data.links.next;
        this.prev_page_url = result.data.links.prev;
      });
    },
    addUser() {
      this.addLoading = true;
      const formData = new FormData();
      formData.append("id", "");
      formData.append("name", this.add.name);
      formData.append("username", this.add.username);
      formData.append("email", this.add.email);
      formData.append("level", this.add.level);
      formData.append("password", this.add.password);
      formData.append("image", this.add.image);
      axios
        .post("/api/v1/akun", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == true) {
            this.addLoading = false;
            this.errors = [];
            $("#modalAdd").modal("toggle");
            alertify.success("Success Create User!");
            this.displayData();
            this.add.name = "";
            this.add.username = "";
            this.add.email = "";
            this.add.level = "";
            this.add.password = "";
            this.add.image = "";
          } else {
            this.addLoading = false;
            this.errors = { error: result.data.status };
          }
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
    editUser(id) {
      axios.get(`/api/v1/akun/${id}/edit`).then((result) => {
        this.edit.id = result.data.id;
        this.edit.name = result.data.name;
        this.edit.username = result.data.username;
        this.edit.email = result.data.email;
        this.edit.level = result.data.level;
        this.edit.image = result.data.image;
        $("#modalEdit").modal("show");
      });
    },
    updateUser() {
      this.addLoading = true;
      const formData = new FormData();
      formData.append("id", this.edit.id);
      formData.append("name", this.edit.name);
      formData.append("username", this.edit.username);
      formData.append("email", this.edit.email);
      formData.append("level", this.edit.level);
      formData.append("password", this.edit.password);
      formData.append("image", this.edit.image);
      axios
        .post(`/api/v1/akun`, formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((res) => {
          this.addLoading = false;
          this.errors = [];
          $("#modalEdit").modal("toggle");
          alertify.success("Success Update User!");
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
    deleteUser(id) {
      const that = this;
      alertify.confirm(
        "Anda yakin ingin menghapus?",
        function (e) {
          e.preventDefault();
          axios.delete(`/api/v1/akun/${id}`).then((res) => {
            alertify.success("Success Delete User!");
            that.displayData();
          });
        },
        function (e) {
          e.preventDefault();
          alertify.error("Berhasil membatalkan");
        }
      );
    },
    onChangePhotoAdd() {
      this.add.image = event.target.files[0];
      $("#add-User-image").attr(
        "src",
        URL.createObjectURL(event.target.files[0])
      );
    },
    onChangePhotoEdit() {
      this.edit.image = event.target.files[0];
      $("#edit-User-image").attr(
        "src",
        URL.createObjectURL(event.target.files[0])
      );
    },
    nextPage() {
      let nextPage = this.current_page + 1;
      window.history.replaceState(null, null, "?page=" + nextPage);
      this.displayData(thinextPage, this.search);
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
.image-table {
  width: 80px;
}
.image-table-users {
  border-radius: 50%;
  width: 50px;
  height: 50px;
  margin-right: 10px;
  object-fit: cover;
}
</style>
