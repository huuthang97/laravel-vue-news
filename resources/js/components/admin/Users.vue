<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table {{ $gate.isAdmin() }}</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-success" @click="newModal">
                    Add new 
                    <i class="fa fa-user-plus fa-fw"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Register At</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                      <td>{{ user.id }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.type | upText }}</td>
                      <td>{{ user.created_at | myDate }}</td>
                      <td>
                          <a @click="editUser(user)" style="cursor: pointer">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          /
                          <a @click="deleteUser(user.id)" style="cursor: pointer">
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
                <pagination :data="users" @pagination-change-page="getResults"></pagination>
              </div>
              <!-- /.card-footer -->

            </div>
            <!-- /.card -->
          </div>
        </div>

        <div v-else>
          <not-found></not-found>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewLabel" v-show="!editMode">New User</h5>
                <h5 class="modal-title" id="addNewLabel" v-show="editMode">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editMode ? updateUser() : createUser()">
            <div class="modal-body">
              <div class="form-group">
                <input v-model="form.name" type="text" name="name"
                  placeholder="Name"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
              </div>

              <div class="form-group">
                <input v-model="form.email" type="text" name="email"
                  placeholder="Email Address"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                <has-error :form="form" field="email"></has-error>
              </div>

              <div class="form-group">
                <textarea v-model="form.bio" name="bio" id="bio"
                placeholder="Short bio for user (Optional)"
                class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                <has-error :form="form" field="bio"></has-error>
              </div>

              <div class="form-group">
                  <select name="type" v-model="form.type" id="type" class="form-control"
                  :class="{ 'is-invalid': form.errors.has('type') }">
                      <option value="">Select User Role</option>
                      <option value="admin">Admin</option>
                      <option value="user">Standard User</option>
                      <option value="author">Author</option>
                  </select>
                  <has-error :form="form" field="type"></has-error>
              </div>

              <div class="form-group">
                <input v-model="form.password" type="password" name="password" id="password"
                placeholder="******"
                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                <has-error :form="form" field="password"></has-error>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" v-show="!editMode">Create</button>
                <button type="submit" class="btn btn-success" v-show="editMode">Update</button>
            </div>
            </form>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
      data () {
          return {
            editMode: false,
            users: {},
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
          getResults(page = 1) {
            axios.get('/api/admin/user?page=' + page)
              .then(response => {
                this.users = response.data;
              });
          },
          updateUser() {
            let id = this.form.id;
            this.form.put(`/api/admin/user/${this.form.id}`)
              .then(() => {
                $("#addNew").modal('hide');
                Fire.$emit('AfterCreate');
                Toast.fire({
                  icon: 'success',
                  title: 'updated user successfully'
                });
              })
              .catch(()=>{
                Swal.fire(
                  'Failed!',
                  'There was something wronged.',
                  'warning'
                )
              });

          },
          newModal() {
            this.editMode = false;
            this.form.reset();
            $('#addNew').modal('show');
          },
          editUser(user) {
            this.editMode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(user);
          },
          deleteUser(id) {
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              this.form.delete(`/api/admin/user/${id}`);
              Fire.$emit('AfterCreate');
              if (result.value) {
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
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
          loadUsers() {
            if ( this.$gate.isAdminOrAuthor() ) {
              axios.get('/api/admin/user').then(res => (this.users = res.data));
            }
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
          }
        },
        created() {
            Fire.$on('searching',() => {
              this.$Progress.start();
              let query = this.$parent.search;
              axios.get('/api/admin/findUsers?q=' + query)
                .then((res)=> {
                  this.users = res.data;
                  this.$Progress.finish();
                })
                .catch(()=> {
                  this.$Progress.fail();
                });
            });
            this.loadUsers();
            Fire.$on('AfterCreate', () => {
              this.loadUsers();
            })
            // setInterval(()=> this.loadUsers() ,3000);
        }
    }
</script>
