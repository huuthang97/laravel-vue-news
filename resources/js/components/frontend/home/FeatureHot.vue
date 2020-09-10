<template>
    <div>
        <div class="position-relative pointer" > 
            <!-- :src="'/img/posts/' + post.avatar" -->
            <img
            
            src="frontend/images/dashboard/banner.jpg"
            :title="post.avatar"
            class="img-fluid"
            />
            <div class="banner-content">
            <div class="badge badge-danger fs-12 font-weight-bold mb-3">
                {{ post.name }}
            </div>
            <!-- <h1 class="mb-0">GLOBAL PANDEMIC</h1> -->
            <h1 class="mb-2 cursor-pointer" @click="pushRouter(post)">
                {{ post.title }}
            </h1>
            <div class="fs-12">
                {{ post.created_at | tranformToHour }}
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "FeatureHot",
    data() {
        return {
            post: {}
        }
    },
    methods: {
        pushRouter(item) {
            Fire.$emit("pushRouter", item);
        },
        getFeatureHot() {
            axios.get("api/frontend/feature-hot")
                .then(res => this.post = res.data)
                .catch(err => console.log(err));
        }
    },
    created() {
        this.getFeatureHot();
    },
}
</script>

<style>

</style>