<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Sub-Agent List</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Sub-Agent</li>
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
            <div class="card card-info card-outline">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-2">
                    <router-link :to="'/subagent/'+this.$route.params.agentid+'/create'" class="btn btn-primary btn-block" style="color:#fff"> Add <i class="fas fa-user-plus fa-fw"></i></router-link>
                  </div>
                  <div class="col-md-10">
                    
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="table-primary text-center">                  
                      <tr>
                        <th width="10">SN</th>
                        <th class="text-left">Name</th>
                        <th class="text-left">Address</th>
                        <th class="text-left">Phone</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <!-- <th>Action</th> -->
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(data,index) in getAllSubAgent" :key="data.id" :class="colorchange(data.is_active)">
                        <td>{{index+1}}</td>
                        <td class="text-left">{{data.name}}</td>
                        <td class="text-left">{{data.address}}</td>
                        <td class="text-left">{{data.phone}}</td>
                        <td v-if="data.is_active == '0'">Inactive <a href="javascript:void(0)" @click.prevent="AgentStatus(data.id, data.is_active)" title="Click to Publish"><i class="nav-icon fas fa-times-circle text-danger"></i></a></td>
                        <td v-else>Active <a href="javascript:void(0)" @click.prevent="AgentStatus(data.id, data.is_active)" title="Click to Unpublish"><i class="nav-icon fas fa-check-circle text-success"></i></a></td>
                        <td>
                          {{data.created_at | timeformat}} 
                          <span class="badge badge-warning text-danger">{{data.created_at  | formatDate}}</span>
                        </td>
                        <!-- <td>
                          <div class="btn-group">
                            <router-link :to="`/agent/add/subagent/${data.id}`" class="btn btn-xs btn-outline-danger" title="Add Agent"><i class="fas fa-plus"></i></router-link> 
                            <router-link :to="`/agent/add/client/${data.id}`" class="btn btn-xs btn-outline-info"><i class="fas fa-plus"></i></router-link> 
                            <router-link :to="`/agent/${data.id}/edit`" class="btn btn-xs btn-outline-info"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                            <a href="" @click.prevent="deleteLuckyDraw(data.id)" class="btn btn-xs btn-outline-danger"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
                          </div>
                        </td> -->
                      </tr>
                    </tbody>
                  </table>

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
<script type="text/javascript">
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
          search: ''
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllSubAgent(){
        var avar = this.$store.getters.getSubAgent;
        if(avar.length==2)
          this.pagination = avar[1];
        return avar[0];
      }
    },
    methods:{
      fetchPosts(){
        this.$Progress.start()
        this.$store.dispatch("allSubAgent", [this.pagination.current_page,this.search,this.$route.params.agentid]);
        this.$Progress.finish()
      },
      AgentStatus(clkid, show){
          axios.get('/manager/agent/status/'+clkid+'/'+show)
          .then(()=>{
              this.$store.dispatch("allSubAgent", [0,0,this.$route.params.agentid]);
              Toast.fire({
                  icon: 'success',
                  title: 'Status changed successfully'
              })
          })
          .catch(()=>{
        })
      },
      colorchange(id){
        return {
          'table-danger':!id,
          'table-default': id
        }
      },
      deleteLuckyDraw(id){
        var that = this;
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          buttonsStyling: true
        }).then(function (isConfirm) {
          if(isConfirm.value === true) {
            axios.delete('/manager/agent/'+id)
            .then((response)=>{
              Toast.fire({
                icon: 'success',
                title: 'Data Deleted successfully'
              })
              that.$store.dispatch("allLuckyDraw", [0,0]);
            })
            .catch((response)=>{
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong'
              })
            })
          }
          else{
            Toast.fire({
              icon: 'error',
              title: 'Setting not Deleted'
            })
          }
        })
      },
      searchSetting(){
        this.fetchPosts();
      }

    }
}
</script>