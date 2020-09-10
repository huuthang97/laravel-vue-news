<template>
    <div class="container">
      <div class="row">
        <div class="col-md-12 mb-3 mt-2 ml-3">
          <h3 class="d-inline">New Post</h3>
          <router-link to="/admin/posts" type="button" class="btn btn-primary float-right">Return</router-link>
        </div>
        <div class="col-md-12">
          <form @submit.prevent="createPost()">
              <div class="modal-body">
                <div class="form-group">
                    <select v-model="form.category_id" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('category_id') }">
                        <option value="">Select a category</option>
                        <option :value="category.id" v-for="category in categories" :key="category.id">{{ category.name }}</option>
                    </select>
                    <has-error :form="form" field="category_id"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.title" type="text" name="title"
                    placeholder="Title"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                  <has-error :form="form" field="title"></has-error>
                </div>

                <div class="form-group">
                  <textarea v-model="form.description" name="description" id="description" rows="4"
                    placeholder="Description"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                  </textarea>
                  <has-error :form="form" field="description"></has-error>
                </div>

                <div class="form-group">
                  <label>Avatar</label>
                  <input type="file" name="avatar" class="form-control" @change="changeAvatar">
                </div>

                <div class="form-group">
                  <img :src="form.avatar" alt="" width="200" >
                </div>

                <div class="form-group">
                  <label>Content</label>
                  <vue-editor v-model="form.content" name="content" max-heigt="400px"
                    :class="{ 'is-invalid': form.errors.has('content') }">
                  </vue-editor>
                  <has-error :form="form" field="content"></has-error>
                </div>

                <div class="form-gr">
                  <label>Tags</label>
                  <input-tag v-model="form.tags" class="form-control mb-4"></input-tag>
                </div>

                <div class="form-group">
                    <label> Status</label>
                    <select v-model="form.post_status" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('post_status') }">
                        <option value="">Select status</option>
                        <option value="0">Not Approved</option>
                        <option value="1">Approved</option>
                    </select>
                    <has-error :form="form" field="post_status"></has-error>
                </div>

                <div class="form-group">
                    <label> Hot?</label>
                    <select name="hot" v-model="form.hot" id="hot" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('hot') }">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    <has-error :form="form" field="hot"></has-error>
                </div>

                <div class="form-group">
                    <label> Feature?</label>
                    <select name="feature" v-model="form.feature" id="feature" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('feature') }">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    <has-error :form="form" field="feature"></has-error>
                </div>

              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Create</button>
              </div>
        </form>
        </div>
      </div>
        
    </div>
</template>

<script>
import InputTag from 'vue-input-tag';

    export default {
      name: 'new',
      data () {
          return {
            categories: [],
            form: new Form({
              category_id: '',
              title: '',
              description: '',
              avatar: '',
              content: '',
              tags: [],
              post_status: '',
              hot: '',
              feature: '',
            })
          }
      },
      components: {
        InputTag
      },
      methods: {
        changeAvatar(element) {
          let file = element.target.files[0];
          let reader = new FileReader();
          reader.onloadend = () => {
            this.form.avatar = reader.result;
          }
          reader.readAsDataURL(file);
        },
        createPost() {
          if (this.form.avatar.length === 0) {
            alert ("Please add a avatar!");
            return;
          }
          this.$Progress.start();
          this.form.post('/api/admin/post').then(() => {
            Toast.fire({
              icon: 'success',
              title: 'Created post successfully'
            });
          })
          .catch((err) => console.log(err));
          this.$Progress.finish();
        },
        getCategoriesList() {
          if ( this.$gate.isAdminOrAuthor() ) {
            axios.get('/api/admin/category').then(res => (this.categories = res.data));
          }
        }
      },
      created() {
        this.getCategoriesList();

      },
    }
</script>
