<template>
    <div>
        <b-modal
            size="lg"
            id="product_modal_new"
            ref="product_modal_new"
            hide-footer
            scrollable
            header-text-variant="light"
            header-class="nav-custom">
            <template v-if="objInit.typeModal=='New'" v-slot:modal-title>
                {{$t('products.modal_title.new')}}
            </template>
            <template v-else v-slot:modal-title>
                {{$t('products.modal_title.edit')}}
            </template>
            <b-form-group
                label-for="name-input"
                label-cols-sm="2"
                label-align-sm="right"
                >
                <template slot="label">{{$t('products.fields.name')}}<span class="red-star">*</span></template>
                <b-form-input
                    id="name-input"
                    v-model="fields_values.name"
                    :state="valid_name"
                    required
                    >
                </b-form-input>
                <b-form-invalid-feedback :state="valid_name">
                    {{$t(error_messages.name)}}
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-group
                label-for="code-input"
                label-cols-sm="2"
                label-align-sm="right"
                >
                <template slot="label">{{$t('products.fields.code')}}<span class="red-star">*</span></template>
                <b-form-input
                    id="code-input"
                    v-model="fields_values.code"
                    :state="valid_code"
                    required
                    >
                </b-form-input>
                <b-form-invalid-feedback :state="valid_code">
                    {{$t(error_messages.code)}}
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-group label-for="user_id-input"
                        label-cols-sm="3"
                        label-align-sm="right"
                            >
                <template slot="label">{{$t('users.fields.user_id')}}<span class="red-star">*</span></template>
                <b-row>
                    <b-col cols="12">
                        <div class="input-group">
                            <input type="text"  v-model="click_selected.user_name" class="form-control"  aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-cus-selected"  @click.prevent="call_modal_list_combo_box('user_modals_combo_box')" type="button">
                                    {{$t('users.btn.user_search')}}
                                </button>
                            </div>
                        </div>        
                    </b-col>
                </b-row>
                <b-form-invalid-feedback :state="valid_user_id">
                    {{$t(error_messages.user_id)}}
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-group
                label-for="address-input"
                label-cols-sm="2"
                label-align-sm="right"
                >
                <template slot="label">{{$t('products.fields.address')}}<span class="red-star">*</span></template>
                <b-form-input
                    id="address-input"
                    v-model="fields_values.address"
                    :state="valid_address"
                    required
                    >
                </b-form-input>
                <b-form-invalid-feedback :state="valid_address">
                    {{$t(error_messages.address)}}
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-group
                label-for="description-input"
                label-cols-sm="2"
                label-align-sm="right"
                >
                <template slot="label">{{$t('products.fields.description')}}</template>
                <b-form-input
                    id="description-input"
                    v-model="fields_values.description"
                    :state="valid_description"
                    required
                    >
                </b-form-input>
                <b-form-invalid-feedback :state="valid_description">
                    {{$t(error_messages.description)}}
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-group v-if='error_messages.all_error!=""'>
                <b-alert show variant="danger"> {{$t(error_messages.all_error)}}</b-alert>
                </b-form-group>
            <b-button right @click.prevent="handlenew"> Save </b-button>
        </b-modal>
        <user_modals_combo_box ref="user_modals_combo_box"></user_modals_combo_box>
    </div>
</template>

<script>
export default {
    data() {
        return {
            objInit: {
                typeModal: ""
            },
            fields_values: {
                name: "",
                code: "",
                description: "",
                address: "",
                user_id: ""
            },
            fields_required: {
                name: true,
                code: true,
                address: true,
                user_id: true
            },
            error_messages: {
                name: "",
                code: "",
                description: "",
                address: "",
                all_error: "",
                user_id: ""
            },
            latLongAddress: "",
            click_selected: {
                user_name: ""
            },
            dataCallBack: {
                action: "",
                data: {}
            }
        }
    },
    computed: {
        valid_name() {
            if (!this.fields_values.name) {
                return null;
            }
            if (this.fields_values.name.length < 2) {
                this.error_messages.name = "products.error.name.min";
                return false;
            }
            if (this.fields_values.name.length > 15) {
                this.error_messages.name = "products.error.name.max";
                return false;
            }
            this.error_messages.name = "";
            this.error_messages.all_error = "";
            return true;
        },
        valid_code() {
            if (!this.fields_values.code) {
                return null;
            }
            if (this.fields_values.code.length < 2) {
                this.error_messages.code = "products.error.code.min";
                return false;
            }
            if (this.fields_values.code.length > 15) {
                this.error_messages.code = "products.error.code.max";
                return false;
            }
            this.error_messages.code = "";
            this.error_messages.all_error = "";
            return true;
        },
        valid_address() {
            if (!this.fields_values.address) {
                return null;
            }
            if (this.fields_values.address.length < 2) {
                this.error_messages.address = "products.error.address.min";
                return false;
            }
            if (this.fields_values.address.length > 15) {
                this.error_messages.address = "products.error.address.max";
                return false;
            }
            this.error_messages.address = "";
            this.error_messages.all_error = "";
            return true;
        },
        valid_description() {
            if (!this.fields_values.description) {
                return null;
            }
            this.error_messages.description = "";
            this.error_messages.all_error = "";
            return true;
        },
        valid_user_id() {
            if (!this.fields_values.user_id) {
                return null;
            }
            let check = this.fields_values.user_id > 0;
            this.error_messages.user_id = check?"":"products.error.user_id.invalid";
            return check;
        }
    },
    methods: {
        showModal(objInit) {
            _.extend(this.objInit,objInit);
            switch (this.objInit.typeModal){
                case "New":
                    this.fields_values = {
                        name: "",
                        code: "",
                        address: "",
                        description: ""
                    }
                    this.error_messages.all_error = "";
                    return this.$refs["product_modal_new"].show();
                case "Edit":

            }
        },
        checkValidateAllFields() {
            if (!Object.values(this.error_messages).every((s)=>s === "")) {
                this.error_messages.all_error = "products.errors.error_all";
                return false;
            }
            for (var key in this.fields_required) {
                if (this.fields_required[key] == true && !this.fields_values[key]) {
                    this.error_messages.all_error = "products.errors.required";
                    return false;
                }
            }
            return true;
        },
        handlenew() {
            if (this.checkValidateAllFields()) {
                console.log("Trueeeeeee");
                this.geocodeAddress();
                console.log(this.latLongAddress);
            }
        },
        geocodeAddress() {
            var geocoder = new google.maps.Geocoder();
            var that = this;
            geocoder.geocode({'address': this.fields_values.address}, function(results, status) {
                if (status === 'OK') {
                    that.latLongAddress= results[0].geometry.location;
                }
            });
        },
        call_modal_list_combo_box(nameCombo) {
            this.$refs[nameCombo].showModal();
        },
        callBack(objInit) {
            if (typeof objInit === 'undefined') {
                if (typeof this.$parent.callBack == 'function') {
                    this.$parent.callBack(this.dataCallBack);
                }
            }
            switch (objInit.action) {
                case "selected_user":
                    this.fields_values.user_id = objInit.data.id;
                    this.click_selected.user_name = objInit.data.name;
                    break;
            }
        }
    }
}
</script>