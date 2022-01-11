<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Allocate Scheme Prize</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Prize</li>
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
                    <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" name="luckydraw_id" @change="luckydrawChange"> 
                      <option disabled value="">Select one scheme</option>
                      <option :value="luckydraw.id" v-for="luckydraw in allSelectLuckyDraws">
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
                  <div class="form-group col-md m-md-0">
                    <input type="text" id="search" class="form-control" v-model="search" placeholder="Search by serial no">
                  </div>
                  <button class="btn btn-primary btn-block col" @click="savedata">{{"Click to continue"}}
                  </button>
                </div>
              </div><!-- /.card-header -->
              <form role="form" @submit.prevent="addDetail()">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="thead-light">                  
                      <tr>
                        <th width="10">SN</th>
                        <th class="text-left">Name</th>
                        <th>Agent</th>
                        <th>Allocate Prize</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(play,ind) in getAllDetail" :key="play.id">
                        <td>{{ind+1}}</td>
                        <td class="text-left">
                          <span class="text-primary">{{play.get_client_info.name}}({{play.get_client_info.serial_no}})</span>
                        </td>
                        <td class="text-left">{{play.get_agent_info.name}}</td>
                        <td>
                          <span class="text-danger" v-if="play.lottery_status == '1'">UnPaid {{play.amount}}</span>
                          <span class="text-primary" v-if="play.lottery_status == '2'">Paid {{play.amount}}
                          <router-link :to="`/client/prize/${play.id}`" class="btn btn-xs btn-outline-info" title="Add Prize"><i class="fas fa-plus fa-sm"></i>
                          </router-link>
                          <span class="badge badge-warning text-info float-sm-right" v-if="play.lottery_prize != null ">{{play.lottery_prize}} is allocated</span> 
                          </span>
                          <span class="text-warning" v-if="play.lottery_status == '3'">Leave</span>
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
            search:'',
        }
    },
		mounted(){
      this.$Progress.start()
      this.$store.dispatch("allSelectLuckyDraw")
      this.$Progress.finish()

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
        var data = this.$store.getters.getKistaDetail;
        return data[0];
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
              location.reload();
            })["catch"](function () {});
          } else {
            Toast.fire({
              icon: 'error',
              title: 'Data couldnot save'
            });
          }
        });
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
        this.$store.dispatch("allKistaDetail", [this.agent_id,this.kista_id,this.search]);
      },

    }
	}
</script>
