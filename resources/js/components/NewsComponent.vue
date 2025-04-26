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
                                    :apiUrl="getRout('newses.index')"
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
                                </template>
                            </b-table>
                        </div>
                    </div>
                    <PaginationComponent ref="PaginationComponent" v-if="Object.keys(newses).length > 0"
                                     :paginate="paginate"
                                     @loadAfterChangePage="loadAfterChangePage">
                </PaginationComponent>
                </div>
                <b-modal
                        class="addModal"
                        v-model="show"
                        :header-text-variant="headerTextVariant"
                        :header-bg-variant="headerBgVariant"
                >
                    <template #modal-title>
                        <b-row>
                            <b-col sm="10" md="10" class="title_popup fs-15 lh-2">Add/Edit</b-col>
                        </b-row>
                    </template>
                    <b-container fluid class="slider_modal">
                        <b-row class="mb-1 bRowPosition">
                            <b-col class='blockInput title_hov_top' v-b-tooltip.hover data-title="title">
                                <b-form-input
                                        :class="[errors['title'] ? 'error-border': '', 'addFormInputs']"
                                        v-model="news.title"
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
                                        v-model="news.description"
                                        type="text"
                                        placeholder="description"
                                ></b-form-input>
                                <small v-if="errors['description']" class="error-msg">{{errors['description'] }}</small>
                            </b-col>
                        </b-row>
                        <b-row class="mb-1 bRowPosition">
                            <b-col class='blockInput title_hov_top' v-b-tooltip.hover data-title="long description">

                                <ckeditor :editor="editor" v-model="news.long_description" :class="[errors['long_description'] ? 'error-border': '', 'addFormInputs']"></ckeditor>
                                <small v-if="errors['long_description']" class="error-msg">{{errors['long_description'] }}</small>
                            </b-col>
                        </b-row>

                        <b-row class="mb-1 bRowPosition">
                            <b-col class='blockInput title_hov_top' v-b-tooltip.hover data-title="write the codes with a space between them">
                                <b-form-input
                                        :class="[errors['youtube_codes'] ? 'error-border': '', 'addFormInputs']"
                                        v-model="news.youtube_codes"
                                        type="text"
                                        placeholder="write the codes with a space between them"
                                ></b-form-input>
                                <small v-if="errors['youtube_codes']" class="error-msg">{{errors['youtube_codes'] }}</small>
                            </b-col>
                        </b-row>

                        <!-- Images -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Images">
                                <label class="inputLabel">Existing Images</label>
                                <div v-if="news.existing_images.length > 0">
                                    <div v-for="(image, index) in news.existing_images" :key="image.id" class="mb-2">
                                        <img :src="image.image_path" class="img-thumbnail" alt="News Image" width="100">
                                        <button @click="removeExistingImage(index)">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                                <label class="inputLabel">Upload New Images</label>
                                <input
                                    type="file"
                                    accept=".png, .jpg, .jpeg"
                                    multiple
                                    @change="handleFileUploadImages"
                                >
                                <small v-if="errors['images']" class="error-msg">{{ errors['images'] }}</small>
                            </b-col>
                        </b-row>
                    </b-container>

                    <template #modal-footer>
                        <div class="w-100 handle_button">
                            <b-button
                                    :disabled = "buttonDisabled"
                                    size="sm"
                                    class="float-right addButton"
                                    @click="sendData(news_id)"
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

    import CKEditor from '@ckeditor/ckeditor5-vue2';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {

        components: {
            Swal,
            Multiselect,
            PaginationComponent,
            ckeditor: CKEditor.component

        },

        name: "newsComponent",

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
                editor: ClassicEditor,

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
                newses: [],
                news: {
                    title: '',
                    description: '',
                    long_description: '',
                    youtube_codes: '',
                    existing_images: [],
                    images: [],
                },
                news_id: '',
                addOrEdit: 'add',
                buttonDisabled: false,
                images : [],
                //Data


            }
        },

        mounted() {
            let self = this;
            PageName.$emit('updatePageName', "News");

        },

        created() {

        },

        methods: {

            handleFileUploadImages(event) {
                let self = this;
                self.images = Array.from(event.target.files);
            },

            removeExistingImage(index) {
                this.news.existing_images.splice(index, 1);
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
                return axios.get(route('newses.index') + `?page=${data.currentPage}`, {params: data})
                    .then((resp) => {
                        if (resp && resp.data && resp.data.data) {
                            self.newses = resp.data.data;
                            self.paginate.rows = resp.data.total;
                            self.paginate.total = resp.data.total;
                            self.paginate.currentPage = resp.data.current_page;
                            self.paginate.currentPageInput = self.paginate.currentPage;
                            self.paginate.lastPage = resp.data.last_page;
                            self.isBusy = false;
                            return self.newses;
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
                let data = Object.assign({}, self.news);
                const formData = new FormData();

                if (id) {
                    data.id = id;
                    formData.append('id', data.id);

                }
                formData.append('title', data.title);
                formData.append('description', data.description);
                formData.append('youtube_codes', data.youtube_codes);
                formData.append('long_description', data.long_description);

                // Append images (multiple files)
                data.existing_images.forEach((image) => {
                    formData.append('existing_images[]', image.image_path);  // Send the path of the existing images to keep
                });

                // Append new images (multiple files)
                if (self.images.length > 0) {
                    for (let i = 0; i < self.images.length; i++) {
                        formData.append(`images[]`, self.images[i]);  // Attach new images as files
                    }
                }
                axios.post(route('newses.store'), formData)
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
                self.news_id = obj ? obj.id : "";
                self.news.title = obj ? obj.title : "";
                self.news.description = obj ? obj.description : "";
                self.news.long_description = obj ? obj.long_description : "";
                self.news.youtube_codes = obj ? obj.youtube_codes : "";
                self.news.existing_images = obj && obj.images ? obj.images : [];
                self.images = [];
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
                        axios.delete(route('newses.destroy', {newse: id}))
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

            resetData() {
                let self = this;
                self.errors = {};
                self.newses = [];
                self.news = {
                    title : "",
                    description : "",
                    long_description : "",
                    youtube_codes : "",
                    existing_images: [],
                    images: [],
                };
                self.images = [];
                self.news_id = '';
                self.addOrEdit = 'add';
                self.buttonDisabled = false;
                self.show = false;
            },

        },
    }
</script>
