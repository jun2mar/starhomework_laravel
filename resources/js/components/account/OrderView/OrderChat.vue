<template>
    <div class="card">
        <!-- <div class="card-header">Example Component</div> -->

        <div class="card-body">
           <ul class="list-unstyled" style="height: 300px; overflow-y:auto" v-chat-scroll>
                <li class="p-2" v-for="(message, index) in allMessages" :key="index"> 
                    <strong>{{ message.firstname }}</strong>
                    {{ message.message }}
                </li>
            </ul>
        </div>
        <input 
            v-on:keyup.enter="sendMessage"
            v-model="newMessage.message"
            type="text" 
            class="form-control" 
            name="message" 
            placeholder="Enter your message">
    </div>
</template>

<script>
    export default {
        props: ['propOrderAssignId'],
        data() {
            return {
                messages: [],
                allMessages: [],
                newMessage: new Form({
                  message: '',
                  order_assign_id: this.propOrderAssignId,
                }),
            };
        },
        methods: {
            getMessages(){
                axios.post("../../api/get_order_messages",
                { order_assign_id: this.propOrderAssignId }).then(({ data }) => {
                    this.allMessages = data;
                }).catch(() => { toast.fire({ icon: 'error', title: glob_error }); });
            },
            sendMessage(){
                this.newMessage.post("../../api/send_order_message")
                .then((data) => {
                    this.newMessage.reset();
                })
              .catch(() => { toast.fire({ icon: 'error', title: glob_error }); });
            }
        },
        created(){
            this.getMessages();

            Echo.channel("order-message")
            .listen("OrderMessageEvent", e => { this.getMessages(); });
        },
        mounted() {
            console.log(this.propOrderAssignId);
        }
    }
</script>
