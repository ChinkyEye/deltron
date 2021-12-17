<template>
	<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Cancel Booking</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Booking</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- main page load here-->
            <div class="row">
              <div class="col-8">
                <div class="card card-primary">
                  <div class="card-header">
                    <router-link :to="'/booking/'">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" @submit.prevent="cancelBooking()">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-12">
                          <label for="serial_no">Serial No:<code>*</code></label>
                          <span v-for="(data,index) in cancel" :key="data.id">
                            <input type="checkbox" id="data[index]" value="data" name="data[index]" checked>
                            <label for="data[index]">{{data}}</label>
                          </span>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Date</label>
                          <date-picker v-model="form.date" format="YYYY-MM-dd" name="date" :max-date='new Date()'>
                            <template v-slot="{ inputValue, inputEvents }">
                              <input
                              class="bg-white border px-2 py-1 rounded form-control"
                              :value="inputValue"
                              v-on="inputEvents"
                              />
                            </template>
                          </date-picker>
                          <has-error :form="form" field="date"></has-error>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Update Client"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Date : {{form.date}}</h5>
                      <!-- <h5>Name : {{form.name}}</h5> -->
                      <!-- <h5>Address : {{form.address}}</h5> -->
                      <!-- <h5>Phone : {{form.phone}}</h5> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
</template>
<script>
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
  export default {
    name: "Edit",
    components: {
      DatePicker
    },
    data(){
        return {
          form: new Form({
            agent_id: '',
            name: '',
            address: '',
            phone: '',
            serail_no:'',
            date:moment(new Date()).format('YYYY-MM-DD'),
            luckydraw_id: '',
            checkedNames:[],
          }),
          cancel:[],
          state: {
            isSending: false,
            isDisplay: true
          }
        }
    },
    mounted(){
      this.$Progress.start()
    	axios.get(`/manager/booking/${this.$route.params.bookingid}/edit`)
    	.then((response)=>{
        // console.log(response.data.bookings.booked_serialno)
    		this.form.fill(response.data.bookings)
        this.cancel= response.data.bookings.booked_serialno;
    	})
      this.$store.dispatch("allSelectLuckyDraw")
      this.$Progress.finish()
    },
    computed:{
      allSelectLuckyDraws(){
        var a = this.$store.getters.getSelectLuckyDraw
        return a;
      },
    },
    methods:{
      // cancelBooking2(){
      //   this.state.isSending = true;
      //   this.form.date = moment(this.form.date).format('YYYY-MM-DD');
      //   this.form.put(`/manager/client/${this.$route.params.clientid}`)
      //   .then((response)=>{
      //     this.$router.push(`/agent/add/client/${this.form.agent_id}`)
      //     Toast.fire({
      //       icon: 'success',
      //       title: 'Data  Updated successfully'
      //     })
      //   })
      //   .catch(()=>{
      //     this.state.isSending = false
      //   })
      // },
      cancelBooking: function cancelBooking() {
        var that = this;
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Save it!',
          cancelButtonText: 'No, cancel!',
          buttonsStyling: true
        }).then(function (isConfirm) {
          if (isConfirm.value === true) {
            axios.put(`/manager/booking/${that.$route.params.bookingid}`, {
              data: that.form,
              cancel: that.cancel
            }).then(function (response) {
              if (response) {
                that.state.isSending = true;
                Toast.fire({
                  icon: 'success',
                  title: 'Detail Updated successfully'
                });
              }
            })["catch"](function () {});
          } else {
            Toast.fire({
              icon: 'error',
              title: 'Data couldnot save'
            });
          }
        });
      },
      isNumber: function(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57) ) && charCode !== 46
          ) {
          evt.preventDefault();;
        } else {
          return true;
        }
      },
    }
  }
</script>