<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Add Member</h5>
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
                    <router-link :to="'/agent/add/client/'+this.$route.params.agentid">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addClient()">
                    <div class="card-body">
                      <div class="row">
                        <!-- <div class="form-group col-md-12">
                          <label for="category_id">Luck Draw<code>*</code></label>
                          <select class="form-control" id="luckydraw_id" v-model="form.luckydraw_id" name="luckydraw_id" :class="{ 'is-invalid': form.errors.has('luckydraw_id') }"> 
                            <option disabled value="">Select one</option>
                            <option :value="luckydraw.id" v-for="luckydraw in allSelectLuckyDraws">{{luckydraw.name}}</option>
                          </select>
                          <has-error :form="form" field="luckydraw_id"></has-error>
                        </div> -->
                         <input type="hidden" class="form-control" id="agent_id" v-model="form.agent_id" name="agent_id">
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
                        <div class="form-group col-md-12">
                          <label for="serial_no">Serial No:<code>must be 4 digits</code></label>
                          <!-- <input type="text" class="form-control" id="serial_no" placeholder="Add serial_no" v-model="form.serial_no" name="serial_no" :class="{ 'is-invalid': form.errors.has('slug') }" autocomplete="off"> -->
                          <input type="text" class="form-control" id="serial_no" placeholder="Add serial_no" v-model="form.serial_no" name="serial_no" :class="{ 'is-invalid': form.errors.has('slug') }" autocomplete="off" v-on:change="changeSerial($event)">
                          <has-error :form="form" field="slug"></has-error>
                        </div>
                        <!-- <div class="form-group col-md-12">
                          <label for="phone">Lottery No:<code>*</code></label>
                          <input type="text" class="form-control" id="lottery no" placeholder="Add lottery_no" v-model="form.lottery_no" name="lottery_no" :class="{ 'is-invalid': form.errors.has('lottery_no') }" autocomplete="off">
                          <has-error :form="form" field="lottery_no"></has-error>
                        </div> -->
                        <div class="form-group col-md-6">
                          <label>Date</label>
                          <date-picker v-model="form.date" format="YYYY-MM-dd" name="date">
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
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Member"}}</button>
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
                      <h5>Lottery No : {{form.lottery_no}}</h5>
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
    name: "New",
    components: {
      DatePicker
    },
    data(){
      return {
        form: new Form({
          name:'',
          address:'',
          phone:'',
          serail_no:'',
          slug:'',
          // lottery_no:'',
          keywords: '',
          date:moment(new Date()).format('YYYY-MM-DD'),
          agent_id: this.$route.params.agentid,
        }),
        state: {
          isSending: false
        }
      }
    },
    mounted(){
      this.$Progress.start()
      this.$store.dispatch("allBooking")
      this.$Progress.finish()
    },
    // computed:{
    //   allSelectLuckyDraws(){
    //     var a = this.$store.getters.getSelectLuckyDraw
    //     console.log(a);
    //     return a;
    //   },
    // },
    methods:{
     addClient(){
      this.state.isSending = true;
      this.form.date = moment(this.form.date).format('YYYY-MM-DD');
      this.form.post('/manager/client')
      .then((response)=>{
        // console.log(response);
        this.$router.push(`/agent/add/client/${this.$route.params.agentid}`)
        Toast.fire({
          icon: 'success',
          title: 'Detail Added successfully'
        })
      })
      .catch(()=>{
        this.state.isSending = false;
      })
      // this.resetForm();
    },
    resetForm() {
      this.form.reset();
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
    isExect(event,amt){
        let file = event.target.value;
        let rem_amount = amt;
        let p_amount = this.rec_amount
        let value = parseInt(p_amount);
        // if(value > rem_amount){
        if(value != rem_amount){
          // this.state.isSending = true;
          // alert("bitch");
          Swal.fire({
           icon: 'error',
           title: 'Please Enter the Exact remaining amount!',
           text: 'ok!',
           footer: '<a href>Why do I have this issue?</a>'
          })
        }
    else{
          // this.state.isSending = false;

        }
      },
      changeSerial(event){
        let file = event.target.value;
        this.keywords = file;
        // console.log(file);
        axios.get('manager/booking/check/'+this.form.agent_id+'/'+this.keywords)
        .then((response)=>{
          if((response.data.checked == 0) && (response.data.typeid == false)){
            this.state.isSending = false;
           //  Swal.fire({
           //   icon: 'success',
           //   title: 'Yes...',
           //   text: 'Can booked!',
           //   footer: '<a href>Please assign another name</a>'
           // })
          }
          else if((response.data.checked == 1) && (response.data.typeid == true)){
            this.state.isSending = false;
           //  Swal.fire({
           //   icon: 'success',
           //   title: 'Yes...',
           //   text: 'Can booked!',
           //   footer: '<a href>Please assign another name</a>'
           // })
          }
          else if((response.data.checked == 1) && (response.data.typeid == false)){
            this.state.isSending = true;
            Swal.fire({
             icon: 'error',
             title: 'Ops...',
             text: 'Cant assigned!',
             // text: 'Cant booked!',
             footer: '<a href>Please assign another name</a>'
           })
          }
          else{
           this.state.isSending = false;
           //  Swal.fire({
           //   icon: 'success',
           //   title: 'Yes...',
           //   text: 'Cant booked!',
           //   footer: '<a href>Please assign another name</a>'
           // })
            
          }
        });
        // let quantity = this.quantity;
        // let total = this.totalsum;
        // let value = parseInt(total) +  parseInt(file) ;
        // console.log(value);
        // console.log(file);
        // 5 mb image
        // if((value > quantity)){
        //   this.state.isSending = true;
        //   Swal.fire({
        //    icon: 'error',
        //    title: 'The entered quantity is greater than actual quantity!',
        //    text: 'ok!',
        //    footer: '<a href>Why do I have this issue?</a>'
        //   })
        // }else{
        //   this.state.isSending = false;

        // }

        // if((total == quantity)){
        //   Swal.fire({
        //    icon: 'error',
        //    title: ' Quantity has been returned!',
        //    text: 'ok!',
        //    footer: '<a href>Why do I have this issue?</a>'
        //   })

        // }
       
      },
  }
}
</script>
<style scoped>
</style>
