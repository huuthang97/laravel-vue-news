<template>
    <div v-if="relatedPosts.length > 0">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h2>Related Posts</h2>

                <div class="d-flex border-bottom-blue pt-3 pb-4 align-items-center justify-content-between"
                    v-for="item in relatedPosts" :key="item.id">
                    <div class="pr-3 w-250">
                    <h5 class="cursor-pointer" @click="pushRouter(item)">{{ item.title }}</h5>
                    <div class="fs-12">
                        <span class="mr-2">{{ item.name }} </span> {{ item.created_at | tranformToHour }}
                    </div>
                    </div>
                    <div class="rotate-img">
                    <img
                        :src="'/img/posts/' + item.avatar"
                        alt="thumb"
                        class="img-fluid img-lg"
                    />
                    </div>
                </div>

            

            
            </div>
        </div>
    </div>
  
</template>

<script>
export default {
    name: 'RelatedPost',
    data() {
        return {
            relatedPosts: {},
            id: this.postId
        }
    },
    watch: {
        $route (to, from){
            this.getRelatedPosts();
        }
    },  
    methods: {
        getRelatedPosts($post_id) {
            let path = this.$route.path;
            let slug = path.split('/').pop();
            axios.get("/api/frontend/related-posts/" + slug)
                .then(res => this.relatedPosts = res.data)
                .catch(err => console.log(err));
        },
        pushRouter(item) {
            Fire.$emit("pushRouter", item);
        },
    },
    created() {
        
        this.getRelatedPosts();

    },
}
</script>

<style>

</style>