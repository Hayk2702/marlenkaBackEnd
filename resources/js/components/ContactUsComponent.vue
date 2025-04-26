<template>
    <div class="container mt-5">
        <h2>Contact Information</h2>
        <div class="contact-form mb-4 p-3 border">
            <h4>Contact Us</h4>
            <b-row class="mb-2">
                <b-col>
                    <label>Phone Number</label>
                    <b-form-input
                        v-model="contactUs.phone_number"
                        :class="{ 'error-border': errors['phone_number'] }"
                        placeholder="Phone Number"
                    ></b-form-input>
                    <small v-if="errors['phone_number']" class="text-danger">{{ errors['phone_number'] }}</small>
                </b-col>
                <b-col>
                    <label>WhatsApp</label>
                    <b-form-input
                        v-model="contactUs.whatsapp"
                        :class="{ 'error-border': errors['whatsapp'] }"
                        placeholder="WhatsApp"
                    ></b-form-input>
                    <small v-if="errors['whatsapp']" class="text-danger">{{ errors['whatsapp'] }}</small>
                </b-col>
            </b-row>

            <b-row class="mb-2">
                <b-col>
                    <label>Email</label>
                    <b-form-input
                        v-model="contactUs.email"
                        :class="{ 'error-border': errors['email'] }"
                        placeholder="Email"
                    ></b-form-input>
                    <small v-if="errors['email']" class="text-danger">{{ errors['email'] }}</small>
                </b-col>
                <b-col>
                    <label>Facebook Link</label>
                    <b-form-input
                        v-model="contactUs.facebook_link"
                        :class="{ 'error-border': errors['facebook_link'] }"
                        placeholder="Facebook Link"
                    ></b-form-input>
                    <small v-if="errors['facebook_link']" class="text-danger">{{ errors['facebook_link'] }}</small>
                </b-col>
            </b-row>

            <b-row class="mb-2">
                <b-col>
                    <label>Instagram Link</label>
                    <b-form-input
                        v-model="contactUs.instagram_link"
                        :class="{ 'error-border': errors['instagram_link'] }"
                        placeholder="Instagram Link"
                    ></b-form-input>
                    <small v-if="errors['instagram_link']" class="text-danger">{{ errors['instagram_link'] }}</small>
                </b-col>
                <b-col>
                    <label>Gmail Link</label>
                    <b-form-input
                        v-model="contactUs.gmail_link"
                        :class="{ 'error-border': errors['gmail_link'] }"
                        placeholder="Gmail Link"
                    ></b-form-input>
                    <small v-if="errors['gmail_link']" class="text-danger">{{ errors['gmail_link'] }}</small>
                </b-col>
            </b-row>

            <b-row class="mb-2">
                <b-col>
                    <label>LinkedIn Link</label>
                    <b-form-input
                        v-model="contactUs.linkedin_link"
                        :class="{ 'error-border': errors['linkedin_link'] }"
                        placeholder="LinkedIn Link"
                    ></b-form-input>
                    <small v-if="errors['linkedin_link']" class="text-danger">{{ errors['linkedin_link'] }}</small>
                </b-col>
                <b-col>
                    <label>Twitter Link</label>
                    <b-form-input
                        v-model="contactUs.twitter_link"
                        :class="{ 'error-border': errors['twitter_link'] }"
                        placeholder="Twitter Link"
                    ></b-form-input>
                    <small v-if="errors['twitter_link']" class="text-danger">{{ errors['twitter_link'] }}</small>
                </b-col>
            </b-row>

            <b-row class="mb-2">
                <b-col>
                    <label>YouTube Link</label>
                    <b-form-input
                        v-model="contactUs.youtube_link"
                        :class="{ 'error-border': errors['youtube_link'] }"
                        placeholder="YouTube Link"
                    ></b-form-input>
                    <small v-if="errors['youtube_link']" class="text-danger">{{ errors['youtube_link'] }}</small>
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

    name: "ContactUsComponent",

    props: [
        'authuser',
    ],

    watch: {
        authuser: function (newVal, oldVal) {
            this.authUser = newVal;
        },
        filter: {
            handler(newVal, oldVal) {
                this.paginate.currentPage = 1;
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

            contactUs: {
                phone_number: '',
                whatsapp: '',
                email: '',
                facebook_link: '',
                instagram_link: '',
                gmail_link: '',
                linkedin_link: '',
                twitter_link: '',
                youtube_link: '',
            },
            buttonDisabled: false,
            //Data


        }
    },

    mounted() {
        let self = this;
        PageName.$emit('updatePageName', "Contact Us");
        self.getData();
    },

    created() {

    },

    methods: {

        getData() {
            let self = this;
            axios.get(route('contact_us.index'))
                .then((resp) => {
                    if (resp && resp.data) {
                        let obj = resp.data;
                        self.errors = {};
                        self.contactUs.phone_number = obj ? obj.phone_number : "";
                        self.contactUs.whatsapp = obj ? obj.whatsapp : "";
                        self.contactUs.email = obj ? obj.email : "";
                        self.contactUs.facebook_link = obj ? obj.facebook_link : "";
                        self.contactUs.instagram_link = obj ? obj.instagram_link : "";
                        self.contactUs.gmail_link = obj ? obj.gmail_link : "";
                        self.contactUs.linkedin_link = obj ? obj.linkedin_link : "";
                        self.contactUs.twitter_link = obj ? obj.twitter_link : "";
                        self.contactUs.youtube_link = obj ? obj.youtube_link : "";
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
            let data = Object.assign({}, self.contactUs);
            axios.post(route('contact_us.store'), data)
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
