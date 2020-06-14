<template>
    <div>
        <b-modal
            size="md"
            id="user_modal_combo_box"
            ref="user_modal_combo_box"
            hide-footer
            scrollable
            header-text-variant="light"
            header-class="nav-custom">
            <template v-slot:modal-title> View </template>
            <b-container>
                <b-row>
                    <b-col cols="12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{$t('users.combo_box.keySearch')}}</span>
                            </div>
                            <b-form-input class="form-control"
                                            v-model="filter.keySearch"
                                            >
                            </b-form-input>
                            <div class="input-group-append">
                                <b-button @click.prevent="searchUser" class="btn-cus-modal btn-cus-search">{{$t('users.btn.btn_search')}}</b-button>
                            </div>
                        </div>
                    </b-col>
                </b-row>
                <b-row class="mt-3">
                    <b-col>
                        <b-table 
                            striped hover 
                            head-variant="primary"
                            small
                            @row-clicked="clickRow"
                            :items="items" 
                            :fields="fields">
                        </b-table>
                    </b-col>
                </b-row>
            </b-container>
        </b-modal>
    </div>
</template>

<script>
export default {
    data() {
        return {
            filter: {
                keySearch: "",
            },
            selected: {
                id: "",
                email: "",
                name: "",
            },
            dataCallBack: {
                action: "",
                data: {}
            },
            items: [],
            fields: [
                {
                    key: 'id',
                    lable: this.$t('users.fields.id'),
                    sortable: true
                },
                {
                    key: 'name',
                    lable: this.$t('users.fields.name'),
                    sortable: true
                },
                {
                    key: 'email',
                    lable: this.$t('users.fields.email'),
                    sortable: true
                }
            ]
        }
    },
    methods: {
        async searchUser() {
            let data = $.extend(true, {}, this.filter);
            data.type = "combo_box";
            try {
                const response = await axios.get('/combo_box', {params:data});
                this.items = response.data
            } catch{
                console.error(error.toString());
            }
            
        },
        showModal(objInit) {
            if (typeof objInit != 'undefined') {
                this.filter.keySearch = objInit.keySearch;
            }
            this.$refs["user_modal_combo_box"].show();
            this.searchUser();
        },
        clickRow(item) {
            this.selected = _.clone(item, true);
            console.log(this.selected);
            this.dataCallBack.data = _.clone(this.selected);
            this.dataCallBack.action = "selected_user"
            this.$refs["user_modal_combo_box"].hide();
            this.callBack();
        },
        callBack(objInit) {
            if (typeof objInit === 'undefined') {
                if (typeof this.$parent.callBack == 'function') {
                    this.$parent.callBack(this.dataCallBack);
                }
                return;
            }
        }
    }
}
</script>