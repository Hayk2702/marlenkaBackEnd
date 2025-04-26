<template>
    <div class="container mt-5">
        <h2>Home Highlighty</h2>
        <div class="contact-form mb-4 p-3 border">

            <b-row class="mb-2">
                <b-col>
                    <label>Title</label>
                    <b-form-input
                        :class="[errors['title'] ? 'error-border': '', 'addFormInputs']"
                        v-model="homeHighlighties.title"
                        type="text"
                        placeholder="title"
                    ></b-form-input>
                    <small v-if="errors['title']" class="error-msg">{{ errors['title'] }}</small>
                </b-col>
            </b-row>

            <b-row class="mb-2">
                <b-col>
                    <label>Description One</label>
                    <b-form-input
                        :class="[errors['description_one'] ? 'error-border': '', 'addFormInputs']"
                        v-model="homeHighlighties.description_one"
                        type="text"
                        placeholder="description_one"
                    ></b-form-input>
                    <small v-if="errors['description_one']" class="error-msg">{{ errors['description_one'] }}</small>
                </b-col>
                <b-col>
                    <label>Description Two</label>
                    <b-form-input
                        :class="[errors['description_two'] ? 'error-border': '', 'addFormInputs']"
                        v-model="homeHighlighties.description_two"
                        type="text"
                        placeholder="description_two"
                    ></b-form-input>
                    <small v-if="errors['description_two']" class="error-msg">{{ errors['description_two'] }}</small>
                </b-col>
                <b-col>
                    <label>Description Three</label>
                    <b-form-input
                        :class="[errors['description_three'] ? 'error-border': '', 'addFormInputs']"
                        v-model="homeHighlighties.description_three"
                        type="text"
                        placeholder="description_three"
                    ></b-form-input>
                    <small v-if="errors['description_three']" class="error-msg">{{errors['description_three'] }}</small>
                </b-col>
            </b-row>

            <b-row class="mb-2">
                <b-col>
                    <label>Image</label>
                    <label for="image_path">
                        <template>
                            <img
                                v-if="homeHighlighties && homeHighlighties.image_path && homeHighlighties.image_path_src"
                                :src="homeHighlighties.image_path_src"
                                alt="image_path"
                                style="width: 100px;height:100px; margin-left: 10px;"
                            />
                            <img v-else-if="homeHighlighties && homeHighlighties.image_path_src"
                                 :src="`${homeHighlighties.image_path_src}`"
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
                    > </b-col>
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

    name: "homeHighlightiesComponent",

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

            //Data
            homeHighlighties: {
                title: '',
                description_one: '',
                description_two: '',
                description_three: '',
                image_path: '',
                image_path_src: '',
            },
            buttonDisabled: false,
            //Data


        }
    },

    mounted() {
        let self = this;
        PageName.$emit('updatePageName', "Home Highlighty");
        self.getData();

    },

    created() {

    },

    methods: {

        handleFileUploadImage(event) {
            let self = this;
            if (event.target && event.target.files && event.target.files[0]) {
                self.homeHighlighties.image_path = event.target.files[0];
                self.homeHighlighties.image_path_src = URL.createObjectURL(event.target.files[0]);
            }
        },

        getData() {
            let self = this;
            axios.get(route('home_highlighties.index'))
                .then((resp) => {
                    if (resp && resp.data) {
                        let obj = resp.data;
                        self.errors = {};
                        self.homeHighlighties.title = obj ? obj.title : "";
                        self.homeHighlighties.description_one = obj ? obj.description_one : "";
                        self.homeHighlighties.description_two = obj ? obj.description_two : "";
                        self.homeHighlighties.description_three = obj ? obj.description_three : "";
                        self.homeHighlighties.image_path = "";
                        self.homeHighlighties.image_path_src = obj ? obj.image_path : "";
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
            let data = Object.assign({}, self.homeHighlighties);

            const formData = new FormData();
            formData.append('image_path', self.homeHighlighties.image_path);
            formData.append('image_path_src', self.homeHighlighties.image_path_src);
            for (let key in data) {
                formData.append(key, data[key]);
            }
            axios.post(route('home_highlighties.store'), formData)
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
