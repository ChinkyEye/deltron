<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">TPNP Report ({{this.manager_name}})</h5>
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
            <button  @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
            <!-- <button @click.prevent="tpnpExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button> -->
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
                  <div class="col-md">
                    <select class="form-control" id="kista_id" name="kista_id" v-model="kista_id"> 
                      <option value="">Select one kista</option>
                      <option :value="kista.id" v-for="kista in getAllKista">{{kista.name}}</option>
                    </select>
                  </div>
                  <button class="btn btn-primary btn-block col" @click="searchdata">{{"Click to continue"}}
                  </button>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div id="printMe">
                  <div class="row">
                    <div class="table-responsive col-sm-5">
                      <table class="table table-bordered table-hover table-sm m-0">
                        <thead class="table-primary">                  
                          <tr>
                            <th colspan="2" class="text-center">Paid</th>
                          </tr>
                          <tr>
                            <th>Count(people)</th>
                            <th>Total Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>{{played}}</td>
                            <td>Rs.{{playedamount}}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="table-responsive col-sm-5">
                      <table class="table table-bordered table-hover table-sm m-0">
                        <thead class="table-primary"> 
                          <tr>
                            <th colspan="2" class="text-center">Not Paid</th>
                          </tr>                 
                          <tr>
                            <th>Count(people)</th>
                            <th>Total Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <span v-for="(data,index) in getAllTpnpReport" :key="data.id"></span>
                          <tr>
                            <td>{{notplayed}}</td>
                            <td>Rs.{{notplayedamount}}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="table-responsive col-sm-2">
                      <table class="table table-bordered table-hover table-sm m-0">
                        <thead class="table-primary"> 
                          <tr>
                            <th colspan="1" class="text-center">Leave</th>
                          </tr>                 
                          <tr>
                            <th class="text-center">Count(people)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-center">no:{{leave}}</td>
                          </tr>
                        </tbody>
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
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          manager_id:'',
          luckydraw_id:'',
          kista_id:'',
          played:'',
          notplayed:'',
          playedamount:'',
          notplayedamount:'',
          leave:'',
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
      allSelectLuckyDraws(){
        var a = this.$store.getters.getSelectLuckyDraw[0]
        return a;
      },
      // allSelectMLuckyDraws(){
      //   var a = this.$store.getters.getSelectMLuckyDraw[0]
      //   return a;
      // },
      getAllKista(){
        var b = this.$store.getters.getSelectKista
        return b[0];
      },
      getAllTpnpReport(){
        var c = this.$store.getters.getTpnpReport
        this.played = c[0];
        this.notplayed = c[1];
        this.playedamount = c[2];
        this.notplayedamount = c[3];
        this.leave = c[4];
        return c[1];
      },
      getAllSelectManager(){
        var d = this.$store.getters.getSelectManager[0]
        return d;
      },

    },
    methods:{
      fetchPosts() {
        // this.$store.dispatch("allSelectManager")
        this.$store.dispatch("allSelectLuckyDraw",[this.$route.params.managerid])
      },
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
      },
      luckydrawChange(){
        this.kistaChange();
      },
      managerChange(){
        this.$store.dispatch("allSelectMLuckyDraw", [this.manager_id]);
        this.luckydrawChange();
      },
      searchdata()
      {
        this.$store.dispatch("allTpnpReport", [this.kista_id,this.luckydraw_id,this.$route.params.managerid]);
      },
      print () {
        this.$htmlToPaper('printMe');
      },
      tpnpExport()
      {
        location.href = '/manager/report/tpnp/export?luckydraw_id='+this.luckydraw_id+'&kista_id='+ this.kista_id;
      }
    }
  }
</script>

<style scoped>
</style>