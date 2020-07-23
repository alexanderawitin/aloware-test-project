<template>
    <div class="posts">
        <alo-post v-for="post in posts" :key="post.id" :post="post" class="mb-3"></alo-post>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts: [],
            }
        },

        mounted() {
            if (window['__STATE__'] && window['__STATE__'].posts && window['__STATE__'].posts.length) {
                this.posts = window['__STATE__'].posts;
            } else {
                window.axios.get('/api/posts').then(response => {
                    console.log(response);
                });
            }
        },
    }
</script>
