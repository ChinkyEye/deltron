<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0 text-dark">Scheme Prize Report ({{this.manager_name}})</h5>
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
                  <option value="">Select one kista</option>
                  <option :value="kista.id" v-for="kista in getAllKista">{{kista.name}}</option>
                </select>
              </div>
              <div class="form-group col-md m-md-0">
                <input type="text" id="search" class="form-control" v-model="search" placeholder="Search by Name or serial_no">
              </div>
              <div class="form-group col-md">
                <button class="btn btn-primary btn-block col" @click="searchdata">{{"Click to continue"}}
                </button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div id="printMe" class="row">
              <div class="col-md-12 text-center mb-2">
                <span>{{auth_name}},{{auth_address}}</span><br>
                <span>Scheme Prize Report</span>
              </div>
              <div class="table-responsive col-sm">
                <table class="table table-bordered table-hover table-sm m-0">
                  <thead class="table-primary">                  
                    <tr>
                      <th>SN</th>
                      <th>Member</th>
                      <th>Info</th>
                      <th>Agent</th>
                      <th>Allocated Prize</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(detail,index) in getAllPrizeReport" :key="detail.id">
                      <td>{{index+1}}</td>
                      <td>{{detail.get_client_info.name}} ({{detail.get_client_info.address}}, {{detail.get_client_info.phone}}) ({{detail.get_client_info.serial_no}})</td>
                      <td>{{detail.get_luckydraw_info.name}} | {{detail.get_kista_info.name}}</td>
                      <td>{{detail.get_agent_info.name}}</td>
                      <td><span class="badge badge-warning text-danger">{{detail.lottery_prize}}</span></td>
                    </tr>
                  </tbody>
                </table>
                <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="searchdata"></pagination>
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
          total:'',
          kista_id:'',
          lottery_status:'',
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          search:'',
          auth_name:'',
          auth_address:'',
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
      getAllPrizeReport(){
        var avar = this.$store.getters.getLotteryPrizeReport;
        this.total = avar[2];
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
        
        // this.$store.dispatch("allSelectLuckyDraw")
        // this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
      },
      managerChange(){
        this.$store.dispatch("allSelectMLuckyDraw", [this.manager_id]);
        this.luckydrawChange();
      },
      pagechange(){
        this.$Progress.start()
        this.$Progress.finish()
      },
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
         this.pagechange();
      },
      luckydrawChange(){
        this.kistaChange();
        this.pagechange();
      },
      print () {
        this.$htmlToPaper('printMe');
      },
      searchdata()
      {
        this.$store.dispatch("allLotteryPrizeReport", [this.luckydraw_id,this.kista_id,this.search,this.pagination.current_page,this.$route.params.managerid]);

      },
    }
  }
</script>

<style scoped>
</style>