<template>
    <tabs :options="{ defaultTabHash: 'teacher0' }">
        <tab :id="'teacher' + index" :name="item.fullname" v-for="(item, index) in order_info" :key="index">
            <div class="row">
                <div class="col-md-8">
                    <order-view-chat-component :prop-order-assign-id="item.order_assign_id"></order-view-chat-component>
                </div>
                <div class="col-md-4"></div>
            </div>
        </tab>
    </tabs>
</template>

<script>
    export default {
        props: ['propOrderId'],
        data() {
            return {
                order_info: {},
            };
        },
        methods: {
            getMessages(){
                axios.post("../../api/get_order_main",
                { orderId: this.propOrderId }).then(({ data }) => {
                    this.order_info = data;
                    // console.log(this.order_info);
                }).catch(() => { toast.fire({ icon: 'error', title: glob_error }); });
            },
        },
        created(){
            this.getMessages();
        },
        mounted() {
            // console.log('Component mounted.');
            // console.log(this.propOrderId);
        }
    }
</script>
