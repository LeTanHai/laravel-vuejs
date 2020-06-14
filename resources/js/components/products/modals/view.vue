<template>
    <b-modal
        size="lg"
        id="product_modal_view"
        ref="product_modal_view"
        hide-footer
        scrollable
        header-text-variant="light"
        header-class="nav-custom">
        <template v-slot:modal-title>
            {{$t('products.modal_title.view')}}
        </template>
        <b-container fluid>
            <example-component :data_init="data.action"></example-component>
        </b-container>
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                data: {
                    action: {}
                }
            }
        },
        methods: {
            showModal(objInit) {
                _.extend(this.data, objInit);
                this.$refs['product_modal_view'].show()
            },
        }
    }
</script>
