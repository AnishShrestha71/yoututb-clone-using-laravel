<template>
    <div class="my-4">
        <div>
            <div class="flex">
                <avatar
                    :username="
                        comment.user !== null ? comment.user.name : 'no name'
                    "
                />
                <div class="ml-2">
                    {{ comment.user !== null ? comment.user.name : "no name" }}
                    <div>
                        {{ comment.body }}
                    </div>
                </div>
            </div>
            
        </div>
        <div class="flex">
            <votes
                :default_votes="comment.votes"
                :entity_id="comment.id"
                :entity_owner="comment.user.id"
            />
            <button @click="showForm = !showForm" type="button" class="ml-4" :class="{'bg-red-700' : showForm}">{{showForm ? 'Cancel' : 'add reply'}}</button>
        </div>
        <div v-if="showForm">
        <input v-model="body" type="text" />
        <button type="button" @click="addReply">add a reply</button>
        </div>
        <replies ref="replies" :comment="comment" />
    </div>
</template>

<script>
import Avatar from "vue-avatar";
import Replies from "./replies.vue";
export default {
    components:{
        Replies,
          Avatar,
    },
    props: {
        comment: {
            required: true,
            default: () => {}
        },
        video: {
            required: true,
            default: () => {}
        }
    },
    data(){
        return{
            showForm: false,
            body: ''
        }
    },
    methods: {
        addReply(){
            // console.log(this.$refs.replies)

            if(!this.body) return

            axios.post(`/comment/${this.video.id}`,
            {
                comment_id : this.comment.id,
                body: this.body
            }).then(({data})=>{
                this.body= '',
                this.showForm =false,
               this.$refs.replies.addReply(data)
            })
        }
    }
   
};
</script>
