<template>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-12 offset-lg-2 offset-md-2">
            <form @submit.prevent="createUsers">
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <label class="sr-only" for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Name" name="name" required="" v-model="newItem.name">
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">Email</label>
                    <input type="email" class="form-control" id="inlineFormInputGroup" placeholder="Email" name="email" required="" v-model="newItem.email"> 
                </div>
    
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary" >Submit</button>
                </div>
            </div>
        </form>
        </div>
        <table class="table col-lg-8 col-md-8 col-12 offset-lg-2 offset-md-2">
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created at</th>
                <th>Action</th>
            </thead>
            <tbody>
                <tr v-for="(user, pkey) in users" :key="pkey" >
                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.created_at}}</td>
                    <td><button class="btn btn-info btn-sm" @click="showModal=true; setVal(user.id, user.name, user.email)" data-target="#edit_modal" data-toggle="modal">EDIT</button>
                    <button class="btn btn-danger btn-sm" @click.prevent="deleteUser(user)">DELETE</button></td>
                </tr>
            </tbody>
        </table>

        <div class="modal fade" tabindex="-1" role="dialog" v-if="showModal" @close="showModal=false" id="edit_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                                <label class="sr-only" for="update_id">ID</label>
                                <input type="hidden" class="form-control" id="update_id" placeholder="Name" name="update_id" required="" :value="this.update_id">
                            </div>
                            <div class="col-auto">
                                <label class="sr-only" for="update_name">Name</label>
                                <input type="text" class="form-control" id="update_name" placeholder="Name" name="update_name" required="" :value="this.update_name">
                            </div>
                            <div class="col-auto">
                                <label class="sr-only" for="update_email">Email</label>
                                <input type="email" class="form-control" id="update_email" placeholder="Email" name="update_email" required="" :value="this.update_email"> 
                            </div>
                
                        </div>
                        
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="updateUser()" data-dismiss="modal">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="showModal=false">Close</button>
                    </div>
                </div>
               
                </div>
            </div>
        </div>
        <!-- <div class="modal fade text-left" id="edit_modal" tabindex="-1" role="dialog">
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
                        </div>
                        <div class="modal-footer">
                            <div class="mt-1 d-flex justify-content-end">
                                <button type="submit" class="btn btn-dark btn-glow text-white">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
    </div>
    
    
</template>

<script>
export default {
    data(){
        return{
            users: {},
            newItem: {'name': '', 'email': ''},
            showModal: false,
            // form: new Form({
            //     id: '',
            //     name: '',
            //     email: ''
            // }),
            update_id: '',
            update_name: '',
            update_email: '',

        }
    },

    methods:{
        getusers() {
            var _this = this;
                axios.get('/api/users').then(function(response)  { 
                    _this.users = response.data; 
                    });
        },
        setVal(val_id, val_name, val_email){
            this.update_id = val_id;
            this.update_name = val_name;
            this.update_email = val_email;
        },
        createUsers(){
            var _this = this;
            var input = this.newItem;
                axios.post('/api/users', input).then(function(response) {
                    _this.newItem = {'name': '', 'email': ''}
                    _this.getusers();
                    });
        },
        deleteUser(user){
            var _this = this;
            axios.delete('/api/users/'+user.id).then(function(response){
                _this.getusers();
            });
        },
        updateUser(){
            var _this = this;
            var user_id = document.getElementById("update_id");
            var user_name = document.getElementById("update_name");
            var user_email = document.getElementById("update_email");
            axios.put('/api/users/'+user_id.value, {val1: user_name.value, val2: user_email.value}).then(function(response){
                _this.getusers();
                _this.showModal = false;
            });

        }

        // editUser(user){
        //     this.editmode = true;
        //     this.form.fill(user);
        //     $('#edit_modal').modal('show');
        // },
        // updateUser() {
        //         this.form.put('/api/users/'+this.form.id)
        //         .then(() => {
        //             this.$Progress.start();
        //             Fire.$emit('AfterCreate');
        //             $('#edit_modal').modal('hide');
        //             toast.fire({
        //                 type:'success',
        //                 title:'User updated successfully'
        //             });
        //             this.$Progress.finish();
        //         })
        //         .catch((err) => {
        //             console.log(err);
        //         });
        //     },
        // deleteUser(id){
        //     swal.fire({
        //         title: 'Delete user?',
        //         text: 'Are you sure?',
        //         type: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'Delete',

        //     }).then((result)=>{
        //         this.form.delete('api/users'+id)
        //         .then(()=>{
        //             swal.fire('Deleted', 'Data has been deleted', 'success');
        //             Fire.$emit('AfterCreate');
        //         })
        //         .catch(()=>{
        //             swal.fire('Not Deleted!', 'Record not deleted', 'error');
        //         })
        //     })
        // }
    },
    mounted(){
 this.getusers();       
//    Fire.$on('AfterCreate', () => {
//                 this.getusers();
//             });  
    }
}
</script>