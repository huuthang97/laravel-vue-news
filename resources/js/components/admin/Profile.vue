<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white" style="background: url('/img/cover.jpg') center center;">
                        <h3 class="widget-user-username text-right">{{ this.form.name }}</h3>
                        <h5 class="widget-user-desc text-right">{{ this.form.type }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                            <h5 class="description-header">3,200</h5>
                            <span class="description-text">SALES</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                            <h5 class="description-header">13,000</h5>
                            <span class="description-text">FOLLOWERS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                            <h5 class="description-header">35</h5>
                            <span class="description-text">PRODUCTS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link " href="#activity" data-toggle="tab">Activity</a></li>
                        <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                        <div class="tab-pane" id="activity">
                           hahdhfshfdhfhah
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" placeholder="Name" v-model="form.name"
                                    :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail" placeholder="Email" v-model="form.email"
                                    :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                <div class="col-sm-10">
                                <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPhoto" class="col-sm-2 col-form-label">Profile Photo</label>
                                <div class="col-sm-10">
                                <input type="file"  id="inputPhoto" @change="updateProfile">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                <input type="password" class="form-control" id="inputPassword" placeholder="Password" v-model="form.password"
                                    :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-danger" @click.prevent="updateInfo">Update</button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: '',
                })
            }
        },
        methods: {
            getProfilePhoto() {
                let photo = ( this.form.photo.length > 200 ) ?  this.form.photo : '/img/profile/' + this.form.photo;
                return photo ;
            },
            updateInfo() {
                this.$Progress.start();
                this.form.put('/api/admin/profile')
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                        Swal.fire({
                            icon: 'error',
                            title: 'Opps',
                            text: 'You are uploading a large file'
                        });
                    })
                    
            },
            updateProfile(element) {
                let file = element.target.files[0];
                if ( file['size'] > 2100000) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps',
                        text: 'You are uploading a large file'
                    });
                    return false;
                }
                let reader = new FileReader();
                reader.onloadend = (file) =>{
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            }
        },  
        created() {
            axios.get('/api/admin/profile')
                .then((user) => {
                    this.form.fill(user.data);
                })
                .catch(() => {

                })
        }
    }
</script>
