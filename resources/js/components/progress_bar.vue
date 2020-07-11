<template>
    <b-row>
        <b-col cols="12">
        <ul class="progressbar">
            <li v-bind:class="[step1Class]"> <i class="fas fa-dolly"></i> Pick up </li>
            <li v-bind:class="[step2Class]"> <i class="fas fa-shipping-fast"></i> Shipping </li>
            <li v-bind:class="[step3Class]"> <i class="fas fa-user-check"></i> Delivered </li>
        </ul>
        </b-col>
    </b-row>
</template>

<script>
export default {
    data() {
        return {
            list_status: {
                0: "",
                1: "active",
                2: "complete"
            },
            step1Class: "",
            step2Class: "",
            step3Class: "",
            data: {
                status: null,
                pickup: null,
                code: null,
                code_current: null
            },
            checkSendMail: 'no'   
        }
    },
    props: {
        dataInit: {
            type: Object,
            default() {
                return {};
            }
        }
    },
    mounted() {
        setTimeout(() =>{
            if (this.data.status == 2) {
                this.checkSendMail = "yes";
            }
            this.updateProgressBar();
        }, 1000);
    },
    watch: {
        dataInit: {
            deep: true,
            immediate: true,
            handler(newData, oldData) {
                _.extend(this.data, newData)
                if (this.data.code != this.data.code_current) {
                    return;
                }
                this.updateProgressBar();
            }
        },
    },
    methods: {
        async updateProgressBar() {
            if (this.data.pickup == 1 && this.data.status == 2 && this.checkSendMail == "no") {
                try {
                    console.log("send maill....")
                    let data = {
                        code: this.data.code
                    }
                    const response = await axios.get('/sendMail', {params:data});
                    this.checkSendMail = response.data.statusSendMail;
                }
                catch($err) {
                    console.log($err)
                }                
            }
            if (this.data.pickup == 0 && this.data.status == 2) {
                this.step1Class = this.list_status[this.data.status]
                this.step2Class = this.list_status[this.data.status]
                this.step3Class = this.list_status[this.data.status]
                return;
            }
            else if (this.data.pickup == 0) {
                this.data.status = 0
                this.step1Class= ""
                this.step2Class= ""
                this.step3Class= ""
                return;
            }
            
            switch(this.data.status){
                case 0:
                    this.step1Class = this.list_status[parseInt(this.data.status) + 1] 
                    this.step2Class = this.list_status[this.data.status]
                    this.step3Class = this.list_status[this.data.status]
                    break;
                case 1:
                    this.step1Class = this.list_status[parseInt(this.data.status) + 1] 
                    this.step2Class = this.list_status[this.data.status]
                    this.step3Class = this.list_status[parseInt(this.data.status) - 1]
                    break;
                case 2:
                    this.step1Class = this.list_status[this.data.status]
                    this.step2Class = this.list_status[this.data.status]
                    this.step3Class = this.list_status[parseInt(this.data.status) - 1]
                    break;
            }
        }
    }
}
</script>