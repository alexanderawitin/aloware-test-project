<template>
    <div class="comment">
        <div class="comment-content">
            <h6 class="comment-header">
                {{ comment.user_name }}
                <small class="comment-extra">• <timeago :datetime="comment.created_at"></timeago></small>
            </h6>

            <p class="comment-body">
                {{ comment.body }}
            </p>

            <alo-reply :comment="comment" @comment-sent="commentSent"></alo-reply>
        </div>

        <alo-comment
            v-for="reply in replies"
            :key="reply.id"
            :comment="reply"
        ></alo-comment>
    </div>
</template>

<script>
    export default {
        props: ['comment'],
        data() {
            return {
                replies: [],
            };
        },
        mounted() {
            this.replies = this.comment.replies;
        },
        methods: {
            commentSent(comment) {
                this.replies.push(comment)
            },
        }
    }
</script>

<style lang="scss">
    .comment {
        &-extra {
            color: #a0a0a0;
        }

        &-content {
            .comment-body,
            .reply-form {
                margin-bottom: 0.5rem;
            }

            .reply-form {
                .comment-actions {
                    opacity: 0;
                    transition: opacity 300ms;
                }

                &.form-enabled {
                    .comment-actions {
                        opacity: 1;
                    }
                }

            }

            &:hover {
                .reply-form {
                    .comment-actions {
                        opacity: 1;
                    }
                }
            }
        }

        &:not(:first-child) {
            margin-left: 20px;
            border-left: 1px solid #ccc;
            padding: 5px 5px 5px 20px;
        }
    }
</style>
