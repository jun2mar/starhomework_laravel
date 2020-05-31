<template>
    <div class="row">
        <div class="col-md-12">

            <div class="homework-wizard mb-4">
                <ul class="nav nav-tabs justify-content-center" role="tablist">
                    <li class="nav-item">
                        <span class="badge bg-success">Step 1</span>
                        <a class="nav-link active" href="#nav_hw_info" role="tab" data-toggle="tab">Homework Details</a>
                    </li>
                    <li class="nav-item">
                        <span class="badge bg-success">Step 2</span>
                        <a class="nav-link disabled" href="#nav_hw_payment" role="tab" data-toggle="tab">Payment</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane in active" id="nav_hw_info">
                    <form @submit.prevent="save_homework_detail">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hw_title">Title</label>
                                    <input type="text"
                                        class="form-control" id="hw_title" v-model="homeworkForm.hw_title"
                                        :class="{ 'is-invalid': homeworkForm.errors.has('hw_title') }">
                                    <has-error :form="homeworkForm" field="hw_title"></has-error>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fk_subject_id">Subject</label>
                                    <select class="form-control" id="fk_subject_id" v-model="homeworkForm.fk_subject_id"
                                        :class="{ 'is-invalid': homeworkForm.errors.has('fk_subject_id') }">
                                        <option selected value="">Select Subject</option>
                                        <option v-for="item in subjectList" :key="item.id" :value="item.id">{{ item.subj_title }}</option>
                                    </select>
                                    <has-error :form="homeworkForm" field="hw_title"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="hw_files">Files</label>
                                <div class="custom-file">
                                    <label for="hw_files" class="custom-file-label">Files</label>
                                    <input type="file" multiple
                                        class="custom-file-input" id="hw_files" @change="homeworkFileProcess($event)"
                                        :class="{ 'is-invalid': homeworkForm.errors.has('hw_files') }">
                                    <has-error :form="homeworkForm" field="hw_files"></has-error>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hw_deadline">Deadline</label>
                                    <input type="number"
                                        class="form-control" id="hw_deadline" v-model="homeworkForm.hw_deadline"
                                        :class="{ 'is-invalid': homeworkForm.errors.has('hw_deadline') }">
                                    <has-error :form="homeworkForm" field="hw_deadline"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hw_price">Price per Teacher</label>
                                    <select class="form-control" id="hw_price" v-model="homeworkForm.hw_price"
                                        :class="{ 'is-invalid': homeworkForm.errors.has('hw_price') }">
                                        <option selected value="">Select price</option>
                                        <option v-for="(counter, index) in 10" :key="index" :value="counter * 5">${{ counter * 5 }}</option>
                                    </select>
                                    <has-error :form="homeworkForm" field="hw_price"></has-error>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hw_number_teacher">Number of Teacher</label>
                                    <select class="form-control" id="hw_number_teacher" v-model="homeworkForm.hw_number_teacher"
                                        :class="{ 'is-invalid': homeworkForm.errors.has('hw_number_teacher') }">
                                        <option selected value="">Select number of teacher</option>
                                        <option v-for="(counter) in 5" :key="counter" :value="counter">{{ counter }}</option>
                                    </select>
                                    <has-error :form="homeworkForm" field="hw_number_teacher"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="row"><div class="col-md-6">
                            <div class="form-group">
                                <label for="hw_expirydate">Expiry date</label>
                                <input type="date"
                                    class="form-control" id="hw_expirydate" v-model="homeworkForm.hw_expirydate"
                                    :class="{ 'is-invalid': homeworkForm.errors.has('hw_expirydate') }">
                                <has-error :form="homeworkForm" field="hw_expirydate"></has-error>
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hw_details">Details</label>
                                    <textarea class="form-control" id="hw_details" v-model="homeworkForm.hw_details"
                                        :class="{ 'is-invalid': homeworkForm.errors.has('hw_details') }"></textarea>
                                    <has-error :form="homeworkForm" field="hw_details"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-info">Save & Proceed</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="nav_hw_payment">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <h5 class="mb-4">Payment method</h5>
                            <PayPal class="ml-4"
                                :button-style="{size:  'medium', shape: 'rect', color: 'gold'}"
                                :amount="homeworkForm.hw_total"
                                currency="USD"
                                :client="credentials"
                                env="sandbox"
                                v-on:payment-completed="paypalCallback($event)"
                                v-on:payment-cancelled="paypalCallback($event)">
                                <!--
                                :items="homeworkForm.hw_paypal_items"
                                :invoice-number="homeworkForm.hw_invoice_number" -->
                            </PayPal>
                        </div>
                        <div class="col-md-4">
                            <table class="table">
                                <thead>
                                    <tr class="text-center">
                                        <th colspan="2">Payment Summary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="pl-3">Sub-total</td>
                                        <td class="pr-3">${{ homeworkForm.hw_subtotal }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3">Service Fee <small><u>{{ homeworkForm.hw_service_fee }}</u></small></td>
                                        <td class="pr-3">${{ homeworkForm.hw_subtotal_w_service_fee }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-3">Total</td>
                                        <td class="pr-3">${{ homeworkForm.hw_total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    export default {
        props:['propUnpaidHomeworkId',],

        data() {
            return {
                myStyle:[
                    {
                        label: 'checkout',
                        size:  'responsive',
                        shape: 'pill',
                        color: 'gold',
                    }
                ],
                credentials: {
                    sandbox: paypal_sandbox,
                    production: paypal_production
                },
                isHomeworkPayment: null,
                subjectList: {},
                homeworkForm: new Form({
                    id: '',
                    hw_title: '',
                    fk_subject_id: '',
                    hw_files: [],
                    hw_details: '',
                    hw_number_teacher: '',
                    hw_price: '',
                    hw_deadline: '',
                    hw_expirydate: '',
                    hw_status: '',
                    is_update: false,
                    hw_subtotal: '',
                    hw_subtotal_w_service_fee: '',
                    hw_service_fee: '',
                    hw_total: '',
                    hw_invoice_number: '',
                    hw_paypal_items: [],
                }),
            };
        },
        methods: {
            proceedToPayment(proceed){
                if(proceed == true){
                    let test = $('.nav-tabs .active').parent().next('li').find('a');
                    $('.nav-tabs .active').parent().next('li').find('a').removeClass('disabled');
                    $('.nav-tabs .active').parent().next('li').find('a').trigger('click');
                }
            },
            paypalCallback(event){
                if(event){
                    if(event.payer.status == "VERIFIED"){
                        let fk_user_homework_id = this.homeworkForm.id;
                        let total_payed = event.transactions[0].amount.total;
                        let payment_method = event.payer.payment_method;
                        let currency = event.transactions[0].amount.currency;
                        let status = event.payer.status;

                        axios.post("../../api/save_order_info",
                        {
                            fk_user_homework_id: fk_user_homework_id,
                            total_payed: total_payed,
                            payment_method: payment_method,
                            currency: currency,
                            status: status,
                        }).then(({ data }) => {
                            // this.subjectList = data;
                        }).catch(() => { toast.fire({ icon: 'error', title: glob_error }); });
                    }
                }

                console.log(event);
            },
            homeworkFileProcess(event){
                this.homeworkForm.hw_files = event.target.files;
                console.log(event.target.files);
            },
            getSubjectList(){
                axios.post("../../api/getSubjectList",
                {}).then(({ data }) => {
                    this.subjectList = data;
                }).catch(() => { toast.fire({ icon: 'error', title: glob_error }); });
            },
            save_homework_detail(){
                this.homeworkForm.post("../../api/save_homework_detail")
                .then((data) => {
                    let newData = data.data;
                    this.homeworkForm.fill(newData);
                    this.proceedToPayment(newData.proceed);
                })
                .catch(() => { toast.fire({ icon: 'error', title: glob_error }); });
            },
            get_unpaid_homework_info(homework_id){
                axios.post("../../api/get_unpaid_homework_info",
                { homework_id: homework_id }).then(({ data }) => {
                    let homeworkInfo = data;
                    if(homeworkInfo == "Paid"){
                        window.location.href = "/account/homework-list";
                    }else{
                        this.homeworkForm.fill(homeworkInfo);
                        this.proceedToPayment(homeworkInfo.proceed);
                    }
                }).catch(() => { toast.fire({ icon: 'error', title: glob_error }); });
            },
        },
        created(){
            this.getSubjectList();
            // window.addEventListener('beforeunload', function(event) {
                // event.returnValue = 'Warning';
            // });

            if(this.propUnpaidHomeworkId){
                this.get_unpaid_homework_info(this.propUnpaidHomeworkId);
            }
        },
        mounted() {
            console.log('Component mounted.');
        }
    }
</script>
