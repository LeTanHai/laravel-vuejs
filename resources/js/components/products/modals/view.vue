<template>
    <b-modal
        size="lg"
        id="product_modal_view"
        ref="product_modal_view"
        hide-footer
        scrollable>
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
                console.log("action view:::",this.data.action);
                this.$refs['product_modal_view'].show()
            },
        }
    }
</script>
