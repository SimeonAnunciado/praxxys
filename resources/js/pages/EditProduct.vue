<template>
    <div class="col-md-2"></div>
    <div class="col-md-8 mt-5">
      <div class="card card-outline card-primary">
        <div class="card-header">Edit Product</div>
        <div class="card-body">
          <form @submit.prevent="create">


             <section v-if="step == 1">

                <div class="input-group mb-3">
                  <input type="text" class="form-control" v-model="form.name" placeholder="Name" />
                </div>
                  <span v-if="errors.name" class="text-danger ">{{errors.name[0]}}</span>

                <div class="input-group mb-3">
                  <input type="text" class="form-control"  v-model="form.category" placeholder="Category" />
                </div>
                  <span v-if="errors.category" class="text-danger ">{{errors.category[0]}}</span>


                <div class="input-group mb-3">
                  <textarea class="form-control" v-model="form.description" placeholder="Description" ></textarea>
                </div>

                  <span v-if="errors.description" class="text-danger ">{{errors.description[0]}}</span>
                  <button @click.prevent="next" class="btn btn-success float-right btn-sm">Next</button>

              </section>


              <section v-if="step == 2">
                  <div class="input-group mb-3">
                    <input type="file" multiple class="form-control" @change="uploadFile" placeholder="Description" >
                  </div>

                  <span v-if="errors.description" class="text-danger ">{{errors.description[0]}}</span>

                  <button @click.prevent="back" class="btn btn-success btn-sm float-left mt-2">Go Back</button>
                  <button @click.prevent="next" class="btn btn-success btn-sm float-right mt-2">Next</button>


              </section>

              <section v-if="step == 3">

                  <div class="input-group mb-3">
                    <VueDatePicker v-model="form.datetime"></VueDatePicker>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block" style="with:100%">
                    Submit
                  </button>

                  <!-- <button @click.prevent="back" class="btn btn-success btn-sm float-left mt-2">Go Back</button> -->
              </section>
          </form>


        </div>
        <!-- /.card-body -->
      </div>
    </div>

</template>

<script>
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
  components:{
    'VueDatePicker': VueDatePicker
  },
  data(){
    return {
      step: 1,
      form : {
        name: '',
        category: '',
        description: '',
        attachments: [],
        datetime: null
      },
      errors: {}
    }
  },
  methods: {
    next(){
      if(this.step == 1){
        if(this.form.name != '' && this.form.category != '' && this.form.description != '' ){
           this.step++
        }else{
          alert('Step 1 Please provide all fields to proceed to next step')
          return false
        }
      }

      if(this.step == 2 ){
        if(this.form.attachments.length > 0){
          this.step++
        } else{
          alert('Step 2 Please provide all fields to proceed to next step')
          return false
        }
      }

      if(this.step == 3){
        if(this.form.datetime != null){
          this.updateUser()
          this.step = 1 //reset
        }else{
          alert('Please provide all fields')
          return false
        }
      }


    },
    back(){
      this.step--
    },

    uploadFile(e){

      if(!e.target.files.length){
        return false
      }

      for (let i = 0; i < e.target.files.length; i++) {
        this.form.attachments.push(e.target.files[i]);
      }
    },

    getUser(){
      axios.get(`/api/products/${this.$route.params.id}/edit`)
      .then(res => {
        console.log(res)
        if(res.data.type){
          let user = res.data.data
          this.form.name = user.name
          this.form.category = user.category
          this.form.description = user.description
          // this.form.attachments = user.attachments
          this.form.datetime = user.datetime
        }
        console.log(res)
      })
      .catch(err => console.log(err))
    },

    updateUser(){
      const config = {
        headers: {
          'Content-Type':'multipart/form-data'
        }
      }

      axios.post(`/api/products/${this.$route.params.id}/update`, this.form, config)
      .then(res => {
          if(res.data.type){
            alert('successfull update product')
            this.$router.push({name:'products'})
            this.form.name = ''
            this.form.category = ''
            this.form.description = ''
          }
      })
      .catch(err => {
          this.errors =  this.errors = err.response.data.errors
      })
    },

  },

   mounted() {
      this.getUser()

    },
};
</script>

<style scoped>

</style>