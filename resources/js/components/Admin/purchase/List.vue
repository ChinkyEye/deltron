<template>
	<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Purchase List ({{this.manager_name}})</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Purchase</li>
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
                        <th class="text-left">Supplier Name</th>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(data,index) in getAllPurchase" :key="data.id" :class="colorchange(data.is_active)">
                        <td>{{index+1}}</td>
                        <td class="text-left">{{data.supplier_name}}</td>
                        <td>{{data.item_name}}</td>
                        <td>{{data.description}}</td>
                        <td>{{data.quantity}}</td>
                        <td>{{data.amount}}</td>
                        <td v-if="data.is_active == '0'">Inactive <a href="javascript:void(0)" @click.prevent="PurchaseStatus(data.id, data.is_active)" title="Click to Publish"><i class="nav-icon fas fa-times-circle text-danger"></i></a></td>
                        <td v-else>Active <a href="javascript:void(0)" @click.prevent="PurchaseStatus(data.id, data.is_active)" title="Click to Unpublish"><i class="nav-icon fas fa-check-circle text-success"></i></a></td>
                        <td>
                          {{data.date_np}} 
                          <span class="badge badge-warning text-danger">{{data.created_at  | formatDate}}</span>
                        </td>                        
                        <td>
                          <router-link :to="`/purchase/${data.id}/edit`" class="btn btn-xs btn-outline-info"><i class="fas fa-pencil-alt" title="Click to edit"></i>
                          </router-link>
                          <a href="" @click.prevent="deletePurchase(data.id)" class="btn btn-xs btn-outline-danger"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
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
      getAllPurchase(){
        var avar = this.$store.getters.getPurchase;
        if(avar.length==2)
          this.pagination = avar[1];
        return avar[0];
      }
    },
	  methods:{
      fetchPosts(){
        this.$Progress.start()
        this.$store.dispatch("allPurchase", [this.pagination.current_page,this.$route.params.managerid]);
        this.$Progress.finish()
      },
      PurchaseStatus(clkid, show){
          axios.get('/home/purchase/status/'+clkid+'/'+show)
          .then(()=>{
              this.$store.dispatch("allPurchase", [0,this.$route.params.managerid]);
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
      deletePurchase(id){
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
            axios.delete('/home/purchase/'+id)
            .then((response)=>{
              Toast.fire({
                icon: 'success',
                title: 'Data Deleted successfully'
              })
              that.$store.dispatch("allPurchase", [0,0]);
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