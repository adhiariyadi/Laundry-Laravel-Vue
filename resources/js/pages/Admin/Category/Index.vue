<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="page-title m-0">Category</h4>
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
                                <h4 class="mt-0 header-title">
                                    List All Category
                                </h4>
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
                                        <span
                                            class="input-group-text"
                                            id="basic-addon1"
                                            ><i class="fas fa-search"></i
                                        ></span>
                                    </div>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Cari Nama Category"
                                        aria-label="Cari Nama Category"
                                        aria-describedby="basic-addon1"
                                        v-model="search"
                                        @keyup="searchData"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table
                                class="table table-hover table-lg"
                                id="category-table"
                            >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Satuan - Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="category in categories"
                                        v-bind:key="category.id"
                                    >
                                        <td>{{ category.id }}</td>
                                        <td>{{ category.name }}</td>
                                        <td>{{ category.description }}</td>
                                        <td>
                                            {{ category.satuan }} - Rp.
                                            {{ formatPrice(category.harga) }}
                                        </td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn btn-warning"
                                                @click="
                                                    editCategory(category.id)
                                                "
                                            >
                                                Edit
                                            </button>
                                            <button
                                                type="button"
                                                @click="
                                                    deleteCategory(category.id)
                                                "
                                                class="btn btn-danger"
                                            >
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav
                            aria-label="Page navigation example"
                            class="float-right"
                        >
                            <ul class="pagination">
                                <li class="page-item">
                                    <button
                                        class="page-link"
                                        href="#"
                                        v-if="
                                            this.current_page !==
                                                this.first_page
                                        "
                                        @click="prevPage"
                                    >
                                        Previous
                                    </button>
                                </li>
                                <li class="page-item">
                                    <button class="page-link" href="#">
                                        {{ this.current_page }}
                                    </button>
                                </li>
                                <li class="page-item">
                                    <button
                                        class="page-link"
                                        href="#"
                                        @click="nextPage"
                                        v-if="
                                            this.current_page !== this.last_page
                                        "
                                    >
                                        Next
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
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
                        <h5 class="modal-title" id="exampleModalLabel">
                            Add Category
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Tutup"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form
                        action=""
                        method="POST"
                        enctype="multipart/form-data"
                        @submit.prevent="addCategory"
                    >
                        <div class="modal-body">
                            <div
                                class="alert alert-danger"
                                v-if="errors.length > 0"
                            >
                                <ul>
                                    <li
                                        v-for="error in errors"
                                        v-bind:key="error.id"
                                    >
                                        {{ error[0] }}
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label>Nama Category: </label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    v-model="add.name"
                                />
                            </div>
                            <div class="form-group">
                                <label>Description: </label>
                                <textarea
                                    name="description"
                                    class="form-control"
                                    v-model="add.description"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="satuan">Satuan: </label>
                                <select
                                    name="satuan"
                                    v-model="add.satuan"
                                    class="form-control"
                                >
                                    <option value="" selected disabled
                                        >-- Pilih Satuan --</option
                                    >
                                    <option value="Kg">Kilogram</option>
                                    <option value="Pcs">Pcs</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Harga: </label>
                                <input
                                    type="number"
                                    name="harga"
                                    class="form-control"
                                    v-model="add.harga"
                                />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                                :disabled="addLoading == true"
                            >
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
                        <h5 class="modal-title" id="exampleModalLabel">
                            Edit Category
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Tutup"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form
                        action=""
                        method="POST"
                        enctype="multipart/form-data"
                        @submit.prevent="updateCategory"
                    >
                        <div class="modal-body">
                            <div
                                class="alert alert-danger"
                                v-if="errors.length > 0"
                            >
                                <ul>
                                    <li
                                        v-for="error in errors"
                                        v-bind:key="error.id"
                                    >
                                        {{ error[0] }}
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label>Nama Category: </label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    v-model="edit.name"
                                />
                            </div>
                            <div class="form-group">
                                <label>Description: </label>
                                <textarea
                                    name="description"
                                    class="form-control"
                                    v-model="edit.description"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="satuan">Satuan: </label>
                                <select
                                    name="satuan"
                                    v-model="edit.satuan"
                                    class="form-control"
                                >
                                    <option value="" selected disabled
                                        >-- Pilih Satuan --</option
                                    >
                                    <option value="Kg">Kilogram</option>
                                    <option value="Pcs">Pcs</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Harga: </label>
                                <input
                                    type="number"
                                    name="harga"
                                    class="form-control"
                                    v-model="edit.harga"
                                />
                            </div>
                            <input
                                type="hidden"
                                name="id"
                                class="form-control"
                                v-model="edit.id"
                            />
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                                :disabled="addLoading == true"
                            >
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
        <!-- end row -->
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
                description: "",
                satuan: "",
                harga: ""
            },
            edit: {
                id: "",
                name: "",
                description: "",
                satuan: "",
                harga: ""
            },
            search: "",
            categories: [],
            errors: [],
            addLoading: false,
            first_page: 1,
            page: 1,
            search: "",
            last_page: null,
            current_page: this.$route.query.page || 1,
            next_page_url: "",
            prev_page_url: ""
        };
    },
    methods: {
        displayData(page = 1, search = "") {
            this.$http({
                url: "/api/v1/category",
                method: "GET",
                params: { search: this.search, page: this.page }
            }).then(result => {
                this.categories = result.data.data;
                this.last_page = result.data.meta.last_page;
                this.current_page = result.data.meta.current_page;
                this.next_page_url = result.data.links.next;
                this.prev_page_url = result.data.links.prev;
            });
        },
        addCategory() {
            this.addLoading = true;
            const formData = new FormData();
            formData.append("id", "");
            formData.append("name", this.add.name);
            formData.append("description", this.add.description);
            formData.append("satuan", this.add.satuan);
            formData.append("harga", this.add.harga);
            axios
                .post("/api/v1/category", formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                })
                .then(res => {
                    this.addLoading = false;
                    this.errors = [];
                    $("#modalAdd").modal("toggle");
                    alertify.success("Success Create Category!");
                    this.displayData();
                    this.name = "";
                })
                .catch(error => {
                    this.addLoading = false;
                    let statusCode = error.response.status;
                    if (statusCode == 500) {
                        this.errors = { error: "Terjadi kesalahan sistem." };
                    } else if (statusCode == 400) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        editCategory(id) {
            axios.get(`/api/v1/category/${id}/edit`).then(result => {
                this.edit.id = result.data.id;
                this.edit.name = result.data.name;
                this.edit.description = result.data.description;
                this.edit.satuan = result.data.satuan;
                this.edit.harga = result.data.harga;
                $("#modalEdit").modal("show");
            });
        },
        updateCategory() {
            this.addLoading = true;
            const formData = new FormData();
            formData.append("id", this.edit.id);
            formData.append("name", this.edit.name);
            formData.append("description", this.edit.description);
            formData.append("satuan", this.edit.satuan);
            formData.append("harga", this.edit.harga);
            axios
                .post(`/api/v1/category/`, formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                })
                .then(res => {
                    this.addLoading = false;
                    this.errors = [];
                    $("#modalEdit").modal("toggle");
                    alertify.success("Success Update Category!");
                    this.displayData();
                })
                .catch(error => {
                    this.addLoading = false;
                    let statusCode = error.response.status;
                    if (statusCode == 500) {
                        this.errors = { error: "Terjadi kesalahan sistem." };
                    } else if (statusCode == 400) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        deleteCategory(id) {
            const that = this;
            alertify.confirm(
                "Anda yakin ingin menghapus?",
                function(e) {
                    e.preventDefault();
                    axios.delete(`/api/v1/category/${id}`).then(res => {
                        alertify.success("Success Delete Category!");
                        that.displayData();
                    });
                },
                function(e) {
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
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    }
};
</script>
