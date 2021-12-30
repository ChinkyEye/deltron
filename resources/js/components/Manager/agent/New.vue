<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Add Agent</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Agent</li>
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
                    <router-link :to="'/agent'">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addAgent()">
                    <div class="card-body">
                      <div class="row">
                        <input type="hidden" class="form-control" id="name" v-model="form.kistaid" name="name">
                        
                        <div class="form-group col-md-12">
                          <label for="name">Name <code>*</code></label>
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
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Agent"}}</button>
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
    name: "New",
    components: {
      DatePicker
    },
    data(){
      return {
        form: new Form({
          kistaid: this.$route.params.kistaid,
          name:'',
          address:'',
          phone:'',
          commission:'',
          date:moment(new Date()).format('YYYY-MM-DD'),
        }),
        state: {
          isSending: false
        }
      }
    },
    mounted(){
      this.$Progress.start()
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
     addAgent(){
      this.state.isSending = true;
      this.form.date = moment(this.form.date).format('YYYY-MM-DD');
      this.form.post('/manager/agent')
      .then((response)=>{
        this.$router.push(`/agent`)
        // this.$router.push(`/kista/add/agent/${this.$route.params.kistaid}`)
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
  }
}
</script>
<style scoped>
</style>
