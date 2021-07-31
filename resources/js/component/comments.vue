<template>
    <div>
        <h4>Comments</h4>
        <div v-if="auth">
            <input v-model="newComment" type="text" />
            <button @click="addComment">comment</button>
        
        </div>
        <comment
            v-for="comment in comments.data"
            :comment="comment"
            :key="comment.id"
            :video="video"
        />
        
        <div>
            <button
                v-if="comments.next_page_url"
                @click="fetchComments"
                type="button"
                class="bg-red-400"
            >
                load more
            </button>
        </div>
        {{ newComment }}
    </div>
</template>

<script>
import Comment from "./comment.vue";

export default {
    props: ["video"],
    components: {
        Comment
    },
    mounted() {
        this.fetchComments();
    },
    computed: {
        auth() {
            return __auth();
        }
    },
    data: () => ({
            comments: {
                data: []
            },
            newComment: ''
        }),
    methods: {
        fetchComments() {
            const url = this.comments.next_page_url
                ? this.comments.next_page_url
                : `/video/${this.video.id}/comment`;
            axios.get(url).then(({ data }) => {
                this.comments = {
                    ...data,
                    data: [...this.comments.data, ...data.data]
                };
            });
        },
        addComment() {
            if (!this.newComment) return;

            axios
                .post(`/comment/${this.video.id}`, {
                    body: this.newComment
                })
                .then(({ data }) => {
                    this.comments = {
                        ...this.comments,
                        data: [data, ...this.comments.data]
                    };
                });

                this.newComment = ''
        }
    }
};
</script>
