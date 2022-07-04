<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Viewall List of {{this.manager_name}}</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Manager</li>
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
          <div  v-for="(detail,index) in getAllOrder"></div>
          <div class="col-lg-3">
            <router-link :to="`/report/tpnp/${this.$route.params.managerid}`">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{tpnp_count}}</h3>
                  <p>TPNP Report</p>
                </div>
              </div>
            </router-link>
          </div>
          <div class="col-lg-3">
              <router-link :to="`/report/tpnpl/${this.$route.params.managerid}`">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{tpnpl_count}}</h3>
                    <p>TPNPL Report</p>
                  </div>
                </div>
              </router-link>
            </div>
            <div class="col-lg-3">
              <router-link :to="`/report/agent/${this.$route.params.managerid}`">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{agent_count}}</h3>
                    <p>Agent Report</p>
                  </div>
                </div>
              </router-link>
            </div>
            <div class="col-lg-3">
              <router-link :to="`/report/lotteryprize/${this.$route.params.managerid}`">
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3>{{lotteryprize_count}}</h3>
                    <p>Scheme Prize Report</p>
                  </div>
                </div>
              </router-link>
            </div>
            <div class="col-lg-3">
              <router-link :to="`/report/purchase/${this.$route.params.managerid}`">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{purchase_count}}</h3>
                    <p>Purchase Report</p>
                  </div>
                </div>
              </router-link>
            </div>
            <div class="col-lg-3 col-6">
              <router-link :to="`/report/incomeexpenditure/${this.$route.params.managerid}`">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{incomeexpenditure_count}}</h3>
                    <p>Income Expenditure Report</p>
                  </div>
                </div>
              </router-link>
            </div>
            <div class="col-lg-3 col-6">
              <router-link :to="`/report/expenditure/${this.$route.params.managerid}`">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{expenditure_count}}</h3>
                    <p>Expenditure Report</p>
                  </div>
                </div>
              </router-link>
            </div>
            <div class="col-lg-3 col-6">
              <router-link :to="`/report/record/${this.$route.params.managerid}`">
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3>{{record_count}}</h3>
                    <p>Record Report</p>
                  </div>
                </div>
              </router-link>
            </div>
            <div class="col-lg-3 col-6">
              <router-link :to="`/report/member/${this.$route.params.managerid}`">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{member_count}}</h3>
                    <p>Member Report</p>
                  </div>
                </div>
              </router-link>
            </div>
          </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
</div>
</template>
<script>
  import pagination from '../../../components/PaginationComponent.vue';
	export default{
    name: "List",
    components: {
      pagination,
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          search:'',
          url_data: null,
          manager_name: null,
          manager_address: null,
          tpnp_count:'',
          tpnpl_count:0,
          agent_count:0,
          lotteryprize_count:0,
          purchase_count:0,
          incomeexpenditure_count:0,
          expenditure_count:0,
          record_count:0,
          member_count:'',
          top_item_customer:0,
          stock_level_count:0,
        }
    },
		mounted(){
      this.fetchPosts();
      axios.get(`/currentmanager/${this.$route.params.managerid}`)
        .then((response)=>{
          console.log(response);
          this.manager_name = response.data.currentuser.name;
          this.manager_address = response.data.currentuser.address;
      })
      this.url_data = this.$route.params.managerid;
		},
		computed:{
		  getAllManager(){
        this.$Progress.start()
        var avar = this.$store.getters.getManager;
        if(avar.length==2)
          this.pagination = avar[1];
        this.$Progress.finish()
        return avar[0];
      },
      getAllOrder(){
        var bvar = this.$store.getters.getReportDashboard;
        if(bvar.length == 0) return [];
        this.tpnp_count = bvar[0].tpnp_count;
        this.tpnpl_count = bvar[0].tpnp_count;
        this.agent_count = bvar[0].tpnp_count;
        this.lotteryprize_count = bvar[0].lotteryprize_count;
        this.purchase_count = bvar[0].purchase_count;
        this.incomeexpenditure_count = bvar[0].incomeexpenditure_count;
        this.expenditure_count = bvar[0].expenditure_count;
        this.record_count = bvar[0].record_count;
        this.member_count = bvar[0].member_count;
      }
		},
		methods:{
      fetchPosts() {
        this.$store.dispatch("allManager",[this.pagination.current_page,0]);
        this.$store.dispatch("allReportDashboard",[this.$route.params.managerid])
      }
		}
	}
</script>

<style scoped>
</style>