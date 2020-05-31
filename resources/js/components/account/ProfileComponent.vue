<template>
    <form @submit.prevent="updateUserInfo">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstname">Firstname</label>
                    <input type="text"
                        class="form-control" id="firstname" v-model="userData.firstname"
                        :class="{ 'is-invalid': userData.errors.has('firstname') }">
                    <has-error :form="userData" field="firstname"></has-error>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lastname">Lastname</label>
                    <input type="text"
                        class="form-control" id="lastname" v-model="userData.lastname">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="user_contactnum">Contact number</label>
                    <input type="text"
                        class="form-control" id="user_contactnum" placeholder="" v-model="userData.user_contactnum">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="text" disabled
                        class="form-control" id="email" placeholder="" v-model="userData.email">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="customCheckbox1" v-model="userData.is_also_teacher" :value="false">
                        <label for="customCheckbox1" class="custom-control-label">Teacher</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-success" type="submit">Update</button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                userInfo: {},
                form: new Form({
                    searchInput: '',
                }),
                userData: new Form({
                    id: '',
                    firstname: '',
                    lastname: '',
                    email: '',
                    user_avatar: '',
                    user_status: '',
                    user_contactnum: '',
                    is_also_teacher: '',
                }),
            };
        },
        methods: {
            getUserInfo(){
                axios.post("../../api/getProfileInfo",
                {}).then(({ data }) => {
                    this.userData.fill(data[0]);
                    console.log(data[0]);
                }).catch(() => { Swal.fire("Error", "There is a problem with your request.", "error"); });
            },
            updateUserInfo(){
                this.userData.post("../../api/updateUserInfo")
                .then((data) => {
                    toast.fire({ icon: 'success', title: 'Successfully Updated' });
                })
                .catch(() => { Swal.fire("Error", "There is a problem with your request.", "error"); });
            }
        },
        created() {
            this.getUserInfo();
        },
        mounted() {
            console.log('Component mounted.');
        }
    }
</script>
