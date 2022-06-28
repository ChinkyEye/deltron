<template>
<div>
  <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Dashboard</h1>
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
      <div class="col-lg-12 my-4">
        <h1 class="text-center text-success">Welcome to Admin Dashboard</h1>
      </div>
    </div>
    

        <!-- <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3></h3>

                <p>TPNP</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <router-link to="/unit" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3></h3>

                <p>TPNP</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <router-link to="/stock" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3></h3>
                <p>TPNPL</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <router-link to="/table" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3></h3>
                <p>Agent</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <router-link to="/order" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
        </div> -->
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
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
          // usertype_count:'',
          // user_count:'',
          // category_count:'',
          // package_count:'',
          // unit_count:'',
          // stock_count:'',
          // table_count:'',
          // order_count:'',
          // confirm_order_count:'',
        }
    },
		mounted(){
      this.fetchPosts();
		},
		computed:{
			// getAllOrder(){
   //      this.$Progress.start()
   //      var bvar = this.$store.getters.getDashboard;
   //      if(bvar.length == 0) return [];
   //      this.usertype_count = bvar[0].usertype_count;
   //      this.user_count = bvar[0].user_count;
   //      this.category_count = bvar[0].category_count;
   //      this.package_count = bvar[0].package_count;
   //      this.unit_count = bvar[0].unit_count;
   //      this.stock_count = bvar[0].stock_count;
   //      this.table_count = bvar[0].table_count;
   //      this.order_count = bvar[0].order_count;
   //      this.confirm_order_count = bvar[0].confirm_order_count;
   //      this.$Progress.finish()
   //    }
		},
		methods:{
      fetchPosts() {
        // this.$store.dispatch("allDashboard")
      }
		}
	}
</script>

<style scoped>
</style>