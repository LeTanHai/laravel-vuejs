<template>
    <b-container class="login-container">
        <b-row class="shadow logo-background">
            <b-col cols="6" align-self="center">
                <h1 class="text-light font-weight-bold cus-font-size">
                    <span class="text-success">{{$t('pages.admin_login.app_name1')}}</span>
                    {{$t('pages.admin_login.app_name2')}}
                </h1>
            </b-col>
            <b-col cols="6" class="bg-white">
                <form ref="form_login" method="POST">
                    <input type="hidden" name="_token" :value="csrf">
                    <b-form-group>
                        <h1 class="login-welcome font-weight-bold">{{$t('pages.admin_login.welcome')}}</h1>
                    </b-form-group>
                    <b-form-group 
                        label-for="email-input"
                        label-align-sm="left"
                        >
                        <template slot="label">{{$t('pages.admin_login.fields.email')}}<span class="red-star">*</span></template>
                        <b-form-input
                            id="email-input"
                            v-model="fields_values.email"
                            name="email"
                            :state="valid_email"
                            v-on:keyup="keymonitor('email')"
                            >
                        </b-form-input>
                        <b-form-invalid-feedback :state="valid_email">
                            {{$t(mess_error.email)}}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group 
                        label-for="password-input"
                        label-align-sm="left"
                        >
                        <template slot="label">{{$t('pages.admin_login.fields.password')}}<span class="red-star">*</span></template>
                        <b-form-input
                            id="password-input"
                            v-model="fields_values.password"
                            name="password"
                            type="password"
                            :state="valid_password"
                            v-on:keyup="keymonitor('password')"
                            >
                        </b-form-input>
                        <b-form-invalid-feedback :state="valid_password">
                            {{$t(mess_error.password)}}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group v-if='mess_error.all!=""'>
                        <b-alert show variant="danger"> {{$t(mess_error.all)}}</b-alert>
                    </b-form-group>
                    <!-- <b-form-group class="align-content-end">
                        <p style="text-align: right">
                            <span @click="forgotPassword">{{$t('pages.admin_login.forgot_password')}}</span>
                        </p>
                    </b-form-group> -->
                    <b-form-group label-align-sm="right">
                        <b-button variant="success"
                                  class="w-100 text-light"
                                  @click.prevent="login">{{$t('pages.admin_login.btn_login')}}</b-button>
                    </b-form-group>
                </form>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
export default {
    data() {
        return {
            mess_error: {
                email: this.data_init.errors.email || "",
                password: this.data_init.errors.password || "",
                all: this.data_init.errors.all || ""
            },
            fields_values: {
                email: this.data_init.fields_values.email || "",
                password: this.data_init.fields_values.password || "",
            },
            fields_require: {
                email: true,
                password: true
            },
            fields_keypress: {
                email: false,
                password: false
            },
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            url_post: this.data_init.url_post || ""
        }
    },
    props: {
        data_init: {
            type: [Array, Object],
            default() {
                return{}
            }
        }
    },
    computed: {
        valid_email() {
            if (!this.fields_values.email) {
                return null;
            }
            let regx = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!regx.test(this.fields_values.email)) {
                this.mess_error.email = "pages.admin_login.errors.email.mes2";
                return false;
            }
            if (this.fields_keypress.email) {
                this.mess_error.all = "";
            }
            this.mess_error.email = "";
            return true;
        },
        valid_password() {
            if (!this.fields_values.password) {
                return null;
            }
            // let regx = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&]).{8,16}$/;
            // if (!regx.test(this.fields_values.password)) {
            //     this.mess_error.password = "pages.admin_login.errors.password.mes2";
            //     return false;
            // }
            if (this.fields_keypress.password) {
                this.mess_error.all = "";
            }
            this.mess_error.password = "";
            return true;
        }
    },
    methods: {
        check_validate() {
            if (!Object.values(this.mess_error).every((s)=>s === "")) {
                this.mess_error.all = "pages.admin_login.errors.error_all";
                return false;
            }
            for (var key in this.fields_require) {
                if (this.fields_require[key] && !this.fields_values[key]) {
                    this.mess_error.all = "pages.admin_login.errors.error_require";
                    return false;
                }
            }
            return true;
        },
        keymonitor(name) {
            this.fields_keypress[name] = true
            if (event.key == "Enter") {
                this.login();
            }
        },
        login() {
            if (this.check_validate() === true) {
                if (this.url_post) {
                    this.$refs.form_login.action = this.url_post;
                    this.$refs.form_login.submit();
                }
            }
        }
    }
}
</script>