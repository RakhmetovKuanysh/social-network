<template>
    <div>
        <div class="post-element" v-for="post in posts" :key="post.id">
            <p class="lead block-text">{{ post.text }}</p>
            <p class="block-created-at-time">{{ post.created_at }}</p>
            <br>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                'posts': ''
            }
        },

        created() {
            this.getPosts();

            Echo.join('posts')
                .listen('PostUpdatedEvent', (event) => {
                    console.log(event.post);

                    this.posts.unshift(event.post);
                });
        },

        methods: {
            getPosts() {
                axios.get('posts').then(response => {
                    console.log(response);
                    this.posts = response.data;
                })
            }
        },
    }
</script>
