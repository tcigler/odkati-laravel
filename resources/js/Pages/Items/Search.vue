<script setup>

import InputText from "primevue/inputtext";
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import Button from "primevue/button";
import axios from "axios";

const ean = ref("");
const res = ref("");
const search = () => {
    axios.get(route('items.find', {ean: ean.value})).then((response) => {
        res.value = response.data;
    }).catch((error) => {
        res.value = error.response.status;
    });
    // router.get(route('items.find', {ean: ean.value}));
}

</script>

<template>

    <form class="flex flex-col gap-x-2 mx-4" @submit.prevent="search">
        <label for="ean">EAN</label>
        <InputText id="ean" v-model="ean"></InputText>

        <Button type="submit" label="Vyhledat" />
    </form>

    <pre class="text-xl">{{ res }}</pre>

</template>

<style scoped>

</style>
