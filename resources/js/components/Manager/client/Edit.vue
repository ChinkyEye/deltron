<template>
	<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Edit: <span class="text-primary">{{form.name}}</span></h5>
            <!-- <h5 class="m-0 text-dark">Edit Detail</h5> -->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Member</li>
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
                    <router-link :to="'/agent/add/client/'+this.form.agent_id">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="updateClient()">
                    <div class="card-body">
                      <div class="row">
                        <input type="hidden" name="id" v-model="form.id">
                        <div class="form-group col-md-12">
                          <label for="name">Member Name <code>*</code></label>
                          <input type="text" class="form-control" id="name" placeholder="Add name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="address">Address<code>*</code></label>
                          <input type="text" class="form-control" id="address" placeholder="Add address" v-model="form.address" name="address" :class="{ 'is-invalid': form.errors.has('address') }" autocomplete="off">
                          <has-error :form="form" field="address"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="phone">Phone<code>*</code></label>
                          <input type="text" class="form-control" id="phone" placeholder="Add phone" v-model="form.phone" name="phone" :class="{ 'is-invalid': form.errors.has('phone') }" autocomplete="off" @keypress="isNumber($event)">
                          <has-error :form="form" field="phone"></has-error>
                        </div>
                        <!-- <div class="form-group col-md-12">
                          <label for="lottery_no">Lottery No:<code>*</code></label>
                          <input type="text" class="form-control" id="lottery_no" placeholder="Add lottery no" v-model="form.lottery_no" name="lottery_no" :class="{ 'is-invalid': form.errors.has('lottery_no') }" autocomplete="off">
                          <has-error :form="form" field="lottery_no"></has-error>
                        </div> -->
                        <div class="form-group col-md-12">
                          <label for="serial_no">Serial No:<code>*</code></label>
                          <!-- <input type="text" class="form-control" id="serial_no" placeholder="Add serial_no" v-model="form.serial_no" name="serial_no" :class="{ 'is-invalid': form.errors.has('serial_no') }" autocomplete="off">
                          <has-error :form="form" field="serial_no"></has-error> -->
                          <input type="text" class="form-control" id="serial_no" placeholder="Add serial_no" v-model="form.serial_no" name="serial_no" :class="{ 'is-invalid': form.errors.has('slug') }" autocomplete="off" v-on:change="changeSerial($event)">
                          <has-error :form="form" field="slug"></has-error>
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
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Update Member"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Name : {{form.name}}</h5>
                      <h5>Address : {{form.address}}</h5>
                      <h5>Phone : {{form.phone}}</h5>
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
            id:'',
            agent_id: '',
            name: '',
            address: '',
            phone: '',
            serial_no:'',
            // lottery_no:'',
            date:moment(new Date()).format('YYYY-MM-DD'),
            // date: '',
            luckydraw_id: '',
          }),
          state: {
            isSending: false,
            isDisplay: true
          }
        }
    },
    mounted(){
      // this.$Progress.start()
    	axios.get(`/manager/client/${this.$route.params.clientid}/edit`)
    	.then((response)=>{
        console.log(response);
    		this.form.fill(response.data.clients)
    	})
      this.$store.dispatch("allSelectLuckyDraw")
      this.$Progress.finish()
    },
    computed:{
      allSelectLuckyDraws(){
        var a = this.$store.getters.getSelectLuckyDraw
        console.log(a);
        return a;
      },
    },
    methods:{
      updateClient(){
        this.state.isSending = true;
        this.form.date = moment(this.form.date).format('YYYY-MM-DD');
        this.form.put(`/manager/client/${this.$route.params.clientid}`)
        .then((response)=>{
          this.$router.push(`/agent/add/client/${this.form.agent_id}`)
          Toast.fire({
            icon: 'success',
            title: 'Data  Updated successfully'
          })
        })
        .catch(()=>{
          this.state.isSending = false
        })
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