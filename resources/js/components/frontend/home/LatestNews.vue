<template>
    <div>
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h2>Latest news</h2>

                <div class="d-flex border-bottom-blue pt-3 pb-4 align-items-center justify-content-between"
                    v-for="item in latestNews" :key="item.id">
                    <div class="pr-3 w-250">
                    <h5 class="cursor-pointer" @click="pushRouter(item)">{{ item.title }}</h5>
                    <div class="fs-12">
                        <span class="mr-2">{{ item.name }} </span> {{ item.created_at | tranformToHour }}
                    </div>
                    </div>
                    <div class="rotate-img cursor-pointer" @click="pushRouter(item)">
                    <img
                        :src="'/img/posts/' + item.avatar"
                        :alt="item.title"
                        :title="item.title"
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
    data() {
        return {
            latestNews: {}
        }
    },
    methods: {
        getLastNews() {
            axios.get("/api/frontend/latest-news")
                .then(res => this.latestNews = res.data)
                .catch(err => console.log(err));
        },
        pushRouter(item) {
            Fire.$emit("pushRouter", item);
        },
    },
    created() {
        this.getLastNews();
    },
}
</script>

<style>

</style>