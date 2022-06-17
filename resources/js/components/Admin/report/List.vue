<template>
<div>
  <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0 text-dark">Report</h5>
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
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- <div  v-for="(detail,index) in getAllOrder"></div> -->
      <div class="col-lg-3">
        <router-link to="/report/tpnp">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>0</h3>
              <p>TPNP Report</p>
            </div>
          </div>
        </router-link>
      </div>
      <div class="col-lg-3">
        <router-link to="/report/tpnpl">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>0</h3>
              <p>TPNPL Report</p>
            </div>
          </div>
        </router-link>
      </div>
      <div class="col-lg-3">
        <router-link to="/report/agent">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{agent_count}}</h3>
              <p>Agent Report</p>
            </div>
          </div>
        </router-link>
      </div>
      <div class="col-lg-3">
        <router-link to="/report/lotteryprize">
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>{{lotteryprize_count}}</h3>
              <p>Scheme Prize Report</p>
            </div>
          </div>
        </router-link>
      </div>
      <div class="col-lg-3">
        <router-link to="/report/purchase">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{purchase_count}}</h3>
              <p>Purchase Report</p>
            </div>
          </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/incomeexpenditure">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{incomeexpenditure_count}}</h3>
              <p>Income Expenditure Report</p>
            </div>
          </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/expenditure">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{expenditure_count}}</h3>
              <p>Expenditure Report</p>
            </div>
          </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/record">
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>{{record_count}}</h3>
              <p>Record Report</p>
            </div>
          </div>
        </router-link>
      </div>
    </div>
</div>
</section>
</div>
</template>
<script>
export default{
    name: "List",
    components: {
    },
    data(){
      return{
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
            // this.$Progress.start()
            // this.fetchPosts();
            // this.$Progress.finish()
        },
        // computed:{
        //     getAllOrder(){
        //         var bvar = this.$store.getters.getReportDashboard;
        //         if(bvar.length == 0) return [];
        //         // console.log(bvar[0].tpnp_count);
        //         this.tpnp_count = bvar[0].tpnp_count;
        //         this.tpnpl_count = bvar[0].tpnp_count;
        //         this.agent_count = bvar[0].tpnp_count;
        //         this.lotteryprize_count = bvar[0].lotteryprize_count;
        //         this.purchase_count = bvar[0].purchase_count;
        //         this.incomeexpenditure_count = bvar[0].incomeexpenditure_count;
        //         this.expenditure_count = bvar[0].expenditure_count;
        //         this.record_count = bvar[0].record_count;
        //         this.member_count = bvar[0].member_count;
        //         // this.order_count = bvar[0].order_count;
        //         // this.stock_level_count = bvar[0].stock_level_count;
        //         // this.counter_count = bvar[0].counter_count;
        //         // this.bill_count = bvar[0].bill_count;
        //         // this.bill_ageing_count = bvar[0].bill_ageing_count;
        //         // this.purchase_return_count = bvar[0].purchase_return_count;
        //         // this.top_item_sale = bvar[0].top_item_sale;
        //         // this.top_item_customer = bvar[0].top_item_customer;
        //     }
        // },
        // methods:{
        //     fetchPosts() {
        //         this.$store.dispatch("allReportDashboard")
        //     }
        // }
    }
</script>

<style scoped>
</style>