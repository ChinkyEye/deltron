<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Supplier List</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Supplier</li>
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
                    <router-link to="/supplier/create" class="btn btn-primary btn-block" style="color:#fff"> Add <i class="fas fa-user-plus fa-fw"></i></router-link>
                  </div>
                  <div class="col-md-10">
                    <input type="text" class="form-control" @keyup="searchSupplier" v-model="search" placeholder="Search by name">
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
                        <th class="text-left">Business ID</th>
                        <th class="text-left">Phone No</th>
                        <th class="text-left">Address</th>
                        <th class="text-left">Pan No</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Auth</th>
                        <th>Created At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <!-- <tr v-for="(supplier,index) in getAllSupplier" :key="supplier.id"  :class="customerStatus(supplier.is_active)">
                        <td>{{index+1}}</td>
                        <td class="text-left">{{supplier.name}}({{supplier.countall_count}}/{{supplier.count_count}})</td>
                        <td class="text-left">{{supplier.email}}</td>
                        <td class="text-left">{{supplier.phone_no}}</td>
                        <td class="text-left">{{supplier.address}}</td>
                        <td class="text-left">{{supplier.pan_no}}</td>
                        <td>{{supplier.date_np}} {{supplier.time_np}}</td>
                        <td v-if="supplier.is_active == '0'">Inactive <a href="javascript:void(0)" @click.prevent="supplierStatus(supplier.id, supplier.is_active)" title="Click to Publish"><i class="nav-icon fas fa-times-circle text-danger"></i></a></td>
                        <td v-else>Active <a href="javascript:void(0)" @click.prevent="supplierStatus(supplier.id, supplier.is_active)" title="Click to Unpublish"><i class="nav-icon fas fa-check-circle text-success"></i></a></td>
                        <td v-if="supplier.is_auth == '0'">Inactive <i class="nav-icon fas fa-times-circle text-danger"></i></a></td>
                        <td>
                          {{supplier.created_at | timeformat}} 
                          <span class="badge badge-warning text-danger">{{supplier.created_at  | formatDate}}</span>
                        </td>
                        <td>
                          <div class="btn-group">
                            <router-link :to="`/supplier/purchase/${supplier.id}`" class="btn btn-xs btn-outline-info"><i class="fas fa-plus" title="Click to Add Bill ID"></i></router-link>
                            <router-link :to="`/supplier/${supplier.id}/edit`" class="btn btn-xs btn-outline-info"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 

                            <router-link :to="`/supplier/${supplier.id}/view`" class="btn btn-xs btn-outline-info"><i class="fas fa-eye" title="Click to view"></i></router-link>
                            
                            <a href="" @click.prevent="deleteSupplier(supplier.id)" class="btn btn-xs btn-outline-danger"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
                          </div>
                        </td>
                      </tr> -->
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
          search: ''
        }
    },
		mounted(){
      this.$Progress.start()
      this.fetchPosts();
      this.$Progress.finish()
		},
		computed:{
			getAllSupplier(){
				var avar = this.$store.getters.getSupplier;
        if(avar.length==2)
          this.pagination = avar[1];
        return avar[0];
			}
		},
		methods:{
      fetchPosts(){
        this.$store.dispatch("allSupplier", [this.pagination.current_page,this.search]);
      },
      customerStatus(id){
        return {
          'table-danger':!id,
          'table-default': id
        }
      },
      deleteSupplier(id){
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
                axios.delete('/home/supplier/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Supplier Deleted successfully'
                  })
                    that.$store.dispatch("allSupplier", [0,0]);
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
                  title: 'Supplier not Deleted'
              })
            }
        })
      },
      supplierStatus(clkid, show){
          axios.get('/home/supplier/status/'+clkid+'/'+show)
          .then(()=>{
              this.$store.dispatch("allSupplier", [0,0]);
              Toast.fire({
                  icon: 'success',
                  title: 'Status changed successfully'
              })
          })
          .catch(()=>{
        })
      },
      searchSupplier(){
        this.fetchPosts();
      }
		}
	}
</script>

<style scoped>
</style>