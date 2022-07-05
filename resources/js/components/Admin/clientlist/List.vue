<template>
	<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Member List ({{this.manager_name}})</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Member List</li>
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
                    <span>Member List</span>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm m-0">
                      <thead class="table-primary text-center">                  
                        <tr>
                          <th width="10">SN</th>
                          <th class="text-left">Member Name</th>
                          <th>Serial No</th>
                          <th>Address</th>
                          <th>Phone</th>
                          <th>Agent</th>
                        </tr>
                      </thead>
                      <tbody class="text-center" v-if="click">
                        <tr v-for="(data,index) in getALLClientList" :key="data.id" >
                          <td>{{index+1}}</td>
                          <td class="text-left">{{data.name}}</td>
                          <td>{{data.serial_no}}</td>
                          <td>{{data.address}}</td>
                          <td>{{data.phone}}</td>
                          <td>{{data.get_agent.name}}</td>
                        </tr>
                      </tbody>
                    </table>
                    <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="savedata"></pagination>

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
          agent_id: '',
          click: '',
          manager_name:'',
        }
    },
    mounted(){
      this.$Progress.start()
      this.fetchPosts();
      axios.get(`/currentmanager/${this.$route.params.managerid}`)
      .then((response)=>{
        this.manager_name = response.data.currentuser.name;
      })
      this.$Progress.finish()
	  },
    computed:{
      getALLClientList(){
        var d = this.$store.getters.getClientList
        if(d.length==2)
          this.pagination = d[1];
        return d[0];
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
        this.$store.dispatch("allSelectAgent", [this.$route.params.managerid]);
        this.$Progress.finish()
      },
      agentChange(){
         this.$store.dispatch("allSelectAgent", [this.$route.params.managerid]);
      },
      savedata()
      {
        this.$store.dispatch("allClientList", [this.agent_id,this.pagination.current_page,this.$route.params.managerid]);
        this.click = true; 
      },
      searchSetting(){
        this.fetchPosts();
      },
      print () {
        this.$htmlToPaper('printMe');
      },

	  }
}
</script>