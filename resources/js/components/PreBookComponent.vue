<template>
    <div class="card">
        <div class="card-header">Meeting room pre booking</div>
        <form :action="app_url + '/booking'" v-on:submit.prevent="onSubmit" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <div v-if="message" class="alert alert-danger py-1" role="alert">
                    {{ message }}
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 mb-1">
                        <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" :disabled="adl" v-model="form.name" :class="errors.hasOwnProperty('name') ? 'is-invalid' : null" />
                            <div v-if="errors.hasOwnProperty('name')" class="invalid-feedback">{{ errors.name[0] }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-1">
                        <label class="form-label" for="mobile">Mobile</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" :disabled="adl" v-model="form.mobile" :class="errors.hasOwnProperty('mobile') ? 'is-invalid' : null" />
                            <div v-if="errors.hasOwnProperty('mobile')" class="invalid-feedback">{{ errors.mobile[0] }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-1">
                        <label class="form-label" for="date">Date <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="date" name="date" placeholder="Date" @change="checkBooking($event, 'date')" :disabled="adl" v-model="form.date" :class="errors.hasOwnProperty('date') ? 'is-invalid' : null" />
                            <div v-if="errors.hasOwnProperty('date')" class="invalid-feedback">{{ errors.date[0] }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-1">
                        <label class="form-label" for="start_time">Start Time <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="start_time" name="start_time" placeholder="Start Time" autocomplete="off" @change="checkBooking($event, 'start_time')" :disabled="adl" v-model="form.start_time" :class="errors.hasOwnProperty('start_time') ? 'is-invalid' : null" />
                            <div v-if="errors.hasOwnProperty('start_time')" class="invalid-feedback">{{ errors.start_time[0] }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-1">
                        <label class="form-label" for="end_time">End Time <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="end_time" name="end_time" placeholder="End Time" @change="checkBooking($event, 'end_time')" :disabled="adl" v-model="form.end_time" :class="errors.hasOwnProperty('end_time') ? 'is-invalid' : null" />
                            <div v-if="errors.hasOwnProperty('end_time')" class="invalid-feedback">{{ errors.end_time[0] }}</div>
                        </div>
                    </div>
                    <div class="col-12 mb-1">
                        <label class="form-label" for="remark">Remark</label>
                        <div class="input-group">
                            <textarea class="form-control" id="remark" name="remark" placeholder="Remark" :disabled="adl" v-model="form.remark" :class="errors.hasOwnProperty('remark') ? 'is-invalid' : null"></textarea>
                            <div v-if="errors.hasOwnProperty('remark')" class="invalid-feedback">{{ errors.remark[0] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="reset" class="btn btn-sm btn-danger me-2">Reset</button>
                <button :disabled="adl || !is_submit" type="submit" class="btn btn-sm btn-primary">
                    <span v-if="!adl">Submit</span>
                    <span v-if="adl">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="sr-only">Loading...</span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            app_url: window.appUrl,
            errors: {},
            adl: false,
            message: "",
            is_submit: false,
            date: "",
            start_time: "",
            end_time: "",
            form: {
                name: "",
                mobile: "",
                date: "",
                start_time: "",
                end_time: "",
                status: "",
                remark: ""
            },
        };
    },
    mounted() {
        flatpickr("#date", {
            allowInput: false,
            dateFormat: "Y-m-d",
            defaultDate: "",
        });
        flatpickr("#start_time, #end_time", {
            allowInput: false,
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false
        });
    },
    methods: {
        onSubmit(e) {
            let _this = this;
            _this.errors = {};
            _this.adl = true;
            _this.message = "";
            _this.is_submit = true;
            axios.post(e.target.action, _this.form)
                .then((res) => {
                    _this.adl = false;
                    if (res.data.success) {
                        _this.message = "";
                        _this.date = "";
                        _this.start_time = "";
                        _this.end_time = "";
                        _this.is_submit = true;
                        _this.form = {};
                        toastr.success(res.data.success);
                    }
                })
                .catch((err) => {
                    _this.adl = false;
                    toastr.error(err.response.data.message);
                    _this.errors = err.response.data.errors ? err.response.data.errors : {};
                });
        },
        checkBooking(e, type) {
            let _this = this;
            if (type == 'date') {
                _this.date = e.target.value;
            }
            if (type == 'start_time') {
                _this.start_time = e.target.value;
            }
            if (type == 'end_time') {
                _this.end_time = e.target.value;
            }

            _this.message = "";
            _this.is_submit = false;
            if (_this.date && _this.start_time && _this.end_time) {
                axios.post(_this.app_url + '/booking/check', {
                    date: _this.date,
                    start_time: _this.start_time,
                    end_time: _this.end_time,
                }).then((res) => {
                    if (res.data.message) {
                        _this.message = res.data.message;
                        _this.is_submit = false;
                        toastr.error(res.data.message);
                    } else {
                        _this.message = "";
                        _this.is_submit = true;
                    }
                }).catch((err) => {
                    toastr.error(err.response.data.message);
                });
            }
        }
    },
}
</script>
