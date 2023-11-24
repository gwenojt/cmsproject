<template lang="">
    <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                   <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                       <div class="p-6 bg-white border-b border-gray-200">
                          <form @submit.prevent="submitPage">
                           <div>
                           <label for="category" value="Category" >Category</label>
                           <select id="category" v-model="fields.category" @change="fetchParentOptions">
                            <option value="1">Label</option>
                            <option value="2">Sub Menu Lvl 1</option>
                            <option value="3">Sub Menu Lvl 2</option>
                            <option value="4">Sub Menu Lvl 3</option>
                            <option value="5">Sidebar Menu</option>
                            
                           </select>

                           <!-- <div v-show="showParent" > -->
                            <div v-if="this.fields.category !== 1" >
                           <label for="parentMenu" value="parentMenu" >Parent Menu</label>
                           <select id="parentMenu" v-model="fields.page_id" >
                            <option v-for="parentMenu in parentOptions" :value=parentMenu.id>{{parentMenu.title}}</option>
                           </select>
                           </div>

                          

                           <div>
                           <label for="type" value="Type" >Type</label>
                           <select id="type" v-model="fields.type">
                            <option value="1">Link</option>
                            <option value="2">Article</option>
                           </select>
                           </div>

                         
                           </div>
                           <div class="mt-4">
                           <label for="title" value="title" >Title</label>
                           <input type="text" id="title" v-model="fields.title" class="mt-1 block w-full">
                          
                           </div>
                           <div class="mt-4">
                           <label for="description" value="description" >Description</label>
                           <textarea name="description" id="description" v-model="fields.description" cols="30" rows="10" class="mt-1 block w-full"></textarea>
                           </div>

                           <div class="mt-4">
                           <label for="contents" value="contents" >Content</label>
                           <textarea name="contents" id="contents" v-model="fields.contents" cols="30" rows="10" class="mt-1 block w-full"></textarea>
                           </div>

                           <div class="flex items-center justify-end mt-4">            
                   <button type="Submit">SUBMIT</button>
               </div>
                          </form>
                       </div>
                   </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table class="w-full">
                            <thead>
                                <th>#</th>
                                <th>Title</th>
                                <th>Types</th>
                                <th>Parent Menu</th>
                                <th>Descriptions</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                <tr v-for="(gen,index) in generic_list" :key="index">
                                    <td>{{gen.id}}</td>
                                    <td>{{gen.title}}</td>
                                    <td>{{gen.type}}</td>
                                    <td>{{gen.parent}}</td>
                                    <td>{{gen.description}}</td>

                                    <td><button @click="edit(gen.id)">EDIT</button></td>
                                    <td><button @click="deleteGen(gen.id)">DELETE</button></td>
                                </tr>
                            </tbody>
                        </table>
                 
                        
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
import axios from 'axios';


export default {

    data() {
        return{ 
            fields: {},
            generic_list: {},
            parentOptions:{},
            showParent: false ,
        }
    },
    created(){
        this.initialData();
    },

    methods:{

        initialData(){
            axios.get('/genericlist').then(response=> {
                this.generic_list = response.data;
            });
        },

        deleteGen(id){
            if(confirm('Are you sure?')){
                axios.post('/delete-content',{id}).then(({data})=>{
                    if(data){
                        alert('success');
                        this.$emit('success');
                        this.initialData();
                    }else{
                        alert('error');
                    }
                })
            }else{
                alert('Cancelled')
            }
        },

        edit(id){
            axios.get(`/content-data/${id}`).then(response=> {
                this.fields = response.data.details;
                this.parentOptions = response.data.parentOption;
            });
        },

        submitPage(){
            axios.post('submit-page',this.fields).then((response)=>{
                if(response.data){
                    this.initialData();
                    // alert('success');
                    this.fields = {};
                    alert('success');
                    this.$emit('success');
                }else{
                    alert('Error');
                }
            });
        },
        fetchParentOptions(){
            var id = this.fields.category;
            this.showParent =(id >=2 && id <=5);
            if(this.showParent){
                axios.get(`/get-parent/${id}`)
                .then(response => {
                    this.parentOptions = response.data;
                })
                .catch(error => {
                    console.error('Error fetching parent items', error);
                });
                
            }
            // axios.get(`/get-parent/${id}`)
            //     .then(response => {
            //         this.parentOptions = response.data;
            //     })
            //     .catch(error => {
            //         console.error('Error fetching parent items', error);
            //     });

        },
    },
   
    
}
</script>
<style lang="">
    
</style>