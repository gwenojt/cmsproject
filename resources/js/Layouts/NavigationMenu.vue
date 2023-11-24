<script setup>
    import BreezeNavLink from '@/Components/NavLink.vue';
</script>

<template>
    <nav>
        <!-- Navigation Links -->
        <div class="nav flex items-center justify-center ">
            <div style="margin: 10px;">
                <BreezeNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    Dashboard
                </BreezeNavLink>
            </div>
            <div style="margin: 10px;">
                <BreezeNavLink :href="route('genericpages')" :active="route().current('page')">
                    Generic Pages
                </BreezeNavLink>
            </div>
            <div style="margin: 10px;">
                <BreezeNavLink :href="route('article')" :active="route().current('article')">
                    Articles
                </BreezeNavLink>
            </div>
            <div style="margin: 10px;">
                <BreezeNavLink :href="route('faqs')" :active="route().current('faqs')">
                    Faqs
                </BreezeNavLink>
            </div>
            <div style="margin: 10px;">
                <BreezeNavLink :href="route('quickLink')" :active="route().current('quickLink')">
                    Quick Links
                </BreezeNavLink>
            </div>
            <div style="margin: 10px;">
                <BreezeNavLink :href="route('image')" :active="route().current('image')">
                    Images
                </BreezeNavLink>
            </div>
            <div style="margin: 10px;">
                <BreezeNavLink :href="route('manageacc')" :active="route().current('manageacc')">
                    Accounts
                </BreezeNavLink>
            </div>
        </div>
    </nav>
</template>



<style>
  .content-heading {
    border-bottom: 2px solid #FFCD00; /* Adjust the color and thickness as needed */
  }

  h2{
    color: white;
    font-family: Garamond;
    font-size: 25px;  
  }

  .nav{
    background-color: #989494;
    font-family: Calibri;
    font-size: 20px;  
    height: 40px;
    font-weight: bold;
    color: white;
    place-items: center;

  }
</style>
