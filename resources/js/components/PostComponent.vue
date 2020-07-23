<template>
    <div class="post">
        <div class="card mb-3">
            <div class="card-body">
                <h2 class="çard-title">{{ post.title }}</h2>

                <p class="card-text" v-html="post.body"></p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">Comments</h4>

                <alo-reply class="mb-3" :post="post" @comment-sent="commentSent" :post-comment="true"></alo-reply>

                <alo-comments :comments="comments"></alo-comments>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['post'],
        data() {
            return {
                comments: [],
            };
        },
        mounted() {
            this.comments = this.post.comments;
        },
        methods: {
            commentSent(comment) {
                this.comments.push(comment);
            },
        },
    }
</script>
