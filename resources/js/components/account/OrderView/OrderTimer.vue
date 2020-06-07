<template>
    <div class="card">
        <div class="card-header">Example Component</div>

        <div class="card-body">
            <vue-countdown-timer
                @start_callback="startCallBack('event started')"
                @end_callback="endCallBack('event ended')"
                :start-time="dateStart"
                :end-time="dateEnd"
                :interval="1000"
                :start-label="'Until start:'"
                :end-label="'Until end:'"
                label-position="begin"
                :end-text="'Event ended!'"
                :day-txt="'days'"
                :hour-txt="'hours'"
                :minutes-txt="'minutes'"
                :seconds-txt="'seconds'">
            </vue-countdown-timer>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                dateStart: '',
                dateEnd: '',
            };
        },
        methods: {
            startCallBack: function (x) {
                console.log(x)
            },
            endCallBack: function (x) {
                console.log(x)
            },
            get_order_timer(){
                axios.post("../../api/get_order_timer",
                {}).then(({ data }) => {
                    this.dateStart = data.StartTime;
                    this.dateEnd = data.EndTime;
                    console.log(data);
                    // this.subjectList = data;
                }).catch(() => { toast.fire({ icon: 'error', title: glob_error }); });
            }
        },
        created(){
            this.get_order_timer();
        },
        mounted() {
            console.log('Component mounted.');
        }
    }
</script>
