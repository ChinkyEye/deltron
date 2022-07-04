<template>
	<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Member Report ({{this.manager_name}})</h5>
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
            <!-- <div class="row"> -->
              <!-- <div> -->
                <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
               <!--  <span v-if="arrors">
                  
                </span> -->
               <!-- <button @click.prevent="memberreportexport()" class="btn btn-success rounded-0" :disabled="click"><i class="fas fa-print" title="Export To Excel"></i>Excel</button> -->
              <!-- </div> -->
            <!-- </div> -->
            <div class="card card-info card-outline">
              <div class="card-header">
                <div class="row">
                  <!-- <div class="col-md">
                    <select class="form-control" id="manager_id" v-model="manager_id" name="manager_id" @change="managerChange"> 
                      <option disabled value="">Select one manager</option>
                      <option :value="manager.id" v-for="manager in getAllSelectManager">
                        {{manager.name}}
                      </option>
                    </select>
                  </div> -->
                  <!-- <div class="col-md">
                    <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" name="luckydraw_id" @change="luckydrawChange"> 
                      <option disabled value="">Select one scheme</option>
                      <option :value="luckydraw.id" v-for="luckydraw in allSelectMLuckyDraws">
                        {{luckydraw.name}}
                      </option>
                    </select>
                  </div> -->
                  <div class="col-md">
                    <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" name="luckydraw_id" @change="luckydrawChange"> 
                      <option disabled value="">Select one scheme</option>
                      <option :value="luckydraw.id" v-for="luckydraw in allSelectLuckyDraws">
                        {{luckydraw.name}}
                      </option>
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
                    <span>Member Payment Report</span><br>
                    <span>{{luckydraw_name}} <span v-if="clicked && luckydraw_id && agent_id">,</span>{{agent_name}}</span>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm m-0">
                      <thead class="table-primary text-center">                  
                        <tr>
                          <th>Serial No</th>
                          <th class="text-left">Member Name</th>
                          <th>Address</th>
                          <th>Phone</th>
                          <th>Through</th>
                          <th>Agent</th>
                          <th>Date</th>
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
                          <td v-if="data.get_refer_person">
                            {{data.get_refer_person.referperson_name}}
                          </td>
                          <td v-else>
                            
                          </td>
                          <td>{{data.get_agent.name}}</td>
                          <td>
                             {{data.get_client_detail[(data.get_client_detail.length - 1)].date_np}}
                          </td>
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
                    <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="savedata"></pagination>
                  </div>

                  <div class="table-responsive mt-4" v-for="(data,index) in getAllDue" :key="data.id">
                    <div>
                      <select class="form-control col-md-1" id="kista_id" name="kista_id" v-model="kista_id"> 
                        <option value="">Kista:</option>
                        <option :value="kista.id" v-for="kista in getAllKista">{{kista.name}}</option>
                      </select>
                    </div>
                    <table class="table table-bordered table-hover table-sm m-0">
                      <tbody class="text-center">
                        <tr>
                          <td class="col-sm-3">Old Dues</td>
                          <td>1000 *</td>
                          <td class="col-sm-1"></td>
                          <td rowspan="4" class="col-sm-6"> <u>Agent Signature</u></td>
                        </tr>
                        <tr>
                          <td class="col-sm-3">Entry Memeber</td>
                          <td>500 * </td>
                          <td></td>
                        </tr>
                        <tr>
                          <td class="col-sm-3">Total</td>
                          <td>50 * </td>
                          <td></td>
                        </tr>
                        <tr>
                          <td class="col-sm-3">Commision</td>
                          <td>100 * </td>
                          <td></td>
                        </tr>
                        <tr>
                          <td class="col-sm-3">New mem</td>
                          <td>20 *</td>
                          <td></td>
                          <td rowspan="4" class="col-sm-6"><u>Client Signature</u></td>
                        </tr>
                        <tr>
                          <td class="col-sm-3">Grant Total</td>
                          <td>10 * </td>
                          <td></td>
                        </tr>
                        <tr>
                          <td class="col-sm-3">Cash Received</td>
                          <td>5 * </td>
                          <td></td>
                        </tr>
                        <tr>
                          <td class="col-sm-3">Dues</td>
                          <td>IC * </td>
                          <td></td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="2" class="text-right">Total:</td>
                          <td></td>
                        </tr>
                      </tfoot>
                    </table>
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
          manager_id:'',
          luckydraw_id:'',
          agent_id: '',
          kista_id:'',
          click: true,
          clicked: '',
          auth_name:'',
          auth_address:'',
          count:'0',
          luckydraw_name:'',
          agent_name:'',
          due_amount:'',
          collected_amount:'',
          amount:'',
          manager_name:'',
        }
    },
    mounted(){
      this.$Progress.start()
      axios.get(`/currentmanager/${this.$route.params.managerid}`)
      .then((response)=>{
        this.manager_name = response.data.currentuser.name;
      })
      this.fetchPosts();
      this.$Progress.finish()
	  },
    computed:{
      // allSelectMLuckyDraws(){
      //   var a = this.$store.getters.getSelectMLuckyDraw[0]
      //   return a;
      // },
      allSelectLuckyDraws(){
        var a = this.$store.getters.getSelectLuckyDraw[0]
        return a;
      },
      getAllKista(){
        var b = this.$store.getters.getSelectKista
        return b[0];
      },
      getAllMember(){
        var d = this.$store.getters.getMemberReport
        this.count = d[4];
        this.luckydraw_name = d[5];
        this.agent_name = d[6];
        if(d.length==5)
          this.pagination = d[1];
        return d[0];
        console.log(d[0]);
      },
      getAllName(){
        var e = this.$store.getters.getMemberReport
        return e[3];
      },
      getAllDue(){
        var a = this.$store.getters.getMemberReport
        if(a.length == 0) return [];
        this.collected_amount = this.$store.getters.getMemberReport[9]
        return a[8];
      },
      getAllAgent(){
        var b = this.$store.getters.getSelectAgent
        return b[0];
      },
      getAllSelectManager(){
        var d = this.$store.getters.getSelectManager[0]
        return d;
      },
    },
	  methods:{
      fetchPosts(){
        this.$Progress.start()
        this.$store.dispatch("allSelectAgent", [this.$route.params.managerid]);
        // this.$store.dispatch("allSelectLuckyDraw")
        this.$store.dispatch("allSelectManager")
        this.$store.dispatch("allSelectLuckyDraw",[this.$route.params.managerid])

        this.$Progress.finish()
      },
      managerChange(){
        this.$store.dispatch("allSelectMLuckyDraw", [this.manager_id]);
        this.luckydrawChange();
      },
      totalSum: function (values) {
         return values.reduce((acc, val) => {
          return acc+=  parseInt(val.amount);
        }, 0);
      },
      totalOrders: function (values,values2,values3) {
        return values + values2;
      },
      agentChange(){
         this.$store.dispatch("allSelectAgent", [this.$route.params.managerid]);
      },
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
      },
      luckydrawChange()
      {
        this.kistaChange();
        this.click = false;
      },
      savedata()
      {
        this.$store.dispatch("allMemberReport", [this.luckydraw_id,this.agent_id,this.pagination.current_page,this.kista_id,this.$route.params.managerid]);
        this.clicked = true;

      },
      memberreportexport(){
        location.href = '/manager/report/member/export?luckydraw_id='+this.luckydraw_id+'&agent_id='+this.agent_id;
      },
      print () {
        this.$htmlToPaper('printMe');
      },

	  }
}
</script>