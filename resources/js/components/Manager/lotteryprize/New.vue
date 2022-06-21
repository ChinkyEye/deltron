<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Add Scheme Prize</h5>
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
                    <router-link :to="'/lotteryprize'">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addPrize()">
                    <div class="card-body">
                      <div class="row">
                        <!-- <input type="hidden" class="form-control" id="name" v-model="form.kistaid" name="name"> -->
                        
                        <div class="form-group col-md-12">
                          <label for="lottery_prize">Scheme Prize<code>*</code></label>
                          <input type="text" class="form-control" id="lottery_prize" placeholder="Add prize" v-model="form.lottery_prize" name="lottery_prize" :class="{ 'is-invalid': form.errors.has('lottery_prize') }" autocomplete="off">
                          <has-error :form="form" field="lottery_prize"></has-error>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Prize"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Prize : {{form.lottery_prize}}</h5>
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
          lottery_prize:'',
          detailid: this.$route.params.detailid,
        }),
        state: {
          isSending: false
        }
      }
    },
    mounted(){
      // this.$Progress.start()
      // axios.get(`/manager/detail/${this.$route.params.detailid}/edit`)
      // .then((response)=>{
      //   // console.log(response.data.details);
      //   this.form.fill(response.data.details)
      // })
      // this.$Progress.finish()
    },
    computed:{
    },
    methods:{
     addPrize(){
      this.state.isSending = true;
      this.form.post('/manager/detail/prize')
      .then((response)=>{
        this.$router.push(`/lotteryprize`);
        // that.$store.dispatch("allKistaDetail");
        // location.reload();
        Toast.fire({
          icon: 'success',
          title: 'Prize Added successfully'
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
  }
}
</script>
<style scoped>
</style>
