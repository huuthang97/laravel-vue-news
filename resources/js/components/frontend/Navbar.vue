<template>
    <header id="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="navbar-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <ul class="navbar-top-left-menu">
                            <li class="nav-item active">
                                <router-link class="nav-link" to="/">Home</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link" to="/contact">Contact</router-link>
                            </li>
                        </ul>
                        <ul class="navbar-top-right-menu">
                            <!-- <li class="nav-item">
                                <a href="#" class="nav-link"><i class="mdi mdi-magnify"></i></a>
                            </li> -->
                            <li class="nav-item">
                                <a href="/admin/login" class="nav-link">Admin</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="#" class="nav-link">Sign in</a>
                            </li> -->
                        </ul>
                    </div>
                </div>
                <div class="navbar-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <router-link class="navbar-brand" to="/"
                                ><img src="/frontend/images/logo.svg" alt="logo"
                            /></router-link>
                        </div>
                        <div>
                            <button
                                class="navbar-toggler"
                                type="button"
                                data-target="#navbarSupportedContent"
                                aria-controls="navbarSupportedContent"
                                aria-expanded="false"
                                aria-label="Toggle navigation"
                            >
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div
                                class="navbar-collapse justify-content-center collapse"
                                id="navbarSupportedContent"
                            >
                                <ul
                                class="navbar-nav d-lg-flex justify-content-between align-items-center"
                                >
                                <li>
                                    <button class="navbar-close">
                                    <i class="mdi mdi-close"></i>
                                    </button>
                                </li>

                                <li class="nav-item" v-for="category in categories" :key="category.id">
                                    <router-link class="nav-link" :to="'/category/' + category.slug">{{ category.name }}</router-link>
                                </li>
                              
                                
                                </ul>
                            </div>
                        </div>
                        <ul class="social-media">
                        <li>
                            <a href="#">
                            <i class="mdi mdi-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <i class="mdi mdi-youtube"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <i class="mdi mdi-twitter"></i>
                            </a>
                        </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
</template>

<script>
export default {
    name: "Navbar",
    data() {
        return {
            categories: {}
        }
    },
    methods: {
        getListCategories() {
            axios.get("/api/frontend/list-categories")
                .then(res => this.categories = res.data)
                .catch(err => console.log(err));
        }
    },
    created() {
        this.getListCategories();
    },
}
</script>

<style>

</style>