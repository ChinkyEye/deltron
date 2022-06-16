<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Manager</h1>
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
                        <div class="form-group col-md-6 mb-0">
                          <label for="nameID">Name</label>
                          <input type="text" class="form-control" id="nameID" placeholder="Add New Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                          <label for="email">Email</label>
                          <input type="text" class="form-control" id="email" placeholder="Add New Name" v-model="form.email" name="email" :class="{ 'is-invalid': form.errors.has('email') }">
                          <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                          <label for="address">Address</label>
                          <input type="text" class="form-control" id="address" placeholder="Add New Name" v-model="form.address" name="address" :class="{ 'is-invalid': form.errors.has('address') }">
                          <has-error :form="form" field="address"></has-error>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                          <label for="phone">Phone</label>
                          <input type="text" class="form-control" id="phone" placeholder="Add New Name" v-model="form.phone" name="phone" :class="{ 'is-invalid': form.errors.has('phone') }">
                          <has-error :form="form" field="phone"></has-error>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                          <label for="photo" class="d-block">Logo <code>Jpeg/Jpg/Png Only with maximum size of 1 MB</code></label>
                          <input type="file" class="" @change="changePhoto($event)" id="photo" name="photo" :class="{ 'is-invalid': form.errors.has('photo') }">
                          <has-error :form="form" field="photo"></has-error>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Update Manager"}}</button>
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
                      <div v-if="form.image_enc">
                        <img :src="updateImage(form.image_enc)" class="img-thumbnail" v-show="state.isDisplay">
                        <img :src="imagePreview" class="img-thumbnail" v-show="showPreview"/>
                      </div>
                      <div v-else>
                        <img :src="imagePreview" class="img-thumbnail" v-show="showPreview"/>
                      </div>
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
                address:'',
                email:'',
                phone:'',
                image_enc:'',
                photo:''
            }),
            state: {
                isSending: false,
                isDisplay: true

            },
            imagePreview: null,
            showPreview: false,
        }
    },
    mounted(){
        // this.$store.dispatch("allManagertypeSelect")
    },
    created(){
          axios.get(`/home/manager/${this.$route.params.managerid}/edit`)
            .then((response)=>{
              this.form.fill(response.data.managers)
            })
        },
    computed:{
        getAllManagertype(){
            return this.$store.getters.getManagertypeSelect
        }
    },
    methods:{
         addNewManager(){
          this.state.isSending = true;
          // this.form.put(`/home/manager/${this.$route.params.managerid}`)
          this.form.post(`/home/manager/${this.$route.params.managerid}/update`,{
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
            this.state.isDisplay = false;
            if ( /\.(jpe?g|jpg|png)$/i.test( file.name ) ) {
              reader.readAsDataURL( file );
            }
          }
        }
      },
      updateImage(image_enc){
        let img = image_enc;
        if(img.length>100){
          return  this.form.image_enc
        }else{
          return "image/manager/"+img
        }
      },
    }
  }
</script>

<style scoped>

</style>