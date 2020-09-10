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
            <div class="row" data-aos="fade-up">
              <div class="col-xl-8 stretch-card grid-margin">
                <!-- feature-hot -->
                <feature-hot></feature-hot>
              </div>
              
              <div class="col-xl-4 stretch-card grid-margin">
                  <!-- lastest-news-->
                  <latest-news></latest-news>
              </div>
              
            </div>
            <div class="row" data-aos="fade-up">
              <div class="col-lg-3 stretch-card grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h2>Category</h2>
                    <ul class="vertical-menu">
                      <li class="cursor-pointer" v-for="category in listCategories" :key="category.id"
                      @click="getCategoryId(category.id)" >
                        <a :class="{ active: category.id ===  categoryId }">{{ category.name }}</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-9 stretch-card grid-margin">
                <!-- post-by-category-->
                <post-by-category :categoryId="categoryId"></post-by-category>
              </div>
            </div>
            
            <div class="row" data-aos="fade-up">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-xl-6">
                        <!-- hot-news-->
                        <hot-news></hot-news>
                      </div>
                      <div class="col-xl-6">
                        <!-- feature-news-->
                        <feature-news></feature-news>
                      </div>
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
import FeatureHot from "./FeatureHot.vue";
import LatestNews from "./LatestNews.vue";
import PostByCategory from "./PostByCategory.vue";
import HotNews from "./HotNews.vue";
import FeatureNews from "./FeatureNews.vue";
import Foot from "../Foot.vue";


export default {
    name: 'Home',
    data() {
      return {
        listCategories: [],
        categoryId: null,
      }
    },
    components: {
        Navbar, FeatureHot, LatestNews, Weather,
        PostByCategory, HotNews, FeatureNews, Foot
    },
    methods: {
      getCategoryId(categoryId) {
        this.categoryId = categoryId;
      },
      getListCategories(){
        this.$Progress.start();
        axios.get("/api/frontend/list-categories")
         .then(res => {
            let data = res.data;
            this.listCategories = data;
            this.categoryId = data[0].id;
            this.$Progress.finish();
          })
         .catch(err => console.log(err));
      },

      
      
    },
    created() {
      this.getListCategories();

    },
    
}
</script>

<style>

</style>

