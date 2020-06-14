<template>
    <b-container fluid>
        <b-row class="mt-3">
            <b-col cols="2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{$t('users.btn.limit')}}</span>
                    </div>
                    <b-form-select
                        v-model="limit.selected"
                        :options="limit.options"
                        @change="clickSelectLimit"
                        disabled-field="notEnabled">
                    </b-form-select>
                </div>
            </b-col>
            <b-col cols="5">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{$t('users.combo_box.keySearch')}}</span>
                    </div>
                    <b-form-input v-on:keyup.enter="handleSearch" class="form-control"
                        v-model="filter.keySearch"
                        >
                    </b-form-input>
                    <div class="input-group-append">
                        <b-button @click.prevent="handleSearch" class="btn btn-secondary"> {{$t('users.btn.btn_search')}} </b-button>
                    </div>
                </div>
            </b-col>
            <b-col cols="5">
                <b-button right @click.prevent="handleNew"> {{$t('users.btn.new')}} </b-button>
            </b-col>
        </b-row>
        <b-row class="mt-3">
            <b-col class="custom-table" md="12">
                <b-table  
                    striped hover 
                    sticky-header
                    head-variant="primary"
                    small
                    :items="items" 
                    :fields="fields">
                    <template  v-slot:cell(actions)="row">
                        <b-button right @click.prevent="productView(row.item)"> View </b-button>
                        <b-button right @click.prevent="productEdit(row.item)"> Edit </b-button>
                    </template>
                </b-table>
            </b-col>
        </b-row>
        <b-row class="custom-pagination">
            <b-pagination v-if="totalRows > perPage"
                v-model="currentPage"
                :total-rows="totalRows"
                :per-page="perPage"
                @change="clickPagination($event)"
                class="mt-2 text-right"
            >
                <template v-slot:first-text><span class="text-success">First</span></template>
                <template v-slot:prev-text><span class="text-danger">Prev</span></template>
                <template v-slot:next-text><span class="text-warning">Next</span></template>
                <template v-slot:last-text><span class="text-info">Last</span></template>
                <template v-slot:ellipsis-text>
                    <b-spinner small type="grow"></b-spinner>
                    <b-spinner small type="grow"></b-spinner>
                    <b-spinner small type="grow"></b-spinner>
                </template>
                <template v-slot:page="{ page, active }">
                    <b v-if="active">{{ page }}</b>
                    <i v-else>{{ page }}</i>
                </template>
            </b-pagination>
        </b-row>
        <product_modals_view ref="product_modals_view"></product_modals_view>
        <product_modals_new_edit ref="product_modals_new_edit"></product_modals_new_edit>
    </b-container>
</template>

<script>
export default {
    data() {
        return {
            filter: {
                keySearch: "",
            },
            limit: {
                selected: "*",
                options: [
                    {value: '5', text: '5'},
                    {value: '10', text: '10'},
                    {value: '15', text: '15'},
                    {value: '*', text: this.$t('users.filter.all')}
                ]
            },
            fields: [
                {
                    key: 'id',
                    lable: 'No.',
                    sortable: true
                },
                {
                    key: 'name',
                    sortable: false
                },
                {
                    key: 'code',
                    sortable: false
                },
                {
                    key: 'email',
                    sortable: false
                },
                {
                    key: 'description',
                    sortable: false
                },
                {
                    key: 'status',
                    sortable: false
                },
                {
                    key: 'created_at',
                    label: 'Created_at',
                    sortable: true,
                },
                {
                    key: 'updated_at',
                    label: 'Updated_at',
                    sortable: true
                },
                {
                    key: 'actions'
                }
            ],
            items: [],
            data: {},
            currentPage: 1,
            totalRows: "",

        }
    },
    created() {
        this.handleSearch();
    },
    computed: {
        perPage() {
            if (this.limit.selected === "*") {
                return 10000000000000000000000;
            }
            return this.limit.selected;
        }
    },
    methods: {
        handleNew() {
            this.$refs.product_modals_new_edit.showModal({
                typeModal: "New"
            });
        },
        productView(item) {
            this.$refs.product_modals_view.showModal({
                action: {
                    id: item.id,
                    type: 'view'
                }
            })
        },
        productEdit(item) {
            this.$refs.product_modals_new_edit.showModal({
                    id: item.id,
                    typeModal: 'Edit'
            })
        },
        async handleSearch(event) {
            console.log("Search User");
            this.items = _.clone([], true);
            if (typeof event === "undefined") {
                    this.currentPage = 1;
                }
            let data = {
                keySearch: this.filter.keySearch,
                type: "admin",
                currentPage: this.currentPage,
                limit: this.limit.selected
            };
            const response = await axios.get('/product',{params:data});
            this.items = _.clone(response.data.listProduct, true);
            this.totalRows = response.data.totalRecord;
        },
        clickPagination(event) {
            this.currentPage = event;
            console.log("current page:::",this.currentPage);
            this.handleSearch(event);
        },
        clickSelectLimit() {
            this.handleSearch();
        },
        callBack() {
            this.handleSearch();
        }
    }
}
</script>