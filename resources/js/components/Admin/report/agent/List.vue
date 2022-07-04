<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Agent Report ({{this.manager_name}})</h5>
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
            <!-- {{this.$route.params.managerid}} -->
            <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
            <!-- <button @click.prevent="salesReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button> -->
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
                    <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" name="luckydraw_id" @change="luckydrawChange"> 
                      <option disabled value="">Select one scheme</option>
                      <option :value="luckydraw.id" v-for="luckydraw in allSelectMLuckyDraws">
                        {{luckydraw.name}}
                      </option>
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
                      <option value="">Select one kista</option>
                      <option :value="kista.id" v-for="kista in getAllKista">{{kista.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-md">
                    <select class="form-control" id="agent_id" name="agent_id" v-model="agent_id"> 
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
                      <!-- <option value="3">Leave</option> -->
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
                      <span>Agent Commission Report</span><br>
                      <span>{{luckydraw_name}}<span v-if="kista_id && clicked">,</span> {{kista_name}}<span v-if="agent_id && clicked">,</span> {{agent_name}}</span>
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
                            <td>{{agent.get_client_info.name}} ({{agent.get_client_info.address}}, {{agent.get_client_info.phone}}) ({{agent.get_client_info.serial_no}})</td>
                            <td v-if="agent.lottery_status == '1'">Unpaid</td>
                            <td v-else-if="agent.lottery_status == '2'">Paid</td>
                            <td v-else>Leave</td>
                            <td>{{agent.amount}}</td>
                            <td>{{agent.remaining}}</td>
                          </tr>
                        </tbody>
                      </table>
                      <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="searchdata"></pagination>
                    </div>
                    <div class="table-responsive col-sm-2">
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
                    <div class="table-responsive col-sm-2">
                      <table class="table table-bordered table-hover table-sm m-0">
                        <thead class="table-primary"> 
                          <tr>
                            <th>Total Collected Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Rs.{{total}}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination> -->
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
          kista_id:'',
          agent_id:'',
          lottery_status:'',
          commisionamount:'0',
          total:'0',
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          auth_name:'',
          auth_address:'',
          luckydraw_name:'',
          kista_name:'',
          agent_name:'',
          clicked:'',
          manager_name:'',
        }
    },
    mounted(){
      this.fetchPosts();
      axios.get(`/currentmanager/${this.$route.params.managerid}`)
        .then((response)=>{
          this.manager_name = response.data.currentuser.name;
      })
    },
    computed:{
      // getAllSelectManager(){
      //   var d = this.$store.getters.getSelectManager[0]
      //   return d;
      // },
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
      getAllAgent(){
        var b = this.$store.getters.getSelectAgent
        return b[0];
      },
      getAgentreport(){
        var avar = this.$store.getters.getAgentReport;
        this.commisionamount = parseFloat(avar[2]).toFixed(2);
        this.total = avar[3];
        this.luckydraw_name = avar[4];
        this.kista_name = avar[5];
        this.agent_name = avar[6];
        if(avar.length==3)
          this.pagination = avar[1];
        return avar[0];

      },

    },
    methods:{
      fetchPosts() {
        this.$store.dispatch("allSelectLuckyDraw",[this.$route.params.managerid])
      },
      luckydrawChange(){
        this.kistaChange();
      },
      managerChange(){
        this.$store.dispatch("allSelectMLuckyDraw", [this.manager_id]);
        this.luckydrawChange();
      },
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
        this.agentChange();
      },
      agentChange(){
        this.$store.dispatch("allSelectAgent", [this.$route.params.managerid]);
      },
      lotterystatuschange(){
         this.pagechange();
      },
      pagechange(){
        this.$Progress.start()
        this.$Progress.finish()
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
        this.$store.dispatch("allAgentReport", [this.luckydraw_id,this.kista_id,this.agent_id,this.lottery_status,this.pagination.current_page,this.$route.params.managerid]);
        this.clicked = true;

      },
    }
  }
</script>
