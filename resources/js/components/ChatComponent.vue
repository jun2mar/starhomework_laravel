<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Messages</div>
                    <div class="card-body p-0">
                        <ul class="list-unstyled" style="height: 300px; overflow-y:scroll">
                            <li class="p-2" v-for="(message, index) in messages" :key="index">
                                <strong>{{ message.user.firstname }}</strong>
                                {{ message.message }}
                            </li>
                        </ul>
                    </div>

                    <input 
                    v-on:keyup.enter="sendMessage"
                    v-model="newMessage"
                    type="text" 
                    class="form-control" 
                    name="message" 
                    placeholder="Enter your message">
                </div>
                <span class="text-muted">User is typing...</span>
            </div>

            <div class="col-md-4">
                <div class="card card-default">
                    <div class="card-header">Active Users</div>
                    <div class="card-body">
                        <ul>
                            <li class="py-2">Harish</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['propUser'],

        data() {
            return {
                messages: [],
                newMessage: '',
            };
        },
        methods: {
            fetchMessages(){
                axios.get('messages').then(response => {
                    this.messages = response.data;
                });
            },
            sendMessage(){
                this.messages.push({
                    user: this.propUser,
                    message: this.newMessage
                });

                axios.post('messages', {message: this.newMessage}).then(response => {
                    this.messages = response.data;
                });
            }
        },
        created(){
            this.fetchMessages();
            Echo.join('chat')
            .listen('MessageEvent'), (event) => {
                this.messages.push(event.message);
            }
        },
        mounted() {
            // console.log('Component mounted.');
            console.log(this.propUser);
        }
    }
</script>
