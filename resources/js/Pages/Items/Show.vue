<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    item: Object,
    eans: Array
})
</script>

<template>
<div>
    <ul>
        <li v-if="eans"><strong>EAN: </strong>
            <ul class="list-disc list-inside px-2">
                <li v-for="ean in eans">{{ ean.ean }}<span v-if="ean.variant">: {{ ean.variant }}</span></li>
            </ul>
        </li>
        <li><strong class="inline-flex font-bold w-32">Název zboží:</strong> {{item.name}}</li>
        <li><strong class="inline-flex font-bold w-32">Kusů skladem:</strong> {{item.quantity}}</li>
        <li><strong class="inline-flex font-bold w-32">Cena:</strong> {{item.price}}</li>
    </ul>

    <div class="py-3">
    <Link :href="route('items.edit', item.id)" class="bg-primary-700 rounded-full p-2 border-2 text-primary-50"><i class="pi pi-pencil"></i></Link>&nbsp
    </div>
</div>
</template>

<style scoped>

</style>
