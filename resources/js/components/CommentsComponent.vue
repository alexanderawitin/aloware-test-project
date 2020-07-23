<template>
    <div class="post-comments">
        <alo-comment v-for="comment in comments" :key="comment.id" :comment="comment"></alo-comment>
    </div>
</template>

<script>
    export default {
        props: ['comments'],
    }
</script>

<style lang="scss">
    .post-comments {
        > .comment {
            margin-left: 0 !important;
            border-left: none !important;
        }
    }
</style>
