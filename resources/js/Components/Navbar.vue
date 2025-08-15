<script setup>
import {Link} from "@inertiajs/vue3"
</script>

<template>
    <nav class="bg-cyan-600 text-white">
        <div class="container mx-auto px-4 md:flex items-center gap-6">
            <!-- Logo -->
            <div class="flex items-center justify-between md:w-auto w-full">
                <a href="#" class="flex items-center py-5 px-2 text-white flex-1">
                    <span class="font-bold">Od Káti</span>
                </a>
                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button class="mobile-menu-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <title>menu</title>
                            <g fill="none">
                                <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Primary Navigation -->
            <div class="hidden md:flex md:flex-row flex-col items-center justify-start md:space-x-1 navigation-menu pb-3 md:pb-0 navigation-menu">

                <Link href="/" class="py-2 px-3 block hover:bg-cyan-500 rounded">Domů</Link>
<!--                <a :href="route('bus.index')" class="py-2 px-3 block hover:bg-cyan-500 rounded">Zájezdy</a>-->
                <Link :href="route('items.index')" class="px-3 py-2 block hover:bg-cyan-500 rounded">Seznam zboží</Link>
                <Link :href="route('items.create')" class="px-3 py-2 block hover:bg-cyan-500 rounded">Přidat zboží</Link>
                <Link :href="route('tx.index')" class="px-3 py-2 block hover:bg-cyan-500 rounded">Nákupy</Link>
                <Link :href="route('tx.store')" method="post" as="button" class="px-3 py-2 block hover:bg-cyan-500 rounded">Nový nákup</Link>
            </div>
        </div>
    </nav>
</template>

<style scoped>

</style>
