<script setup>

import Navbar from "@/Components/Navbar.vue";
</script>

<template>
    <div class="container mx-auto px-4">
        <header>
            Logo
        </header>
        <Navbar />
        <main>
            <slot />
        </main>
        <footer>
            &copy; Tomáš Cigler & Káťa Ciglerová Hrbková
        </footer>
    </div>
</template>

<style scoped>

</style>
