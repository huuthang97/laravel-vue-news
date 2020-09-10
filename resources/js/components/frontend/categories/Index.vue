<template>

  <div class="container-scroller">
      <div class="main-panel">
        <!-- partial:partials/_navbar.html -->
        <navbar></navbar>

        <!-- partial -->
        <weather></weather>
        <!-- content-wrapper -->
        <div class="content-wrapper">
          <div class="container">
            <div class="col-sm-12">
              <div class="card" data-aos="fade-up">
                <div class="card-body" v-if="posts.data">
                  <div class="row">
                    <div class="col-sm-12" >
                      <h1 class="font-weight-600 text-uppercase mb-4" >
                          {{ posts.data[0].name }}
                      </h1>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="row" v-for="post in posts.data" :key="post.id">
                        <div class="col-sm-4 grid-margin cursor-pointer" @click="pushRouter(post)">
                          <div class="rotate-img">
                            <img
                              :src="'/img/posts/' + post.avatar"
                              alt="banner"
                              class="img-fluid"
                            />
                          </div>
                        </div>
                        <div class="col-sm-8 grid-margin">
                          <h2 class="font-weight-600 mb-2 cursor-pointer" @click="pushRouter(post)">
                            {{ post.title }}
                          </h2>
                          <p class="fs-13 text-muted mb-0">
                            <span class="mr-2">{{ post.name }} </span>{{ post.created_at | tranformToHour }}
                          </p>
                          <p class="fs-15">
                            {{ post.description }}
                          </p>
                        </div>
                      </div>
                        <pagination :data="posts" @pagination-change-page="getPostsByCategory"></pagination>
                      </div>
                    <div class="col-lg-4">
                      <!-- latest-news -->
                      <latest-news class="mb-4"></latest-news>
                      
                      <!-- top-view -->
                      <top-view></top-view>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- main-panel ends -->
        <!-- container-scroller ends -->

        <!-- partial:partials/_footer.html -->
        <foot></foot>

        <!-- partial -->
      </div>
  
  </div>

</template>

<script>
import Navbar from "../Navbar.vue";
import Weather from "../Weather.vue";
import Foot from "../Foot.vue";
import LatestNews from "../home/LatestNews.vue";
import TopView from "./TopView.vue";

export default {
    name: 'Category',
    components: {
        Navbar, Weather, Foot, LatestNews, TopView
    },
    data() {
      return {
        posts: {},
      }
    },
    watch: {
        $route (to, from){
            this.getPostsByCategory();
        }
    },
    methods: {
      pushRouter(item) {
        Fire.$emit('pushRouter', item);
      },
      getPostsByCategory(page = 1){
        this.$Progress.start();
        let slug = this.$route.path.split('/').pop();
        axios.get("/api/frontend/posts_by_category/" + slug + "?page=" + page)
         .then(res => {
            this.posts = res.data;
            this.$Progress.finish();
          })
         .catch(err => console.log(err));
      },
      
    },
    created() {
        this.getPostsByCategory();
    },
    
}
</script>

<style>
  .pagination {
    padding-bottom: 0px;
    padding-top: 0px;
  }
  .pagination .page-item .page-link {
    
    padding: 10px 13px;
  }
  .pagination .page-item.active .page-link {
    color: whitesmoke;
  }
  
</style>

