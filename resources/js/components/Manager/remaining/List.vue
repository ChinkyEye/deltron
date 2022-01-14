<template>
	<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz"></h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active"></li>
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
              <!-- <div class="card-header">
                <div class="row">
                  <div class="col-md-2">
                    <router-link to="/kista/create" class="btn btn-primary btn-block" style="color:#fff"> Add <i class="fas fa-user-plus fa-fw"></i></router-link>
                  </div>
                  <div class="col-md-10">
                  	
                  </div>
                </div>
              </div> --><!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="table-primary text-center">                  
                      <tr>
                        <th width="10">SN</th>
                        <th>Name</th>
                        <th>Info</th>
                        <!-- <th>Kista</th> -->
                        <th>Agent</th>
                        <th>Remaining Amount</th>
                        <th>Pay Amount</th>
                        <th>Created At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                    	<tr v-for="(data,index) in getAllRemaining" :key="data.id" :class="colorchange(data.is_active)">
                    		<td>{{index+1}}</td>
                    		<td>{{data.get_client_info.name}}</td>
                        <td>{{data.get_luckydraw_info.name}} | {{data.get_kista_info.name}}</td>
                    		<!-- <td>{{data.get_kista_info.name}}</td> -->
                    		<td>{{data.get_agent_info.name}}</td>
                    		<td>{{data.remaining}}</td>
                    		<td class="col-md-1">
                    			<input type="hidden" class="form-control" v-model="data.id">
                    			 <input type="text" class="form-control" v-model="rec_amount[index]" autocomplete="off" @change="isExect($event,data.remaining,index)">
                    			 <!-- <input type="text" class="form-control" v-model="rec_amount[index]" autocomplete="off" @change="isExect($event,data.remaining)"> -->
                    		</td>
                    		<td>
                    			{{data.date_np}} 
                    			<span class="badge badge-warning text-danger">{{data.created_at  | formatDate}}</span>
                    		</td>
                    		<td class="col-md-1">
                    			<!-- <button type="submit" class="btn btn-success btn-block"  @keypress="updateAmount(data.id, rec_amount[index])">Save</button> -->
                          <button type="submit" class="btn btn-success btn-block"  @click="updateAmount(data.id, rec_amount[index])" :disabled="state.isSending">Save</button>
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
          state: {
            isSending: true
          },
          search: '',
          rec_amount:[],
        }
    },
    mounted(){
		this.fetchPosts();
	  },
    computed:{
      getAllRemaining(){
        var d = this.$store.getters.getRemaining
        return d[0];
      }
    },
	  methods:{
      fetchPosts(){
        this.$Progress.start()
        this.$store.dispatch("allRemaining", [this.pagination.current_page,this.search]);
        this.$Progress.finish()
      },
      KistaStatus(clkid, show){
          axios.get('/manager/kista/status/'+clkid+'/'+show)
          .then(()=>{
              this.$store.dispatch("allKista", [0,0]);
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
            axios.delete('/manager/kista/'+id)
            .then((response)=>{
              Toast.fire({
                icon: 'success',
                title: 'Data Deleted successfully'
              })
              that.$store.dispatch("allKista", [0,0]);
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
      },
      updateAmount2(detailId,amount){
        // axios.post('/manager/remaining',{
        //       amount: amount,
        //       detail_id: detailId,
        //       // agent_id: this.$route.params.agentid,
        //   })
        // .then((response)=>{
        //   this.$store.dispatch("allRemaining", [0,0]);
        //   this.rec_amount = [];
        //   if(response.data.message == 'Data Updated'){
        //     Toast.fire({
        //       icon: 'success',
        //       title: 'Detail Updated successfully'
        //     })
        //   }else{
        //     Toast.fire({
        //       icon: 'success',
        //       title: 'Detail Added successfully'
        //     })
        //   }
        // })
        // .catch(()=>{
        // })
      },
      updateAmount(detailId,amount){
        axios.post('/manager/remaining',{
              amount: amount,
              detail_id: detailId,
              // agent_id: this.$route.params.agentid,
          })
        .then((response)=>{
          this.$store.dispatch("allRemaining", [0,0]);
          this.rec_amount = [];
          if(response.data.message == 'Data Updated'){
            Toast.fire({
              icon: 'success',
              title: 'Detail Updated successfully'
            })
          }else{
            Toast.fire({
              icon: 'success',
              title: 'Detail Added successfully'
            })
          }
        })
        .catch(()=>{
        })
      },
      isExect(event,amt,index){
      	let file = event.target.value;
      	let rem_amount = amt;
      	let p_amount = this.rec_amount
        let value = p_amount[index];
        // let value = parseInt(p_amount[index]);
        // console.log(value);
        // console.log(file,rem_amount,p_amount,value);
        // if(value > rem_amount){
        if(value != rem_amount)
        {
          this.state.isSending = true;
          Swal.fire({
           icon: 'error',
           title: 'Please Enter the Exact remaining amount!',
           text: 'ok!',
           footer: '<a href>Why do I have this issue?</a>'
          })
        }
        else{
          this.state.isSending = false;

        }
      }

	  }
}
</script>