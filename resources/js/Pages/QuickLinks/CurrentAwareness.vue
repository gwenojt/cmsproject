<template lang="">
    <!-- ADD QUICK LINK MODAL -->
    <div v-if="showModal" class="modal">
        <div class="flex items-center justify-center h-screen">
            <div class="w-3/5 mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 body" id="container-form">
                        <form @submit.prevent="submitCurrent">
                            <div class="mt-4 mb-6 md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label
                                        class="block pr-4 mb-1 font-bold md:text-right md:mb-0"
                                        style="color: black"
                                        for="section"
                                        >Section</label
                                    >
                                </div>
                                <div class="md:w-2/3">
                                    <select
                                        id="section"
                                        v-model="fields.section"
                                        @change="updateFileVisibility"
                                        class="block mt-1 w-96"
                                    >
                                        <option value="" disabled>
                                            Select a Section
                                        </option>
                                        <option value="1">
                                            Current Awareness Services
                                        </option>
                                        <option value="2">ULS Forms</option>
                                        <option value="3">
                                            Virtual Libraries
                                        </option>
                                        <option value="4">
                                            Library Search Tools
                                        </option>
                                        <option value="5">
                                            Featured Links
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4 mb-6 md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label
                                        class="block pr-4 mb-1 font-bold md:text-right md:mb-0"
                                        style="color: black"
                                        for="category"
                                        >Category</label
                                    >
                                </div>
                                <div class="md:w-2/3">
                                    <select
                                        id="category"
                                        v-model="fields.link_category"
                                        @change="fetchParentOptions"
                                        class="block mt-1 w-96"
                                    >
                                        <option value="1">Label</option>
                                        <option value="2">
                                            Sub Menu Lvl 1
                                        </option>
                                        <option value="3">
                                            Sub Menu Lvl 2
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div
                                v-if="fields.link_category != 1"
                                class="mt-4 mb-6 md:flex md:items-center"
                            >
                                <div class="md:w-1/3">
                                    <label
                                        class="block pr-4 mb-1 font-bold md:text-right md:mb-0"
                                        style="color: black"
                                        for="parentMenu"
                                        >Parent Menu</label
                                    >
                                </div>
                                <div class="md:w-2/3">
                                    <select
                                        id="parentMenu"
                                        v-model="fields.parent_link_id"
                                        class="block mt-1 w-96"
                                    >
                                        <option
                                            v-for="parentMenu in parentOptions"
                                            :value="parentMenu.id"
                                        >
                                            {{ parentMenu.title }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4 mb-6 md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label
                                        class="block pr-4 mb-1 font-bold md:text-right md:mb-0"
                                        style="color: black"
                                        for="type"
                                        >Type</label
                                    >
                                </div>
                                <div class="md:w-2/3">
                                    <select
                                        id="type"
                                        v-model="fields.type"
                                        @change="handleTypeChange"
                                        class="block mt-1 w-96"
                                    >
                                        <option value="1">Label</option>
                                        <option value="2">Clickable</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4 mb-6 md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label
                                        class="block pr-4 mb-1 font-bold md:text-right md:mb-0"
                                        style="color: black"
                                        for="title"
                                        >Title</label
                                    >
                                </div>
                                <div class="md:w-2/3">
                                    <input
                                        type="text"
                                        id="title"
                                        v-model="fields.title"
                                        class="block mt-1 w-96"
                                    />
                                </div>
                            </div>

                            <div
                                v-show="showFileUpload"
                                class="mt-4 mb-6 md:flex md:items-center"
                            >
                                <div class="md:w-1/3">
                                    <label
                                        class="block pr-4 mb-1 font-bold md:text-right md:mb-0"
                                        style="color: black"
                                        for="files"
                                        >File Upload</label
                                    >
                                </div>
                                <div class="md:w-2/3">
                                    <input
                                        type="file"
                                        id="files"
                                        ref="docs"
                                        class="block mt-1 w-96"
                                        @change="onFileChange()"
                                    />
                                </div>
                            </div>

                            <div
                                v-show="showLinkInput"
                                class="mt-4 mb-6 md:flex md:items-center"
                            >
                                <div class="md:w-1/3">
                                    <label
                                        class="block pr-4 mb-1 font-bold md:text-right md:mb-0"
                                        style="color: black"
                                        for="link"
                                        >Link</label
                                    >
                                </div>
                                <div class="md:w-2/3">
                                    <input
                                        type="text"
                                        id="link"
                                        v-model="fields.link"
                                        class="block mt-1 w-96"
                                    />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button
                                    type="Submit"
                                    class="px-4 py-2 mr-4 font-bold text-white rounded shadow buttonForm bg-green hover:opacity-80 focus:shadow-outline focus:outline-none"
                                >
                                    SUBMIT
                                </button>
                                <button
                                    type="button"
                                    class="px-4 py-2 mr-4 font-bold text-white rounded shadow buttonForm bg-red hover:opacity-80 focus:shadow-outline focus:outline-none"
                                    @click="clearFilters"
                                >
                                    CANCEL
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SEARCH PART -->
    <div class="mx-auto max-w-8xl sm:px-6 lg:px-8 mt-4">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 body bg-gray">
                <div class="flex items-center justify-between mb-4">
                    <div class="heading-container">
                        <h3 class="content-heading">
                            QUICK LINKS
                        </h3>
                    </div>

                    <div class="flex items-center space-x-4 mt-4">
                        <div class="search-container">

                            <input
                                type="search"
                                v-model="searchQuery"
                                @input="filterQuicklinks"
                                placeholder="Search..."
                                class="rounded-input"
                            />
                            <img
                                src="/images/search.svg"
                                alt="Search"
                                class="search-icon"
                            />
                        </div>


                        <button
                            @click="showRecentQuickLinks"
                            class="flex items-center button bg-green"
                        >
                            Add QuickLink
                        </button>
                    </div>
            </div>

                <div class="table-container">
                    <table class="table">
                        <thead class="items-center thead">
                            <th class="py-2">Section</th>
                            <th class="py-2">Category</th>
                            <th class="py-2">Type</th>
                            <th class="py-2">Title</th>
                            <th class="py-2">Filename</th>
                            <th class="py-2">Link</th>
                            <th class="py-2">Action</th>
                        </thead>

                        <tbody>
                            <tr
                                v-for="(ql, index) in displayedQuicklinkList"
                                :key="index"
                                class="row"
                            >
                                <td class="py-2" style="text-align: center">
                                    {{ ql.section }}
                                </td>
                                <td class="py-2" style="text-align: center">
                                    {{ ql.link_category }}
                                </td>
                                <td class="py-2" style="text-align: center">
                                    {{ ql.type }}
                                </td>
                                <td class="py-2" style="text-align: center">
                                    {{ ql.title }}
                                </td>
                                <td class="py-2" style="text-align: center">
                                    {{ ql.filename }}
                                </td>
                                <td class="py-2" style="text-align: center">
                                    {{ ql.link }}
                                </td>
                                <td class="py-2" style="text-align: center">
                                    <button @click="edit(ql.id)">
                                        <img
                                            src="/images/edit.svg"
                                            alt="Edit"
                                            class="icon"
                                        />
                                    </button>
                                    <button
                                        @click="deleteQL(ql.id)"
                                        class="ml-3"
                                    >
                                        <img
                                            src="/images/delete.svg"
                                            alt="Delete"
                                            class="icon"
                                        />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import "/css/CurrentAwarenessStyles.css";

export default {
    data() {
        return {
            fields: {
                section: "",
            },
            parentOptions: {},
            quicklink_list: {},
            showParent: false,
            file: null,
            section: null,
            docs: "",
            showFileUpload: false,
            showLinkInput: false,
            searchQuery: "",
            filteredQuicklinkList: [],
            noMatchMessage: "",
            showModal: false,
        };
    },

    created() {
        this.initialData();
        this.filterQuicklinks();
    },

    computed: {
        displayedQuicklinkList() {
            
            let sortedList = Array.isArray(this.quicklink_list) ? [...this.quicklink_list] : [];

    
            sortedList.sort((a, b) => a.index - b.index);

            if (this.searchQuery) {
            return sortedList.filter((ql) => {
                const query = this.searchQuery.toLowerCase();
                return (
                ql.title.toLowerCase().includes(query) ||
                ql.section.toLowerCase().includes(query) ||
                ql.link_category.toLowerCase().includes(query)
                );
            });
            } else {
                return sortedList;
            }
        },
    },


    methods: {
        showRecentQuickLinks() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        filterQuicklinks() {
            if (this.searchQuery) {
                this.filteredQuicklinkList = this.quicklink_list.filter(
                    (ql) => {
                        const query = this.searchQuery.toLowerCase();
                        return (
                            ql.title.toLowerCase().includes(query) ||
                            ql.section.toLowerCase().includes(query) ||
                            ql.link_category.toLowerCase().includes(query)
                        );
                    }
                );

              
                if (this.filteredQuicklinkList.length === 0) {
                    this.noMatchMessage = "No matches found.";
                } else {
                    this.noMatchMessage = ""; 
                }
            } else {
      
                this.filteredQuicklinkList = [];
                this.noMatchMessage =
                    "Enter a search query to find QuickLinks.";
            }
        },

        initialData() {
            axios.get("/quicklinklist").then((response) => {
                this.quicklink_list = response.data;
                console.log("Quicklink List:", this.quicklink_list); 
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

            const showFileUploadSections = ["2", "1", "4"];
            this.showFileUpload =
                showFileUploadSections.includes(this.fields.section) &&
                this.fields.link_category !== "1";

            const showLinkInputSections = ["3", "5"];
            this.showLinkInput = showLinkInputSections.includes(
                this.fields.section
            );
        },

        submitCurrent() {
        this.updateFileVisibility();

        const formData = new FormData();
        formData.append("section", this.fields.section);
        formData.append("link_category", this.fields.link_category);
        formData.append("parent_link_id", this.fields.parent_link_id);
        formData.append("type", this.fields.type);
        formData.append("title", this.fields.title);

        if (this.showFileUpload) {
            formData.append("file", this.docs);
        } else {
            this.docs = null;
        }

        if (this.showLinkInput) {
            formData.append("link", this.fields.link);
        }

        // Determine if it's an edit or add
        const url = this.fields.id ? `/edit-quicklink/${this.fields.id}` : "/submit-current";

        axios
            .post(url, formData)
            .then((response) => {
                console.log("Form submitted successfully:", response.data);

                Swal.fire({
                    icon: "success",
                    title: "Content " + (this.fields.id ? "updated" : "uploaded") + " successfully!",
                }).then(() => {
                    this.showModal = false;
                    window.location.reload();
                });
            })
            .catch((error) => {
                console.error("Error submitting form:", error);

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                });
            });
        },

        // submitCurrent() {
        //     this.updateFileVisibility();

        //     const formData = new FormData();
        //     formData.append("section", this.fields.section);
        //     formData.append("link_category", this.fields.link_category);
        //     formData.append("parent_link_id", this.fields.parent_link_id);
        //     formData.append("type", this.fields.type);
        //     formData.append("title", this.fields.title);

        //     if (this.showFileUpload) {
        //         formData.append("file", this.docs);
        //     } else {
        //         this.docs = null;
        //     }

        //     if (this.showLinkInput) {
        //         formData.append("link", this.fields.link);
        //     }

        //     axios
        //         .post("/submit-current", formData)
        //         .then((response) => {
        //             console.log("Form submitted successfully:", response.data);

        //             Swal.fire({
        //                 icon: "success",
        //                 title: "Content uploaded successfully!",
        //             }).then(() => {
        //                 window.location.reload();
        //             });
        //         })
        //         .catch((error) => {
        //             console.error("Error submitting form:", error);

        //             Swal.fire({
        //                 icon: "error",
        //                 title: "Oops...",
        //                 text: "Something went wrong!",
        //             });
        //         });
        // },

        edit(id) {
        axios.get(`/get-quicklink/${id}`)
            .then((response) => {
                const editedQuickLink = response.data;
                this.fields = { ...editedQuickLink };

                this.showModal = true;
            })
            .catch((error) => {
                console.error('Error fetching QuickLink for editing', error);
            });
        },

        clearFilters() {
     
            this.fields.section = "";
            this.fields.link_category = "1"; 
            this.fields.parent_link_id = "";
            this.fields.type = "1"; 
            this.fields.title = "";
            this.fields.link = "";
            this.showFileUpload = false;
            this.showLinkInput = false;
            this.searchQuery = "";

    
            this.fetchParentOptions();

         
            this.filterQuicklinks();

            location.reload();
        },

        deleteQL(id) {
           
            console.log("first loop Deleting QuickLink with ID:", id);

        
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it?",
                cancelButtonText: "No, cancel",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log("Deleting QuickLink with ID:", id);

              
                    console.log("ID for deletion:", id);

                    axios
                        .post("/delete-content", { id: id })
                        .then((response) => {
                            console.log("Server response:", response.data);
                            if (response.data.success) {
                                
                                Swal.fire({
                                    icon: "success",
                                    title: "Successfully deleted!",
                                }).then(() => {
                                    this.initialData(); 
                                    location.reload(); 
                                });
                            } else {
                                
                                Swal.fire({
                                    icon: "error",
                                    title: "Error deleting content",
                                    text: response.data.error,
                                });
                            }
                        })
                        .catch((error) => {
                            console.error("Error deleting content", error);

                          
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                            });
                        });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    
                    Swal.fire("Cancelled", "Your content is safe :)", "info");
                }
            });
        },

        fetchParentOptions() {
            var section = this.fields.section;
            var linkCategory = this.fields.link_category;

            this.showParent = linkCategory >= 2 && linkCategory <= 5;

            if (this.showParent) {
                axios
                    .get(`/get-parent/${section}/${linkCategory}`)
                    .then((response) => {
                        this.parentOptions = response.data;
                    })
                    .catch((error) => {
                        console.error("Error fetching parent items", error);
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
};
</script>
