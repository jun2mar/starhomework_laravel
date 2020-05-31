<template>
    <div class="row">
        <div class="col-md-8">
            <a :href="propsRouteNew" class="btn btn-info">Create Homework</a>
        </div>
        <div class="col-md-4 mb-2">
            <form @submit.prevent="getHomeworks">
                <div class="form-inline">
                    <label for="input_search">Search:</label>
                    <input type="text" v-model="searchForm.inputSearch" id="input_search" class="form-control flex-fill ml-2">
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>No. of Teacher</th>
                        <th>Date</th>
                        <th>Payment status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in homework_list.data" :key="index">
                        <td>{{ item.hw_title }}</td>
                        <td>{{ item.hw_number_teacher }}</td>
                        <td>{{ item.created_at }}</td>
                        <td>{{ item.payment_status }}</td>
                        <td>
                            <a v-if="item.payment_status == 'Unpaid'" :href="propsRouteBilling + '/' + item.hw_id" class="btn btn-info">Pay</a>
                            <a v-else :href="propsRouteOrderView + '/' + item.order_id" class="btn btn-info">View</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <pagination :data="homework_list" @pagination-change-page="getHomeworks" :limit="1"></pagination>
        </div>
    </div>
</template>

<script>
    export default {
        props:['propsRouteNew','propsRouteBilling', 'propsRouteOrderView'],

        data() {
            return {
                homework_list: {},
                searchForm: new Form({
                    inputSearch: '',
                }),
            };
        },
        methods: {
            getHomeworks(page = 1){
                this.searchForm.post("../../api/getHomeworks?page=" + page)
                .then((data) => {
                    this.homework_list = data.data;
                })
                .catch(() => { Swal.fire("Error", "There is a problem with your request.", "error"); });
            }
        },
        created(){
            this.getHomeworks();
        },
        mounted() {
            console.log('Component mounted.');
        }
    }
</script>
