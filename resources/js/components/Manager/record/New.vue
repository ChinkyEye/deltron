<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Add Record Detail</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Kista</li>
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
                    <router-link to="/record">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addRecord()">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="luckydraw_id">Scheme<code>*</code></label>
                          <select class="form-control" id="luckydraw_id" v-model="form.luckydraw_id" name="luckydraw_id" @change="luckydrawChange" :class="{ 'is-invalid': form.errors.has('luckydraw_id') }"> 
                            <option disabled value="">Select one scheme</option>
                            <option :value="luckydraw.id" v-for="luckydraw in allSelectLuckyDraws">
                              {{luckydraw.name}}
                            </option>
                          </select>
                          <has-error :form="form" field="luckydraw_id"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="kista_id">Kista Name<code>*</code></label>
                          <select class="form-control" id="kista_id" name="kista_id" v-model="form.kista_id"  @change="kistaChange"> 
                            <option value="">Select Kista</option>
                            <option :value="kista.id" v-for="kista in getAllKista">{{kista.name}}</option>
                          </select>
                          <has-error :form="form" field="kista_id"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="title">Topic<code>*</code></label>
                          <input type="text" class="form-control" id="title" placeholder="Add title" v-model="form.title" name="title" :class="{ 'is-invalid': form.errors.has('title') }" autocomplete="off">
                          <has-error :form="form" field="title"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="description">Description<code></code></label>
                          <input type="text" class="form-control" id="description" placeholder="Add description" v-model="form.description" name="description" :class="{ 'is-invalid': form.errors.has('description') }" autocomplete="off">
                          <has-error :form="form" field="description"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="amount">Amount<code>*</code></label>
                          <input type="text" class="form-control" id="amount" placeholder="Add amount" v-model="form.amount" name="amount" :class="{ 'is-invalid': form.errors.has('amount') }" autocomplete="off" @keypress="isNumber($event)">
                          <has-error :form="form" field="amount"></has-error>
                        </div>
                        <div class="form-group col-md-12">
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
                      <h5>Topic : {{form.title}}</h5>
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
          title:'',
          description:'',
          amount:'',
          date:moment(new Date()).format('YYYY-MM-DD'),
          luckydraw_id: '',
          kista_id: '',
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
        return a;
      },
      getAllKista(){
        var b = this.$store.getters.getSelectKista
        return b[0];
      },
    },
    methods:{
     addRecord(){
      this.state.isSending = true;
      this.form.date = moment(this.form.date).format('YYYY-MM-DD');
      this.form.post('/manager/record')
      .then((response)=>{
        this.$router.push('/record')
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
    kistaChange(){
      this.$store.dispatch("allSelectKista", [this.form.luckydraw_id]);
    },
    luckydrawChange(){
      this.kistaChange();
    },
  }
}
</script>
<style scoped>
</style>
