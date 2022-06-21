<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Agent Commision</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Commision</li>
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
                </div>
              </div><!-- /.card-header -->
              <!-- <form role="form"> -->
              <!-- <form role="form" @submit.prevent="addDetail()"> -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="thead-light">                  
                      <tr>
                        <th>SN</th>
                        <th>Kista Name</th>
                        <th>Status</th>
                        <th>Commsion(% or Rs)</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(detail,index) in getAllDetail" :key="detail.id" v-if="luckydraw_id">
                        <td class="pt-3 col-md-1">{{index+1}}</td>
                        <td class="col-md-6">
                          <input type="hidden" class="form-control" v-model="detail.id">
                          {{detail.name}}
                          
                        </td>
                        <td class="col-md-1" v-if="detail.get_commision != null ">
                          <span v-for="(data,index) in detail.get_commision ">
                            <span v-if="data.agent_id == agentid">
                              {{data.commission}}
                              <span v-if="data.commission_type == '1'"> %</span><span v-else> Rs</span>
                            </span>
                          </span>
                        </td>
                        <td v-else>
                          <span class="text-center"><i class="nav-icon fas fa-times-circle text-danger"></i></span>
                        </td>
                        <td class="col-md-3">
                          <input type="text" class="form-control" v-model="amount[index]" autocomplete="off">

                            <input type="radio" id="commissionpercent[index]" value="1" v-model="status[index]" >
                            <label for="commissionpercent[index]">%</label>

                            <input type="radio" id="commissionrs[index]" value="2" v-model="status[index]">
                            <label for="commissionrs[index]">Rs</label>

                        </td>
                        <td class="col-md-1">
                          <button type="submit" class="btn btn-success btn-block" @click="storeData(detail.id, amount[index], status[index])">Save</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- </form> -->
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
            luckydraw_id: '',
            amount:[],
            agentid:'',
            status:[],
        }
    },
    mounted(){
      this.$store.dispatch("allSelectLuckyDraw");
      this.$store.dispatch("allAgentCommision");
    },
    computed:{
      allSelectLuckyDraws(){
        var a = this.$store.getters.getSelectLuckyDraw[0]
        return a;
      },
      getAllDetail(){
        var b = this.$store.getters.getSelectKistaCommision
        if(b.length == 0) return [];
        this.agentid = b[1];
        this.status = b[0].map(function (kd, i) {
          return 1;
        });
        return b[0];
      },
      getAllAgentCommision(){
        var c = this.$store.getters.getAgentCommision
        return c[0];
      }
    },
    methods:{
      pagechange(){
        this.$Progress.start()
        this.$store.dispatch("allSelectKistaCommision", [this.luckydraw_id,this.$route.params.agentid]);
        this.$Progress.finish()
      },
      luckydrawChange(){
        this.pagechange();
      },
      addDetail(){
        axios.post('/manager/commision',{
              amount: this.amount,
              data: this.getAllDetail,
          })
        .then((response)=>{
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
      storeData(kistId,amount,status){
        axios.post('/manager/agent/commision',{
              amount: amount,
              commission_type: status,
              kista_id: kistId,
              agent_id: this.$route.params.agentid,
          })
        .then((response)=>{
          this.$store.dispatch("allAgentCommision", [0,0]);
          if(response.data.message == 'Data Updated'){
           this.pagechange();
            Toast.fire({
              icon: 'success',
              title: 'Detail Updated successfully'
            })
          }else{
            this.pagechange();
            Toast.fire({
              icon: 'success',
              title: 'Detail Added successfully'
            })
          }
            // this.$router.push(`/agent/commision/${this.$route.params.agentid}`)
          // location.reload()
        })
        .catch(()=>{
        })

      }

    }
  }
</script>
