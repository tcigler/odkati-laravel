<script setup>
import dayjs from "dayjs";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    transactions: Object
})
</script>

<template>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 table-auto">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">Transakce</th>
            <th scope="col" class="px-6 py-3">Vytvořena</th>
            <th scope="col" class="px-6 py-3">Dokončena</th>
        </tr>
        </thead>
        <tbody>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="tx in transactions">
            <td class="px-6 py-4"><Link :href="route('tx.show', tx.id)">{{ tx.id }}</Link></td>
            <td class="px-6 py-4">{{ dayjs(tx.created_at).format('DD. MM. YYYY   hh:mm') }}</td>
            <td class="px-6 py-4">{{ tx.finished ? "Ano" : "Ne" }}</td>
        </tr>
        </tbody>
    </table>
</template>

<style scoped>

</style>
