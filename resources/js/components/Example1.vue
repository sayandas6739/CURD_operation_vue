<template>
    <div class="container">
        <span v-bind:title="message">
            <h3>Welcome to vue.js</h3>
            <button v-on:click="reverseMessage" class="btn btn-info btn-md">Reverse</button>
            <pagination :data="users" @pagination-change-page="getusers"></pagination>
            <p v-if="valid">True</p>
        </span>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                message: 'This is my first project',
                valid: false
            }
        },
        method: {
                reverseMessage: function(){
                this.message = this.message.split('').reverse().join('')
            }
        },
        mounted() {
            //console.log('Component mounted.')
        }
    }
</script>