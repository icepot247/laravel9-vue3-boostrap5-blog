<template>
    <div class="p-5 mb-4 box rounded-3">
        <div class="container-fluid p-4 p-md-5 mb-4 text-white rounded bg-dark">
            <div class="col-md-6 px-0">
                <h1 class="display-4 fst-italic">Title of a longer featured blog post</h1>
                <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and
                    efficiently about what’s most interesting in this post’s contents.</p>
                <p class="lead mb-0"><a href="#" class="text-white fw-bold">Continue reading...</a></p>
            </div>
        </div>
    </div>

    <div class="p-5 mb-4 box rounded-3">
        <div class="row mb-2">
            <div class="col-md-6"  v-for="post in posts.data">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary">World</strong>
                        <h3 class="mb-0">{{post.title}}</h3>
                        <div class="mb-1 text-muted">{{post.excerpt}} {{post.status}}</div>
                        <p class="card-text mb-auto">{{formatDate(post.created_at)}}</p>
<!--                        <a href="'/blog/'+${{post.slug}}"   class="stretched-link">Continue reading</a>-->

                        <router-link :to="'/blog/'+post.slug" class="stretched-link" :title="post.title">
                            Continue reading
                        </router-link>

                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg"
                             role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice"
                             focusable="false"><title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#55595c"></rect>
                            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                        </svg>

                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
    import {defineComponent, onMounted, onUnmounted, ref} from "vue";

    const products = ref(null);

    export default defineComponent({
        data() {
            return {
                name: '',
                posts: []

            }
        },
        mounted() {
            this.getPosts()
        },
        methods: {
            getPosts() {
                // console.log(import.meta.env.API_BASE_URL)
                console.log(this.apiBaseUrl )
                const requestOptions = {
                    method: 'GET',
                    headers: {'Content-Type': 'application/json'},
                    /*body: JSON.stringify({
                        "name": "morpheus",
                        "job": "leader"
                    })*/
                };
                fetch(`${this.apiBaseUrl}/posts`, requestOptions)
                    .then(async response => {
                        const data = await response.json();

                        // check for error response
                        if (!response.ok) {
                            // get error message from body or default to response status
                            const error = (data && data.message) || response.status;
                            return Promise.reject(error);
                        }

                        this.posts = data.data;
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
