<template>
  <div class="p-5 mb-4 box rounded-3">
      <div class="container-fluid py-5">
          <h1 class="display-5 fw-bold">  {{ post.title }}</h1>
          <div class="col-md-8 fs-4" v-html="post.body" >  </div>
      </div>
  </div>
</template>

<script>
    import {defineComponent, onMounted, onUnmounted, ref} from "vue";

    export default defineComponent({
        data() {
            return {
                post: []
            }
        },
        mounted() {
            this.getPost()
        },
        methods: {
            getPost() {
                const requestOptions = {
                    method: 'GET',
                    headers: {'Content-Type': 'application/json'},
                };
                fetch(`${this.apiBaseUrl}/posts/${this.$route.params.slug}`, requestOptions)
                    .then(async response => {
                        const data = await response.json();
                        if (!response.ok) {
                            const error = (data && data.message) || response.status;
                            return Promise.reject(error);
                        }

                        this.post = data.data;
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
