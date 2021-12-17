<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0 text-dark">Serail No: List</h5>
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
        <button @click.prevent="previewreportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button>
        <div class="card card-info card-outline">

          <div class="card-header">
            <div class="row">
              <div class="form-group col-md">
                <select class="form-control" id="agent_id" name="agent_id" v-model="agent_id"  @change="agentChange"> 
                  <option value="">Select one agent</option>
                  <option :value="agent.id" v-for="agent in getAllAgent">{{agent.name}}</option>
                </select>
              </div>
              <div class="form-group col-md m-md-0">
                <input type="text" id="search" class="form-control" v-model="search" placeholder="Search by serail no" @keyup="searchByno">
              </div>
            </div>
          </div>
          <div class="card-body">
            <div id="printMe">
              <div class="row">
                <div class="table-responsive col-md">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="table-primary">                  
                      <tr>
                        <th>Member Name</th>
                        <th>Used serial no</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(data,index) in getAllPreviewReport" :key="data.id">
                        <td><span class="text-danger">{{data.name}}</span></td>                       
                        <td class="text-center bg-success">{{data.serial_no}}</td> 

                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td><strong>Total count:</strong></td>
                        <td class="text-center text-info">count({{total}})</td>
                      </tr>
                    </tfoot>
                  </table>
                  <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
                </div>
                <div class="table-responsive col-sm">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="table-primary">                  
                      <tr>
                        <th>Available Serial no</th>
                      </tr>
                    </thead>
                    <tbody class="bg-primary">
                      <span v-for="(detail,index) in getAllPreviewReport2" :key="detail.id">
                        <!-- <td class="text-center">{{detail}}</td>  -->
                        {{detail}},
                      </span>
                    </tbody>
                  </table>
                </div>
                <div class="table-responsive col-sm-2">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="table-primary">                  
                      <tr>
                        <th>Booked Serial no</th>
                      </tr>
                    </thead>
                    <tbody class="bg-warning">
                      <span v-for="(data,index) in getAllPreviewReport3" :key="data.id">
                        {{data}},
                      </span>
                    </tbody>
                  </table>
                </div>
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
  // const exampleItems = [1,2];
  // const exampleItems = [...Array(150).keys()].map(i => ({ id: (i+1), name: 'Item ' + (i+1) }));
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
          agent_id:'',
          total:'',
          data:[],
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          search:'',
          // exampleItems,
          // pageOfItems: []

        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllPreviewReport(){
        var avar = this.$store.getters.getPreviewReport;
        this.total = avar[2];
        // if(avar.length==4)
        //   this.pagination = avar[1];
        return avar[0];
      },
      getAllPreviewReport2(){
        var avar = this.$store.getters.getPreviewReport;
        // console.log(avar[3])
        return avar[3];

      }, 
      getAllPreviewReport3(){
        var avar = this.$store.getters.getPreviewReport;
        return avar[4];

      },
      getAllAgent(){
        var b = this.$store.getters.getSelectAgent
        return b[0];
      },
    },
    methods:{
      fetchPosts() {
        this.pagechange();
        // this.$store.dispatch("allSelectLuckyDraw")
        this.$store.dispatch("allSelectAgent");

      },
      pagechange(){
        this.$Progress.start()
        this.$store.dispatch("allPreviewReport", [this.pagination.current_page,this.agent_id,this.search]);
        this.$Progress.finish()
      },
      agentChange(){
        // this.$store.dispatch("allSelectAgent", [this.kista_id]);
        this.pagechange();

      },
      searchByno(){
        this.pagechange();
      },
      print () {
        this.$htmlToPaper('printMe');
      },
      previewreportExport(){
        location.href = '/manager/report/preview/export?agent_id='+this.agent_id+'&search='+this.search;
      },
     // paddy: function paddy(num, padlen, padchar) {
     //    var pad_char = typeof padchar !== 'undefined' ? padchar : '0';
     //    var pad = new Array(1 + padlen).join(pad_char);
     //    return (pad + num).slice(-pad.length);
     //  }
     
    }
  }
</script>

<style scoped>
</style>