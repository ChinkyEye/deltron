<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0 text-dark">Income-Expenditure Report ({{this.manager_name}})</h5>
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
        <div class="card card-info card-outline">
          <div class="card-header">
            <div class="row">
              <!-- <div class="col-md">
                <select class="form-control" id="manager_id" v-model="manager_id" name="manager_id" @change="managerChange"> 
                  <option disabled value="">Select one manager</option>
                  <option :value="manager.id" v-for="manager in getAllSelectManager">
                    {{manager.name}}
                  </option>
                </select>
              </div> -->
              <!-- <div class="col-md">
                <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" @change="luckydrawChange"> 
                  <option value="">Select One Scheme</option>
                  <option :value="luckydraw.id" v-for="luckydraw in allSelectMLuckyDraws">{{luckydraw.name}}</option>
                </select>
              </div> -->
              <div class="col-md">
                <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" name="luckydraw_id" @change="luckydrawChange"> 
                  <option disabled value="">Select one scheme</option>
                  <option :value="luckydraw.id" v-for="luckydraw in allSelectLuckyDraws">
                    {{luckydraw.name}}
                  </option>
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
        <div class="col-md-12 text-center mb-2">
          <span>{{auth_name}},{{auth_address}}</span><br>
          <span>Income Expenditure Report</span><br>
          <span v-if="luckydraw_id && kista_id" >{{luckydraw_name}},{{kista_name}} ({{to_date}} / {{from_date}})</span>
        </div>
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
                <td>Opening Balance</td>
                <td>{{opening_balance}}</td>
              </tr>
              <tr>
                <td>Income of this kista:</td>
                <td>{{latest_income}}</td>
              </tr>
              <tr v-for="(data,index) in getAllIncome" :key="data.id">
                <td>{{data.topic}}</td>                       
                <td>{{data.amount}}</td>                       
              </tr>
            </tbody>
            <tfoot v-if="luckydraw_id && kista_id">
              <tr>
                <td><strong>Total:</strong></td>
                <td>{{total1}}</td>
              </tr>
              <tr>
                <td><span class="text-info">Grand Total:</span></td>
                <td>{{total1}}</td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="table-responsive col-sm-6">
          <table class="table table-bordered table-hover table-sm m-0">
            <thead class="table-primary">                  
              <tr>
                <th>Expenditure</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody v-if="luckydraw_id && kista_id">
              <tr>
                <td>Deposited in Bank</td>
                <td>{{bank_balance}}</td>
              </tr>
              <tr v-for="(data,index) in getAllExpenditure" :key="data.id">
                <td>{{data.topic}}</td>                       
                <td>{{data.amount}}</td>                       
              </tr>
            </tbody>
            <tfoot v-if="luckydraw_id && kista_id">
              <tr>
                <td><strong>Total:</strong></td>
                <td>{{total2}}</td>
              </tr>
              <tr>
                <td>Cash Balance:</td>
                <td>{{cash_balance}}</td>
              </tr>
               <tr>
                <td><span class="text-info">Grand Total:</span></td>
                <td>{{grandtotal2}}</td>
              </tr>
            </tfoot>
          </table>
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
          manager_id:'',
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
          latest_income:'',
          bank_balance:'',
          opening_balance:'',
          cash_balance:'',
          income_total:'',
          expenditure_total:'',
          grandtotal2:'',
          auth_name:'',
          auth_address:'',
          luckydraw_name:'',
          kista_name:'',
          to_date:'',
          from_date:'',
          manager_name:'',
        }
    },
    mounted(){
      this.$Progress.start()
      this.fetchPosts();
      axios.get(`/currentmanager/${this.$route.params.managerid}`)
      .then((response)=>{
        this.manager_name = response.data.currentuser.name;
      })
      this.$Progress.finish()
    },
    computed:{
      // allSelectMLuckyDraws(){
      //     return this.$store.getters.getSelectMLuckyDraw[0]
      // },
      allSelectLuckyDraws(){
        var a = this.$store.getters.getSelectLuckyDraw[0]
        return a;
      },
      getAllKista(){
        var b = this.$store.getters.getSelectKista
        return b[0];
      },
      getAllIncome(){
        var avar = this.$store.getters.getIncomeExpenditureReport;
        this.latest_income = avar[6];
        this.opening_balance = avar[7];
        this.income_total = avar[2];
        this.total1 = this.latest_income + this.opening_balance + this.income_total;
        this.luckydraw_name = avar[8];
        this.kista_name = avar[9];
        this.to_date = avar[10];
        this.from_date = avar[11];
        return avar[0];
      },
      getAllExpenditure(){
        var avar = this.$store.getters.getIncomeExpenditureReport;
        this.bank_balance = avar[4];
        this.expenditure_total = avar[3];
        this.total2 = this.bank_balance + this.expenditure_total;
        this.cash_balance = this.total1 - this.total2;
        this.grandtotal2 = this.cash_balance + this.total2;
        return avar[1];
      },
      getAllSelectManager(){
        var d = this.$store.getters.getSelectManager[0]
        return d;
      },
    },
    methods:{
      fetchPosts() {
        this.$store.dispatch("allSelectLuckyDraw",[this.$route.params.managerid])
        // this.$store.dispatch("allSelectManager")
        this.pagechange();

      },
       managerChange(){
        this.$store.dispatch("allSelectMLuckyDraw", [this.manager_id]);
        this.luckydrawChange();
      },
      pagechange(){
        this.$Progress.start()
        this.$store.dispatch("allIncomeExpenditureReport", [this.pagination.current_page,this.kista_id,this.luckydraw_id,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD'),this.$route.params.managerid]);
        this.$Progress.finish()
      },
   
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
         this.pagechange();
      },
      luckydrawChange(){
        this.pagechange();
        this.kistaChange();
      },
      dateChange(){
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