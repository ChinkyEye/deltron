<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Add Supplier</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Supplier</li>
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
                    <router-link to="/supplier">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" @submit.prevent="addSupplier()">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="name">Name <code>*</code></label>
                        <input type="text" class="form-control" id="name" placeholder="Add Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off" ref="name">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="phone_no">Phone </label>
                        <input type="text" class="form-control" id="phone_no" placeholder="Add Phone no" v-model="form.phone_no" name="phone_no" :class="{ 'is-invalid': form.errors.has('phone_no') }" autocomplete="off">
                        <has-error :form="form" field="phone_no"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="address">Address </label>
                        <input type="text" class="form-control" id="address" placeholder="Add Address" v-model="form.address" name="address" autocomplete="off">
                      </div>
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
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Supplier"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Name : {{form.name}}</h5>
                      <h5>Phone no : {{form.phone_no}}</h5>
                      <h5>Address : {{form.address}}</h5>
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
    data(){
      return {
        form: new Form({
          name:'',
          phone:'',
          address:'',
          date:moment(new Date()).format('YYYY-MM-DD'),
        }),
        state: {
          isSending: false
        }
      }
    },
    mounted(){
      this.$Progress.start()
      this.focusInput()
      this.$Progress.finish()
    },
    methods:{
     addSupplier(){
      this.state.isSending = true;
      this.form.date = moment(this.form.date).format('YYYY-MM-DD');
      this.form.post('/manager/supplier')
      .then((response)=>{
        this.$router.push('/supplier')
        Toast.fire({
          icon: 'success',
          title: 'Supplier Added successfully'
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
    focusInput() {
      this.$refs.name.focus();
    }
  }
}
</script>
<style scoped>
</style>
