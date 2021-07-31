<template>
    <div class="w-8/12 ml-8">
       
        <div v-for="reply in replies.data" class="my-4">
            <div>
                <div class="flex ">
                    <div>
                        <avatar
                            :username="
                                reply.user !== null
                                    ? reply.user.name
                                    : 'no name'
                            "
                        />
                    </div>
                    <div class="ml-4">
                        <div>
                        {{ reply.user !== null
                                ? reply.user.name
                                : "no name" }}
                        </div>
                        <div>
                        {{ reply.body }}
                        </div>
                    </div>
                    
                </div>
                <div class="">
                    <votes :default_votes=" reply.votes " :entity_id=" reply.id" :entity_owner="reply.user.id "/>
                   
                </div>
            </div>
        </div>
        <div>
            <button
                @click="fetchReplies"
                v-if="comment.repliesCount > 0 && replies.next_page_url"
                class="bg-gray-200"
            >
                load replies
            </button>
        </div>
    </div>
</template>

<script>
import Avatar from "vue-avatar";
export default {
    components: {
        Avatar
    },
    props: ["comment"],
    data() {
        return {
            replies: {
                data: [],
                next_page_url: `/comment/${this.comment.id}/reply`
            }
        };
    },
    methods: {
        fetchReplies() {
            axios.get(this.replies.next_page_url).then(({ data }) => {
                this.replies = {
                    ...data,
                    data: [...this.replies.data, ...data.data]
                };
            });
            console.log(this.replies)
        },
        addReply(reply){
            this.replies = {
                ...this.replies,
                data: [
                    reply,
                    ...this.replies.data
                ]
            }
        }
    }
};
</script>
