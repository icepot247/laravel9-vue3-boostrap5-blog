<template>
  <div class="p-5 mb-4 box rounded-3">
      <div class="container-fluid py-5">
          <div class="row">
              <div class="col-md-6">
                  <div class="mb-4">
                      <h1 class="display-5 fw-bold">Contact</h1>
                  </div>
                  <form action="#" method="post" @submit.prevent="sendMessage">
                      <div class="form-group first py-2">
                          <label for="name">Full Name <em class="text-danger">*</em></label>
                          <input type="text" v-model="name" class="form-control" id="name" placeholder="Enter your full name">
                      </div>
                      <div class="form-group first  py-2">
                          <label for="email">Email  <em class="text-danger">*</em></label>
                          <input type="text" class="form-control" id="email" placeholder="Enter your email">
                      </div>
                      <div class="form-group last  py-2">
                          <label for="message">Message  <em class="text-danger">*</em></label>
                          <textarea rows="5" class="form-control" id="message" placeholder="Write your message"></textarea>
                      </div>
                      <input type="submit" value="Send" class="btn text-white btn-block btn-primary">
                  </form>
              </div>

              <div class="col-md-6 fs-4">
                  <GoogleMap
                          api-key="AIzaSyDOFlx7_zAF2nBL2D8rdhJTREPgnGgvtKk"
                          style="width: 100%; height: 500px"
                          :center="center"
                          :zoom="15"
                  >
                      <Marker :options="{ position: center }" />
                  </GoogleMap>
              </div>
          </div>




      </div>
  </div>
</template>

<script>
    import {defineComponent, onMounted, onUnmounted, ref} from "vue";
    import { GoogleMap, Marker } from "vue3-google-map";
    const products = ref(null);

    export default defineComponent({
        components: { GoogleMap, Marker },
        setup() {
            const center = { lat: 40.689247, lng: -74.044502 };
            return { center };
        },

        data(){
           return {
               name:'',
               products:''

           }
        },
        methods: {
              sendMessage(){
                  const requestOptions = {
                      method: 'POST',
                      headers: { 'Content-Type': 'application/json' },
                      body: JSON.stringify({
                          "name": "morpheus",
                          "job": "leader"
                      })
                  };
                  fetch('https://reqres.in/api/users', requestOptions)
                      .then(async response => {
                          const data = await response.json();

                          // check for error response
                          if (!response.ok) {
                              // get error message from body or default to response status
                              const error = (data && data.message) || response.status;
                              return Promise.reject(error);
                          }

                          this.postId = data.id;

                          console.log(data)

                      })
                      .catch(error => {
                          this.errorMessage = error;
                          console.error('There was an error!', error);
                      });



            }
        }

    });





</script>
