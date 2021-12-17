<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0 text-dark">Purchase Report</h5>
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
         <!-- main page load here -->
        <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
        <button @click.prevent="purchaseReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button>
        <div class="card card-info card-outline">

          <div class="card-header">
            <div class="row">
              <div class="form-group col-md-5">
                <date-picker mode='range' v-model="date" lang="en" type="date" format="YYYY-MM-dd" v-on:input="dateChange" is-range>
                  <template v-slot="{ inputValue, inputEvents }">
                    <div class="flex justify-center items-center">
                      <input
                      :value="inputValue.start"
                      v-on="inputEvents.start"
                      class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                      /><i class="fas fa-arrow-right fa-fw"></i>
                      <input
                      :value="inputValue.end"
                      v-on="inputEvents.end"
                      class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                      />
                    </div>
                  </template>
                </date-picker>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div id="printMe" class="row">
              <div class="table-responsive col-sm">
                <table class="table table-bordered table-hover table-sm m-0">
                  <thead class="table-primary">                  
                    <tr>
                      <th width="10">SN</th>
                      <th class="text-left">Supplier Name</th>
                      <th>Item Name</th>
                      <th>Purchase Date</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(data,index) in getAllPurchase" :key="data.id">
                      <td>{{index+1}}</td>
                      <td class="text-left">{{data.supplier_name}}</td>
                      <td>{{data.item_name}}</td>
                      <td>
                        <span class="badge badge-warning">{{data.date_np}}</span>
                      </td>
                      <td>{{data.amount}}</td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4">Total:</td>
                      <td>{{total}}</td>
                    </tr>
                  </tfoot>
                </table>
                <!-- <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination> -->
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
          luckydraw_id:'',
          cost_price:'',
          total:'',
          kista_id:'',
          lottery_status:'',
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          search:'',
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllPurchase(){
        var b = this.$store.getters.getPurchaseReport;
        this.total = b[2];
        return b[0];
      },

    },
    methods:{
      fetchPosts() {
        this.pagechange();
        // this.$store.dispatch("allPurchaseReport")

      },
      pagechange(){
        this.$Progress.start()
        this.$store.dispatch("allPurchaseReport", [this.pagination.current_page,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
        this.$Progress.finish()
      },
      dateChange(){
        this.pagechange();
      },
      print () {
        this.$htmlToPaper('printMe');
      },
      purchaseReportExport(){
        location.href = '/manager/report/purchase/export?start_date='+moment(this.date.start).format('YYYY-MM-DD')+'&end_date='+moment(this.date.end).format('YYYY-MM-DD');
      }
   
    }
  }
</script>

<style scoped>
</style>