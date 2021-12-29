<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Kista Closing List</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
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
            <div class="card card-info card-outline">
              <div class="card-header">
                <div class="row">
                  <div class="col-md">
                    <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" @change="luckydraw_change"> 
                      <option value="">Select one Scheme</option>
                      <option :value="luckydraw.id" v-for="luckydraw in getAllLuckydraw">{{luckydraw.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-md">
                    <select class="form-control" id="kista_id" name="kista_id" v-model="kista_id"  @change="kistaChange"> 
                      <option value="">Select one kista</option>
                      <option :value="kista.id" v-for="kista in getAllKista">{{kista.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-md">
                    <button class="btn btn-primary btn-block col" @click="searchdata">{{"Click to continue"}}
                    </button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div id="printMe" class="row">
                  <div class="table-responsive col-sm">
                    <table class="table table-bordered table-hover table-sm m-0">
                      <thead class="table-primary">                  
                        <tr>
                          <th>SN</th>
                          <th>Kista</th>
                          <th>Income</th>
                          <th>Expenditure</th>
                          <th>Closing Balance</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody v-if="click">
                        <tr v-for="(detail,index) in getAllKistaHasOpening" :key="detail.id">
                          <td>{{index+1}}</td>
                          <td>{{detail.name}}</td>
                          <td>{{totalIncome}}</td>
                          <td>{{totalExpenditure}}</td>
                          <td>
                            <div class="row">
                              <div class="col">
                               <input type="text" class="form-control" v-model="closing_amount" autocomplete="off" readonly>
                             </div>
                             <div class="col-md-2">
                               {{check_amount}} <span class="text-danger">(pre)</span>
                             </div>
                            </div>
                          </td>
                          <td v-if="status == true">
                            <button type="submit" class="btn btn-success btn-block"  @click="updateAmount(detail.id, closing_amount)">Save</button>
                          </td>
                          <td v-if="status == false">
                              <button type="submit" class="btn btn-success btn-block"  @click="updateAmount(detail.id, closing_amount)">Update</button>
                          </td>
                        </tr>
                      </tbody>
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
<script>
  // import pagination from '../../../../components/PaginationComponent.vue';
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
  export default{
    name: "List",
    components: {
      // pagination,
      DatePicker
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          luckydraw_id:'',
          cost_price:'',
          total:'',
          kista_id:'',
          lottery_status:'',
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          lotteryId:'',
          search:'',
          latest_income:'',
          latest_opening:'0',
          income_total:'',
          expenditure_total:'',
          bank_balance:'',
          totalIncome:'',
          totalExpenditure:'',
          closing_amount:'',
          status:'',
          click:'',
          check_amount:'',
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllLuckydraw(){
          return this.$store.getters.getSelectLuckyDraw[0]
      },
      getAllKista(){
        var b = this.$store.getters.getSelectKista
        return b[0];
      },
      getAllKistaHasOpening(){
        var avar = this.$store.getters.getKistaHasOpening;
        if(avar.length == 0) return [];
        this.latest_income = avar[0].latest_income;
        this.latest_opening = avar[0].latest_opening;
        this.income_total = avar[0].income_total;
        this.expenditure_total = avar[0].expenditure_total;
        this.income_total = avar[0].income_total;
        this.bank_balance = avar[0].bank_balance;
        this.totalIncome = this.latest_income + this.income_total + parseInt(this.latest_opening);
        // console.log(this.latest_income,this.income_total,parseInt(this.latest_opening));
        this.totalExpenditure =  this.expenditure_total + this.bank_balance;
        this.closing_amount =  this.totalIncome - this.totalExpenditure;
        this.status = avar[0].status;
        this.check_amount = avar[0].check_amount;
        return avar[0].kistas;
      },
    },
    methods:{
      fetchPosts() {
        this.pagechange();
        this.$store.dispatch("allSelectLuckyDraw")
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);

      },
      pagechange(){
        this.$Progress.start()
        this.$Progress.finish()
      },
   
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
         this.pagechange();
      },
      luckydraw_change(){
        this.kistaChange();
        this.pagechange();
      },
      print () {
        this.$htmlToPaper('printMe');
      },
      salesReportExport(){
        location.href = '/home/report/purchase/export?name='+this.name+'&supplier_id='+this.supplier_id+'&category_id='+this.category_id+'&subcategory_id='+this.sub_category_id+'&start_date='+moment(this.date.start).format('YYYY-MM-DD')+'&end_date='+moment(this.date.end).format('YYYY-MM-DD');
      },
      searchdata()
      {
        this.$store.dispatch("allKistaHasOpening", [this.luckydraw_id,this.kista_id]);
        this.lotteryId = this.luckydraw_id;
        this.click = true;
      },
      updateAmount(kistaId,amount){
        axios.post('/manager/kistahasopening',{
              amount: amount,
              kista_id: kistaId,
              luckydraw_id: this.lotteryId,
          })
        .then((response)=>{
          this.$store.dispatch("allKistaHasOpening", [0,0]);
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
    }
  }
</script>

<style scoped>
</style>