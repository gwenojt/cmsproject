<script >
  import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
  import { Head } from '@inertiajs/inertia-vue3';

  import UserList from '@/Pages/Accounts/UserList.vue';
  import NavigationMenu from '@/Layouts/NavigationMenu.vue';

  import axios from 'axios';
  
  export default {
      data(){
          return{
              users:[],
              is_edit:false,
              edit_id:0,
          }
      },
    
      components: {
          BreezeAuthenticatedLayout,
          NavigationMenu,
          UserList,        
      },

      methods: {
        getter(){
            axios.get('/userlist').then(({data})=>{
              this.users = data;
            })
        },

          editData(id){
              this.is_edit=true;
              this.edit_id=id;
          },

          successEdit(){
              this.is_edit=false;
              this.edit_id=0;
              this.getter();
          }

      },
      
      mounted(){
          this.getter();
      }
  };
</script>

<template>
    <Head title="Accounts" />
    <BreezeAuthenticatedLayout>
        <NavigationMenu/>
            <div class="flex items-center justify-center">
                <p class="content-heading">MANAGE ACCOUNTS</p>
            </div>
        <UserList @success="getter"/>
    </BreezeAuthenticatedLayout>
</template>

<style>
    .content-heading {
        border-bottom: 2px solid #FFCD00; 
        height: 70px; 
        width: max-content; 
        place-items: center;
    }
</style>

