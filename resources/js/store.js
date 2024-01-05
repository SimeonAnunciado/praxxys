import { createStore } from 'vuex'


const store = createStore({
    state: {
      authenticated: false,
      access_token:null,
      products: null,
      categories:null


    },

    getters:{

      getProducts(state){
        return state.products
      },
      getCategories(state){
        return state.categories
      }

    },

    mutations: {


      init(state, data){
       state.authenticated = data != null ? true : false
      },

      login(state, data){
        state.authenticated = localStorage.getItem('access_token') != null ? true : false
        state.user = data.user
        state.access_token = data.token
      },

      logout(state, data){
        state.authenticated = false
      },

      setProducts(state,data){
        state.products = data
      },

      setCategories(state,data){
        state.categories = data
      },

    },

    actions: {
      // search({commit}, data){
      //   commit('setSearchQuery', data);
      //   const getFilterProduct = getters.filteredData;
      //   commit('setSearchResults', getFilterProduct);
      // },

      login({commit} , data){
        commit('login', data)
      },

      logout({commit}, data){
        commit('logout',data)
      },

      initialized({commit}, data){
        commit('init',data)
      },

      initProducts( {commit}, data){
        commit('setProducts',data)
      },

      initCategories( {commit}, data){
        commit('setCategories',data)
      }

    }
  })
  export default store