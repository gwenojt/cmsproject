<template lang="">
  <div class="" style="margin-top:50px; margin-bottom:50px;">
      <div class="w-2/5 mx-auto sm:px-6 lg:px-8">
          <div class=" overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 body" id="container-form">
                  <form @submit.prevent="uploadImage">
                      <div class="mt-4 md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                          <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" style="color: black;" for="inline-category">
                            Category
                          </label>
                        </div>
                        <div class="md:w-2/3">
                          <select v-model="image.category" class="!important w-full text-black bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-category" placeholder="Select Category">
                            <option value="" disabled selected>Select Category</option>
                            <option value="1">Featured Books</option>
                            <option value="2">News</option>
                          </select>
                        </div>
                      </div>
                      <div class="mt-4 md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" style="color: black;" for="inline-image">
                            Upload Image
                            </label>
                        </div>
                        <div class="md:w-2/3">
                          <input @change="onFileChange" class="!important w-full text-black bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="image" name="image" type="file">
                        </div>
                      </div>

                      <div class="mt-4 md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                          <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" style="color: black;" for="inline-category">
                            Status
                          </label>
                        </div>
                        <div class="md:w-2/3">
                          <select v-model="image.status" class="!important w-full text-black bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" name="file" id="inline-status" placeholder="Select Status">
                            <option value="" disabled selected>Select Category</option>
                            <option value="1">Display</option>
                            <option value="2">Hide</option>
                          </select>
                        </div>
                      </div>

                      <div class="flex items-center justify-end mt-4 -ml-96">            
                          <button type="Submit" @click="uploadImage" class=" buttonForm text-white w-28 shadow bg-green hover:opacity-80 mr-4 focus:shadow-outline focus:outline-none font-bold py-2 px-4 rounded">SUBMIT</button>
                          <button type="Submit" @click="resetForm" class="buttonForm text-white w-28 shadow bg-red hover:opacity-80 mr-4 focus:shadow-outline focus:outline-none font-bold py-2 px-4 rounded">CANCEL</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <!-- <div class="" style="margin-top: 5px; margin-bottom: 50px;">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-8" style="margin-top: 50px;">
          <div class="overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 body bg-gray">
              <div>
                  <h3 class="content-heading">
                  Recently Updated Images
                  </h3>
              </div>
              <div class="flex justify-center py-3">
                  <div>
                  <div class="mb-3">
                      <div class="relative mb-4 flex justify-center flex-wrap items-stretch" style="width: 600px;">
                          <input
                              type="search"
                              class="relative m-0 -mr-0.5 textArea block w-[1px] min-w-0 flex-auto rounded-l border bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                              placeholder="Search"
                              aria-label="Search"
                              aria-describedby="button-addon1"
                              v-model="searchQuery"
                              @input="filterImages"
                          />
                      </div>
                  </div>
                  </div>
              </div>
              <div v-if="filteredImageList.length > 0" class="table-container">
          <table class="table">
          <thead class="thead items-center">
              <th>Category</th>
              <th>Filename</th>
              <th>Status</th>
              <th>Action</th>
          </thead>
          <tbody>
              <tr v-for="(image, index) in filteredFaqList" :key="index" class="row">
              <td style="width: 500px; text-align:justify; padding: 15px;">{{ image.category }}</td>
              <td style="width: 700px; text-align:justify; padding: 15px;">{{ image.filename }}</td>
              <td style="width: 700px; text-align:justify; padding: 15px;">{{ image.status }}</td>
              <td style="text-align: center;">
                  <button @click="edit(image.id)" class="buttonTable items-center shadow text-black bg-yellow hover:opacity-70 focus:shadow-outline focus:outline-none font-bold py-2 px-7 rounded">EDIT</button>
                  <button @click="deleteFaqs(image.id)" class="buttonDelTable items-center shadow text-white bg-red hover:opacity-70 focus:shadow-outline focus:outline-none font-bold py-2 px-4 rounded mx-2">DELETE</button>
              </td>
              </tr>
          </tbody>
          </table>
      </div>
      <p v-if="noMatchMessage" class="message">{{ noMatchMessage }}</p>
      </div>
  </div>
  </div>
</div> -->

</template>

<script>
    import axios from 'axios';

    export default {
  data() {
    return {
      image: {
        category: '',
        file: null,
        status: '',
      },
    };
  },

  methods: {
    onFileChange(event) {
      this.image.file = event.target.files[0];
    },

    uploadImage() {
      // Create a FormData object to contain the image file and other data.
      const formData = new FormData();
      formData.append('image', this.image.file);
      formData.append('category', this.image.category);
      formData.append('status', this.image.status);

      // Send the FormData object to the Laravel backend using a POST request.
      axios.post('/uploadimage', formData)
        .then((response) => {
          // Success!
          console.log('Image uploaded successfully!');
        })
        .catch((error) => {
          // Error!
          console.log(error);
        });
    },

    upload(){
      
    },

    resetForm() {
      this.image = {
        category: '',
        status: '',
        file: '',
      };
    },
  },
};

</script>

<style>
.table-container {
    max-height: 500px; /* Adjust the desired fixed height */
    overflow-y: auto; /* Add a vertical scrollbar when the content exceeds the fixed height */
    border: 2px solid #696767;
    background-color: white;
    position: relative; /* Create a new stacking context */
}

/* Style the table to fill the container */
.table {
    width: 100%;
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
    margin: 5px;
    border-radius: 5px;
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

</style>