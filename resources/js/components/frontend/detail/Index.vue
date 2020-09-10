<template>
    


    <div class="container-scroller">
      <div class="main-panel">
        <!-- partial:partials/_navbar.html -->
        <navbar></navbar>

        <!-- partial -->
        <weather></weather>
        
        <!-- content-wrapper -->
        <!-- <router-view></router-view> -->


        <div class="content-wrapper">
          <div class="container">
            <div class="row">

                <!-- Post Content Column -->
                <div class="col-lg-8">

                    <!-- Title -->
                    <h1 class="mt-4">{{ post.title }}</h1>

                    <hr>

                    <!-- Date/Time -->
                    <p>{{ post.created_at | transfromDay}}</p>

                    <hr>

                    <!-- Preview Image -->
                    <!-- <img class="img-fluid rounded" :src="'/img/posts/' + post.avatar" alt=""> -->

                    <hr>

                    <!-- Post Content -->
                    <div v-html="post.content">

                    </div>

                    <hr>

                    <!-- Comments Form -->
                    <!-- <div class="card my-4">
                        <h5 class="card-header">Leave a Comment:</h5>
                        <div class="card-body">
                            <form>
                            <div class="form-group">
                                <textarea class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div> -->

                    <!-- Single Comment -->
                    <!-- <div class="media mb-4">
                        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                        <div class="media-body">
                            <h5 class="mt-0">Commenter Name</h5>
                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        </div>
                    </div> -->

                    <!-- Comment with nested comments -->
                    <!-- <div class="media mb-4">
                        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                        <div class="media-body">
                            <h5 class="mt-0">Commenter Name</h5>
                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.

                            <div class="media mt-4">
                            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                            <div class="media-body">
                                <h5 class="mt-0">Commenter Name</h5>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                            </div>

                            <div class="media mt-4">
                            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                            <div class="media-body">
                                <h5 class="mt-0">Commenter Name</h5>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                            </div>

                        </div>
                    </div> -->

                </div>

                <!-- Sidebar Widgets Column -->
                <div class="col-md-4">
                    <!-- related-post -->
                    <related-post></related-post>

                </div>

            </div>
            <!-- /.row -->
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
import RelatedPost from "./RelatedPost.vue";

export default {
    name: 'Detail',
    components: {
      Navbar, Weather, Foot, RelatedPost
    },
    data() {
        return {
            post: {}
        }
    },
    watch: {
        $route (to, from){
            this.getPostDetail();
        }
    },  
    filters: {
        transfromDay(value) {
            return moment(value).add(10, 'days').calendar();
        }
    },
    methods: {
        getPostDetail() {
          this.$Progress.start();
            let path = this.$route.path;
            let slug = path.split("/").pop();
            axios.get("/api/frontend/detail/" + slug)
                .then(res => {
                  this.post = res.data;
                  this.$Progress.finish();
                })
                .catch(err => console.log(err));
        }
    },
    created() {
        this.getPostDetail();
    },
}
</script>

<style>

</style>