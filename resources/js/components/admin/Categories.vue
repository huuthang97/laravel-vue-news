<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Category Table</h3>

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
                      <th>Status</th>
                      <th>Register At</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="category in categories" :key="category.id">
                      <td>{{ category.id }}</td>
                      <td>{{ category.name }}</td>
                      <td>{{ category.status | transformStatus}}</td>
                      <td>{{ category.created_at | myDate }}</td>
                      <td>
                          <a @click="editUser(category)" style="cursor: pointer">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          /
                          <a @click="deleteCategory(category.id)" style="cursor: pointer">
                              <i class="fa fa-trash red"></i>
                          </a>
                          
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

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
                <h5 class="modal-title" id="addNewLabel" v-show="!editMode">New Category</h5>
                <h5 class="modal-title" id="addNewLabel" v-show="editMode">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editMode ? updateCategory() : createCategory()">
            <div class="modal-body">
              <div class="form-group">
                <input v-model="form.name" type="text" name="name"
                  placeholder="Name"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
              </div>
              <div class="form-group">
                  <select name="status" v-model="form.status" id="status" class="form-control"
                  :class="{ 'is-invalid': form.errors.has('status') }">
                      <option >Select Status</option>
                      <option value="0"> Not Approved</option>
                      <option value="1">Approved</option>
                  </select>
                  <has-error :form="form" field="status"></has-error>
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
            categories: {},
            form: new Form({
              id: '',
              name: '',
              status: '',
            })
          }
      },
      filters: {
        transformStatus: function(value) {
          let result = "";
          if (value === 0) {
            result = "Not Approved";
          }
          else if (value === 1) {
            result = "Approved";
          }
          return result;
        }
      },
      methods: {
        updateCategory() {
          let id = this.form.id;
          this.form.put(`/api/admin/category/${this.form.id}`)
            .then(() => {
              $("#addNew").modal('hide');
              Fire.$emit('ReloadCategoriesList');
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
        deleteCategory(id) {
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            this.form.delete(`/api/admin/category/${id}`);
            Fire.$emit('ReloadCategoriesList');
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
        loadCategories() {
          if ( this.$gate.isAdminOrAuthor() ) {
            axios.get('/api/admin/category').then(res => this.categories = res.data);
          }
        },
        createCategory() {
          this.$Progress.start();
          this.form.post('/api/admin/category').then(() => {
            $('#addNew').modal('hide');
            Toast.fire({
              icon: 'success',
              title: 'Created user successfully'
            });
          });
          Fire.$emit('ReloadCategoriesList');
          this.$Progress.finish();
        }
      },
      created() {
          this.loadCategories();
          Fire.$on('ReloadCategoriesList', () => {
            this.loadCategories();
          })
      }
    }
</script>
