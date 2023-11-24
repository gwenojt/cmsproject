<template>
  <div class="flex items-center justify-center py-4">
    <div class="flex items-center justify-center py-4">
      <button @click="openModal" class="mt-12w-52 shadow bg-green text-white hover:opacity-80 focus:shadow-outline focus:outline-none font-bold py-2 px-4 rounded-lg" style="align-items: center;">
        ADD ACCOUNT
      </button>
      <manage-acc-modal :show="showModal" @close="closeModal" :fields="fields" @save="saveAccount"/>
    </div>
  </div>

    <!-- Start of the table -->
  <div class="max-w-9xl mx-auto sm:px-6 lg:px-8" style="margin-top:50px;">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6 bg-gray body">
        <div>
          <h3 class="content-heading">
            RECENTLY UPLOADED ACCOUNTS
          </h3>
        </div>
          <div class="flex justify-center py-3">
            <div>
              <div class="mb-3">
                <div class="relative mb-4 flex justify-center flex-wrap items-stretch" style="width: 600px;">
                  <input
                    type="search"
                    class="relative m-0 -mr-0.5 textArea block w-[1px] min-w-0 flex-auto rounded border bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                    placeholder="Search"
                    aria-label="Search"
                    aria-describedby="button-addon1"
                    v-model="searchQuery"
                    @input="filterUser"
                  />
                </div>
              </div>
            </div>
          </div>
        <div v-if="filteredUserList.length > 0" class="table-container">
          <table class="table" >
            <thead class="thead items-center">
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Access</th>
              <th>Status</th>
              <th>Action</th>
            </thead>
            <tbody>
              <tr v-for="(user, index) in filteredUserList" :key="index" class="row">
                <td style="width: 30px; text-align:center; padding: 15px;">{{ index + 1 }}</td>
                <td style="width: 500px; text-align:center; padding: 15px;">{{user.name}}</td>
                <td style="width: 500px; text-align:center; padding: 15px;">{{user.email}}</td>
                <td style="width: 100px; text-align:center; padding: 15px;">{{roleLabels[user.role]}}</td>
                <td style="width: 500px; text-align:center; padding: 15px;">
                  <ul class="no-bullet-list">
                    <li>
                    {{ user.access && user.access.generic_pages === 1 ? 'Generic Pages' : '' }}
                  </li>
                  <li>
                    {{ user.access && user.access.faq === 1 ? 'FAQ' : '' }}
                  </li>
                  <li>
                    {{ user.access && user.access.articles === 1 ? 'Articles' : '' }}
                  </li>
                  <li>
                    {{ user.access && user.access.images === 1 ? 'Images' : '' }}
                  </li>
                  <li>
                    {{ user.access && user.access.accounts === 1 ? 'Accounts' : '' }}
                  </li>
                  </ul>
                </td>
                <td style="width: 200px; text-align:center; padding: 15px;">
                  <button @click="toggleUserStatus(user)" class="buttonDelTable items-center shadow text-white bg-green" :class="{ 'bg-red': user.status === 'deactive' }">
                    {{ user.status === 0 ? 'ACTIVATE' : 'DEACTIVATE' }}
                  </button>
                </td>
                <td style="width: 300px; text-align:center; padding: 15px;">
                  <button @click="edit(user.id)" >
                    <img src="/images/edit.svg" alt="" class="icon">
                  </button>
                  <edit-acc-modal :show="showEditAccModal" @close="closeEditAccModal" :fields="fields" @save="saveEditedData" />

                  <button @click="editPass(user.id)" >
                    Change Password
                  </button>
                  <change-password-modal :show="showChangePasswordModal" @close="closeChangePasswordModal" :fields="fields" @save="saveEditedData" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <p v-if="noMatchMessage" class="message">{{ noMatchMessage }}</p>
      </div>
    </div>
  </div>
    <!-- End of the table -->
</template>

<script>
  import ManageAccModal from '@/Components/ManageAccModal.vue';
  import EditAccModal from '@/Components/EditAccModal.vue';
  import ChangePasswordModal from '@/Components/ChangePasswordModal.vue';
  import axios from 'axios';
  
  export default {

    components: {
      ManageAccModal,
      EditAccModal,
      ChangePasswordModal,
    },

    data() {
      return {
        fields: {
          name: '',
          email: '',
          role: '',
          password: ''
        },
        user_list: [],
        searchQuery: "", 
        filteredUserList: [], 
        noMatchMessage: "",
        showModal: false,
        editingUserId: null,
        showEditAccModal: false,
        showChangePasswordModal: false,

        roleLabels: {
          1: 'Admin',
          2: 'Librarian',
        },
      };
    },

    created() {
      this.initialData();
    },

    methods: {
      openModal() {
        this.showModal = true;
        this.fields = {
          name: '',
          email: '',
          role: '',
        };
      },

      closeModal() {
        this.showModal = false;
      },

      openChangePasswordModal() {
        this.showChangePasswordModal = true;
        this.fields = {
          password: '',
        };
      },

      closeChangePasswordModal() {
        this.showChangePasswordModal = false;
      },

      // initialData() {
      //   axios.get(`/userlist`).then((response) => {
      //     this.user_list = response.data;

      //     // Fetch user statuses
      //     // this.user_list.forEach((user) => {
      //     //   this.getUserStatus(user);
      //     // });

      //     // Initially, display the complete User list
      //     this.filteredUserList = this.user_list;
      //   });
      // },

      initialData() {
          axios.get(`/userlist`).then((response) => {
              this.user_list = response.data;

              // Fetch user access data
              this.user_list.forEach(async (user) => {
                  await this.getUserAccess(user);
              });

              // Initially, display the complete User list
              this.filteredUserList = this.user_list;
          });
      },

      async getUserAccess(user) {
          await axios.get(`/get-user-access/${user.id}`).then((response) => {
              user.access = response.data;
          });
      },

      edit(id){
        axios.get(`/user-data/${id}`).then(response=> {
          this.openEditAccModal();
          this.fields = response.data;
        });
      },

      editPass(id){
        axios.get(`/user-data/${id}`).then(response=> {
          this.openChangePasswordModal();
          this.fields = response.data;
        });
      },

      openEditAccModal() {
        this.showEditAccModal = true;
      },

      closeEditAccModal() {
        this.showEditAccModal = false;
      },

      getUserStatus(user) {
        axios.get(`/get-user-status/${user.id}`).then((response) => {
          user.status = response.data.status;
        });
      },
      
      activateUser(id){
        if(confirm('Are you sure to activate this account?')){
          axios.post('/activate-acc/'+id).then((response) => {
            alert('Account successfully Activated!');
          }).catch((error) => {
            alert('Error while activating: ' + error);
          });
        }else{
          alert('Cancelled!');
        }
      },

      deactivateUser(id){
        if(confirm('Are you sure to deactive this account?')){
          axios.post('/deactivate-acc/'+id).then((response) => {
            alert('Account succesfully Deactivated!');
          }).catch((error) => {
            alert('Error while deactivating: '+ error)
          });
        }else{
          alert('Cancelled!');
        }
      },

      // Function to filter the user list based on the search query
      filterUser() {
        if (this.searchQuery) {
          // Filter the User list when a search query is entered
          this.filteredUserList = this.user_list.filter((user) => {
            // Adjust this logic based on your search requirements
            const query = this.searchQuery.toLowerCase();
            const nameMatch = user.name.toLowerCase().includes(query);
            const emailMatch = user.email.toLowerCase().includes(query);
            const roleMatch = this.roleLabels[user.role].toLowerCase().includes(query);

            // Return true if any of the fields match the query
            return nameMatch || emailMatch || roleMatch;
          });

          // Check if there are no matches and set the "no match" message
          if (this.filteredUserList.length === 0) {
            this.noMatchMessage = "No matches found.";
          } else {
            this.noMatchMessage = ""; // Clear the "no match" message
          }
        } else {
          // Display the complete User list when the query is empty
          this.filteredUserList = this.user_list;
          this.noMatchMessage = ""; // Clear the "no match" message
        }
      },

      toggleUserStatus(user) {
        if (confirm(`Are you sure to ${user.status === 1 ? 'deactivate' : 'activate'} this account?`)) {
          const action = user.status === 1 ? 'deactivate' : 'activate';
          axios.post(`/${action}-acc/${user.id}`).then((response) => {
            user.status = user.status === 'deactivate' ? 'active' : 'deactive';
            alert(`Account successfully ${action.charAt(0).toUpperCase() + action.slice(1)}d!`);
            this.initialData();
          }).catch((error) => {
            alert(`Error while ${action}ing: ${error}`);
          });
        } else {
          alert('Cancelled!');
        }
      },

      // changePassword() {
      //   Inertia.visit(route('changepassword'));
      // },
    }
  };
</script> 

<style>

  h1{
      color: #0C4B05;
      font-size: 50px;
      font-weight: bold;
      font-family: Calibri;
  }


  #content1{
    color: #e5e7eb;
  }

  .table{
    width: 100%;
  }

  .textArea{
        border: 2px solid #696767 ;
        resize: none;
        height: 50px;
    }

    .body{
        max-width: max-w-9xl;
        margin-left: auto;
        margin-right: auto;
        background-color: #D9D9D9;

        @media screen and (max-width: 640px) {
            /* This applies to small screens (sm:px-6) */
            padding-left: 6px;
            padding-right: 6px;
        }

        @media (min-width: 1024px) {
            padding-left: 2rem;
            padding-right: 2rem;
        }

    }

    .table{
        border: 2px solid #696767;
        background-color: white;
        width: 100%;
    }

    .table-container {
        max-height: 500px; /* Adjust the desired fixed height */
        overflow-y: auto; /* Add a vertical scrollbar when the content exceeds the fixed height */
        border: 2px solid #696767;
        background-color: white;
        position: relative; /* Create a new stacking context */
    }

    .row{
        border-bottom: 2px solid #696767;
    }

    .buttonForm{
        border: 1px solid #000000;
        width: 90px;
        height: 40px;
        border-radius: 10px;
        margin: 5px;
        align-items: center;
    }

    .buttonTable{
        margin: 5px;
        align-items: center;
        text-align: center;
        width: 35;
    }

    .buttonDelTable{
        margin: 5px;
        align-items: center;
        text-align: center;
        width: 25;
    }

    .thead{
        background-color: #BDBDBD;
        border: 2px solid #696767; 
        text-align: center;
    }

    .label{
        font-family: Calibri;
        font-weight: bold;
        font-size: 25px;
        text-align: center;
    }

    .content-heading {
        border-bottom: 2px solid #FFCD00; /* Adjust the color and thickness as needed */
        width: max-content;
        margin-bottom: 10px;
        font-family: Calibri;
        font-weight: bold;
        font-size: 50px
    }

    .search{
        width: 900px;
    }

    .message{
        text-align: center;
        font-family: Calibri;
        font-weight: bold;
        font-size: 30px;
    }

    .checkbox-container {
      display: flex;
      align-items: center;
    }

    .no-bullet-list {
      list-style-type: none;
    }
</style>

<style scoped>
  #content1 {
    
    margin-top: 80px;
    background-color: #D9D9D9;
  }

  .icon{
    height: 24px;
    width: auto;
  }
</style>