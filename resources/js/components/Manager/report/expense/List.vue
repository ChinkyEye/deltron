<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Expense Report</h5>
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
            <!-- main page load here-->
            <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
            <!-- <button class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button> -->
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
                  <button class="btn btn-primary btn-block col" @click="searchdata">{{"Click to continue"}}
                  </button>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div id="printMe" class="row">
                  <div class="table-responsive col-sm">
                    <table class="table table-bordered table-hover table-sm m-0">
                      <thead class="table-primary">                  
                        <tr>
                          <th>SN</th>
                          <th>Kista</th>
                          <th>Collected Amount</th>
                          <th>Expenses</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(detail,index) in getAllTpnpReport" :key="detail.id">
                          <td>{{index+1}}</td>
                          <td>{{detail.name}}</td>
                          <td v-if="detail.get_amount">
                            {{detail.get_amount.totals}}
                          </td>
                          <td v-else></td>
                          <td v-if="detail.get_expense">
                            {{detail.get_expense.total}}
                          </td>
                          <td v-else></td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="2">Total:</td>
                          <td>{{gtotal}}</td>
                          <td>{{extotal}}</td>
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
<script>
  import pagination from '../../../../components/PaginationComponent.vue';
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
  export default{
    name: "List",
    components: {
      pagination,
      DatePicker
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          luckydraw_id:'',
          kista_id:'',
          played:'',
          notplayed:'',
          playedamount:'',
          notplayedamount:'',
          leave:'',
          detail:'',
          details:[],
          orders:[],
          gtotal:'',
          extotal:'',
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      allSelectLuckyDraws(){
        var a = this.$store.getters.getSelectLuckyDraw[0]
        return a;
      },
      getAllTpnpReport(){
        var c = this.$store.getters.getExpenseReport;
        this.gtotal = c[2];
        this.extotal = c[3];
        // console.log(c[3]);
        return c[0];
      },
      total: function() {
        return this.details.reduce(function (total, value) {
                return total + Number(value.amount);
            }, 0);
      },

    },
    methods:{
      fetchPosts() {
        this.$store.dispatch("allSelectLuckyDraw")
      },
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
      },
      luckydrawChange(){
        this.kistaChange();
      },
      searchdata()
      {
        this.$store.dispatch("allExpenseReport", [this.luckydraw_id]);
        // this.$store.dispatch("allTpnpReport", [this.kista_id,this.luckydraw_id]);
      },
      print () {
        this.$htmlToPaper('printMe');
      },
    }
  }
</script>

<style scoped>
</style>