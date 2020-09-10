<template>
    <div>
        <div class="card">
          <div class="card-body">
            <div class="row" v-for="item in listPosts" :key="item.id">
              <div class="col-sm-4 grid-margin">
                <div class="position-relative">
                  <div class="rotate-img cursor-pointer" @click="pushRouter(item)">
                    <img
                      :src="'/img/posts/' + item.avatar"
                      :alt="item.title"
                      :title="item.title"
                      class="img-fluid"
                    />
                  </div>
                </div>
              </div>
              <div class="col-sm-8  grid-margin">
                <h2 class="mb-2 font-weight-600 cursor-pointer"  @click="pushRouter(item)">
                  {{ item.title }}
                </h2>
                <div class="fs-13 mb-2">
                  <span class="mr-2">{{ item.name }} </span> {{ item.created_at | tranformToHour }}
                </div>
                <p class="mb-0">
                  {{ item.description }}
                </p>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PostByCategory",
    props: {
        categoryId: {
            type: Number,
            require: true
        }
    },
    data() {
        return {
            listPosts: {},
        }
    },
    watch: {
        categoryId() {
            axios.get("/api/frontend/list-posts-by-category/" + this.categoryId)
                .then(res => this.listPosts = res.data)
                .catch(err => console.log(err));
        }
    },
    methods: {
        pushRouter(slug) {
            Fire.$emit("pushRouter", slug);
        },
        getlistPostsByCategory() {
            axios.get("/api/frontend/list-posts-by-category/" + this.categoryId)
                .then(res => this.listPosts = res.data)
                .catch(err => console.log(err));
        }
    },
    created() {
        this.getlistPostsByCategory();
    },
}
</script>

<style>

</style>