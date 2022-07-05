<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Record List ({{this.manager_name}})</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Record</li>
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
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="table-primary text-center">                  
                      <tr>
                        <th width="10">SN</th>
                        <th>Topic</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Info</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(data,index) in getAllRecord" :key="data.id" :class="colorchange(data.is_active)">
                        <td>{{index+1}}</td>
                        <td>{{data.title}}</td>
                        <td>{{data.description}}</td>
                        <td>{{data.amount}}</td>
                        <td>{{data.get_lucky_draw.name}} | {{data.get_kista.name}}</td>
                        <td v-if="data.is_active == '0'">Inactive <a href="javascript:void(0)" @click.prevent="RecordStatus(data.id, data.is_active)" title="Click to Publish"><i class="nav-icon fas fa-times-circle text-danger"></i></a></td>
                        <td v-else>Active <a href="javascript:void(0)" @click.prevent="RecordStatus(data.id, data.is_active)" title="Click to Unpublish"><i class="nav-icon fas fa-check-circle text-success"></i></a></td>
                        <td>
                          {{data.date_np}} 
                          <span class="badge badge-warning text-danger">{{data.created_at  | formatDate}}</span>
                        </td> 
                        <td>{{data.get_user_name.name}}</td>                       
                        <td>
                          <router-link :to="`/record/${data.id}/edit`" class="btn btn-xs btn-outline-info"><i class="fas fa-pencil-alt" title="Click to edit"></i>
                          </router-link> 
                          <a href="" @click.prevent="deleteRecord(data.id)" class="btn btn-xs btn-outline-danger"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
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
          manager_name: ''
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
      getAllRecord(){
        var avar = this.$store.getters.getRecord;
        if(avar.length==2)
          this.pagination = avar[1];
        return avar[0];
      },
     
    },
    methods:{
      fetchPosts(){
        this.$Progress.start()
        this.$store.dispatch("allRecord", [this.pagination.current_page,this.$route.params.managerid]);
        this.$Progress.finish()
      },
      RecordStatus(clkid, show){
          axios.get('/home/record/status/'+clkid+'/'+show)
          .then(()=>{
              this.$store.dispatch("allRecord", [0,this.$route.params.managerid]);
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
      deleteRecord(id){
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
            axios.delete('/home/record/'+id)
            .then((response)=>{
              Toast.fire({
                icon: 'success',
                title: 'Data Deleted successfully'
              })
              that.$store.dispatch("allRecord", [0,0]);
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
              title: 'Data not Deleted'
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