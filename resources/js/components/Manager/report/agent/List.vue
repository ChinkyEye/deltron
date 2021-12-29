<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Agent Report</h5>
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
            <!-- <button @click.prevent="salesReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button> -->
            <div class="card card-info card-outline">

              <div class="card-header">
                <div class="row">
                  <div class="col-md">
                    <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" @change="luckydraw_change"> 
                      <option value="">Select one Member</option>
                      <option :value="luckydraw.id" v-for="luckydraw in getAllLuckydraw">{{luckydraw.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-md">
                    <select class="form-control" id="kista_id" name="kista_id" v-model="kista_id"  @change="kistaChange"> 
                      <option value="">Select one kista</option>
                      <option :value="kista.id" v-for="kista in getAllKista">{{kista.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-md">
                    <select class="form-control" id="agent_id" name="agent_id" v-model="agent_id"  @change="agentChange"> 
                      <option value="">Select one agent</option>
                      <option :value="agent.id" v-for="agent in getAllAgent">{{agent.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-md">
                    <!-- <label for="lottery_status">Type </label> -->
                    <select class="form-control" id="lottery_status" v-model="lottery_status" @change="lotterystatuschange"> 
                      <option disabled value="">Select one</option>
                      <option value="1">Unpaid</option>
                      <option value="2">Paid</option>
                      <option value="3">Leave</option>
                    </select>
                  </div>
                  <div class="form-group col-md">
                    <button class="btn btn-primary btn-block col" @click="searchdata">{{"Click to continue"}}
                    </button>
                  </div>

                </div>
              </div>
              <div class="card-body">
                <div id="printMe">
                  <div class="row">
                    <div class="col-md-12 text-center mb-2">
                      <span>Agent Commission Report</span>
                    </div>
                    <div class="table-responsive col-sm-8">
                      <table class="table table-bordered table-hover table-sm m-0">
                        <thead class="table-primary">                  
                          <tr>
                            <th>SN</th>
                            <th>Member</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Remaining</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(agent,index) in getAgentreport" :key="agent.id">
                            <td>{{index+1}}</td>
                            <td>{{agent.get_client_info.name}} ({{agent.get_client_info.address}}, {{agent.get_client_info.phone}})</td>
                            <td v-if="agent.lottery_status == '1'">Unpaid</td>
                            <td v-else-if="agent.lottery_status == '2'">Paid</td>
                            <td v-else>Leave</td>
                            <td>{{agent.amount}}</td>
                            <td>{{agent.remaining}}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="table-responsive col-sm-4">
                      <table class="table table-bordered table-hover table-sm m-0">
                        <thead class="table-primary"> 
                          <tr>
                            <th>Total Commision Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Rs.{{commisionamount}}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
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
          luckydraw_id:'',
          kista_id:'',
          agent_id:'',
          lottery_status:'',
          commisionamount:'0',
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          }
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
      getAgentreport(){
        var avar = this.$store.getters.getAgentReport;
        this.commisionamount = parseFloat(avar[2]).toFixed(2);
        if(avar.length==2)
          this.pagination = avar[1];
        return avar[0];

      },
      getAllAgent(){
        var b = this.$store.getters.getSelectAgent
        return b[0];
      },
    },
    methods:{
      fetchPosts() {
        this.pagechange();
        this.$store.dispatch("allSelectLuckyDraw")
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
        // this.$store.dispatch("allTpnplReport", [this.luckydraw_id,this.kista_id]);

      },
      pagechange(){
        this.$Progress.start()
        // console.log(this.lottery_status);
        this.$Progress.finish()
      },
      lotterystatuschange(){
         this.pagechange();
      },
      agentChange(){
        this.$store.dispatch("allSelectAgent", [this.kista_id]);
      },
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
        this.agentChange();
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
        this.$store.dispatch("allAgentReport", [this.luckydraw_id,this.kista_id,this.agent_id,this.lottery_status]);

      },
    }
  }
</script>

<style scoped>
</style>