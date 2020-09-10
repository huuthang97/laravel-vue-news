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
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card" data-aos="fade-up">
                            <div class="card-body">
                                <div class="aboutus-wrapper">
                                    <h1 class="mt-5 text-center mb-5">
                                        Contact Us
                                    </h1>
                                    <div class="row">
                                        <div class="col-lg-12 mb-5 mb-sm-2">
                                            <form @submit.prevent="sendContact">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <textarea
                                                            class="form-control textarea"
                                                            placeholder="Content *"
                                                            id="message"
                                                            v-model="form.content"
                                                            :class="{ 'is-invalid': form.errors.has('content') }"
                                                            ></textarea>
                                                            <has-error :form="form" field="content"></has-error>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <input
                                                            type="text"
                                                            class="form-control"
                                                            id="name"
                                                            aria-describedby="name"
                                                            placeholder="Name *"
                                                            v-model="form.name"
                                                            :class="{ 'is-invalid': form.errors.has('name') }"
                                                            />
                                                            <has-error :form="form" field="name"></has-error>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <input
                                                            type="email"
                                                            class="form-control"
                                                            id="email"
                                                            aria-describedby="email"
                                                            placeholder="Email *"
                                                            v-model="form.email"
                                                            :class="{ 'is-invalid': form.errors.has('email') }"
                                                            />
                                                            <has-error :form="form" field="email"></has-error>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <button
                                                        type="submit"
                                                        class="btn btn-lg btn-dark font-weight-bold mt-3"
                                                        >Send Message</button
                                                        >
                                                    </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
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
import Navbar from "./Navbar.vue";
import Weather from "./Weather.vue";
import Foot from "./Foot.vue";


export default {
    name: 'Contact',
    components: {
        Navbar, Weather, Foot
    },
    data() {
      return {
        form: new Form({
            content: '',
            name: '',
            email: ''
        })
      }
    },
    methods: {
        sendContact() {
            this.$Progress.start();
            this.form.post('/api/frontend/contact')
                .then(data => {
                    this.$Progress.finish();
                    Toast.fire({
                        icon: 'success',
                        title: 'Sent successfully'
                    });
                    this.form.reset();
                    })
                .catch(err => console.log(er))
        }
      
    },
    created() {
      


      
    },
    
}
</script>

<style>

</style>

