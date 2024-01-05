<template>
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4 mt-5">
      <div class="card card-outline card-primary">
        <div class="card-header">Register</div>
        <div class="card-body">
          <form @submit.prevent="register">

             <div class="input-group mb-3">
              <input type="text" class="form-control" v-model="form.name" placeholder="Username" />
            </div>
              <span v-if="errors.name" class="text-danger ">{{errors.name[0]}}</span>

            <div class="input-group mb-3">
              <input type="email" class="form-control"  v-model="form.email" placeholder="Email" />
            </div>
              <span v-if="errors.email" class="text-danger ">{{errors.email[0]}}</span>

            <div class="input-group mb-3">
              <input type="password" class="form-control" v-model="form.password" placeholder="Password"/>
            </div>
              <span v-if="errors.password" class="text-danger ">{{errors.password[0]}}</span>

            <div class="input-group mb-3">
              <input type="password" class="form-control" v-model="form.password_confirmation" placeholder="Password Confirmation"/>
            </div>
              <span v-if="errors.password_confirmation" class="text-danger ">{{errors.password_confirmation[0]}}</span>

            <div class="row">
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">
                  Submit
                </button>
              </div>
                <router-link to="/login" >
                  login Here
                </router-link>
              <!-- /.col -->
            </div>
          </form>

          <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <div class="col-md-4"></div>
  </div>
</template>

<script>
export default {
  data(){
    return {
      form : {
        name: '',
        email: '',
        password: '',
      },
      errors: {}
    }
  },
  methods: {
    register(){
      axios.post('/api/register', this.form)
      .then(res => {
        if(res.data.type == 1){
           alert('success')
           this.form.name = ''
           this.form.email = ''
           this.form.password = ''
           this.$router.push('/login')
        }
      })
      .catch(err => {
          this.errors =  this.errors = err.response.data.errors
      })
    }
  },
};
</script>

<style>
</style>