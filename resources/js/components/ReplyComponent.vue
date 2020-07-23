<template>
    <validation-observer ref="veeObserver" v-slot="{ invalid }" tag="div" class="reply-form" :class="{ 'form-enabled': formEnabled }">

        <div class="comment-form" v-if="formEnabled">
            <form novalidate>
                <validation-provider rules="required" v-slot="{ errors }" tag="div" class="form-group">
                    <input type="text" v-model="form.name" class="form-control form-control-sm" placeholder="Your name..."/>
                    <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
                <validation-provider rules="required" v-slot="{ errors }" tag="div" class="form-group">
                    <textarea v-model="form.message" class="form-control form-control-sm" placeholder="Your reply..."/>
                    <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
            </form>
        </div>

        <div class="comment-actions d-flex">
            <button class="btn btn-sm btn-link" v-if="!formEnabled" @click="formEnabled = true">Reply</button>
            <button class="btn btn-sm btn-link" v-if="formEnabled && !postComment" @click="closeForm">Close</button>
            <button
                class="btn btn-sm btn-primary"
                v-if="formEnabled"
                :disabled="invalid"
                @click="sendReply"
            >{{ postComment ? 'Comment' : 'Send' }}</button>
        </div>

    </validation-observer>
</template>

<script>
    export default {
        data() {
            return {
                formEnabled: false,
                form: {
                    name: '',
                    message: '',
                },
            };
        },
        props: ['post', 'comment', 'postComment'],
        mounted() {
            if (this.postComment) {
                this.formEnabled = true;
            }
        },
        methods: {
            closeForm() {
                if (!this.postComment) {
                    this.formEnabled = false;
                }

                this.resetForm();
            },

            sendReply() {
                window.axios.post('/api/comments', {
                    'post_id': (this.post && this.post.id) || null,
                    'parent_id': (this.comment && this.comment.id) || null,
                    'user_name': this.form.name,
                    'body': this.form.message,
                }).then(response => {
                    const reply = response.data;

                    this.$emit('comment-sent', reply);

                    this.closeForm();
                }).catch(e => {
                    if (e.response && e.response.status === 422) {
                        const errors = e.response.data.errors;

                        if (errors && errors['level']) {
                            alert(errors['level']);
                            this.closeForm();
                        }
                    } else {
                        alert('Oops! Something went wrong. The error has been logged into the console.');
                    }
                });
            },

            resetForm() {
                this.form.name = '';
                this.form.message = '';
                this.$refs.veeObserver.reset();
            },
        },
    }
</script>

<style lang="scss">
    .reply-form {
        .comment-actions {
            .btn {
                margin-right: 5px;
            }
        }
    }
</style>
