<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Add Booking</h5>
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
                    <router-link to="/booking">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addBooking()">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md">
                          <label for="agent_id">Agent Name<code>*</code></label>
                          <select class="form-control" id="agent_id" v-model="form.agent_id" name="agent_id"> 
                            <option disabled value="">Select one agent</option>
                            <option :value="agent.id" v-for="agent in getAllAgent">
                              {{agent.name}}
                            </option>
                          </select>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="agent_id">Serial No<code>*</code></label><br>
                          <span v-for="(detail,index) in getAllPreviewReport2" :key="detail.id">
                            <input type="checkbox" id="detail[index]" value="detail" v-model="form.checkedNames[index]">
                            <label for="detail[index]">{{detail}}</label>
                          </span>

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
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Booking"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Date : {{form.date}}</h5>
                      <!-- <h5>Serial No : {{form.checkedNames}}</h5> -->
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
          startRange:'',
          endRange:'',
          date:moment(new Date()).format('YYYY-MM-DD'),
          agent_id: '',
          checkedNames:[],
        }),

        state: {
          isSending: false
        },
        pagination: {
          'current_page': 1
        },
        agent_id:'',
        search:'',
      }
    },
    mounted(){
      // this.fetchPosts();
      this.$Progress.start()
      this.$store.dispatch("allPreviewReport", [this.pagination.current_page,this.agent_id,this.search]);
      this.$store.dispatch("allSelectLuckyDraw")
      this.$store.dispatch("allSelectAgent");
      this.$Progress.finish()
    },
    computed:{
      allSelectLuckyDraws(){
        var a = this.$store.getters.getSelectLuckyDraw[0]
        return a;
      },
      getAllAgent(){
        var b = this.$store.getters.getSelectAgent
        return b[0];
      },
      getAllPreviewReport2(){
        var avar = this.$store.getters.getPreviewReport;
        return avar[3];
      },
    },
    methods:{
    // fetchPosts() {
    //     this.$store.dispatch("allPreviewReport", [this.pagination.current_page,this.agent_id,this.search]);
    // },
    addBooking(){
      this.state.isSending = true;
      this.form.date = moment(this.form.date).format('YYYY-MM-DD');
      this.form.post('/manager/booking')
      .then((response)=>{
        this.$router.push('/booking')
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
  }
}
</script>
<style scoped>
</style>
