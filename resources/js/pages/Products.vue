<template>
      <div class="col-md-2"></div>
      <div class="col-md-8 mb-5">

        <div class="p-3">  <h1>Products</h1> </div>

        <form action="">
           <!-- <div class="input-group mb-3">
            <div class="col-md-8">
              <input type="text" class="form-control" v-model="search" placeholder="Search products">
            </div>
          </div>
          <div class="col-md-2">
          <button class="btn btn-success" @click="submit">Search</button> -->

          <div class="input-group mb-3">
            <input type="text" class="form-control"  v-model="search" placeholder="Search products">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" @click="searchProduct">Search</button>
            </div>
        </div>
            <a @click="initProducts" v-if="search!=''" class="text-danger my-2">X REMOVE SEARCH </a>

        </form>

        <div class="form-group">
          <label for="exampleFormControlSelect1">filtered by category </label>
          <select class="form-control" @change="onChange($event)">
            <option disabled selected>please select category</option>
             <option v-for="cat in categories" :key="cat.id" :value="cat.category">{{cat.category}}</option>
          </select>
            <a @click="initProducts" v-if="selectedCategory != ''" class="text-danger my-2">X REMOVE FILTER CATEGORY </a>

      </div>


        <router-link to="/products-create/" class="btn btn-success btn-sm my-3 float-end "> create </router-link>

        <Bootstrap4Pagination :data="products"  @pagination-change-page="initProducts" />


        <div class="card" v-for="product in products.data" :key="product.id">
            <div class="card-header">
                name:  {{ product.name }}
                <div class="float-right">
                <router-link :to="{ path:`/products/${product.id}/edit` }" class="text-success " style="cursor-pointer" ><i class="nav-icon fas fa-pencil-alt"></i> edit </router-link>
                 &nbsp;&nbsp; <span class="text-danger" style="cursor-pointer" @click="remove(product)"><i class="nav-icon fas fa-trash-alt"></i> remove</span>
              </div>
            </div>
            <div class="card-body">
                <h5 class="card-title">category:  {{ product.category }}</h5>
                <p class="card-text">description:  {{ product.description }}.</p>
            </div>
        </div>

      </div>
</template>

<script>
import { Bootstrap4Pagination } from 'laravel-vue-pagination';


export default {
  components:{
    Bootstrap4Pagination
  },
  data() {
    return {
      search: '',
      selectedCategory:'',
      products: {},
      filterCategory: false,
      isSearch: false
    };
  },
  methods: {
    searchProduct(){
      this.isSearch = true;
    },
    onChange(e){
      this.selectedCategory = e.target.value,
      this.filterCategory = true
    },

    remove(product){
        axios.post('/api/products/delete', {'id' : product.id})
        .then(res => {
            if(res.data.type){
                alert('success delete')

                let index = this.products.data.indexOf(product)
                this.products.data.splice(index, 1)

                this.initProducts()
            }

        })
        .catch(err=> console.log(err))

    },

    initProducts(page=1){
      this.search= ''
      this.selectedCategory= ''

      axios
      .get(`/api/products?page=${page}`)
      .then(res=> {
        let result = res.data.data;
        this.products = result
        // this.$store.dispatch('initProducts',result)
      })
      .catch( err => console.log(err));
    },

    initCategories(){
      axios
      .get("/api/products/categories")
      .then((res) => {
        let result = res.data.data;
        this.$store.dispatch('initCategories',result)
      })
      .catch( err => console.log(err));
    }
  },
  computed: {
    categories(){
      return this.$store.getters.getCategories
    },

    products(){

      if(this.selectedCategory != '' && this.filterCategory ){
        axios.get('/api/products/filter/'+ this.selectedCategory)
        .then(res => {
          this.filterCategory = !this.filterCategory
          let result = res.data.data
          this.products = result
        })
        .catch(err => console.log(err))
      }

      if(this.isSearch){

        axios.get('/api/products/search/'+this.search)
        .then(res => {
          let result = res.data.data
          this.products = result
          this.isSearch =! this.isSearch
        })
        .catch(err => console.log(err))
      }


      if(this.search == '' || this.selectedCategory == '' ){
        return this.products
      }

      return this.products



    },

  },
  mounted() {
    let token = localStorage.getItem('access_token')
    if(token != null) {
      window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}` ;
      this.initProducts()
      this.initCategories()
      this.$store.dispatch('initialized', localStorage.getItem('access_token'))
    }

    if( this.search == '' ){
      this.isSearch = false
      return this.products
    }
  },

};
</script>

<style>
</style>