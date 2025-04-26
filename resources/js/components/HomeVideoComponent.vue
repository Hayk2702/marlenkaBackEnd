<template>
    <div class="container mt-5">
        <h2>Home Video</h2>
        <div class="contact-form mb-4 p-3 border">
            <h4>Youtube</h4>
            <b-row class="mb-2">
                <b-col>
                    <label>Youtube Code</label>
                    <b-form-input
                        :class="[errors['youtube_code'] ? 'error-border': '', 'addFormInputs']"
                        v-model="homeVideo.youtube_code"
                        type="text"
                        placeholder="youtube_code"
                    ></b-form-input>
                    <small v-if="errors['youtube_code']" class="error-msg">{{errors['youtube_code'] }}</small>
                </b-col>
            </b-row>

            <b-button variant="primary" @click="sendData()">Update</b-button>
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

        name: "homeVideoComponent",

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
                errors: {},
                //default

                //Data
                homeVideo: {
                    youtube_code: '',
                },
                buttonDisabled: false,
                //Data


            }
        },

        mounted() {
            let self = this;
            PageName.$emit('updatePageName', "Home Video");
            self.getData();

        },

        created() {

        },

        methods: {

            getData() {
                let self = this;
                axios.get(route('home_video.index'))
                    .then((resp) => {
                        if (resp && resp.data ) {
                            let obj = resp.data
                            self.errors = {};
                            self.homeVideo.youtube_code = obj ? obj.youtube_code : "";
                        }
                    })

                    .catch((err) => {
                        self.showCatchError(err);
                    });
            },

            sendData() {
                if (this.buttonDisabled) {
                    return;
                }
                this.buttonDisabled = true;
                let self = this;
                self.errors = {};
                let data = Object.assign({}, self.homeVideo);
                axios.post(route('home_video.store'), data)
                    .then((data) => {
                        if (data && data.data && data.data.isSuccess) {
                            self.getData();

                            Swal.fire(
                                "success",
                                '',
                                'success'
                            );
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

        },
    }
</script>
