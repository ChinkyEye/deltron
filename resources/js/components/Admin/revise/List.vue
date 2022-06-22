<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Revise Activities</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Detail</li>
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
                    <select class="form-control" id="manager_id" v-model="manager_id" name="manager_id" @change="managerChange"> 
                      <option disabled value="">Select one manager</option>
                      <option :value="manager.id" v-for="manager in getAllSelectManager">
                        {{manager.name}}
                      </option>
                    </select>
                  </div>
                  <div class="col-md">
                    <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" name="luckydraw_id" @change="luckydrawChange"> 
                      <option disabled value="">Select one scheme</option>
                      <!-- <option :value="luckydraw.id" v-for="luckydraw in allSelectLuckyDraws"> -->
                      <option :value="luckydraw.id" v-for="luckydraw in allSelectMLuckyDraws">
                        {{luckydraw.name}}
                      </option>
                    </select>
                  </div>
                  <div class="col-md">
                    <select class="form-control" id="kista_id" name="kista_id" v-model="kista_id"  @change="kistaChange"> 
                      <option value="">Select Kista</option>
                      <option :value="kista.id" v-for="kista in getAllKista">{{kista.name}}</option>
                    </select>
                  </div>
                  <div class="col-md">
                    <select class="form-control" id="agent_id" name="agent_id"  v-model="agent_id" @change="agentChange"> 
                      <option value="">Select Agent</option>
                      <option :value="agent.id" v-for="agent in getAllAgent">{{agent.name}}</option>
                    </select>
                  </div>
                  <button class="btn btn-primary btn-block col" @click="savedata">{{"Click to continue"}}
                  </button>
                </div>
              </div><!-- /.card-header -->
              <!-- <form role="form" @submit.prevent="addDetail()"> -->
              <form role="form">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="thead-light">                  
                      <tr>
                        <th width="10">SN</th>
                        <th class="text-left">Name</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(play,ind) in getAllDetail" :key="play.id">
                        <td>{{ind+1}}</td>
                        <td class="text-left">
                          <span class="text-primary">{{play.get_client_info.name}}</span>
                        </td>
                        <td>
                          <span class="text-danger" v-if="play.lottery_status == '1'">UnPaid {{play.amount}}</span>
                          <span class="text-primary" v-if="play.lottery_status == '2'">Paid {{play.amount}}
                          </span>
                          <span class="text-warning" v-if="play.lottery_status == '3'">Leave</span>
                        </td>
                        <td>
                          <a href="" @click.prevent="editClientDetail(play.id, play.lottery_status)" class="btn btn-xs btn-outline-success" title="Click to Revise"><i class="fas fa-undo"></i></a>
                        </td>
                      </tr>
                    </tbody>
                    <!-- <tfoot  v-if="this.status == false">
                      <tr>
                        <td colspan="2"></td>
                        <td>
                            <button type="submit" class="btn btn-success">Save</button>{{count}}
                        </td>
                      </tr>
                    </tfoot> -->
                  </table>
                </div>
              </div>
              </form>
            </div>
          </section>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>
</template>
<script>
	export default{
		name: "List",
    components: {
    },
    data(){
      return{
            manager_id:'',
            luckydraw_id: '',
            kista_id: '',
            agent_id: '',
            lottery_status: [],
            status: '',
            amount: [],
            state: {
                isSending: true,
                isOrdering: true
            },
            gender: "female",
            isOnline: "2",
            items :
            [
            {txt: 'pay', val: 1},
            {txt: 'unpay', val: 2}
            ],
            comparisonvalue : '2',
            state: true,
            count: '',
        }
    },
		mounted(){
      this.$store.dispatch("allSelectManager")
      this.$store.dispatch("allSelectLuckyDraw")

		},
    computed:{
      allSelectLuckyDraws(){
        var a = this.$store.getters.getSelectLuckyDraw[0]
        return a;
      },
      getAllKista(){
        var b = this.$store.getters.getSelectKista
        return b[0];
      },
      getAllAgent(){
        var b = this.$store.getters.getSelectAgent
        return b[0];
      },
      getAllDetail(){
        var data = this.$store.getters.getDetail;
        if(data.length == 0) return [];
        console.log(data[0].kistadetails);
        return data[0].kistadetails;
      },
      getAllSelectManager(){
        var d = this.$store.getters.getSelectManager[0]
        return d;
      },
      allSelectMLuckyDraws(){
        var a = this.$store.getters.getSelectMLuckyDraw[0]
        return a;
      },
    },
    methods:{
      addDetail: function addDetail() {
        var that = this;
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Save it!',
          cancelButtonText: 'No, cancel!',
          buttonsStyling: true
        }).then(function (isConfirm) {
          if (isConfirm.value === true) {
            axios.post('/manager/detail', {
              data: that.getAllDetail,
              lottery_status: that.lottery_status,
              amount: that.amount,
              agent_id: that.agent_id,
              luckydraw_id: that.luckydraw_id,
              kista_id: that.kista_id
            }).then(function (response) {
              if (response) {
                that.state.isSending = true;
                Toast.fire({
                  icon: 'success',
                  title: 'Detail Updated successfully'
                });
              }
            })["catch"](function () {});
          } else {
            Toast.fire({
              icon: 'error',
              title: 'Data couldnot save'
            });
          }
        });
      },
       editClientDetail(id,lotteryStatus){
        var that = this;
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, change it!',
          cancelButtonText: 'No, cancel!',
          buttonsStyling: true
        }).then(function (isConfirm) {
          if(isConfirm.value === true) {
            axios.get('/home/detail/revise/'+id+'/'+lotteryStatus)
            .then((response)=>
              {
              that.savedata();
              Toast.fire({
                icon: 'success',
                title: 'Data Changed successfully'
              })
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
              title: ' not Changed'
            })
          }
        })
      },
      managerChange(){
        this.$store.dispatch("allSelectMLuckyDraw", [this.manager_id]);
        this.luckydrawChange();
      },
      agentChange(){
        this.$store.dispatch("allSelectAgent", [this.kista_id]);
      },
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
        this.agentChange();
      },
      luckydrawChange(){
        this.kistaChange();
      },
      savedata()
      {
        this.$store.dispatch("allDetail", [this.luckydraw_id,this.kista_id,this.agent_id,this.manager_id]);
      },

    }
	}
</script>
