<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Add Expense Detail</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Expense</li>
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
                    <router-link to="/expenselist">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addExpense()">
                    <div class="card-body">
                      <div class="row">
                        <!-- <input type="text" class="form-control" id="luckydraw_id" v-model="form.luckydraw_id" name="luckydraw_id"> -->

                        <div class="form-group col-md-12">
                          <label for="name">Title<code>*</code></label>
                          <input type="text" class="form-control" id="title" placeholder="Add title" v-model="form.title" title="title" :class="{ 'is-invalid': form.errors.has('title') }" autocomplete="off" @change="changename($event)">
                          <has-error :form="form" field="title"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="amount">Amount<code>*</code></label>
                          <input type="text" class="form-control" id="amount" placeholder="Add amount" v-model="form.amount" name="amount" :class="{ 'is-invalid': form.errors.has('amount') }" autocomplete="off" @keypress="isNumber($event)">
                          <has-error :form="form" field="amount"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Date</label>
                          <date-picker v-model="form.date" format="YYYY-MM-dd" name="date" >
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
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Detail"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Title : {{form.title}}</h5>
                      <h5>Amount : {{form.amount}}</h5>
                      <h5>Date : {{form.date}}</h5>
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
          title:'',
          amount:'',
          date:moment(new Date()).format('YYYY-MM-DD'),
          keywords: '',
          luckydrawid: this.$route.params.luckydrawid,
        }),
        state: {
          isSending: false
        }
      }
    },
    mounted(){
      // this.$Progress.start()
      this.$store.dispatch("allSelectLuckyDraw")
      // this.$Progress.finish()
    },
    computed:{
      allSelectLuckyDraws(){
        var a = this.$store.getters.getSelectLuckyDraw[0]
        // console.log(a);
        return a;
      },
    },
    methods:{
     addExpense(){
      this.state.isSending = true;
      this.form.date = moment(this.form.date).format('YYYY-MM-DD');
      this.form.post('/manager/expense')
      .then((response)=>{
        console.log(response);
        this.$store.dispatch("allExpense", [0,this.$route.params.kistaid]);
        // this.$router.push('/kista/has/expense/${this.$route.params.agentid}')
        // this.$router.push('/expenselist')
        Toast.fire({
          icon: 'success',
          title: 'Detail Added successfully'
        })
      })
      .catch(()=>{
        this.state.isSending = false;
      })
      this.resetForm();
    },
    resetForm() {
      this.form.reset();
    },
    changename(event){
      // const value = event
      const value = event.target.value
      console.log(value);
      this.keywords = value;
      axios.get('manager/check/'+this.form.luckydraw_id+'/'+this.keywords)
      .then((response)=>{
        console.log(response.data.message);
        if(response.data.message == 'unique'){
          // Toast.fire({
          //   icon: 'success',
          //   title: 'Name is avalaible'
          // })
        }
        else{
          this.state.isSending = true;
          Swal.fire({
           icon: 'error',
           title: 'Oops...',
           text: 'Name is already assign!',
           footer: '<a href>Please assign another name</a>'
         })
          // Toast.fire({
          //   icon: 'warning',
          //   title: 'Name is not avalaible'
          // })
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
<style scoped>
</style>
