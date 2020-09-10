<template>
    <div>
        <div class="card-title">
            Hot News
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-8 col-sm-6">
                <div class="rotate-img cursor-pointer" @click="pushRouter(firstPost)">
                    <img
                    :src="'/img/posts/' + firstPost.avatar"
                    :alt="firstPost.title"
                    :title="firstPost.title"
                    class="img-fluid"
                    />
                </div>
                <h2 class="mt-3 text-primary mb-2 cursor-pointer" @click="pushRouter(firstPost)">
                    {{ firstPost.title }}
                </h2>
                <p class="fs-13 mb-1 text-muted">
                    <span class="mr-2">{{ firstPost.name }} </span>{{ firstPost.created_at | tranformToHour }}
                </p>
                <p class="my-3 fs-15" :title="firstPost.description">
                    {{ firstPost.description | shortenDescription }}
                </p>
                
            </div>
            <div class="col-xl-6 col-lg-4 col-sm-6">
                <div class="border-bottom pb-3 mb-3" v-for="post in postNotFirst" :key="post.id">
                    <h3 class="font-weight-600 mb-0 cursor-pointer" @click="pushRouter(post)">
                        {{ post.title }}
                    </h3>
                    <p class="fs-13 text-muted mb-0">
                    <span class="mr-2">{{ post.name }} </span>{{ post.created_at | tranformToHour }}
                    </p>
                    <p class="mb-0" :title="post.description">
                        {{ post.description | shortenDescription }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HotNews",
    data() {
        return {
            firstPost: {},
            postNotFirst: {}
        }
    },
    methods: {
        pushRouter(item) {
            Fire.$emit("pushRouter", item);
        },
        getHotNews() {
            axios.get("/api/frontend/hot-news")
                .then(res => {
                    let posts = res.data;
                    this.firstPost = posts[0];
                    this.postNotFirst = posts.splice(1);
                })
                .catch(err => console.log(err));
        }
    },
    created() {
        this.getHotNews();
    },
}
</script>

<style>

</style>