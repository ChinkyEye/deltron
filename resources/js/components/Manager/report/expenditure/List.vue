<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0 text-dark">Expenditure Report</h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
          <li class="breadcrumb-item active">Dashboard v1</li>
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
        <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
        <button @click.prevent="expenditurereportExport()" class="btn btn-success rounded-0" :disabled="click"><i class="fas fa-print" title="Export To Excel"></i> Excel</button>
        <div class="card card-info card-outline">

          <div class="card-header">
            <div class="row">
              <div class="col-md">
                <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" @change="luckydraw_change"> 
                  <option value="">Select one Scheme</option>
                  <option :value="luckydraw.id" v-for="luckydraw in getAllLuckydraw">{{luckydraw.name}}</option>
                </select>
              </div>
              <div class="form-group col-md">
                <select class="form-control" id="kista_id" name="kista_id" v-model="kista_id"  @change="kistaChange"> 
                  <option value="">Select Kista</option>
                  <option :value="kista.id" v-for="kista in getAllKista">{{kista.name}}</option>
                </select>
              </div>
              <div class="form-group col-md">
                <select class="form-control" id="expenditure_type" name="expenditure_type" v-model="expenditure_type" @change="expendituretypechange"> 
                  <option disabled value="">Select one</option>
                  <option value="1">Direct</option>
                  <option value="2">Indirect</option>
                </select>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div id="printMe" class="row">
              <div class="col-md-12 text-center mb-2">
                <span>{{auth_name}},{{auth_address}}</span><br>
                <span>Expenditure Report</span><br>
                <span>{{luckydraw_name}} {{kista_name}} {{expendituretype}}</span>

              </div>
              <div class="table-responsive col-sm">
                <table class="table table-bordered table-hover table-sm m-0">
                  <thead class="table-primary">                  
                    <tr>
                      <th>Expenditure Topic</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody v-if="expenditure_type">
                    <tr v-for="(data,index) in getAllIncomeExpenditures" :key="data.id">
                      <td>{{data.topic}}</td>                       
                      <td>{{data.amount}}</td>                       
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td><strong>Total:</strong></td>
                      <td>{{total}}</td>
                    </tr>
                  </tfoot>
                </table>
                <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
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
  import pagination from '../../../../components/PaginationComponent.vue';
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
  export default{
    name: "List",
    components: {
      pagination,
      DatePicker
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          expenditure_type:'',
          luckydraw_id:'',
          kista_id:'',
          total:'',
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          search:'',
          click: true,
          auth_name:'',
          auth_address:'',
          luckydraw_name:'',
          kista_name:'',
          expendituretype:'',
        }
    },
    mounted(){
      this.$Progress.start()
      this.fetchPosts();
      axios.get(`/currentuser`)
        .then((response)=>{
          this.auth_name = response.data.currentuser.name;
          this.auth_address = response.data.currentuser.address;
      })
      this.$Progress.finish()
    },
    computed:{
      getAllLuckydraw(){
          return this.$store.getters.getSelectLuckyDraw[0]
      },
      getAllKista(){
        var b = this.$store.getters.getSelectKista
        return b[0];
      },
      getAllIncomeExpenditures(){
        var avar = this.$store.getters.getExpenditureReport;
        this.total = avar[2];
        this.luckydraw_name = avar[3];
        this.kista_name = avar[4];
        this.expendituretype = avar[5];
        if(avar.length==3)
          this.pagination = avar[1];
        return avar[0];
      },
    },
    methods:{
      fetchPosts() {
        this.pagechange();
        this.$store.dispatch("allSelectLuckyDraw")

      },
      pagechange(){
        this.$Progress.start()
        this.$store.dispatch("allExpenditureReport", [this.pagination.current_page,this.luckydraw_id,this.kista_id,this.expenditure_type,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
        this.$Progress.finish()
      },
   
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
         this.pagechange();
      },
      lotterystatuschange(){
         this.pagechange();
      },
      luckydraw_change(){
        this.kistaChange();
        this.pagechange();
        this.click = false;
      },
      dateChange(){
        this.pagechange();
      },
      expendituretypechange(){
        this.pagechange();
      },
      categoryChange(){
        this.pagechange();
        this.subCatchange();
      },
      subCatchange(){
        this.pagechange();
      },
      print () {
        this.$htmlToPaper('printMe');
      },
      expenditurereportExport(){
        location.href = '/manager/report/expenditure/export?luckydraw_id='+this.luckydraw_id+'&kista_id='+this.kista_id+'&expenditure_type='+this.expenditure_type;
      },
      searchdata()
      {
        this.$store.dispatch("allLotteryPrizeReport", [this.luckydraw_id,this.kista_id,this.search]);

      },
    }
  }
</script>

<style scoped>
</style>