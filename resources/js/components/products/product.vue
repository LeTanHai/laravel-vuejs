<template>
    <div>
        <b-row>
            <b-col md="12">
                <b-table  
                    striped hover 
                    sticky-header
                    head-variant="primary"
                    small
                    :items="items" 
                    :fields="fields">
                    <template  v-slot:cell(actions)="row">
                        <b-button right @click.prevent="productView(row.item)"> View </b-button>
                        <b-button right @click.prevent="productDelete(row.item)"> Delete </b-button>
                    </template>
                </b-table>
            </b-col>
            <b-button right @click.prevent="handleNew"> New </b-button>
        </b-row>
        <product_modals_view ref="product_modals_view"></product_modals_view>
        <product_modals_new_edit ref="product_modals_new_edit"></product_modals_new_edit>
    </div>
</template>

<script>
export default {
    data() {
        return {
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
                    key: 'description',
                    sortable: false
                },
                {
                    key: 'status',
                    sortable: false
                },
                {
                    key: 'created_at',
                    label: 'created_at',
                    sortable: true,
                },
                {
                    key: 'actions'
                }
            ],
            items: [],
            data: {}
        }
    },
    created() {
        this.getProducts()
    },
    methods: {
        getProducts() {
                axios
                    .get('product', {
                        params: {
                            type: "admin"
                    }})
                    .then(response=>{
                        console.log("::::::data",response.data)
                        this.items = response.data
                    })
        },
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
        }
    }
}
</script>