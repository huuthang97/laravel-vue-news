<template>
    <div>
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h2>Top View</h2>

                <div class="d-flex border-bottom-blue pt-3 pb-4 align-items-center justify-content-between"
                    v-for="item in topViews" :key="item.ids">
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
    data() {
        return {
            topViews: {}
        }
    },
    methods: {
        getTopViews() {
            axios.get("/api/frontend/top-views")
                .then(res => {
                    //Get 3 first item
                    this.topViews = res.data.slice(0, 3);
                })
                .catch(err => console.log(err));
        },
        pushRouter(item) {
            Fire.$emit("pushRouter", item);
        },
    },
    created() {
        this.getTopViews();
    },
}
</script>

<style>

</style>