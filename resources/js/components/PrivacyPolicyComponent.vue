<template>
    <div class="container mt-5">
        <h2>Privacy Policy</h2>
        <div class="contact-form mb-4 p-3 border">
            <b-row class="mb-2">
                <b-col>
                    <ckeditor
                        :editor="editor"
                        v-model="privacyPolicy.description"
                        :class="[errors['description'] ? 'error-border': '', 'addFormInputs']">
                    </ckeditor>
                    <small v-if="errors['description']" class="error-msg">{{errors['description'] }}</small>
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
    import CKEditor from '@ckeditor/ckeditor5-vue2';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {

        components: {
            Swal,
            Multiselect,
            PaginationComponent,
            ckeditor: CKEditor.component

        },

        name: "privacyPolicyComponent",

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
                errors: {},
                //default



                //Data
                privacyPolicy: {
                    description: '',
                },
                buttonDisabled: false,
                //Data


            }
        },

        mounted() {
            let self = this;
            PageName.$emit('updatePageName', "Privacy Policy");
            self.getData();

        },

        created() {

        },

        methods: {

            getData() {
                let self = this;
                axios.get(route('privacy_policy.index'))
                    .then((resp) => {
                        if (resp && resp.data) {
                            let obj = resp.data;
                            self.errors = {};
                            self.privacyPolicy.description = obj ? obj.description : "";
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
                let data = Object.assign({}, self.privacyPolicy);

                const formData = new FormData();
                for (let key in data) {
                    formData.append(key, data[key]);
                }
                axios.post(route('privacy_policy.store'), formData)
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
            }
        },
    }
</script>
