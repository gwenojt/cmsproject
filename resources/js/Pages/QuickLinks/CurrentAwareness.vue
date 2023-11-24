<template lang="">
    <div class="" style="margin-top:50px; margin-bottom:50px;">
        <div class="w-3/5 mx-auto sm:px-6 lg:px-8">
          <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 body" id="container-form">
              <form @submit.prevent="submitCurrent">
      
                <div class="mt-4 md:flex md:items-center mb-6">
                  <div class="md:w-1/3">
                    <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" style="color: black;" for="section">Section</label>
                  </div>
                  <div class="md:w-2/3">
                    <select id="section" v-model="fields.section" @change="updateFileVisibility" class="mt-1 block w-96" >
                        <option value="" disabled hidden>Select a Section</option>
                      <option value="1">Current Awareness Services</option>
                      <option value="2">ULS Forms</option>
                      <option value="3">Virtual Libraries</option>
                      <option value="4">Library Search Tools</option>
                      <option value="5">Featured Links</option>
                    </select>
                  </div>
                </div>
      
                <div class="mt-4 md:flex md:items-center mb-6">
                  <div class="md:w-1/3">
                    <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" style="color: black;" for="category">Category</label>
                  </div>
                  <div class="md:w-2/3">
                    <select id="category" v-model="fields.link_category" @change="fetchParentOptions" class="mt-1 block w-96">
                      <option value="1">Label</option>
                      <option value="2">Sub Menu Lvl 1</option>
                      <option value="3">Sub Menu Lvl 2</option>
                    </select>
                  </div>
                </div>
      
                <div v-if="fields.link_category != 1" class="mt-4 md:flex md:items-center mb-6">
                  <div class="md:w-1/3">
                    <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" style="color: black;" for="parentMenu">Parent Menu</label>
                  </div>
                  <div class="md:w-2/3">
                    <select id="parentMenu" v-model="fields.parent_link_id" class="mt-1 block w-96">
                      <option v-for="parentMenu in parentOptions" :value=parentMenu.id>{{parentMenu.title}}</option>
                    </select>
                  </div>
                </div>
      
                <div class="mt-4 md:flex md:items-center mb-6">
                  <div class="md:w-1/3">
                    <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" style="color: black;" for="type">Type</label>
                  </div>
                  <div class="md:w-2/3">
                    <select id="type" v-model="fields.type" @change="handleTypeChange" class="mt-1 block w-96">
                      <option value="1">Label</option>
                      <option value="2">Clickable</option>
                    </select>
                  </div>
                </div>
      
                <div class="mt-4 md:flex md:items-center mb-6">
                  <div class="md:w-1/3">
                    <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" style="color: black;" for="title">Title</label>
                  </div>
                  <div class="md:w-2/3">
                    <input type="text" id="title" v-model="fields.title" class="mt-1 block w-96">
                  </div>
                </div>
      
                <div v-show="showFileUpload" class="mt-4 md:flex md:items-center mb-6">
                  <div class="md:w-1/3">
                    <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" style="color: black;" for="files">File Upload</label>
                  </div>
                  <div class="md:w-2/3">
                    <input type="file" id="files" ref="docs" class="mt-1 block w-96" @change="onFileChange()">
                  </div>
                </div>
      
                <div v-show="showLinkInput" class="mt-4 md:flex md:items-center mb-6">
                  <div class="md:w-1/3">
                    <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" style="color: black;" for="link">Link</label>
                  </div>
                  <div class="md:w-2/3">
                    <input type="text" id="link" v-model="fields.link" class="mt-1 block w-96">
                  </div>
                </div>
      
                <div class="flex items-center justify-end mt-4">
                  <button type="Submit" class="buttonForm shadow text-white bg-green hover:opacity-80 mr-4 focus:shadow-outline focus:outline-none font-bold py-2 px-4 rounded">SUBMIT</button>
                  <button type="Submit" class="buttonForm shadow text-white bg-red hover:opacity-80 mr-4 focus:shadow-outline focus:outline-none font-bold py-2 px-4 rounded">CANCEL</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      

        <div class="" style="margin-top: 5px; margin-bottom: 50px;">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8" style="margin-top: 50px;">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 body bg-gray">

                        <div class="heading-container">
                            <div>
                                <h3 class="content-heading">RECENTLY UPLOADED QUICK LINKS</h3>
                            </div>
                            <div class="search-container">
                                <!-- Add an input field for search -->
                                <input type="search" v-model="searchQuery" @input="filterQuicklinks" placeholder="Search..." class="rounded-input">
                                <!-- Replace filter button with search icon -->
                                <img src="/images/search.svg" alt="Search" class="search-icon">

                            </div>
                        </div>

                        <div class="table-container">

                            <table class="table">
                                <thead class="thead items-center">
                                    <th class="py-2">Section</th>
                                    <th class="py-2">Category</th>
                                    <th class="py-2">Type</th>
                                    <th class="py-2">Title</th>
                                    <th class="py-2">Filename</th>
                                    <th class="py-2">Link</th>
                                    <th class="py-2">Action</th>
                                </thead>

                                <tbody>
                                    
                                    <tr v-for="(ql, index) in filteredQuicklinkList" :key="index" class="row">
                                        <td class="py-2" style="text-align: center;">{{ ql.section }}</td>
                                        <td class="py-2" style="text-align: center;">{{ ql.link_category }}</td>
                                        <td class="py-2" style="text-align: center;">{{ ql.type }}</td>
                                        <td class="py-2" style="text-align: center;">{{ ql.title }}</td>
                                        <td class="py-2" style="text-align: center;">{{ ql.filename }}</td>
                                        <td class="py-2" style="text-align: center;">{{ ql.link }}</td>
                                        <td class="py-2" style="text-align: center;">
                                            <button @click="edit(ql.id)" >
                                                <img src="/images/edit.svg" alt="Edit" class="icon">
                                            </button>
                                            <button @click="deleteQL(ql.id)" class="ml-3">
                                                <img src="/images/delete.svg" alt="Delete" class="icon">
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
import axios from 'axios';

export default {

    data(){
    return{
        fields: {},
        parentOptions: {},
        quicklink_list: {},
        showParent: false,
        file: null,
        section: null,
        docs:"",
        showFileUpload: false,
        showLinkInput: false,
        searchQuery: "", 
        filteredQuicklinkList: [], 
        noMatchMessage: "", 
        
    }
    
   },

   created(){
     this.initialData();
     this.filterQuicklinks();
   },

   computed: {
    sortedQuicklinkList() {

        const quicklinkArray = Array.isArray(this.quicklink_list)
        ? this.quicklink_list
        : [];


        const sectionOrder = {
        'Current Awareness Services': 1,
        'ULS Forms': 2,
        'Virtual Libraries': 3,
        'Library Search Tools': 4,
        'Featured Links': 5,
        };


        return [...quicklinkArray].sort((a, b) => {
        return sectionOrder[a.section] - sectionOrder[b.section];
        });
    },
   },

   methods: {

    filterQuicklinks() {
    if (this.searchQuery) {

        this.filteredQuicklinkList = this.quicklink_list.filter((ql) => {
         
            const query = this.searchQuery.toLowerCase();
            return (
                ql.title.toLowerCase().includes(query) ||
                ql.section.toLowerCase().includes(query) ||
                ql.link_category.toLowerCase().includes(query)
            );
        });

        // Check if there are no matches and set the "no match" message
        if (this.filteredQuicklinkList.length === 0) {
            this.noMatchMessage = "No matches found.";
        } else {
            this.noMatchMessage = ""; // Clear the "no match" message
        }
    } else {
        // Display the complete QuickLink list when the query is empty
        this.filteredQuicklinkList = this.quicklink_list;
        this.noMatchMessage = ""; // Clear the "no match" message
    }
    },

    initialData() {
        axios.get('/quicklinklist').then((response) => {
            this.quicklink_list = response.data;
            console.log('Quicklink List:', this.quicklink_list); // Add this line for debugging
        });
    },


    onFileChange() {
        // alert("sfasfdaskf");
    // this.file = event.target.files[0];
    // alert ('sfjksafa');
        // this.docs.push(files[0]);
        this.docs = this.$refs.docs.files[0];
    },

    updateFileVisibility() {
        // Show file upload if section is ULS Forms, Current Awareness, or Library Search Tools
        const showFileUploadSections = ['2', '1', '4'];
        this.showFileUpload = showFileUploadSections.includes(this.fields.section) && this.fields.link_category !== '1';


        // Show link input if section is Virtual Libraries or Featured Links
        const showLinkInputSections = ['3', '5'];
        this.showLinkInput = showLinkInputSections.includes(this.fields.section);
    },
    
    submitCurrent() {

        this.updateFileVisibility();

        const formData = new FormData();
        formData.append('section', this.fields.section);
        formData.append('link_category', this.fields.link_category);
        formData.append('parent_link_id', this.fields.parent_link_id);
        formData.append('type', this.fields.type);
        formData.append('title', this.fields.title);
        
        
        if (this.showFileUpload) {
        formData.append('file', this.docs);
            }
        else {
            this.docs = null;
            }

        if (this.showLinkInput) {
                formData.append('link', this.fields.link);
            }

        axios.post('/submit-current', formData)
            .then(response => {
            console.log('Form submitted successfully:', response.data);
            alert('Content uploaded successfully!');
            window.location.reload();
            })
            .catch(error => {
            console.error('Error submitting form:', error);
            });

        
},


deleteQL(id) {
    // Log the ID to the console for debugging
    console.log('Deleting QuickLink with ID:', id);

    if (confirm('Are you sure?')) {
        axios.post('/delete-content', { id })
            .then(response => {
                if (response.data.success) {
                    alert('Successfully deleted');
                    this.initialData();  // Refresh the data after successful deletion
                } else {
                    alert('Error deleting content: ' + response.data.error);
                }
            })
            .catch(error => {
                console.error('Error deleting content', error);
                alert('Error deleting content');
            });
    } else {
        alert('Cancelled');
    }
},


    fetchParentOptions() {
    var section = this.fields.section;
    var linkCategory = this.fields.link_category;
    
    this.showParent = (linkCategory >= 2 && linkCategory <= 5);
    
    if (this.showParent) {
        axios.get(`/get-parent/${section}/${linkCategory}`)
            .then(response => {
                this.parentOptions = response.data;
            })
            .catch(error => {
                console.error('Error fetching parent items', error);
            });
    }
},


//     fetchParentOptions(){
//             var id = this.fields.link_category;
//             this.showParent =(id >=2 && id <=5);
//             if(this.showParent){
//                 axios.get(`/get-parent/${id}`)
//                 .then(response => {
//                     this.parentOptions = response.data;
//                 })
//                 .catch(error => {
//                     console.error('Error fetching parent items', error);
//                 });
                
//             }

//    },

},

}




</script>

<style>
.heading-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.search-container {
    display: flex;
    align-items: center;
}

.rounded-input {
    border-radius: 8px; /* Adjust the border-radius value as needed */
    padding: 10px; /* Adjust the padding value as needed */
}


.search-icon {
    width: 30px; /* Adjust the width as needed */
    height: auto;
    margin-left: 8px; /* Adjust the margin as needed */
}

.table-container {
    max-height: 500px; /* Adjust the desired fixed height */
    overflow: auto; /* Add a scrollbar when the content exceeds the fixed height */
    border: 2px solid #696767;
    background-color: white;
    position: relative; /* Create a new stacking context */
}

.table {
    width: 100%;
    border-collapse: collapse; /* Combine borders for a cleaner look */
}

.row{
    border-bottom: 2px solid #696767;
}

.textArea{
    border: 2px solid #696767 ;
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
}

.buttonForm{
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
    width: 25;
}


.thead {
    background-color: #BDBDBD;
    border: 2px solid #696767; 
    text-align: center;
    position: sticky;
    top: 0;
    z-index: 1;
}

.label{
    font-family: Calibri;
    font-weight: bold;
    font-size: 25px;
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

.icon{
    width:30px;
    height: auto;
}
</style>
        