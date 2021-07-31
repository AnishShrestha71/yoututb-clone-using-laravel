<template>
    <button type="button"
        @click="toggleSubscription"
        class="bg-red-600 text-white border border-red-800 h-8 w-1/2 rounded-md hover:bg-red-800"
    >
         {{ owner ? "" : subscribed ? "Unsubscribe" : "Subscribe" }}
         {{ subscriptions.length }}
         {{ owner ? "Subscriber" : "" }} 
    </button>
</template>

<script>
export default {
    props: {
        initialSubscriptions: {
            type: Array,
            require: true,
            default: () => []
        },
        channel: {
            type: Object,
            require: true,
            default: () => [{}]
        },
    },
    data: function() {
        return {
            subscriptions: this.initialSubscriptions
        };
    },
    computed: {
        subscribed() {
            if (!__auth() || this.channel.user_id === __auth().id) {
                return false;
            }
            return !!this.subscription;
        },
        owner() {
            if (__auth() && this.channel.user_id === __auth().id) {
                return true;
            }
        },
        subscription() {
            if (!__auth()) {
                return null;
            }
            return this.subscriptions.find(
                subscription => subscription.user_id === __auth().id
            );
        }
    },

    methods: {
        toggleSubscription() {
            if (!__auth()) {
                alert("you are not logged in");
            }
            if (this.owner) {
                alert("you are owner of this channel");
            }
            if (this.subscribed && __auth()) {
                axios
                    .delete(
                        `/channel/${this.channel.id}/subscription/${this.subscription.id}`
                    )
                    .then(() => {
                        this.subscriptions = this.subscriptions.filter(
                            s => s.id != this.subscription.id
                        );
                    });
            } else if(__auth() && !this.owner) {
                axios
                    .post(`/channel/${this.channel.id}/subscription`)
                    .then(response => {
                        this.subscriptions = [
                            ...this.subscriptions,
                            response.data
                        ];
                    });
            }
        }
    }
}
</script>
