<template>
    <div>
        <div class="row justify-content-center " style="margin-top: 50px; ">
            <div>
                <b-row class="justify-content-end">
                    <b-col sm="5" md="5" class="d-flex table_navigate justify-content-end pb-1">
                        <div class="col-md-1">
                            <a class="btn btnAdd" href="javascript:void(0)" @click="showAddOrEditForm()"> Add Data </a>
                        </div>
                    </b-col>
                </b-row>
<!--                <b-row class="justify-content-end">
                    <b-col sm="5" md="5" class="d-flex table_navigate justify-content-end pb-1">
                        <b-button
                                size="sm"
                                class="addButton toggleTableBtm"
                                @click="toggleTable"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-border-all" viewBox="0 0 16 16">
                                <path d="M0 0h16v16H0V0zm1 1v6.5h6.5V1H1zm7.5 0v6.5H15V1H8.5zM15 8.5H8.5V15H15V8.5zM7.5 15V8.5H1V15h6.5z"/>
                            </svg>
                        </b-button>

                    </b-col>
                </b-row>-->
                <div class="parent_card_pagination">
                    <div class="card">
                        <div>
                            <b-table
                                    :class="showTableLine ? 'table_line': 'table_grid'"
                                    :stacked="!showTableLine"
                                    :responsive="showTableLine"
                                    ref="table"
                                    :busy="isBusy"
                                    :hover="showTableLine"
                                    :items="getData"
                                    :fields="fields"
                                    :sort-by.sync="sortBy"
                                    :sort-desc.sync="sortDesc"
                                    :apiUrl="getRout('about_us_data.index')"
                                    :perPage="paginate.perPage"
                                    :currentPage="paginate.currentPage"
                                    :striped="showTableLine"
                                    :small="showTableLine"
                                    :bordered="showTableLine"
                                    :filter="filter"
                            >
                                <template #table-busy>
                                    <div class="text-center text-danger my-2">
                                        <b-spinner class="align-middle"></b-spinner>
                                        <strong>loaded</strong></div>
                                </template>
                                <template #cell(actions)="row">
                                    <a class="btn btn-inverse-warning  p-1 a_position"
                                       href="javascript:void(0)" @click="showAddOrEditForm(row.item, 'edit')">
                                        <i class="bi bi-pencil title_hov_top" data-title="edit">
                                            <svg v-b-tooltip.hover
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 fill="currentColor"
                                                 class="bi bi-pencil" viewBox="0 0 16 16">
                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                            </svg>
                                        </i>
                                    </a>
                                    <button  v-b-tooltip.hover class="btn btn-danger p-1 a_position"
                                            @click="destroyItem(row.item.id)">
                                        <i class="bi bi-trash title_hov_top" data-title="Delete">
                                            <svg v-b-tooltip.hover
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red"
                                                 class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd"
                                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </i>
                                    </button>
                                    <button  v-b-tooltip.hover class="p-1 btn-danger a_position"
                                            @click="setMain(row.item.id)">
                                        <i class="bi bi-trash bi-arrow-up-square-fill title_hov_top" data-title="Set Main">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-up-square-fill" viewBox="0 0 16 16">
                                                <path d="M2 16a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2zm6.5-4.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 1 0"/>
                                            </svg>
                                        </i>
                                    </button>

                                </template>
                                <template #cell(image_path)="row">
                                    <img v-if="row.item.image_path" :src="row.item.image_path" alt="Image" style="width: 50px; height: auto;" />
                                </template>
                            </b-table>
                        </div>
                    </div>
                    <PaginationComponent ref="PaginationComponent" v-if="Object.keys(aboutUsDatas).length > 0"
                                     :paginate="paginate"
                                     @loadAfterChangePage="loadAfterChangePage">
                </PaginationComponent>
                </div>
                <b-modal
                        class="addModal center_fields"
                        v-model="show"
                        :header-text-variant="headerTextVariant"
                        :header-bg-variant="headerBgVariant"
                >
                    <template #modal-title>
                        <b-row>
                            <b-col sm="10" md="10" class="title_popup fs-15 lh-2">Add/Edits</b-col>
                        </b-row>
                    </template>
                    <b-container fluid class="center_fields">
                        <b-row class="mb-1 bRowPosition">
                            <b-col class='blockInput title_hov_top' v-b-tooltip.hover data-title="title">
                                <b-form-input
                                        :class="[errors['title'] ? 'error-border': '', 'addFormInputs']"
                                        v-model="aboutUsData.title"
                                        type="text"
                                        placeholder="title"
                                ></b-form-input>
                                <small v-if="errors['title']" class="error-msg">{{errors['title'] }}</small>
                            </b-col>
                        </b-row>
                        <b-row class="mb-1 bRowPosition">
                            <b-col class='blockInput title_hov_top' v-b-tooltip.hover data-title="description">
                                <b-form-input
                                        :class="[errors['description'] ? 'error-border': '', 'addFormInputs']"
                                        v-model="aboutUsData.description"
                                        type="text"
                                        placeholder="description"
                                ></b-form-input>
                                <small v-if="errors['description']" class="error-msg">{{errors['description'] }}</small>
                            </b-col>
                        </b-row>
                        <b-row class="mb-1 images">
                            <b-col v-b-tooltip.hover data-title="image"
                                   class='blockInput images title_hov_center'>
                                <label class="inputLabel">image</label>
                                <label for="image_path">
                                    <template >
                                        <img v-if="aboutUsData && aboutUsData.image_path && aboutUsData.image_path_src"
                                             :src="aboutUsData.image_path_src"
                                             alt="image_path"
                                             style="width: 100px;height:100px; margin-left: 10px;"
                                        />
                                        <img v-else-if="aboutUsData && aboutUsData.image_path_src"
                                             :src="`${aboutUsData.image_path_src}`"
                                             alt="image_path"
                                             style="width: 100px;height:100px; margin-left: 10px;"
                                        />
                                        <img v-else
                                             :src="`/assets/images/photo.png`"
                                             alt="photo"
                                             style="width: 100px;height:100px; margin-left: 10px;"
                                        />
                                    </template>

                                </label>
                                <small v-if="errors['image_path']" class="error-msg imgError">
                                    <svg fill="none" height="11" viewBox="0 0 12 11" width="12"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path clip-rule="evenodd"
                                              d="M4.77931 1.16908C5.31481 0.217078 6.68471 0.217078 7.21951 1.16908L11.1255 8.11308C11.6505 9.04688 10.9764 10.1991 9.90611 10.1991H2.09341C1.02241 10.1991 0.348305 9.04688 0.873306 8.11308L4.77931 1.16908ZM6.69941 8.09978C6.69941 8.28543 6.62566 8.46348 6.49438 8.59476C6.36311 8.72603 6.18506 8.79978 5.99941 8.79978C5.81376 8.79978 5.63571 8.72603 5.50443 8.59476C5.37316 8.46348 5.29941 8.28543 5.29941 8.09978C5.29941 7.91413 5.37316 7.73608 5.50443 7.60481C5.63571 7.47353 5.81376 7.39978 5.99941 7.39978C6.18506 7.39978 6.36311 7.47353 6.49438 7.60481C6.62566 7.73608 6.69941 7.91413 6.69941 8.09978ZM5.99941 2.49978C5.81376 2.49978 5.63571 2.57353 5.50443 2.7048C5.37316 2.83608 5.29941 3.01413 5.29941 3.19978V5.29978C5.29941 5.48543 5.37316 5.66348 5.50443 5.79475C5.63571 5.92603 5.81376 5.99978 5.99941 5.99978C6.18506 5.99978 6.36311 5.92603 6.49438 5.79475C6.62566 5.66348 6.69941 5.48543 6.69941 5.29978V3.19978C6.69941 3.01413 6.62566 2.83608 6.49438 2.7048C6.36311 2.57353 6.18506 2.49978 5.99941 2.49978Z"
                                              fill="#EB5757"
                                              fill-rule="evenodd"/>
                                    </svg>
                                    {{ errors['image_path'] }}
                                </small>
                                <input
                                    id="image_path"
                                    ref="fileInput"
                                    accept=".png, .jpg, .jpeg"
                                    type="file"
                                    @change="handleFileUploadImage($event)"
                                >
                            </b-col>
                        </b-row>
                    </b-container>

                    <template #modal-footer>
                        <div class="w-100 handle_button">
                            <b-button
                                    :disabled = "buttonDisabled"
                                    size="sm"
                                    class="float-right addButton"
                                    @click="sendData(aboutUsData_id)"
                            >
                               Add/Edit
                            </b-button>
                        </div>
                    </template>
                </b-modal>

            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Swal from 'sweetalert2/dist/sweetalert2.js';
    import 'sweetalert2/src/sweetalert2.scss';
    import Multiselect from 'vue-multiselect';
    import PaginationComponent from "./PaginationComponent";
    import {PageName} from '../PageName';

    export default {

        components: {
            Swal,
            Multiselect,
            PaginationComponent,
        },

        name: "aboutUsDataComponent",

        props: [
            'authuser',
        ],

        watch: {
            authuser: function (newVal, oldVal) {
                this.authUser = newVal;
            },
            filter: {
                handler(newVal, oldVal) {
                    this.paginate.currentPage  = 1;
                },
                deep: true,
            },
        },

        data() {
            return {

                //default
                authUser: this.authuser,
                paginate: {
                    perPage: 10,
                    currentPage: 1,
                    total : '',
                    currentPageInput : '',
                    lastPage : '',
                },
                errors: {},
                //default

                //BTable
                showTableLine: false,
                fields: [
                    {
                        key: 'image_path',
                        label: 'Image',
                        sortable: false,
                        formatter: (val, key, row) => {
                            return '';
                        }

                    },

                    {
                        key: 'id',
                        label: 'ID',
                        sortable: true
                    },
                    {
                        key: 'title',
                        label: 'Title',
                        sortable: true
                    },
                    {
                        key: 'actions',
                        label: "Action",
                        sortable: false,
                        formatter: (val, key, row) => {
                            return '';
                        }
                    }
                ],
                isBusy: false,
                total: '',
                sortBy: 'id',
                sortDesc: false,
                filter: [
                    {
                        text : '',
                        key : '',
                    }
                ],
                //BTable

                //Modal
                show: false,
                headerBgVariant: 'custom',
                headerTextVariant: 'white',
                //Modal

                //Data
                aboutUsDatas: [],
                aboutUsData: {
                    title: '',
                    description: '',
                    image_path: '',
                    image_path_src: '',
                },
                aboutUsData_id: '',
                addOrEdit: 'add',
                buttonDisabled: false,
                //Data


            }
        },

        mounted() {
            let self = this;
            PageName.$emit('updatePageName', "About Us Data");

        },

        created() {

        },

        methods: {

            handleFileUploadImage(event) {
                let self = this;
                if (event.target && event.target.files && event.target.files[0]) {
                    self.aboutUsData.image_path = event.target.files[0];
                    self.aboutUsData.image_path_src = URL.createObjectURL(event.target.files[0]);
                }
            },


            updateFilter(newFilter){
                this.filter = newFilter;
            },

            toggleTable() {
                this.showTableLine = !this.showTableLine;
            },

            loadAfterChangePage(currentPage,perPage){
                if(currentPage){
                    this.paginate.currentPage = currentPage;
                }
                if(perPage){
                    this.paginate.perPage = perPage;

                }
            },

            getData(data) {
                let self = this;
                return axios.get(route('about_us_data.index') + `?page=${data.currentPage}`, {params: data})
                    .then((resp) => {
                        if (resp && resp.data && resp.data.data) {
                            self.aboutUsDatas = resp.data.data;
                            self.paginate.rows = resp.data.total;
                            self.paginate.total = resp.data.total;
                            self.paginate.currentPage = resp.data.current_page;
                            self.paginate.currentPageInput = self.paginate.currentPage;
                            self.paginate.lastPage = resp.data.last_page;
                            self.isBusy = false;
                            return self.aboutUsDatas;
                        }
                    })

                    .catch((err) => {
                        self.showCatchError(err);
                    });
            },

            sendData(id) {
                if (this.buttonDisabled) {
                    return;
                }
                this.buttonDisabled = true;
                let self = this;
                self.errors = {};
                let data = Object.assign({}, self.aboutUsData);

                if (id) {
                    data.id = id;
                }
                const formData = new FormData();
                formData.append('image_path', self.aboutUsData.image_path);
                formData.append('image_path_src', self.aboutUsData.image_path_src);
                for (let key in data) {
                    formData.append(key, data[key]);
                }
                axios.post(route('about_us_data.store'), formData)
                    .then((data) => {
                        if (data && data.data && data.data.isSuccess) {
                            self.show = false;
                            self.resetData();
                            self.$refs.table.refresh();
                        }
                        this.buttonDisabled = false;
                    })
                    .catch((err) => {
                        if (err && err.response && err.response.data) {
                            let errors = err.response.data;
                            for (let i in errors) {
                                Vue.set(self.errors, i, errors[i][0]);
                            }
                        }
                        this.buttonDisabled = false;

                    })
            },


            getRout(param) {
                return getRout(param)
            },

            showCatchError(err) {
                if (err.response && err.response.data) {
                    Swal.fire({
                        icon: 'error',
                        title: `${err.response.data.message}`,
                        confirmButtonText: "ok"
                    });
                }
            },

            showAddOrEditForm(obj = '', addOrEdit = 'add') {

                let self = this;
                self.errors = {};
                self.addOrEdit = addOrEdit;
                self.aboutUsData_id = obj ? obj.id : "";
                self.aboutUsData.title = obj ? obj.title : "";
                self.aboutUsData.description = obj ? obj.description : "";
                self.aboutUsData.image_path = "";
                self.aboutUsData.image_path_src = obj ? obj.image_path : "";

                self.show = true;
            },

            destroyItem(id) {
                let self = this;
                Swal.fire({
                    title: "Sure?",
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "YES",
                    cancelButtonText: "NO",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(route('about_us_data.destroy', {about_us_datum: id}))
                            .then((data) => {
                                if (data && data.data && data.data.isSuccess) {
                                    if(this.paginate.perPage === 1){
                                        this.paginate.currentPage--;
                                    }
                                    self.getData({
                                        currentPage: ((this.paginate.currentPage > 1) ? this.paginate.currentPage : 1),
                                        perPage: this.paginate.perPage,filter:this.filter
                                    }).then(function () {
                                        self.show = false;
                                        self.resetData();
                                        self.$refs.table.refresh();

                                    });
                                    Swal.fire(
                                        "success",
                                        '',
                                        'success'
                                    );
                                } else if (data && data.data && !data.data.isSuccess && data.data.message) {
                                    Swal.fire({
                                        title: data.data.message,
                                        confirmButtonText: "ok"
                                    });
                                }

                            })
                            .catch((err) => {
                                self.showCatchError(err);
                            })
                    }
                })
            },

            setMain(id) {
                let self = this;
                Swal.fire({
                    title: "Sure?",
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "YES",
                    cancelButtonText: "NO",
                }).then((result) => {
                    if (result.isConfirmed) {
                        let data = {id : id};
                        axios.post(route('setMainAbout'),data)
                            .then((data) => {
                                if (data && data.data && data.data.isSuccess) {
                                    Swal.fire(
                                        "success",
                                        '',
                                        'success'
                                    );
                                } else if (data && data.data && !data.data.isSuccess && data.data.message) {
                                    Swal.fire({
                                        title: data.data.message,
                                        confirmButtonText: "ok"
                                    });
                                }

                            })
                            .catch((err) => {
                                self.showCatchError(err);
                            })
                    }
                })
            },

            resetData() {
                let self = this;
                self.errors = {};
                self.aboutUsDatas = [];
                self.aboutUsData = {
                    title : "",
                    description : "",
                    image_path : "",
                    image_path_src : "",
                };
                self.aboutUsData_id = '';
                self.addOrEdit = 'add';
                self.buttonDisabled = false;
                self.show = false;
            },

        },
    }
</script>
