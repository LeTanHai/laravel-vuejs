<template>
  <div>
    <b-input-group prepend="Click to Select Your Product">
        <b-input-group-append>
            <b-button v-b-toggle.sidebar-variant> {{data_init.name}} </b-button>
        </b-input-group-append>
    </b-input-group>
    <b-sidebar id="sidebar-variant" shadow>
        <div class="px-3 py-2">
            <b-table striped hover :fields="fields" :items="listProduct" @row-clicked="clickProduct"></b-table>
        </div>
    </b-sidebar>
  </div>
</template>

<script>
export default {
    data() {
        return {
            listProduct: [],
            fields: [
                {
                    key: 'name',
                    label: 'Name',
                    sortable: true
                },
                {
                    key: 'code',
                    label: 'Code',
                    sortable: true
                }
            ]
        }
    },
    props: {
        data_init: {
            type: [Array, Object],
            default() {
                return {}
            }
        }
    },
    created() {
        this.getListProduct();
    },
    methods: {
        async getListProduct() {
            let data = {
                type: 'slide_bar'
            }
            const response = await axios.get('/product', {params: data});
            this.listProduct = _.clone(response.data, true); 
       },
       clickProduct(item, index, event) {
           this.$emit('re-render', item);
       }
    }
}
</script>