<template>
	<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Member Report</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Client List</li>
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
            <div class="row">
              <div>
                <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
               <button @click.prevent="memberreportexport()" class="btn btn-success rounded-0" :disabled="click"><i class="fas fa-print" title="Export To Excel"></i>Excel</button>
              </div>
              <div class="ml-1">
                 <form role="form" enctype="multipart/form-data" @submit.prevent="addSlider()">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary rounded-0" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Import"}}</button>
                    <input type="file" class=""  id="file" name="file" @change="changePhoto($event)" :class="{ 'is-invalid': form.errors.has('file') }">
                    <has-error :form="form" field="file"></has-error>
                  </div>
                </form>
              </div>
            </div>
            <div class="card card-info card-outline">
              <div class="card-header">
                <div class="row">
                  <div class="col-md">
                    <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" @change="LuckyDrawChange"> 
                      <option value="">Select One Scheme</option>
                      <option :value="luckydraw.id" v-for="luckydraw in getAllLuckydraw">{{luckydraw.name}}</option>
                    </select>
                  </div>
                  <div class="col-md">
                    <select class="form-control" id="agent_id" v-model="agent_id" name="agent_id" @change="agentChange"> 
                      <option disabled value="">Select agent</option>
                      <option :value="agent.id" v-for="agent in getAllAgent">
                        {{agent.name}}
                      </option>
                    </select>
                  </div>
                  <button class="btn btn-primary btn-block col" @click="savedata">{{"Click to continue"}}
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="printMe">
                  <div class="col-md-12 text-center mb-2">
                    <span>{{auth_name}},{{auth_address}}</span><br>
                    <span>Member Payment Report</span>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm m-0">
                      <thead class="table-primary text-center">                  
                        <tr>
                          <th>Serial No</th>
                          <th class="text-left">Member Name</th>
                          <th>Address</th>
                          <th>Phone</th>
                          <th>Agent</th>
                          <th>S.N</th>
                          <th v-for="(data,index) in getAllName" :key="data.id">
                            {{data}}
                          </th>
                        </tr>
                      </thead>
                      <tbody class="text-center">
                        <tr v-for="(data,index) in getAllMember" :key="data.id" >
                          <td>{{data.serial_no}}</td>
                          <td class="text-left">{{data.name}}</td>
                          <td>{{data.address}}</td>
                          <td>{{data.phone}}</td>
                          <td>{{data.get_agent.name}}</td>
                          <td v-if="data.get_count">
                            <span v-if="data.get_count.total == null">
                                1
                            </span>
                            <span v-if="data.get_count.total == 1">
                               2
                            </span>
                            <span v-if ="data.get_count.total == 2">
                                3
                            </span>
                            <span v-else>
                              
                            </span>
                          </td>
                          <td v-else>
                            1
                          </td>
                          <td v-for="(detail,index) in data.get_client_detail">
                            {{detail.amount}}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="searchSetting"></pagination>
                  </div>
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
  import pagination from '../../../../components/PaginationComponent.vue';
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
          form: new Form({
            title:'',
            file: null,
          }),
          state: {
            isSending: false
          },
          imagePreview: null,
          showPreview: false,
          luckydraw_id:'',
          agent_id: '',
          click: true,
          auth_name:'',
          auth_address:'',
        }
    },
    mounted(){
      this.$Progress.start()
      this.fetchPosts();
      axios.get(`/currentuser`)
        .then((response)=>{
          this.auth_name = response.data.currentuser.name;
          this.auth_address = response.data.currentuser.address;
      })
      this.$Progress.finish()
	  },
    computed:{
      getAllLuckydraw(){
        return this.$store.getters.getSelectLuckyDraw[0]
      },
      getAllMember(){
        var d = this.$store.getters.getMemberReport
        // console.log(d[1]);
        if(d.length==5)
          this.pagination = d[1];
        return d[0];
      },
      getAllName(){
        var e = this.$store.getters.getMemberReport
        return e[3];
      },
      getAllAgent(){
        var b = this.$store.getters.getSelectAgent
        return b[0];
      },
     
    },
	  methods:{
      fetchPosts(){
        this.$Progress.start()
        this.$store.dispatch("allClientList", [this.agent_id]);
         this.$store.dispatch("allSelectAgent", [this.kista_id]);
        this.$store.dispatch("allSelectLuckyDraw")
        this.$Progress.finish()
      },
      agentChange(){
         this.$store.dispatch("allSelectAgent", [this.kista_id]);
      },
      LuckyDrawChange()
      {
        this.click = false;
      },
      savedata()
      {
        this.$store.dispatch("allMemberReport", [this.luckydraw_id,this.agent_id,this.pagination.current_page]);
      },
      searchSetting(){
        this.fetchPosts();
      },
      memberreportexport(){
        location.href = '/manager/report/member/export?luckydraw_id='+this.luckydraw_id+'&agent_id='+this.agent_id;
      },
      changePhoto(event){
      let file = event.target.files[0];
        this.form.file = file;

     //  if((file.size>5242880) || ((file.type != 'image/jpeg') && (file.type != 'image/jpg'))){
     //    this.state.isSending = true;
     //    Swal.fire({
     //     icon: 'error',
     //     title: 'Oops...',
     //     text: 'Something went wrong!',
     //     footer: '<a href>Why do I have this issue?</a>'
     //   })
     // }else{
     //  let reader  = new FileReader();
     //  reader.addEventListener("load", function () {
     //      this.showPreview = true;
     //      this.imagePreview = reader.result;
     //      this.state.isSending = false;
     //  }.bind(this), false);
     //  if( file ){
     //    this.form.photo = file;
     //      if ( /\.(jpe?g|jpg)$/i.test( file.name ) ) {
     //          reader.readAsDataURL( file );
     //      }
     //    }
     //  }
    },
    addSlider(){
      this.state.isSending = true;
      this.form.post('/manager/report/member/import',{
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        transformRequest: [function (data,headers){
          return objectToFormData(data)
        }]
      })
      .then((response)=>{
        this.state.isSending = false;
        // this.$router.push('/report/member')
        Toast.fire({
          icon: 'success',
          title: 'Detail Added successfully'
        })
      })
      .catch(()=>{
        this.state.isSending = false;
      })
      // this.resetForm();
    },
    print () {
      this.$htmlToPaper('printMe');
    },

	  }
}
</script>