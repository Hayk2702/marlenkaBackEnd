<template>
    <div>
        <div>
            <div>
                <SearchComponent
                    ref="SearchComponent"
                    @filter-updated="updateFilter"
                    :keys="searchKeys"
                    :dateKeys="['orders.created_at']"
                    :isCondition=true
                    :isAction=true
                ></SearchComponent>
            </div>
            <div class="row justify-content-center mt-5">
                <div>
                    <div class="parent_card_pagination">
                        <div class="card">
                            <div>
                                <b-tabs>
                                    <b-tab @click="resetPagination('order')" title="Orders">
                                        <template v-if="status === 'order'">
                                            <div>
                                                <b-table
                                                    :class="'table_line'"
                                                    :stacked="!showTableLine"
                                                    :responsive="showTableLine"
                                                    ref="table"
                                                    :busy="isBusy"
                                                    :hover="showTableLine"
                                                    :items="getData"
                                                    :fields="fields"
                                                    :sort-by.sync="sortBy"
                                                    :sort-desc.sync="sortDesc"
                                                    :apiUrl="getRout('orders.index')"
                                                    :perPage="paginate.perPage"
                                                    :currentPage="paginate.currentPage"
                                                    :striped="showTableLine"
                                                    :small="showTableLine"
                                                    :bordered="showTableLine"
                                                    :filter="filter"
                                                    :tbody-tr-class="rowClass"
                                                    label-sort-asc=""
                                                    label-sort-desc=""
                                                    label-sort-clear=""

                                                >
                                                    <template #table-busy>
                                                        <div class="text-center text-danger my-2">
                                                            <b-spinner class="align-middle"></b-spinner>
                                                            <strong>loaded</strong></div>
                                                    </template>
                                                    <template #cell(actions)="row">
                                                        <button
                                                                class=" btn btn-inverse-warning  p-1 a_position"
                                                                @click="showAddOrEditForm(row.item)">
                                                            <i class="bi bi-eye title_hov_top">
                                                                <svg v-b-tooltip.hover
                                                                     xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                     fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                                </svg>
                                                            </i>
                                                        </button>
                                                        <button  v-b-tooltip.hover class="btn btn-danger p-1 a_position"
                                                                 @click="finishOrder(row.item.id)">
                                                            <i class="bi bi-calendar-check title_hov_top" data-title="Delete">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     width="24" height="24" fill="black" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                                    <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                                                </svg>
                                                            </i>
                                                        </button>
                                                    </template>
                                                </b-table>
                                            </div>
                                        </template>
                                    </b-tab>
                                    <b-tab
                                           @click="resetPagination('finish_order')" title="Finished Orders">
                                        <template v-if="status === 'finish_order'">
                                            <div>
                                                <b-table
                                                    :class="'table_line'"
                                                    :stacked="!showTableLine"
                                                    :responsive="showTableLine"
                                                    ref="table"
                                                    :busy="isBusy"
                                                    :hover="showTableLine"
                                                    :items="getData"
                                                    :fields="fields"
                                                    :sort-by.sync="sortBy"
                                                    :sort-desc.sync="sortDesc"
                                                    :apiUrl="getRout('orders.index')"
                                                    :perPage="paginate.perPage"
                                                    :currentPage="paginate.currentPage"
                                                    :striped="showTableLine"
                                                    :small="showTableLine"
                                                    :bordered="showTableLine"
                                                    :filter="filter"
                                                    label-sort-asc=""
                                                    label-sort-desc=""
                                                    label-sort-clear=""

                                                >
                                                    <template #table-busy>
                                                        <div class="text-center text-danger my-2">
                                                            <b-spinner class="align-middle"></b-spinner>
                                                            <strong>loaded</strong></div>
                                                    </template>
                                                    <template #cell(actions)="row">
                                                        <button
                                                            class=" btn btn-inverse-warning  p-1 a_position"
                                                            @click="showAddOrEditForm(row.item)">
                                                            <i class="bi bi-eye title_hov_top">
                                                                <svg v-b-tooltip.hover
                                                                     xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                     fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                                </svg>
                                                            </i>
                                                        </button>
                                                    </template>
                                                </b-table>

                                            </div>
                                        </template>
                                    </b-tab>
                                </b-tabs>
                            </div>
                        </div>
                        <PaginationComponent ref="PaginationComponent"
                                             v-if="Object.keys(orders).length > 0"
                                             :paginate="paginate"
                                             @loadAfterChangePage="loadAfterChangePage">
                        </PaginationComponent>
                        <b-modal
                            id="order-modal"
                            title="Order Products"
                            hide-footer
                            v-model="show"
                        >
                            <div v-if="selectedData.length > 0">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="color : black;">Product ID</th>
                                        <th style="color : black;">Product name</th>
                                        <th style="color : black;">Product description</th>
                                        <th style="color : black;">Count</th>
                                        <th style="color : black;">Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(product, index) in selectedData" :key="index">
                                        <td>{{ product.product_id }}</td>
                                        <td>{{ product.product.name }}</td>
                                        <td>{{ product.product.description }}</td>
                                        <td>{{ product.count }}</td>
                                        <td>{{ product.price }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div v-else>
                                No order products found.
                            </div>
                        </b-modal>
                    </div>
                </div>
            </div>
            <template>
                <div v-if="isLoading">
                    <svg class="pl" style="margin: 0 auto;" viewBox="0 0 200 200" width="200" height="200"
                         xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="pl-grad1" x1="1" y1="0.5" x2="0" y2="0.5">
                                <stop offset="0%" stop-color="hsl(313,90%,55%)"/>
                                <stop offset="100%" stop-color="hsl(223,90%,55%)"/>
                            </linearGradient>
                            <linearGradient id="pl-grad2" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="hsl(313,90%,55%)"/>
                                <stop offset="100%" stop-color="hsl(223,90%,55%)"/>
                            </linearGradient>
                        </defs>
                        <circle class="pl__ring" cx="100" cy="100" r="82" fill="none" stroke="url(#pl-grad1)"
                                stroke-width="36" stroke-dasharray="0 257 1 257" stroke-dashoffset="0.01"
                                stroke-linecap="round" transform="rotate(-90,100,100)"/>
                        <line class="pl__ball" stroke="url(#pl-grad2)" x1="100" y1="18" x2="100.01" y2="182"
                              stroke-width="36" stroke-dasharray="1 165" stroke-linecap="round"/>
                    </svg>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
import PaginationComponent from "./PaginationComponent";
import SearchComponent from "./SearchComponent";
import {PageName} from '../PageName';
import Multiselect from "vue-multiselect";
import Datepicker from "vue2-datepicker-mask";

export default {
    components: {
        Datepicker,
        Multiselect,
        Swal,
        PaginationComponent,
        SearchComponent,
    },

    name: "OrdersComponent",

    props: [
        'authuser',
    ],

    watch: {

        filter: {
            handler(newVal, oldVal) {
                this.paginate.currentPage = 1;
            },
            deep: true,
        },
        authuser: function (newVal, oldVal) {
            this.authUser = newVal;
        },
    },

    data() {
        return {
            //default
            authUser: this.authuser,

            paginate: {
                perPage: 10,
                currentPage: 1,
                total: '',
                currentPageInput: '',
                lastPage: '',
            },
            errors: {},

            //default


            //BTable
            showTableLine: true,
            fields: [
                {
                    key: 'id',
                    label: "ID",
                    sortable: true
                },
                {
                    key: 'created_at',
                    label: "Date",
                    sortable: true
                },
                {
                    key: 'transaction',
                    label: "Transaction",
                    sortable: true
                },
                {
                    key: 'payment_amount',
                    label: "Payment amount",
                    sortable: true
                },
                {
                    key: 'tax',
                    label: "Tax",
                    sortable: true
                },
                {
                    key: 'payment_method',
                    label: "Payment method",
                    sortable: true
                },
                {
                    key: 'name',
                    label: "Name",
                    sortable: true
                },
                {
                    key: 'surname',
                    label: "Surname",
                    sortable: true
                },
                {
                    key: 'company_name',
                    label: "Company Name",
                    sortable: true
                },
                {
                    key: 'email',
                    label: "email",
                    sortable: true
                },
                {
                    key: 'phone_number',
                    label: "Phone number",
                    sortable: true
                },
                {
                    key: 'country',
                    label: "Country",
                    sortable: true
                },
                {
                    key: 'city',
                    label: "City",
                    sortable: true
                },
                {
                    key: 'address',
                    label: "Address",
                    sortable: true
                },
                {
                    key: 'apartment',
                    label: "Apartment",
                    sortable: true
                },
                {
                    key: 'state',
                    label: "State",
                    sortable: true
                },
                {
                    key: 'zip_code',
                    label: "ZIP Code",
                    sortable: true
                },
                {
                    key: 'notes',
                    label: "Notes",
                    sortable: true
                },
                {
                    key: 'type',
                    label: "Type",
                    sortable: true
                },
                {
                    key: 'ip_address',
                    label: "IP",
                    sortable: true
                },
                {
                    key: 'actions',
                    label: "Action",
                    sortable: true,
                    formatter: (val, key, row) => {
                        return '';
                    }
                }
            ],

            isBusy: false,
            total: '',
            sortBy: 'orders.id',
            sortDesc: false,
            filter: [
                {
                    text: '',
                    key: '',
                }
            ],
            //BTable

            //Modal
            show: false,
            headerBgVariant: 'custom',
            headerTextVariant: 'white',

            //Modal
            orders: [],
            order_id: '',


            addOrEdit: 'add',
            buttonDisabled: false,
            isLoading: true,
            status: 'order',
            selectedData: [],


        }
    },

    mounted() {
        let self = this;
        PageName.$emit('updatePageName', "Orders");
    },

    created() {
        let self = this;
    },

    methods: {

        getData(data) {
            let self = this;
            data['status'] = self.status;
            return axios.get(route('orders.index') + `?page=${data.currentPage}`, {params: data})
                .then((resp) => {
                    if (resp && resp.data && resp.data.data) {
                        self.orders = resp.data.data;
                        self.paginate.rows = resp.data.total;
                        self.paginate.total = resp.data.total;
                        self.paginate.currentPage = resp.data.current_page;
                        self.paginate.currentPageInput = self.paginate.currentPage;
                        self.paginate.lastPage = resp.data.last_page;
                        self.isBusy = false;
                        self.isLoading = false;
                        return self.orders;
                    } else {
                        self.isBusy = false;
                        self.isLoading = false;
                        return [];
                    }
                })
                .catch((err) => {
                    self.showCatchError(err);
                });
        },

        updateFilter(newFilter) {
            this.filter = newFilter;
        },

        loadAfterChangePage(currentPage, perPage) {
            if (currentPage) {
                this.paginate.currentPage = currentPage;
            }
            if (perPage) {
                this.paginate.perPage = perPage;

            }
        },

        showAddOrEditForm(obj = '') {

            let self = this;
            self.selectedData = [];
            if(obj && obj.order_products && obj.order_products.length){
                self.selectedData = obj.order_products;
            }
            self.show = true;
        },


        finishOrder(id) {
            let self = this;
            Swal.fire({
                title: "Sure ?",
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "YES",
                cancelButtonText: "NO",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(route('finishOrder'), {order: id})
                        .then((data) => {
                            if (data && data.data && data.data.isSuccess) {
                                self.$refs.table.refresh();
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

        getRout(name, param = '') {
            if (param)
                return route(name, param);
            return route(name);
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

        resetData() {
            let self = this;
            self.orders = [];
            self.isLoading = true;
            self.errors = {};
            self.order = {
                name: '',
                description: '',
                from: '',
                from_id: '',
                to: '',
                to_id: '',
                send_user_id: '',
                need_date: '',
                products: [
                    {
                        type: '',
                        id: '',
                        count: 1,
                        data: [],
                    }
                ],
            };
            self.order_id = '';
            self.order_id = '';
            self.addOrEdit = 'add';
            self.buttonDisabled = false;
        },

        resetPagination(tabName = 'order') {
            let self = this;
            self.sortBy = 'orders.id';
            self.sortDesc = false;
            self.paginate = {
                perPage: 10,
                currentPage: 1,
                total: '',
                currentPageInput: '',
                lastPage: '',
            };
            self.isBusy = false;
            self.filter = [
                {
                    text: '',
                    key: '',
                }
            ];
            this.$refs.SearchComponent.resetFilter();
            self.status = tabName;

        },

        rowClass(item) {
            return '';
        },

    },


    computed: {
        searchKeys() {
            let fields = [
                {
                    key: 'orders.id',
                    label: "ID",
                },
                {
                    key: 'orders.created_at',
                    label: "Date",
                },
                {
                    key: 'orders.transaction',
                    label: "Transaction",
                },
                {
                    key: 'orders.payment_amount',
                    label: "Payment amount",
                },
                {
                    key: 'orders.payment_method',
                    label: "Payment method",
                },
                {
                    key: 'name',
                    label: "Name",
                },
                {
                    key: 'surname',
                    label: "Surname",
                },
                {
                    key: 'email',
                    label: "email",
                },
                {
                    key: 'phone_number',
                    label: "Phone number",
                },
                {
                    key: 'country',
                    label: "Country",
                },
                {
                    key: 'city',
                    label: "City",
                },
                {
                    key: 'address',
                    label: "Address",
                },
                {
                    key: 'ip_address',
                    label: "IP",
                },
            ];
            return fields;
        },
    }

}
</script>

<style scoped>
.isBroken__wrapper {
    display: flex;
    align-items: center;
    column-gap: 5px;
}

.isBroken__dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-left: 15px;
}

.isBroken__dot-green {
    background-color: #38ae00;
}

.isBroken__dot-red {
    background-color: #f3530e;
}

.isBroken__name-green {
    color: #38ae00;
}

.isBroken__name-red {
    color: #f3530e;
}

.newRow {
    display: flex;
    align-items: flex-start;
    column-gap: 7px;
    margin-top: 15px;
    background-color: #dddfe5;
    padding: 8px 5px;
    border-radius: 8px;
}

.new_line_complate_order {
    display: flex;
    flex-direction: column;
    /* column-gap: 7px; */
    margin-top: 15px;
    background-color: #dddfe5;
    padding: 15px 20px;
    border-radius: 8px;
}

.new_line_complate_card {
    border: 1px solid #ccc !important;
    margin-top: 8px;
    padding: 20px 10px;
    border-radius: 8px;
}

.new_line_head {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.pl {
    display: block;
    width: 6.25em;
    height: 6.25em;
}

.pl__ring, .pl__ball {
    animation: ring 2s ease-out infinite;
}

.pl__ball {
    animation-name: ball;
}

/* Dark theme  */
@media (prefers-color-scheme: dark) {
    :root {
        --bg: hsl(var(--hue), 10%, 10%);
        --fg: hsl(var(--hue), 10%, 90%);
    }
}

/* Animation */
@keyframes ring {
    from {
        stroke-dasharray: 0 257 0 0 1 0 0 258;
    }
    25% {
        stroke-dasharray: 0 0 0 0 257 0 258 0;
    }
    50%, to {
        stroke-dasharray: 0 0 0 0 0 515 0 0;
    }
}

@keyframes ball {
    from, 50% {
        animation-timing-function: ease-in;
        stroke-dashoffset: 1;
    }
    64% {
        animation-timing-function: ease-in;
        stroke-dashoffset: -109;
    }
    78% {
        animation-timing-function: ease-in;
        stroke-dashoffset: -145;
    }
    92% {
        animation-timing-function: ease-in;
        stroke-dashoffset: -157;
    }
    57%, 71%, 85%, 99%, to {
        animation-timing-function: ease-out;
        stroke-dashoffset: -163;
    }
}
</style>
