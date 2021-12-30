<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Add Purchase</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Purchase</li>
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
                    <router-link :to="'/purchase'">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addPurchase()">
                    <div class="card-body">
                      <div class="row">
                        <input type="hidden" class="form-control" id="name" v-model="form.kistaid" name="name">
                        
                        <div class="form-group col-md-12">
                          <label for="supplier_name">Supplier Name</label>
                          <input type="text" class="form-control" id="supplier_name" placeholder="Add supplier_name" v-model="form.supplier_name" name="supplier_name" :class="{ 'is-invalid': form.errors.has('supplier_name') }" autocomplete="off">
                          <has-error :form="form" field="supplier_name"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="item_name">Item Name <code>*</code></label>
                          <input type="text" class="form-control" id="item_name" placeholder="Add item_name" v-model="form.item_name" name="item_name" :class="{ 'is-invalid': form.errors.has('item_name') }" autocomplete="off">
                          <has-error :form="form" field="item_name"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="quantity">Quantity<code>*</code></label>
                          <input type="text" class="form-control" id="quantity" placeholder="Add quantity" v-model="form.quantity" name="quantity" :class="{ 'is-invalid': form.errors.has('quantity') }" autocomplete="off">
                          <has-error :form="form" field="quantity"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="rate">Rate<code></code></label>
                          <input type="text" class="form-control" id="rate" placeholder="Add rate" v-model="form.rate" name="rate" :class="{ 'is-invalid': form.errors.has('rate') }" autocomplete="off">
                          <has-error :form="form" field="rate"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="amount">Amount<code>*</code></label>
                          <input type="text" class="form-control" id="amount" placeholder="Add amount" v-model="form.amount" name="amount" :class="{ 'is-invalid': form.errors.has('amount') }" autocomplete="off">
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
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Purchase"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Supplier Name : {{form.supplier_name}}</h5>
                      <h5>Item Name : {{form.item_name}}</h5>
                      <h5>Quantity : {{form.quantity}}</h5>
                      <h5>Amount : {{form.amount}}</h5>
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
          supplier_name:'',
          item_name:'',
          quantity:'',
          amount:'',
          rate:'',
          date:moment(new Date()).format('YYYY-MM-DD'),
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
        var a = this.$store.getters.getSelectLuckyDraw
        console.log(a);
        return a;
      },
    },
    methods:{
     addPurchase(){
      this.state.isSending = true;
      this.form.date = moment(this.form.date).format('YYYY-MM-DD');
      this.form.post('/manager/purchase')
      .then((response)=>{
        this.$router.push(`/purchase`)
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
