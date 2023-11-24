<template>
    <div class="modal" v-if="show">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Account</h5>
                    <button type="button" class="close" @click="closeChangePassModal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="saveAccount">
                        <div class="mb-4">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">New Password</label>
                            <input type="password" name="password" id="password" v-model="fields.password" class="input-field" autocomplete="new-password">
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" v-model="fields.password_confirmation" class="input-field" autocomplete="new-password" @input="checkPasswordMatch">
                            <p v-if="fields.password_confirmation && !passwordMatch" class="text-red-600">Password and Confirm Password do not match.</p>
                        </div>
                        <div class="text-center mb-4">
                            <button type="submit" class="bg-green text-white rounded px-4 py-2">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
  import axios from 'axios';
  
  export default {
    props: {
      show: Boolean,
      fields: {
        password: '',
      },
    },

    data() {
      return {
        passwordMatch: true
      };
    },
  
    methods: {
      initialData() {
        axios.get(`/userlist`).then((response) => {
          this.user_list = response.data;
          // Initially, display the complete User list
          this.filteredUserList = this.user_list;
        });
      },
  
      closeChangePassModal() {
        this.$emit('close'); // Emit the 'close' event to close the modal
      },
  
      // edit(id){
      //   axios.get(`/user-data/${id}`).then(response=> {
      //       this.fields = response.data;
      //   });
      // },
  
      checkPasswordMatch() {
        this.passwordMatch = this.fields.password === this.fields.password_confirmation;
      },
  
      clearFormFields() {
        this.fields = {};
      },

      edit(id) {
        axios.get(`/user-data/${id}`).then(response => {
          this.fields = response.data;
        });
      },

      saveAccount() {
        axios.post('/submit-edit-form', this.fields).then((response) => {
          if (response.data) {
            // User data has been updated successfully
            alert('User updated successfully');
            this.$emit('close');
          } else {
            alert('Error while updating user data');
          }
        });
      },

    },
  };
  </script>
  
  <style scoped>
    .modal-title {
      color: rgb(1, 72, 1); 
      text-align: center;
      font-size: 20px; 
      display: block; 
      margin: 0 auto; 
    }
  
    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
  
    .modal-content {
      background-color: white;
      border-radius: 8px; /* Increase the border radius for rounded corners */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 400px; /* Adjust the maximum width to widen the modal */
    }
  
    .modal-dialog {
      background-color: white;
      border-radius: 8px; /* Increase the border radius for rounded corners */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 400px; /* Increase the maximum width to widen the modal */
    }
  
    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #ccc;
    }
  
    .modal-title {
    font-size: 20px;
    }
  
    .modal-body {
      padding: 20px;
      text-align: left;
    }
  
    .input-field {
      background-color: #F3F4F6;
      border: 1px solid #D1D5DB;
      color: #111827;
      font-size: 14px;
      border-radius: 8px;
      padding: 10px;
      outline: none;
      width: 100%;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
  
  
    .close {
      cursor: pointer;
    }
  </style>