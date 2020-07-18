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
                        label-cols-sm="2"
                        label-align-sm="right"
                            >
                <template slot="label">{{$t('users.fields.user_name')}}<span class="red-star">*</span></template>
                <b-row>
                    <b-col cols="12">
                        <div class="input-group">
                            <input type="text" v-model="click_selected.user_name" class="form-control"
                            aria-describedby="basic-addon2" v-on:keyup="handlerEnter" v-on:blur="handleSearch">
                            <div class="input-group-append">
                                <b-button class="btn btn-custom-search" variant="secondary" 
                                    @click.prevent="call_modal_list_combo_box('user_modals_combo_box')">
                                    {{$t('users.btn.btn_search')}}
                                </b-button>
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
                    v-model="click_selected.address"
                    :state="valid_address"
                    required
                    disabled
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
            <template v-if="objInit.typeModal == 'New'">
                <b-button class="text-right" right @click.prevent="handlenew"> Save </b-button>
            </template>
            <template v-else>
                <b-button class="ml-1 float-right" @click.prevent="handleEdit"> Save </b-button>
                <b-button class="float-right" @click.prevent="handleDelete"> Delete </b-button>
            </template>
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
                location_id: "",
                user_id: ""
            },
            fields_required: {
                name: true,
                code: true,
                location_id: true,
                user_id: true
            },
            error_messages: {
                name: "",
                code: "",
                description: "",
                location_id: "",
                all_error: "",
                user_id: ""
            },
            latLongAddress: "",
            click_selected: {
                user_name: "",
                address: ""
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
                this.error_messages.name = "products.errors.name.min";
                return false;
            }
            if (this.fields_values.name.length > 15) {
                this.error_messages.name = "products.errors.name.max";
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
                this.error_messages.code = "products.errors.code.min";
                return false;
            }
            if (this.fields_values.code.length > 15) {
                this.error_messages.code = "products.errors.code.max";
                return false;
            }
            this.error_messages.code = "";
            this.error_messages.all_error = "";
            return true;
        },
        valid_address() {
            if (!this.fields_values.location_id) {
                return null;
            }
            if (this.fields_values.location_id.length < 2) {
                this.error_messages.location_id = "products.errors.address.min";
                return false;
            }
            if (this.fields_values.location_id.length > 15) {
                this.error_messages.location_id = "products.errors.address.max";
                return false;
            }
            this.error_messages.location_id = "";
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
            this.error_messages.user_id = check?"":"products.errors.user_id.invalid";
            return check;
        }
    },
    methods: {
        async showModal(objInit) {
            _.extend(this.objInit,objInit);
            switch (this.objInit.typeModal){
                case "New":
                    this.fields_values = {
                        name: "",
                        code: "",
                        location_id: "",
                        user_id: "",
                        description: ""
                    }
                    this.click_selected.user_name = "";
                    this.click_selected.address = "";
                    this.error_messages.all_error = "";
                    return this.$refs["product_modal_new"].show();
                case "Edit":
                    let data = {
                        type: 'view',
                        id: this.objInit.id
                    }
                    this.click_selected.user_name = "";
                    this.click_selected.address = "";
                    this.fields_values.user_id = "";
                    const response = await axios.get('/product', {params: data});
                    _.extend(this.fields_values, response.data);
                    this.click_selected.user_name = response.data.email;
                    this.handleSearch();
                    return this.$refs["product_modal_new"].show();    
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
        async handlenew() {
            if (this.checkValidateAllFields()) {
                try {
                    let data = _.clone(this.fields_values, true);
                    data.type = "new";
                    const response = await axios.post('/newProduct', data);
                    if (response.data.error) {
                        return this.error_messages.all_error = response.data.error;
                    }
                    this.$refs["product_modal_new"].hide();
                    this.callBack();
                }
                catch(error) {
                    console.log(error);
                }

            }
        },
        async handleEdit() {
            if (this.checkValidateAllFields()) {
                let data = _.clone(this.fields_values, true);
                data.type = "edit";
                data.id = this.objInit.id;
                const response = await axios.post('/newProduct', data);
            }
        },
        handleDelete() {
            this.$bvModal.msgBoxConfirm(this.$t("products.modal_delete.content"), {
                    title: this.$t("products.modal_delete.title"),
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: this.$t("products.modal_delete.btn_ok"),
                    cancelTitle: this.$t("products.modal_delete.btn_no"),
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                        .then(value => {
                            if (value === true) {
                                let data = {
                                    id: this.fields_values.id,
                                    type: 'delete'
                                }
                                axios
                                    .post("/newProduct", data)
                                    .then(response => {
                                        if (response.data.error) {
                                            return this.error_messages.all = response.data.error;
                                        }
                                        this.$refs['product_modal_new'].hide();
                                    })
                                    .catch(error => console.log(error))
                                    .finally(() => {
                                        this.$parent.callBack();
                                    })
                            }
                        })
                        .catch(err => {
                            // An error occurred
                        })
        },
        async handleSearch() {
            let data = {
                keySearch: this.click_selected.user_name,
                type: "combo_box"
            }
            const response = await axios.get('/combo_box', {params: data});
            if (response.data.length === 1) {
                this.fields_values.user_id = response.data[0].id;
                this.fields_values.location_id = response.data[0].location_id;
                this.click_selected.user_name = response.data[0].name;
                this.click_selected.address = response.data[0].origin;
                return;
            }
            this.fields_values.user_id = "";
            this.fields_values.location_id = "";
        },
        async handlerEnter(event) {
            if (event.keyCode === 13) {
                this.handleSearch();
            }
            this.fields_values.user_id = "";
            this.fields_values.location_id = "";
            this.click_selected.address = ""
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
            this.$refs[nameCombo].showModal({keySearch: this.click_selected.user_name});
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
                    this.fields_values.location_id = objInit.data.location_id;
                    this.click_selected.user_name = objInit.data.name;
                    this.click_selected.address = objInit.data.destination;
                    break;
            }
        }
    }
}
</script>