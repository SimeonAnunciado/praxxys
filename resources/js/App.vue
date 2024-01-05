<template>
  <div>
    <Nav v-if="$store.state.authenticated" />
    <Aside v-if="$store.state.authenticated"/>

    <div class="content-wrapper" v-if="$store.state.authenticated">
        <div class="content-header">
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>

    <div v-if="!$store.state.authenticated">
        <div class="container" >
            <router-view></router-view>
        </div>
    </div>

    <Footer-components v-if="$store.state.authenticated"/>


  </div>
</template>

<script>
import Nav from './components/Nav.vue'
import Aside from './components/Aside.vue'
import Footer from './components/Footer.vue'

export default {
    components : {
        Nav,
        Aside,
        'Footer-components': Footer,
    },
    data(){
        return {
            auth : false //&& localStorage.getItem('access_token') != null

        }
    },
    mounted() {
        // this.auth = ? true : false

        this.$store.dispatch('initialized', localStorage.getItem('access_token'))

        if(this.$store.state.authenticated ){
            this.$router.push('/')
        }

        if(this.$store.state.authenticated == false){
            this.$router.push({ name: 'login'})
        }
    },

}
</script>

<style>

</style>