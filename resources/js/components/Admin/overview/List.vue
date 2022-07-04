<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Manager List</h5>
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
            <div class="col-lg-3" v-for="(manager,index) in getAllManager" :key="manager.id">
              <div class="col-lg-12 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <p>{{manager.name}}</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <router-link :to="`/overview/${manager.id}/viewall`" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
                </div>
              </div>
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
          search:''
        }
    },
		mounted(){
      this.fetchPosts();
		},
		computed:{
		  getAllManager(){
        this.$Progress.start()
        var avar = this.$store.getters.getManager;
        console.log(avar[0]);
        if(avar.length==2)
          this.pagination = avar[1];
        this.$Progress.finish()
        return avar[0];
      }
		},
		methods:{
      fetchPosts() {
        this.$store.dispatch("allManager",[this.pagination.current_page,0]);
      }
		}
	}
</script>

<style scoped>
</style>