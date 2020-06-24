<template>
    <div>
        <example-component :key="index" :data_init="data_init"></example-component>
    </div>
</template>

<script>
export default {
    data() {
        return {
            index: 1
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
    methods: {
        reRender(objInit) {
            this.data_init.id = objInit.id;
            this.data_init.type = 'view';
            this.index = 1 - this.index;
        }
    }
}
</script>