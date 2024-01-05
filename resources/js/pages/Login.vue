<template>
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4 mt-5">
      <div class="card card-outline card-primary">
        <div class="card-header">Sign In </div>
        <div class="card-body">

          <form @submit.prevent="login">
            <div class="input-group my-3">
              <input type="text" class="form-control" v-model="form.email" placeholder="Email" />
            </div>
              <span v-if="errors.email" class="text-danger ">{{errors.email[0]}}</span>
            <div class="input-group my-3">
              <input type="password" class="form-control" v-model="form.password" placeholder="Password" />
            </div>
              <span v-if="errors.password" class="text-danger">{{errors.password[0]}}</span>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember" v-model="rememberMe" />
                  <label for="remember">  &nbsp; Remember Me </label>
                </div>
                  <router-link to="/register" >
                  Register Here
                </router-link>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">
                  Sign In
                </button>

              </div>
              <!-- /.col -->
            </div>
          </form>

        </div>
      </div>
    </div>
    <div class="col-md-4"></div>
  </div>
</template>

<script>
export default {
    data(){
        return {
          rememberMe: false,
          form: {
            email: '',
            password: '',
          },
          errors: {

          }
        }
    },
    methods: {
      login(){


        if (this.rememberUser) {
          localStorage.setItem('rememberedUser', JSON.stringify(this.rememberUser))
        } else {
          localStorage.removeItem('rememberedUser')
        }

        axios.post('/api/login', this.form)
        .then(res => {
          if(res.data.type == 1){
            localStorage.setItem('access_token', res.data.token)
            this.$store.dispatch('login', res.data)
            this.$router.push('/')
          }
        })
        .catch(err => {
          this.errors = err.response.data.errors
        })
      }
    },
    computed:{
      rememberUser() {
        return this.rememberMe ? { email: this.form.email, password: this.form.password } : null
      }

    },
    mounted(){

      const rememberedUser = JSON.parse(localStorage.getItem('rememberedUser'))

      if (rememberedUser) {
        this.form.email = rememberedUser.email
        this.form.password = rememberedUser.password
        this.rememberMe = true
      }

      if(this.$store.state.authenticated){
            this.$router.push('/')
      }

    }
};
</script>

<style>
</style>