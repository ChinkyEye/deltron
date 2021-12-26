<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Add Scheme</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Scheme</li>
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
            <div class="row">
              <div class="col-8">
                <div class="card card-primary">
                  <div class="card-header">
                    <router-link to="/luckydraw">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addLuckyDraw()">
                    <div class="card-body">
                      <div class="row">
                      <div class="form-group col-md-12">
                        <label for="name">Name<code>*</code></label>
                        <input type="text" class="form-control" id="name" placeholder="Add name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                    </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Create Scheme"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Name : {{form.name}}</h5>
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
  export default {
    name: "New",
    data(){
      return {
        form: new Form({
          name:'',
        }),
        state: {
          isSending: false
        }
      }
    },
    mounted(){
      // this.$Progress.start()
      // this.$Progress.finish()
    },
    methods:{
     addLuckyDraw(){
      this.state.isSending = true;
      this.form.post('/manager/luckydraw')
      .then((response)=>{
        this.$router.push('/luckydraw')
        Toast.fire({
          icon: 'success',
          title: 'Detail Added successfully'
        })
      })
      .catch(()=>{
        this.state.isSending = false;
      })
      this.resetForm();
    },
    resetForm() {
      this.form.reset();
    },
    // isNumber: function(evt) {
    //     evt = (evt) ? evt : window.event;
    //     var charCode = (evt.which) ? evt.which : evt.keyCode;
    //     if ((charCode > 31 && (charCode < 48 || charCode > 57) ) && charCode !== 46
    //       ) {
    //       evt.preventDefault();;
    //   } else {
    //     return true;
    //   }
    // },
  }
}
</script>
