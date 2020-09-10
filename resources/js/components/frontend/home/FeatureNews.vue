<template>
    <div>
        <div class="row">
            <div class="col-sm-6">
            <div class="card-title">
                Feature News
            </div>
            <div class="border-bottom pb-3">
                <div class="rotate-img cursor-pointer" @click="pushRouter(firstPost)">
                <img 
                    :src="'img/posts/' + firstPost.avatar"
                    :alt="firstPost.title"
                    :title="firstPost.title"
                    class="img-fluid"
                />
                </div>
                <p class="fs-16 font-weight-600 mb-0 mt-3 cursor-pointer" @click="pushRouter(firstPost)">
                    {{ firstPost.title }}
                </p>
                <p class="fs-13 text-muted mb-0">
                <span class="mr-2">{{ firstPost.name }} </span>{{ firstPost.created_at | tranformToHour }}
                </p>
            </div>
            <div class="pt-3 pb-3">
                <div class="rotate-img cursor-pointer" @click="pushRouter(secondPost)">
                <img
                    :src="'img/posts/' + secondPost.avatar"
                    alt="thumb"
                    class="img-fluid"
                />
                </div>
                <p class="fs-16 font-weight-600 mb-0 mt-3 cursor-pointer" @click="pushRouter(secondPost)">
                    {{ secondPost.title }}
                </p>
                <p class="fs-13 text-muted mb-0">
                <span class="mr-2">{{ secondPost.name }} </span>{{ secondPost.created_at | tranformToHour }}
                </p>
            </div>
            </div>
            <div class="col-sm-6">
                <div class="row" v-for="post in posts" :key="post.id">
                    <div class="col-sm-12">
                    <div class="border-bottom pb-3">
                        <div class="row">
                        <div class="col-sm-5 pr-2">
                            <div class="rotate-img cursor-pointer" @click="pushRouter(post)">
                            <img
                                :src="'img/posts/' + post.avatar"
                                :alt="post.title"
                                :title="post.title"
                                class="img-fluid w-100"
                            />
                            </div>
                        </div>
                        <div class="col-sm-7 pl-2">
                            <p class="fs-16 font-weight-600 mb-0 cursor-pointer" @click="pushRouter(post)" :title="post.title">
                                {{ post.title | shortenTitle}}
                            </p>
                            <p class="fs-13 text-muted mb-0">
                            <span class="mr-2">{{ post.name }} </span>
                                {{ post.created_at | tranformToHour }}
                            </p>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "FeatureNews",
    data() {
        return {
            firstPost: {},
            secondPost: {},
            posts: {}
        }
    },
    methods: {
        pushRouter(item) {
            Fire.$emit("pushRouter", item);
        },
        getFeatureNews() {
            axios.get("/api/frontend/feature-news")
                .then(res => {
                    let posts = res.data;
                    this.firstPost = posts[0];
                    this.secondPost = posts[1];
                    this.posts = posts.splice(2);
                })
                .catch(err => console.log(err));
        }
    },
    created() {
        this.getFeatureNews();
    },
}
</script>

<style>

</style>