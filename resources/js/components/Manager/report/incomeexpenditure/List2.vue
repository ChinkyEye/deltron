<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0 text-dark">Income-Expenditure Report</h5>
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
        <button @click.prevent="salesReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button>
        <div class="card card-info card-outline">
          <div class="card-header">
            <div class="row">
              <div class="col-md">
                <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" @change="luckydraw_change"> 
                  <option value="">Select All Scheme</option>
                  <option :value="luckydraw.id" v-for="luckydraw in getAllLuckydraw">{{luckydraw.name}}</option>
                </select>
              </div>
              <div class="form-group col-md">
                <select class="form-control" id="kista_id" name="kista_id" v-model="kista_id"  @change="kistaChange"> 
                  <option value="">Select one</option>
                  <option :value="kista.id" v-for="kista in getAllKista">{{kista.name}}</option>
                </select>
              </div>
              <div class="form-group col-md-5">
                <date-picker mode='range' v-model="date" lang="en" type="date" format="YYYY-MM-dd" v-on:input="dateChange" is-range>
                  <template v-slot="{ inputValue, inputEvents }">
                    <div class="flex justify-center items-center">
                      <input
                      :value="inputValue.start"
                      v-on="inputEvents.start"
                      class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                      /><i class="fas fa-arrow-right fa-fw"></i>
                      <input
                      :value="inputValue.end"
                      v-on="inputEvents.end"
                      class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                      />
                    </div>
                  </template>
                </date-picker>
              </div>
      <!-- <div class="form-group col-md">
        <button class="btn btn-primary btn-block col" @click="searchdata">{{"Click to continue"}}
        </button>
      </div> -->

    </div>
  </div>
  <div class="card-body">
    <div id="printMe">
      <div class="row">
        <div class="table-responsive col-sm-6">
          <table class="table table-bordered table-hover table-sm m-0">
            <thead class="table-primary">                  
              <tr>
                <th>Income</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody v-if="luckydraw_id && kista_id">
              <tr>
              <!-- <tr v-if="opening_balance"> -->
                <td>Opening Balance</td>
                <td>{{opening_balance}}</td>
                <!-- <td>{{pre_opening_amount}}</td> -->
              </tr>
              <tr v-if="latest_income">
                <td>Income of this kista:</td>
                <td>{{latest_income}}</td>
              </tr>
              <tr v-for="(data,index) in getAllIncomeExpenditure" :key="data.id">
                <td>{{data.topic}}</td>                       
                <td>{{data.amount}}</td>                       
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td>Total:</td>
                <td><span>{{grandtotalIn}}</span></td>
              </tr>
              <tr>
              <!-- <tr v-if="cash_balance"> -->
                <td class="text-info">Grand Total</td>
                <td>{{grandtotalIn}}</td>
              </tr>
            </tfoot>
          </table>
          <!-- <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination> -->
        </div>
        <div class="table-responsive col-sm-6">
          <table class="table table-bordered table-hover table-sm m-0">
            <thead class="table-primary">                  
              <tr>
                <th>Expenditure</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody v-if="luckydraw_id">
              <tr v-if="bankbalance">
                <td>Deposited in {{bank_name}}</td>
                <td>{{bankbalance}}</td>
              </tr>
              <tr v-for="(data,index) in getAllIncomeExpenditures" :key="data.id">
                <td>{{data.topic}}</td>                       
                <td>{{data.amount}}</td>                       
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td><strong>Total:</strong></td>
                <td>{{total2}}</td>
              </tr>
              <tr v-if="cash_balance">
                <td>Cash Balance</td>
                <td>{{cash_balance2}}</td>
                <!-- <td>{{cash_balance}}</td> -->
              </tr>
              <tr v-if="cash_balance">
                <td class="text-info">Grand Total</td>
                <td>{{grandtotalEx}}</td>
              </tr>
            </tfoot>
          </table>
          <!-- <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination> -->
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
          luckydraw_id:'',
          cost_price:'',
          total1:'',
          total2:'',
          kista_id:'',
          lottery_status:'',
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          search:'',
          bankbalance:'',
          bank_name:'',
          cash_balance:'',
          cash_balance2:'',
          opening_balance:'0',
          prev_income:'0',
          grandtotalEx:'0',
          grandtotalIn:'0',
          latest_income:'0',
          pre_opening_amount:'0',
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllLuckydraw(){
          return this.$store.getters.getSelectLuckyDraw[0]
      },
      getAllKista(){
        var b = this.$store.getters.getSelectKista
        return b[0];
      },
      getAllIncomeExpenditure(){
        var avar = this.$store.getters.getIncomeExpenditureReport;
        this.total1= avar[2];
        this.opening_balance = avar[9];
        this.pre_opening_amount = avar[12];
        this.prev_income = avar[10];
        this.latest_income = avar[11];
        this.grandtotalIn= avar[9]+avar[11];
        if(avar.length==2)
          this.pagination = avar[1];
        return avar[0];
      },
      getAllIncomeExpenditures(){
        var avar = this.$store.getters.getIncomeExpenditureReport;
        this.total2 = avar[3];
        this.bankbalance = avar[6];
        this.bank_name = avar[7];
        this.cash_balance = avar[8];
        this.cash_balance2 = avar[9]+avar[11] - avar[3];
        // this.grandtotalEx = avar[3]+ avar[8];
        this.grandtotalEx = avar[3]+ this.cash_balance2;
        if(avar.length==2)
          this.pagination = avar[1];
        return avar[1];
      },
    },
    methods:{
      fetchPosts() {
        this.pagechange();
        this.$store.dispatch("allSelectLuckyDraw")
        // this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
        // this.$store.dispatch("allTpnplReport", [this.luckydraw_id,this.kista_id]);

      },
      pagechange(){
        this.$Progress.start()
        this.$store.dispatch("allIncomeExpenditureReport", [this.pagination.current_page,this.kista_id,this.luckydraw_id,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
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
      },
      dateChange(){
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
      salesReportExport(){
        location.href = '/home/report/purchase/export?name='+this.name+'&supplier_id='+this.supplier_id+'&category_id='+this.category_id+'&subcategory_id='+this.sub_category_id+'&start_date='+moment(this.date.start).format('YYYY-MM-DD')+'&end_date='+moment(this.date.end).format('YYYY-MM-DD');
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