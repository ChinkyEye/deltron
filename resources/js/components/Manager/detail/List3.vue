<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Client Detail List</h5>
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
                    <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" name="luckydraw_id" @select="luckydrawChange"> 
                      <option disabled value="">Select one lucky draw</option>
                      <option :value="luckydraw.id" v-for="luckydraw in allSelectLuckyDraws">
                        {{luckydraw.name}}
                      </option>
                    </select>
                  </div>
                  <div class="col-md">
                    <select class="form-control" id="kista_id" name="kista_id" v-model="kista_id"  @change="kistaChange"> 
                      <option value="">Select one</option>
                      <option :value="kista.id" v-for="kista in getAllKista">{{kista.name}}</option>
                    </select>
                  </div>
                  <div class="col-md">
                    <select class="form-control" id="agent_id" name="agent_id"  v-model="agent_id"> 
                      <option value="">Select one</option>
                      <option :value="agent.id" v-for="agent in getAllAgent">{{agent.name}}</option>
                    </select>
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
                        <!-- <th>Amount</th> -->
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(detail,index) in getAllDetail" :key="detail.id">
                        <td>{{index+1}}</td>
                        <td class="text-left">
                          <input type="hidden" class="form-control" name="id" v-model="detail.id">
                          {{detail.name}}
                        </td>
                        <!-- <td>
                          {{index}}
                          <input type="radio" value="1" id="pay.id" name="" v-model="lottery_status[index]"> Choose as profile image {{index}} {{detail.id}}
                          <input type="radio" value="2" id="unpay.id" name="" v-model="lottery_status[index]"> Dont {{index}} {{detail.id}}
                        </td> -->
                        <td v-if="detail.is_leave == '1' && detail.get_detail == null">

                          <input type="radio" id="unpaid[index]" value="1" v-model="lottery_status[index]" checked>Unpay
                          <input type="radio" id="already_pay[index]" value="2" v-model="lottery_status[index]">Pay
                          <input type="radio" id="leave[index]" class="d-none" value="3" v-model="lottery_status[index]">
                          <input type="text"  name="amount[]" v-model="amount[index]" :disabled="lottery_status[index] == 1">

                        </td>
                        <td v-else-if="detail.is_leave == '0' && detail.get_detail == null">
                          <input type="radio"  id="unpaid" value="1" class="d-none" v-model="lottery_status[index]" checked>
                          <input type="radio" id="already_pay" value="2" class="d-none" v-model="lottery_status[index]">
                          <input type="radio"  id="leave" value="3" v-model="lottery_status[index]" >Leave
                            <input type="text"  class ="d-none" name="amount[]" v-model="amount[index]" :disabled="lottery_status[index] == 1">
                        </td>
                        <td v-else-if="detail.get_detail.lottery_status == '1'">
                          Unpaid
                        </td>
                        <td v-else-if="detail.get_detail.lottery_status == '2'">
                          Paid
                        </td>
                        <td v-else-if="detail.get_detail.lottery_status == '3'">
                          Leave
                        </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                       <td colspan="2"></td>
                        <td>
                          <button type="submit" class="btn btn-success btn-block">Save</button>
                        </td>
                      </tr>
                    </tfoot>
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
  import pagination from '../../../components/PaginationComponent.vue';
	export default{
		name: "List",
    components: {
      pagination,
    },
    data(){
      return{
            luckydraw_id: this.$route.params.luckydrawid,
            kista_id: '',
            agent_id: '',
            lottery_status: [],
            lottery_status: ['2','3'],
            amount: [],
            pay: '',
            already_pay: '',
            state: {
                isSending: true,
                isOrdering: true
            },
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
        var c = this.$store.getters.getDetail
        return c[0];
      },
    },
    methods:{
      addDetail(){
        axios.post('/manager/detail',{
              data: this.getAllDetail,
              lottery_status: this.lottery_status,
              amount: this.amount,
          })
        .then((response)=>{
          // console.log(response.data.message);
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
      agentChange(){
        this.$store.dispatch("allSelectAgent", [this.kista_id]);
      },
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
        this.agentChange();
      },
      luckydrawChange(){
        console.log("bitch");
        this.kistaChange();
      },
      savedata()
      {
        this.$store.dispatch("allDetail", [this.agent_id]);
      },
      addAmount(id) {
        // console.log(id);
        // this.items.push({
        //   value: '',
        // });
      },

    }
	}
</script>
