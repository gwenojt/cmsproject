<template lang="">

    <div class="" style="margin-top:50px; margin-bottom:50px;">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 body ">
                    <form @submit.prevent="submitFaq">
                        <div class="mt-4">
                            <label for="questions" value="Questions" class="label">Question</label>
                            <textarea name="questions" id="question" v-model="fields.question" cols="50" rows="10" class="!important mt-1 block w-full rounded-md textArea "> </textarea>
                        </div>
                        <div class="mt-4">
                            <label for="answer" value="Answer" class="label">Answer</label>
                            <textarea name="answers" id="answer" v-model="fields.answer" cols="50" rows="10" class="mt-1 block w-full rounded-md textArea"></textarea>
                        </div>
                        <div class="flex items-center justify-end mt-4">            
                            <button type="Submit"  class="buttonForm shadow text-white bg-green hover:opacity-80 mr-4 focus:shadow-outline focus:outline-none font-bold py-2 px-4 rounded">SUBMIT</button>
                            <button type="Submit" class="buttonForm shadow text-white bg-red hover:opacity-80 mr-4 focus:shadow-outline focus:outline-none font-bold py-2 px-4 rounded">CANCEL</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="" style="margin-top: 5px; margin-bottom: 50px;">
    <button @click="openModal" v-if="showModal">Add FAQs</button>
    </div>

    <div class="" style="margin-top: 5px; margin-bottom: 50px;">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8" style="margin-top: 50px;">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 body bg-gray">
                    <div>
                        <h3 class="content-heading">
                        RECENTLY UPLOADED FAQs
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
                                @input="filterFaqs"
                            />
                        </div>
                    </div>
                    </div>
                </div>
                <div v-if="filteredFaqList.length > 0" class="table-container">
            <table class="table">
            <thead class="thead items-center">
                <th>#</th>
                <th>Questions</th>
                <th>Answer</th>
                <th>Action</th>
            </thead>
            <tbody>
                <tr v-for="(faq, index) in filteredFaqList" :key="index" class="row">
                <td style="width: 30px; text-align:center; padding: 15px;">{{ index + 1 }}</td>
                <td style="width: 500px; text-align:justify; padding: 15px;">{{ faq.question }}</td>
                <td style="width: 700px; text-align:justify; padding: 15px;">{{ faq.answer }}</td>
                <td style="text-align: center;">
                    <button @click="edit(faq.id)" class="buttonTable pl-7 pr-7 shadow bg-yellow hover:opacity-80 mr-4 focus:shadow-outline focus:outline-none font-bold py-2 px-4 rounded text-black">EDIT</button>
                    <button @click="deleteFaqs(faq.id)" class="buttonTable shadow bg-red hover:opacity-80 mr-4 focus:shadow-outline focus:outline-none font-bold py-2 px-4 rounded text-black text-white">DELETE</button>
                </td>
                </tr>
            </tbody>
            </table>
        </div>
        <p v-if="noMatchMessage" class="message">{{ noMatchMessage }}</p>
        </div>
    </div>
    </div>
</div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
            fields: {},
            faq_list: [],
            searchQuery: "", // To store the search query
            filteredFaqList: [], // To store the filtered FAQ list
            noMatchMessage: "",
            };
        },

        props :{
            showModal: Boolean,
        },

        created() {
            this.initialData();
        },

        methods: {
            openModal(){
                this.$emit('open-modal');
            },
            
            initialData() {
                axios.get(`/faqlist`).then((response) => {
                    this.faq_list = response.data;
                    // Initially, display the complete FAQ list
                    this.filteredFaqList = this.faq_list;
                });
            },

            deleteFaqs(id){
                if(confirm('Are you sure?')){
                    axios.post('/delete-faqs',{id}).then(({data})=>{
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
                axios.get(`/faqs-data/${id}`).then(response=> {
                    this.fields = response.data;
                });
            },

            submitFaq(){
                axios.post('submit-form',this.fields).then((response)=>{
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

            // Function to filter the FAQ list based on the search query
            filterFaqs() {
                if (this.searchQuery) {
                    // Filter the FAQ list when a search query is entered
                    this.filteredFaqList = this.faq_list.filter((faq) => {
                    // Adjust this logic based on your search requirements
                    const query = this.searchQuery.toLowerCase();
                    return (
                        faq.question.toLowerCase().includes(query) ||
                        faq.answer.toLowerCase().includes(query)
                    );
                    });

                    // Check if there are no matches and set the "no match" message
                    if (this.filteredFaqList.length === 0) {
                    this.noMatchMessage = "No matches found.";
                    } else {
                    this.noMatchMessage = ""; // Clear the "no match" message
                    }
                } else {
                    // Display the complete FAQ list when the query is empty
                    this.filteredFaqList = this.faq_list;
                    this.noMatchMessage = ""; // Clear the "no match" message
                }
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