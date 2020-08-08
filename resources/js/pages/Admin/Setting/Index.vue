<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h4 class="page-title m-0">Setting</h4>
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
                <h4 class="mt-0 header-title">Setting Laundry</h4>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-lg" id="setting-table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Value</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="setting in settings" v-bind:key="setting.id">
                    <td>{{ setting.name }}</td>
                    <td>{{ setting.description }}</td>
                    <td>{{ setting.value }}</td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-warning btn-sm"
                        @click="editSetting(setting.id)"
                      >
                        <i class="fas fa-edit mr-1"></i> Edit
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
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
            <h5 class="modal-title" id="exampleModalLabel">Edit Setting</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action method="POST" @submit.prevent="updateSetting">
            <div class="modal-body">
              <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                  <li v-for="error in errors" v-bind:key="error.id">{{ error[0] }}</li>
                </ul>
              </div>
              <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" v-model="edit.name" readonly />
              </div>
              <div class="form-group">
                <label>Description:</label>
                <input
                  type="text"
                  name="description"
                  class="form-control"
                  v-model="edit.description"
                  readonly
                />
              </div>
              <div class="form-group">
                <label>Value:</label>
                <input type="text" name="value" class="form-control" v-model="edit.value" />
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
    this.displayData();
  },
  data() {
    return {
      edit: {
        id: "",
        name: "",
        description: "",
        value: "",
      },
      settings: [],
      errors: [],
      addLoading: false,
    };
  },
  methods: {
    displayData(id) {
      axios.get(`/api/v1/setting`).then((result) => {
        this.settings = result.data.data;
      });
    },
    editSetting(id) {
      axios.get(`/api/v1/setting/${id}`).then((result) => {
        this.edit.id = result.data.id;
        this.edit.name = result.data.name;
        this.edit.description = result.data.description;
        this.edit.value = result.data.value;
        $("#modalEdit").modal("show");
      });
    },
    updateSetting() {
      this.addLoading = true;
      const formData = new FormData();
      formData.append("id", this.edit.id);
      formData.append("value", this.edit.value);
      axios
        .post("/api/v1/setting", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((res) => {
          this.addLoading = false;
          this.errors = [];
          $("#modalEdit").modal("toggle");
          alertify.success("Success Update Setting!");
          this.displayData();
          this.edit.id = "";
          this.edit.name = "";
          this.edit.description = "";
          this.edit.value = "";
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
