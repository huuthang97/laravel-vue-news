<template>
    <div class="container-fluid">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table {{ $gate.isAdmin() }}</h3>

                <div class="card-tools">
                  <router-link to="/admin/posts/new" type="button" class="btn btn-success">
                    Add new 
                    <i class="fa fa-user-plus fa-fw"></i>
                  </router-link>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Avatar</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th>Feature</th>
                      <th>Hot</th>
                      <th>View</th>
                      <th>Register At</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="post in posts.data" :key="post.id">
                      <td>{{ post.id }}</td>
                      <td>{{ post.title }}</td>
                      <td><img :src="'/img/posts/' + post.avatar" alt="avatar" width="150"></td>
                      <td>{{ post.name }}</td>
                      <td>{{ post.post_status | transformStatus}}</td>
                      <td>{{ post.feature }}</td>
                      <td>{{ post.hot }}</td>
                      <td>{{ post.view }}</td>
                      <td>{{ post.created_at | myDate }}</td>
                      <td>
                          <a @click="editPost(post)" style="cursor: pointer">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          /
                          <a @click="deletePost(post.id)" style="cursor: pointer">
                              <i class="fa fa-trash red"></i>
                          </a>
                          
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <!-- .card-footer -->
              <div class="card-footer">
                <pagination :data="posts" @pagination-change-page="getResults"></pagination>
              </div>
              <!-- /.card-footer -->

            </div>
            <!-- /.card -->
          </div>
        </div>

        <div v-else>
          <not-found></not-found>
        </div>
    </div>
</template>

<script>
    export default {
      name: 'index',
      data () {
          return {
            posts: {},
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
        filters: {
          transformStatus: function(value) {
            let result = "";
            if ( value === 0 ) {
              result = "Not Approved";
            }
            else if ( value === 1) {
              result = "Approved";
            }
            return result;
          }
         
        },
        methods: {
          getResults(page = 1) {
            axios.get('/api/admin/post?page=' + page)
              .then(response => {
                this.posts = response.data;
              });
          },
          
          editPost(post) {
            this.$router.push("/admin/posts/edit?slug=" + post.slug);
          },
          createUser() {
            this.$Progress.start();
            this.form.post('/api/admin/user').then(() => {
              $('#addNew').modal('hide');
              Toast.fire({
                icon: 'success',
                title: 'Created user successfully'
              });
            });
            Fire.$emit('AfterCreate');
            this.$Progress.finish();
          },
          deletePost(id) {
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                  this.form.delete(`/api/admin/post/${id}`);
                  Fire.$emit('reloadPost');
                  Swal.fire(
                    'Deleted!',
                    'Your post has been deleted.',
                    'success'
                  )
                }
            }).catch(()=>{
              Swal.fire(
                  'Failed!',
                  'There was something wronged.',
                  'warning'
                )
            })
          },
        },
        created() {
          if ( this.$gate.isAdminOrAuthor() ) {
            this.getResults();
          }
          Fire.$on("reloadPost", () => this.getResults());
        }
    }
</script>
