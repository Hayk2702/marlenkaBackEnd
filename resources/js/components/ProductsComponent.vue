<template>
    <div>
        <div>
            <SearchComponent
                ref="SearchComponent"
                @filter-updated="updateFilter"
                :keys="searchKeys"
                :dateKeys="[]"
                :isCondition=true
                :isAction=true
            ></SearchComponent>
        </div>
        <div class="row justify-content-center " style="margin-top: 50px; ">
            <div>
                <b-row class="justify-content-end">
                    <b-col sm="5" md="5" class="d-flex table_navigate justify-content-end pb-1">
                        <div class="col-md-1">
                            <a class="btn btnAdd" href="javascript:void(0)" @click="showAddOrEditForm()"> Add Product </a>
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
                <div class="parent_card_pagination products_table">
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
                                    :apiUrl="getRout('products.index')"
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
                                    <a class="btn btn-inverse-warning  p-1 a_position"
                                       href="javascript:void(0)" @click="showAddOrEditForm(row.item, 'repeat')">
                                        <i class="title_hov_top" data-title="Duplicate">
                                            <img src="/images/duplicate.svg" alt="Duplicate" width="24" height="24">
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
                                <template #cell(image_path)="row">
                                    <img v-if="row.item.images && row.item.images.length" :src="row.item.images[0].image_path" alt="Image" style="width: 50px; height: auto;" />
                                </template>
                            </b-table>
                        </div>
                    </div>
                    <PaginationComponent ref="PaginationComponent" v-if="Object.keys(productData).length > 0"
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
                            <b-col sm="10" md="10" class="title_popup fs-15 lh-2">Edit Product</b-col>
                        </b-row>
                    </template>
                    <b-container fluid>
                        <!-- Product Name -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Name">
                                <label class="inputLabel">Product Name</label>
                                <b-form-input
                                    :class="[errors['name'] ? 'error-border': '', 'addFormInputs']"
                                    v-model="product.name"
                                    type="text"
                                    placeholder="Enter product name"
                                ></b-form-input>
                                <small v-if="errors['name']" class="error-msg">{{ errors['name'] }}</small>
                            </b-col>
                        </b-row>

                        <!-- Product Description -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Description">
                                <label class="inputLabel">Description</label>
                                <b-form-input
                                    :class="[errors['description'] ? 'error-border': '', 'addFormInputs']"
                                    v-model="product.description"
                                    type="text"
                                    placeholder="Enter product description"
                                ></b-form-input>
                                <small v-if="errors['description']" class="error-msg">{{ errors['description'] }}</small>
                            </b-col>
                        </b-row>

                        <!-- Product IsNew -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Is New">
                                <label class="inputLabel">Is New</label>
                                <b-form-radio-group
                                    v-model="product.isNew"
                                    name="isNew"
                                    :class="[errors['isNew'] ? 'error-border': '', '']"
                                >
                                    <b-form-radio :value="1">Yes</b-form-radio>
                                    <b-form-radio :value="0">No</b-form-radio>
                                </b-form-radio-group>
                                <small v-if="errors['isNew']" class="error-msg">{{ errors['isNew'] }}</small>
                            </b-col>
                        </b-row>

                        <!-- Product Serving -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Serving">
                                <label class="inputLabel">Serving</label>
                                <b-form-select
                                    :class="[errors['serving'] ? 'error-border': '', 'addFormInputs']"
                                    v-model="product.serving"
                                    :options="servingOptions"
                                    placeholder="Select product serving"
                                ></b-form-select>
                                <small v-if="errors['serving']" class="error-msg">{{ errors['serving'] }}</small>
                            </b-col>
                        </b-row>
                        <!-- Category -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Category">
                                <label class="inputLabel">Category</label>
                                <multiselect
                                    v-model="product.category_id"
                                    :options="categories.map(category => ({value: category.id, text: category.name}))"
                                    label="text"
                                    track-by="value"
                                    placeholder="Select category"
                                ></multiselect>
                                <small v-if="errors['category_id']" class="error-msg">{{ errors['category_id'] }}</small>
                            </b-col>
                        </b-row>

                        <!-- Product Details -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Details">
                                <label class="inputLabel">Details</label>
                                <b-form-input
                                    :class="[errors['details_one'] ? 'error-border': '', 'addFormInputs']"
                                    v-model="product.details_one"
                                    type="text"
                                    placeholder="Details One"
                                ></b-form-input>
                                <b-form-input
                                    :class="[errors['details_two'] ? 'error-border': '', 'addFormInputs']"
                                    v-model="product.details_two"
                                    type="text"
                                    placeholder="Details Two"
                                ></b-form-input>
                                <b-form-input
                                    :class="[errors['details_three'] ? 'error-border': '', 'addFormInputs']"
                                    v-model="product.details_three"
                                    type="text"
                                    placeholder="Details Three"
                                ></b-form-input>
                                <small v-if="errors['details_one'] || errors['details_two'] || errors['details_three']" class="error-msg">
                                    {{ errors['details_one'] || errors['details_two'] || errors['details_three'] }}
                                </small>
                            </b-col>
                        </b-row>

                        <!-- Product Price -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Price">
                                <label class="inputLabel">Price</label>
                                <b-form-input
                                    :class="[errors['price'] ? 'error-border': '', 'addFormInputs']"
                                    v-model="product.price"
                                    type="number"
                                    placeholder="Enter price"
                                ></b-form-input>
                                <small v-if="errors['price']" class="error-msg">{{ errors['price'] }}</small>
                            </b-col>
                        </b-row>

                        <!-- Product Status -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Status">
                                <label class="inputLabel">Status</label>
                                <b-form-select
                                    :class="[errors['status'] ? 'error-border': '', 'addFormInputs']"
                                    v-model="product.status"
                                    :options="[{ value: 1, text: 'Active' }, { value: 0, text: 'Inactive' }]"
                                ></b-form-select>
                                <small v-if="errors['status']" class="error-msg">{{ errors['status'] }}</small>
                            </b-col>
                        </b-row>

                        <!-- Product Images -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Images">
                                <label class="inputLabel">Existing Images</label>
                                <div v-if="product.existing_images.length > 0">
                                    <div v-for="(image, index) in product.existing_images" :key="image.id" class="mb-2">
                                        <img :src="image.image_path" class="img-thumbnail" alt="Product Image" width="100">
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

                        <!-- Product Flavors -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Flavors">
                                <label class="inputLabel">Flavors</label>
                                <multiselect
                                    v-model="product.flavor_ids"
                                    :options="flavors.map(flavor => ({ value: flavor.id, text: flavor.name }))"
                                    label="text"
                                    track-by="value"
                                    placeholder="Select flavors"
                                    :multiple="true"
                                ></multiselect>
                                <small v-if="errors['flavor_ids']" class="error-msg">{{ errors['flavor_ids'] }}</small>
                            </b-col>
                        </b-row>


                        <!-- Product Technicals -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Technicals">
                                <label class="inputLabel">Technicals</label>
<!--                                <b-button @click="addTechnicalDetail" style="margin: 10px;">
                                    +
                                </b-button>-->
                                <b-form-group v-for="(technical, index) in product.technicals" :key="index">
                                    <b-form-input
                                        v-model="technical.technical"
                                        type="text"
                                        placeholder="Enter technical detail"
                                        :disabled="true"
                                    ></b-form-input>
                                    <b-form-input
                                        v-model="technical.value"
                                        type="text"
                                        placeholder="Enter technical value"
                                    ></b-form-input>
<!--                                    <b-col>
                                        <b-button  @click="removeTechnicalDetail(index)" style="margin: 10px;">
                                            Remove
                                        </b-button>
                                    </b-col>-->
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <!-- Product PackageTechnicals -->
                        <b-row class="mb-1">
                            <b-col v-b-tooltip.hover data-title="Package Technicals">
                                <label class="inputLabel">Package Technicals</label>
<!--
                                <b-button @click="addPackageTechnicalDetail" style="margin: 10px;">
                                    +
                                </b-button>
-->
                                <b-form-group v-for="(packageTechnical, index) in product.packageTechnicals" :key="index">
                                    <b-form-input
                                        v-model="packageTechnical.technical"
                                        type="text"
                                        placeholder="Enter technical detail"
                                        :disabled="true"
                                    ></b-form-input>
                                    <b-form-input
                                        v-model="packageTechnical.value"
                                        type="text"
                                        placeholder="Enter technical value"
                                    ></b-form-input>
<!--
                                    <b-col>
                                        <b-button  @click="removePackageTechnicalDetail(index)" style="margin: 10px;">
                                            Remove
                                        </b-button>
                                    </b-col>
-->
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-container>

                    <template #modal-footer>
                        <div class="w-100 handle_button">
                            <b-button
                                :disabled="buttonDisabled"
                                size="sm"
                                class="float-right addButton"
                                @click="sendData(product_id)"
                            >
                                Save Changes
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
    import SearchComponent from "./SearchComponent";

    export default {

        components: {
            Swal,
            Multiselect,
            PaginationComponent,
            SearchComponent,

        },

        name: "productComponent",

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
                        key: 'name',
                        label: 'Name',
                        sortable: true
                    },
                    {
                        key: 'description',
                        label: 'Description',
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
                servingOptions: [
                    { text: '1', value: 1 },
                    { text: '2-3', value: 2 },
                    { text: '4-8', value: 3 },
                    { text: '8+', value: 4 }
                ],
                categories: [],
                flavors: [],
                productData: [],
                product: {
                    name: '',
                    description: '',
                    category_id: "",
                    details_one: '',
                    details_two: '',
                    details_three: '',
                    price: 0,
                    isNew: 0,
                    status: 1,
                    serving: 1,
                    flavor_ids: [],
                    existing_images: [],
                    images: [],
                    technicals: [
                        { technical: 'Weight:', value: '' },
                        { technical: 'Product Dimensions:', value: '' },
                        { technical: 'Product EAN:', value: '' },
                    ],
                    packageTechnicals: [
                        { technical: 'Weight:', value: '' },
                        { technical: 'Box Dimensions:', value: '' },
                        { technical: 'Box EAN:', value: '' },
                    ],
                },
                product_id: '',
                addOrEdit: 'add',
                buttonDisabled: false,
                //Data


            }
        },

        mounted() {
            let self = this;
            PageName.$emit('updatePageName', "Home Sliders");

        },

        created() {

        },

        methods: {

            handleFileUploadImage(event) {
                let self = this;
                if (event.target && event.target.files && event.target.files[0]) {
                    self.product.image_path = event.target.files[0];
                    self.product.image_path_src = URL.createObjectURL(event.target.files[0]);
                }
            },

            handleFileUploadSmallImage(event) {
                let self = this;
                if (event.target && event.target.files && event.target.files[0]) {
                    self.product.small_image_path = event.target.files[0];
                    self.product.small_image_path_src = URL.createObjectURL(event.target.files[0]);
                }
            },

            /*handleFileUploadImages(event) {
                const files = event.target.files;
                this.product.images = [];
                for (let i = 0; i < files.length; i++) {
                    this.product.images.push(files[i]);
                }
            },*/

            handleFileUploadImages(event) {
                let self = this;
                self.images = Array.from(event.target.files);
            },

            removeExistingImage(index) {
                this.product.existing_images.splice(index, 1);
            },

            addTechnicalDetail() {
                this.product.technicals.push({ technical: '', value: '' });
            },

            addPackageTechnicalDetail() {
                this.product.packageTechnicals.push({ technical: '', value: '' });
            },

            removeTechnicalDetail(index) {
                if (this.product.technicals.length > 1) {
                    this.product.technicals.splice(index, 1);
                }
            },

            removePackageTechnicalDetail(index) {
                if (this.product.packageTechnicals.length > 1) {
                    this.product.packageTechnicals.splice(index, 1);
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
                return axios.get(route('products.index') + `?page=${data.currentPage}`, {params: data})
                    .then((resp) => {
                        if (resp && resp.data && resp.data.data) {
                            self.productData = resp.data.data;
                            self.paginate.rows = resp.data.total;
                            self.paginate.total = resp.data.total;
                            self.paginate.currentPage = resp.data.current_page;
                            self.paginate.currentPageInput = self.paginate.currentPage;
                            self.paginate.lastPage = resp.data.last_page;
                            self.isBusy = false;
                            return self.productData;
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
                let data = Object.assign({}, self.product);
                const formData = new FormData();

                if (id) {
                    data.id = id;
                    formData.append('id', data.id);

                }
                data.category_id = data.category_id && data.category_id.value ? data.category_id.value : "";
                formData.append('name', data.name);
                formData.append('description', data.description);
                formData.append('category_id', data.category_id);
                formData.append('details_one', data.details_one);
                formData.append('details_two', data.details_two);
                formData.append('details_three', data.details_three);
                formData.append('price', data.price);
                formData.append('status', data.status);
                formData.append('serving', data.serving);
                formData.append('isNew', data.isNew ? 1 : 0);

                // Append flavors
                data.flavor_ids.forEach((flavor, index) => {
                    formData.append(`flavor_ids[${index}]`, flavor.value);
                });
                // Append technical details
                data.technicals.forEach((technical, index) => {
                    formData.append(`technicals[${index}][technical]`, technical.technical);
                    formData.append(`technicals[${index}][value]`, technical.value);
                });
                // Append technical details
                data.packageTechnicals.forEach((technical, index) => {
                    formData.append(`packageTechnicals[${index}][technical]`, technical.technical);
                    formData.append(`packageTechnicals[${index}][value]`, technical.value);
                });

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
                axios.post(route('products.store'), formData)
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
                if(addOrEdit !== "repeat"){
                    self.product_id = obj ? obj.id : "";
                }else{
                    self.product_id = "";
                }
                self.product.name = obj ? obj.name : "";
                self.product.description = obj ? obj.description : "";
                self.product.category_id = obj ? obj.product_id : "";
                self.getCategories(function () {
                    self.product.category_id = {
                        value: obj.category_id,
                        text: self.categories.find((item) => item.id === obj.category_id)['name']
                    };
                })

                self.getFlavors(function () {
                    self.product.flavor_ids = obj && obj.flavors
                        ? obj.flavors.map(flavor => ({
                            value: flavor.flavor.id,
                            text: flavor.flavor.name
                        }))
                        : [];
                });

                self.product.details_one = obj ? obj.details_one : "";
                self.product.details_two = obj ? obj.details_two : "";
                self.product.details_three = obj ? obj.details_three : "";
                self.product.price = obj ? obj.price : 0;
                self.product.status = obj ? obj.status : 1;
                self.product.serving = obj ? obj.serving : 1;
                self.product.isNew = obj ? obj.isNew : 0;
                self.product.technicals =  [
                    { technical: 'Weight:', value: '' },
                    { technical: 'Product Dimensions:', value: '' },
                    { technical: 'Product EAN:', value: '' },
                ];

                if(obj && obj.technicals){
                    let x1 = obj.technicals.find(({ technical })=>technical === "Weight:");
                    let x2 = obj.technicals.find((item)=>item.technical === "Product Dimensions:");
                    let x3 = obj.technicals.find((item)=>item.technical === "Product EAN:");

                    self.product.technicals.forEach((row)=>{
                        switch (row.technical){
                            case "Weight:":
                                row.value = x1 ? x1.value : "";
                                break;
                            case "Product Dimensions:":
                                row.value = x2 ? x2.value : "";
                                break;
                            case "Product EAN:":
                                row.value = x3 ? x3.value : "";
                                break
                        }
                    })
                }

                self.product.packageTechnicals = [
                    { technical: 'Weight:', value: '' },
                    { technical: 'Box Dimensions:', value: '' },
                    { technical: 'Box EAN:', value: '' },
                ];
                if(obj && obj.package_technicals){
                    let y1 = obj.package_technicals.find((item)=>item.technical === "Weight:");
                    let y2 = obj.package_technicals.find((item)=>item.technical === "Box Dimensions:");
                    let y3 = obj.package_technicals.find((item)=>item.technical === "Box EAN:");

                    self.product.packageTechnicals.forEach((row)=>{
                        switch (row.technical){
                            case "Weight:":
                                row.value = y1 ? y1.value : "";
                                break;
                            case "Box Dimensions:":
                                row.value = y2 ? y2.value : "";
                                break;
                            case "Box EAN:":
                                row.value = y3 ? y3.value : "";
                                break
                        }
                    })
                }
                if(addOrEdit !== "repeat"){
                    self.product.existing_images = obj && obj.images ? obj.images : [];
                }else{
                    self.product.existing_images = [];
                }
                self.images = [];
                self.show = true;
            },

            getFlavors(callback) {
                let self = this;
                axios.get(route('getFlavors'))
                    .then(resp => {
                        if (resp.data.isSuccess) {
                            self.flavors = resp.data.data;
                            if (callback) {
                                callback();
                            }
                        } else {
                            if (resp.data.message) {
                                Swal.fire({
                                    icon: 'error',
                                    title: resp.data.message,
                                    confirmButtonText: "ok"
                                });
                            }
                        }

                    })
                    .catch((err) => {
                        self.showCatchError(err);
                    });

            },

            getCategories(callback = null) {
                let self = this;
                axios.get(route('getCategories'))
                    .then((resp) => {
                        if (resp.data.isSuccess) {
                            self.categories = resp.data.data;
                            if (callback) {
                                callback();
                            }
                        } else {
                            if (resp.data.message) {
                                Swal.fire({
                                    icon: 'error',
                                    title: resp.data.message,
                                    confirmButtonText: "ok"
                                });
                            }
                        }
                    })
                    .catch((err) => {
                        self.showCatchError(err);
                    });
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
                        axios.delete(route('products.destroy', {product: id}))
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
                self.productData = [];
                self.categories = [];
                self.flavors = [];
                self.product = {
                    name: '',
                    description: '',
                    category_id: "",
                    details_one: '',
                    details_two: '',
                    details_three: '',
                    price: 0,
                    isNew: 0,
                    status: 1,
                    serving: 1,
                    flavor_ids: [],
                    existing_images: [],
                    images: [],
                    technicals: [
                        { technical: 'Weight:', value: '' },
                        { technical: 'Product Dimensions:', value: '' },
                        { technical: 'Product EAN:', value: '' },
                    ],
                    packageTechnicals: [
                        { technical: 'Weight:', value: '' },
                        { technical: 'Box Dimensions:', value: '' },
                        { technical: 'Box EAN:', value: '' },
                    ],
                };
                self.product_id = '';
                self.addOrEdit = 'add';
                self.buttonDisabled = false;
                self.show = false;
            },

        },

        computed: {
            searchKeys() {
                let fields = [
                    {
                        key: 'id',
                        label: "ID",
                    },
                    {
                        key: 'name',
                        label: "Name",
                    },
                    {
                        key: 'description',
                        label: "Description",
                    },
                ];
                return fields;
            },
        }

    }
</script>
