<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0 text-dark">Expenditure Report ({{this.manager_name}})</h5>
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
                  <option value="">Select one Scheme</option>
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
                <span>Expenditure Report</span><br>
                <span>{{luckydraw_name}}<span v-if="clicked">,</span> {{kista_name}}<span v-if="clicked">,</span> {{expendituretype}}</span>

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
          manager_id:'',
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
          clicked: '',
          auth_name:'',
          auth_address:'',
          luckydraw_name:'',
          kista_name:'',
          expendituretype:'',
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
      //   var a = this.$store.getters.getSelectMLuckyDraw[0]
      //   return a;
      // },
      allSelectLuckyDraws(){
        var a = this.$store.getters.getSelectLuckyDraw[0]
        return a;
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
      getAllSelectManager(){
        var d = this.$store.getters.getSelectManager[0]
        return d;
      },
    },
    methods:{
      fetchPosts() {
        this.pagechange();
        this.$store.dispatch("allSelectLuckyDraw",[this.$route.params.managerid])
        // this.$store.dispatch("allSelectManager")

      },
      managerChange(){
        this.$store.dispatch("allSelectMLuckyDraw", [this.manager_id]);
        this.luckydrawChange();
      },
      pagechange(){
        this.$Progress.start()
        this.$store.dispatch("allExpenditureReport", [this.pagination.current_page,this.luckydraw_id,this.kista_id,this.expenditure_type,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD'),this.$route.params.managerid]);
        this.$Progress.finish()
      },
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
         this.pagechange();
      },
      luckydrawChange(){
        this.kistaChange();
        this.pagechange();
        this.click = false;
      },
      expendituretypechange(){
        this.pagechange();
        this.clicked = true;
      },
      print () {
        this.$htmlToPaper('printMe');
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