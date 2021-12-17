<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Booking List</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <!-- <li class="breadcrumb-item active">Booking</li> -->
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
                    <router-link :to="'/booking/create'" class="btn btn-primary btn-block" style="color:#fff"> Add <i class="fas fa-user-plus fa-fw"></i></router-link>
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
                        <th>Agent</th>
                        <th>Booked Serial No</th>
                        <th>Booked At</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(data,index) in getAllBooking" :key="data.id">
                         <td>{{index+1}}</td>
                         <td>{{data.name}}</td>
                           <td>
                         <span v-for="(detail,index) in data.get_booking">
                             <strong>{{detail.booked_serialno}}</strong><a href="javascript:void(0)" title="Click to Cancel Booking" @click.prevent="deleteBooking(detail.id)"><i class="fas fa-times text-danger"></i></a>,
                         </span>
                           </td>
                         <td>
                          <!-- {{data.date_np}} 
                          <span class="badge badge-warning text-danger">{{data.created_at  | formatDate}}</span> -->
                          <span v-if="data.get_booking_latest" class="badge badge-warning">
                             <strong>{{data.get_booking_latest.date_np}}</strong>
                         </span>
                        </td>
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
      getAllBooking(){
        var avar = this.$store.getters.getBooking;
        if(avar.length==2)
          this.pagination = avar[1];
        return avar[0];
      },
     
    },
    methods:{
      fetchPosts(){
        this.$Progress.start()
        this.$store.dispatch("allBooking", [this.pagination.current_page]);
        this.$Progress.finish()
      },
      deleteBooking(id){
        var that = this;
        Swal.fire({
          title: 'Are you sure?',
          text: 'Do you want to cancel your Booking?',
          // text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes!',
          cancelButtonText: 'No!',
          // confirmButtonText: 'Yes, delete it!',
          // cancelButtonText: 'No, cancel!',
          buttonsStyling: true
        }).then(function (isConfirm) {
          if(isConfirm.value === true) {
            axios.delete('/manager/booking/'+id)
            .then((response)=>{
              Toast.fire({
                icon: 'success',
                title: 'Booking is cancel successfully'
              })
              that.$store.dispatch("allBooking", [0,0]);
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
              title: 'Booking not Cancelled'
            })
          }
        })
      },
      cancelBooking(clkid, sts){
        // console.log(sts);
        var that = this;
        Swal.fire({
          title: 'Do you want to cancel your Booking?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes!',
          cancelButtonText: 'No!',
          buttonsStyling: true
        }).then(function (isConfirm) {
          if(isConfirm.value === true) {
            // axios.delete('/manager/client/'+id)
            axios.get('/manager/booking/cancel/'+clkid+'/'+sts)
            .then((response)=>{
              Toast.fire({
                icon: 'success',
                title: 'Booking Cancelled successfully'
              })
               this.$store.dispatch("allBooking",[0,0]);
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
              title: 'Booking not Cancelled'
            })
          }
        })
      },

    }
}
</script>