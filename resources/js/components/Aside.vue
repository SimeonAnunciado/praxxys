<template>
  <div>
      <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img :src="image" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">PRAXXYS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <router-link to="/" class="nav-link"> Home</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/products" class="nav-link">Products</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/videos" class="nav-link">Video</router-link>
          </li>

          <li class="nav-item">
            <a @click="logout" style="cursor:pointer" class="nav-link">Logout</a>
          </li>

        </ul>


      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  </div>
</template>

<script>
export default {
  data(){
    return{
      image: "/dist/img/AdminLTELogo.png"
    }
  },
  methods: {
    logout(){
      axios.post('/api/logout')
      .then(res => {
          localStorage.removeItem('access_token')
          this.$router.push({name: 'login'})
          this.$store.dispatch('logout',{})
      })
      .catch(err => {
        let statusCode = err.response.request.status
        if(statusCode == 401 ){
            localStorage.removeItem('access_token')
            this.$router.push({name: 'login'})
            this.$store.dispatch('logout',{})
        }
      })
    }
  },
}
</script>

<style>

</style>