<template>
	<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz"><span class="font-weight-bold">{{agent_name}}'s</span> Member List</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Member</li>
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
                    <router-link :to="'/client/'+this.$route.params.agentid+'/create'" class="btn btn-primary btn-block" style="color:#fff"> Add <i class="fas fa-user-plus fa-fw"></i></router-link>
                    <!-- <router-link to="/client/create" class="btn btn-primary btn-block" style="color:#fff"> Add <i class="fas fa-user-plus fa-fw"></i></router-link> -->
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
                        <th class="text-left">Member Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Serail No.</th>
                        <!-- <th>Lottery No.</th> -->
                        <th>Agent</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(data,index) in getALLClient" :key="data.id" :class="colorchange(data.is_active,data.is_leave)" >
                        <td>{{index+1}}</td>
                        <td class="text-left">{{data.name}}</td>
                        <td>{{data.address}}</td>
                        <td>{{data.phone}}</td>
                        <td>{{data.serial_no}}</td>
                        <!-- <td>{{data.lottery_no}}</td> -->
                        <td>{{data.get_agent.name}}</td>
                        <td v-if="data.is_active == '0'">Inactive <a href="javascript:void(0)" @click.prevent="ClientStatus(data.id, data.is_active)" title="Click to Publish"><i class="nav-icon fas fa-times-circle text-danger"></i></a></td>
                        <td v-else>Active <a href="javascript:void(0)" @click.prevent="ClientStatus(data.id, data.is_active)" title="Click to Unpublish"><i class="nav-icon fas fa-check-circle text-success"></i></a></td>
                        <td>
                          {{data.date_np}} 
                          <!-- {{data.created_at | timeformat}}  -->
                          <span class="badge badge-warning text-danger">{{data.created_at  | formatDate}}</span>
                        </td>                        
                        <td>
                          <router-link :to="`/client/${data.id}/edit`" class="btn btn-xs btn-outline-info"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                          <a href="" @click.prevent="deleteClient(data.id)" class="btn btn-xs btn-outline-danger"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
                          <a href="" @click.prevent="editClient(data.id, data.is_leave)" class="btn btn-xs btn-outline-success"><i class="fa fa-times" aria-hidden="true" title="Click to make member leave"></i></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
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
          search: '',
          agent_name:'',
        }
    },
    mounted(){
		this.fetchPosts();
    axios.get(`/manager/agent_name/${this.$route.params.agentid}`)
      .then((response)=>{
        this.agent_name = response.data.agent_name.name;
      })

	  },
    computed:{
      getALLClient(){
        var avar = this.$store.getters.getClient;
        // this.agent_name = avar[0];
        if(avar.length==3)
          this.pagination = avar[2];
        return avar[0];
      }
    },
	  methods:{
      fetchPosts(){
        this.$Progress.start()
        this.$store.dispatch("allClient", [this.pagination.current_page,this.search,this.$route.params.agentid]);
        this.$Progress.finish()
      },
      ClientStatus(clkid, show){
          axios.get('/manager/client/status/'+clkid+'/'+show)
          .then(()=>{
              this.$store.dispatch("allClient", [0,0,this.$route.params.agentid]);
              Toast.fire({
                  icon: 'success',
                  title: 'Status changed successfully'
              })
          })
          .catch(()=>{
        })
      },
      colorchange(id,ids){
        return {
          'table-danger':!id,
          'table-default': id,
          'table-danger':!ids,
          'table-default': ids
        }
      },
      deleteClient(id){
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
            axios.delete('/manager/client/'+id)
            .then((response)=>{
              Toast.fire({
                icon: 'success',
                title: 'Data Deleted successfully'
              })
              that.$store.dispatch("allClient", [0,0]);
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
              title: 'Data not Cancelled'
            })
          }
        })
      },
      editClient(id,leaveId){
        var that = this;
        Swal.fire({
          title: 'Are you sure?',
          text: "You want to make member leave!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, change it!',
          cancelButtonText: 'No, cancel!',
          buttonsStyling: true
        }).then(function (isConfirm) {
          if(isConfirm.value === true) {
            axios.get('/manager/client/leave/'+id+'/'+leaveId)
            .then((response)=>{
              Toast.fire({
                icon: 'success',
                title: 'Data Changed successfully'
              })
               that.$store.dispatch("allClient", [0,0,`${that.$route.params.agentid}`]);
            })
            .catch((response)=>{
               // this.$store.dispatch("allClient", [0,0,`${that.$route.params.agentid}`]);
               Toast.fire({
                icon: 'success',
                title: 'Data Changed successfully'
              })
            })
          }
          else{
            Toast.fire({
              icon: 'error',
              title: ' not Changed'
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