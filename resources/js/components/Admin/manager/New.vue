<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Manager</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
            <div class="row">
              <div class="col-8">
                <div class="card card-primary">
                  <div class="card-header">
                    <router-link to="/manager">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addNewManager()">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-12 mb-0">
                          <label for="nameID">Name <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="nameID" placeholder="Add New Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                          <label for="emailID">Email <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="emailID" placeholder="Add New Email" v-model="form.email" name="email" :class="{ 'is-invalid': form.errors.has('email') }">
                          <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                          <label for="password">Password <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="password" placeholder="Add New Password" v-model="form.password" name="password" :class="{ 'is-invalid': form.errors.has('password') }">
                          <has-error :form="form" field="password"></has-error>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                          <label for="phone">Phone <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="phone" placeholder="Add New Phone" v-model="form.phone" name="phone" :class="{ 'is-invalid': form.errors.has('phone') }">
                          <has-error :form="form" field="phone"></has-error>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                          <label for="address">Address <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="address" placeholder="Add New Address" v-model="form.address" name="address" :class="{ 'is-invalid': form.errors.has('address') }">
                          <has-error :form="form" field="address"></has-error>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                          <label for="photo" class="d-block">Logo <code>Jpeg/Jpg/png Only with maximum size of 1 MB</code></label>
                          <input type="file" class="" @change="changePhoto($event)" id="photo" name="photo" :class="{ 'is-invalid': form.errors.has('photo') }">
                          <has-error :form="form" field="photo"></has-error>
                        </div>

                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Create Manager"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Name : {{form.name}}</h5>
                      <h5>Email : {{form.email}}</h5>
                      <h5>Phone No : {{form.phone}}</h5>
                      <h5>Address : {{form.address}}</h5>
                      <img :src="imagePreview" class="img-thumbnail" v-show="showPreview"/>
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
                email:'',
                password:'',
                phone:'',
                address:'',
                photo: null,
            }),
            state: {
                isSending: false
            },
            imagePreview: null,
            showPreview: false,
        }
    },
    methods:{
         addNewManager(){
          this.state.isSending = true;
          this.form.post('/home/manager',{
            headers: {
              'Content-Type': 'multipart/form-data',
            },
            transformRequest: [function (data,headers){
              return objectToFormData(data)
            }]
          })
          .then((response)=>{
            this.$router.push('/manager')
            Toast.fire({
                icon: 'success',
                title: 'Manager Added successfully'
            })
        })
          .catch(()=>{
              this.state.isSending = false;
          })
      },
      changePhoto(event){
        let file = event.target.files[0];
        // console.log(file);
        // 5 mb image
        if((file.size>5242880) || ((file.type != 'image/jpeg') && (file.type != 'image/jpg') && (file.type != 'image/png') )){
          this.state.isSending = true;
          Swal.fire({
           icon: 'error',
           title: 'Oops...',
           text: 'Something went wrong!',
           footer: '<a href>Why do I have this issue?</a>'
         })
        }else{
          let reader  = new FileReader();
          reader.addEventListener("load", function () {
            this.showPreview = true;
            this.imagePreview = reader.result;
            this.state.isSending = false;
          }.bind(this), false);
          if( file ){
            this.form.photo = file;
            if ( /\.(jpe?g|jpg|png)$/i.test( file.name ) ) {
              reader.readAsDataURL( file );
            }
          }
        }
      },
    }
  }
</script>

<style scoped>

</style>