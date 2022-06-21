<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Member Payment List</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Payment</li>
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
                  <button class="btn btn-primary btn-block col" @click="savedata">{{"Click to continue"}}
                  </button>
                </div>
              </div><!-- /.card-header -->
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
                    <tbody class="text-center" v-if="click">
                      <tr v-for="(detail,index) in getAllDetail" :key="detail.id">
                        <td>{{index+1}}</td>
                        <td class="text-left">
                          <input type="hidden" class="form-control" name="id" v-model="detail.id">
                          <span class="text-primary">{{detail.name}} ({{detail.serial_no}})</span>
                        </td>
                        <td v-if="detail.is_leave == '1'" class="text-left">
                          <input type="radio" id="unpaid[index]" value="1" v-model="lottery_status[index]" >
                          <label for="unpaid[index]">Unpay</label>

                          <input type="radio" id="already_pay[index]" value="2" v-model="lottery_status[index]">
                          <label for="already_pay[index]">Pay</label>

                          <input type="radio" id="leave[index]" value="3" class="d-none" v-model="lottery_status[index]">
                          <input type="text" name="amount[]" v-model="amount[index]"  :disabled="lottery_status[index] == 1">
                        </td>
                        <td v-if="detail.is_leave == '0'">
                          <input type="radio"  id="leave" value="3" v-model="lottery_status[index]" ><label for="leave">Leave</label>
                        </td>
                        <!-- {{detail}} -->
                        <td class="col-md-1" v-if="detail.get_payment.length == 0 && detail.is_leave != '0' ">
                            <button type="submit" class="btn btn-success btn-block" @click="storeData(detail, amount[index], lottery_status[index])">Save</button>
                        </td>
                      </tr>
                    </tbody>
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
            comparisonvalue : '2',
            state: true,
            count: '',
            kistaid:'',
            kistacount:'',
            click:'',
        }
    },
		mounted(){
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
        this.$Progress.start()
        var data = this.$store.getters.getPayment;
        if(data.length == 0) return [];
        // this.status = data[0].status;
        this.kistaid = data[0].kista_id;
        this.kistacount = data[0].kistacount;
        this.amount = data[0].kistadetails.map(function (kd, i) {
          return data[0].kistaAmount;
        });
        this.lottery_status = data[0].kistadetails.map(function (kd, i) {
          return 2;
        });
        this.$Progress.finish()
        return data[0].kistadetails;
      },
    },
    methods:{
      storeData(detail,amount,status){
        axios.post('/manager/payment',{
              data: detail,
              amount: amount,
              lottery_status: status,
              agent_id: this.agent_id,
              luckydraw_id: this.luckydraw_id,
              kista_id: this.kista_id
          })
        .then((response)=>{
          this.$store.dispatch("allAgentCommision", [0,0]);
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
          // location.reload()
        })
        .catch(()=>{
        })

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
        this.$store.dispatch("allPayment", [this.agent_id,this.kista_id,this.luckydraw_id]);
        this.click = true;
      },
    }
	}
</script>
