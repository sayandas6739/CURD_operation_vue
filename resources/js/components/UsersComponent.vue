<template>
    <div>
        <div class="content-header row">
            <div class="content-header-light col-12">
                <div class="row align-items-center">
                    <div class="content-header-left col-md-9 col-12 mb-2">
                        <h3 class="content-header-title">Users</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="">Registered Users</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="content-header-right col-md-3 col-12">
                        <div class="float-md-right pt-0 pt-md-1">
                            <a href="/admin/export-users" target="_blank" class="btn btn-secondary btn-min-width waves-effect waves-light box-shadow-1 px-2 standard-button"> 
                            <i class="ft-download"></i> Export 
                            </a>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
        <div class="content-wrapper table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="wf-100">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <!-- <th>Verified On</th> -->
                        <th class="wf-120">Registered On</th>
                        <th class="wf-120">Status</th>
                        <th class="wf-80">Actions</th>
                    </tr> 
                </thead>
                <tbody>
                    <tr v-for="(user, pkey) in users.data" :key="pkey">
                        <td class="wf-100">{{ pkey+1 }}</td>
                        <td>{{ user.name | capitalize }}</td>
                        <td>{{ user.email }}</td>
                        <!-- <td class="wf-120">
                            <span class="badge badge-success" v-if="user.email_verified_at">
                                {{user.email_verified_at | setusdate}}
                            </span>
                            <span class="badge badge-warning" v-else>
                                Not Verified
                            </span>
                        </td> -->
                        <td class="wf-120">{{user.created_at | setusdate}}</td>
                        <td class="wf-120">
                            <span class="badge badge-success" v-if="user.status_id == 2">
                                Active
                            </span>
                            <span class="badge badge-warning" v-else>
                                Deactive
                            </span>
                        </td>
                        <td class="text-right">
                            <a href="javascript:;" class="table-icon-btn waves-effect waves-light" @click="editUser(user)">
                                <i class="ft-edit"></i>
                            </a>
                            <a href="javascript:;" class="table-icon-btn waves-effect waves-light"  @click="deleteUser(user.id)">
                                <i class="ft-trash-2"></i>
                            </a>
                        </td>
                    </tr> 
                </tbody>
            </table>
            <pagination :data="users" @pagination-change-page="getusers"></pagination>
        </div>
        <div class="modal fade text-left" id="downForm" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title" v-if="editmode"> Edit User Details</h3>
                        <h3 class="modal-title" v-else> Add New User</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="ft-x text-secondary" aria-hidden="true"></i>
                        </button>
                    </div>
                    <form  @submit.prevent="updateUser">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="text-uppercase">Name</label>
                                <input name="name" class="form-control border" type="text" placeholder="Enter name" required v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label class="text-uppercase">Email</label>
                                <input name="email" class="form-control border" type="email" placeholder="Enter Email" required v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group my-2">
                                <label class="d-inline-block mr-1 text-uppercase mb-1 font-weight-bold">Activate  </label>
                                <div class="d-inline-block custom-control custom-radio mr-1">
                                    <input type="radio" v-model="form.status_id" name="status" class="custom-control-input" id="yes1" value="2">
                                    <label class="custom-control-label" for="yes1">Yes</label>
                                </div>
                                <div class="d-inline-block custom-control custom-radio">
                                    <input type="radio" v-model="form.status_id" name="status" class="custom-control-input" id="no1" value="1">
                                    <label class="custom-control-label" for="no1">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="mt-1 d-flex justify-content-end">
                                <button type="submit" class="btn btn-dark btn-glow text-white">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
#downForm{
    height: calc(100vh - 2rem);
}
</style>
<script>
    export default {
        data() {
            return {
                imgurl: '/images/',
                editmode: false,
                users: {},
                form: new Form({
                    id:'',
                    email:'',
                    name:'',
                    password:'',
                    status_id:'',
                    email_verified_at:''
                }),
            }
        },
        methods: {
            getusers(page = 1) {
                axios.get('/api/users?page=' + page).then((response) => { this.users = response.data });
            },
            btoa(id) {
                return btoa(id);
            },
            updateUser() {
                this.form.post('/api/users/'+this.form.id)
                .then(() => {
                    this.$Progress.start();
                    Fire.$emit('AfterCreate');
                    $('#downForm').modal('hide');
                    toast.fire({
                        type:'success',
                        title:'User updated successfully'
                    });
                    this.$Progress.finish();
                })
                .catch((err) => {
                    console.log(err);
                });
            },
            editUser(user) {
                this.editmode = true;
                this.form.fill(user);
                $('#downForm').modal('show');
            },
            deleteUser(id) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#38c172',
                    cancelButtonColor: '#e3342f',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('/api/users/'+id)
                            .then(() => {
                                swal.fire('Deleted!', 'Record has been deleted.', 'success');
                                Fire.$emit('AfterCreate');
                            })
                            .catch(() => {
                                swal.fire('Not Deleted!', 'Record can not be deleted.', 'error');
                            });
                    }
                });
            }
        },
        mounted() {
            this.getusers();
            Fire.$on('AfterCreate', () => {
                this.getusers();
            }); 
        }
    }
</script>

