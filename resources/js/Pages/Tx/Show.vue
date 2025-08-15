<script setup>
import dayjs from "dayjs";
import {computed, ref} from "vue";
import {Link} from "@inertiajs/vue3"

const props = defineProps({
    transaction: Object,
    transaction_items: Array
})

const paid = ref(0);

const moneyBack = computed(() => {
    return paid.value - totalPrice.value;
})

const totalPrice = computed(() => {
    let total = 0;
    props.transaction_items.forEach((it) => {
        total = total + (it.price_per_unit * it.quantity)
    });
    return total;
});


</script>

<template>
    <div>
        <p>Objednávka z {{ dayjs(transaction.created_at).format('DD. MM. YYYY   hh:mm') }}</p>

        <div class="py-3 flex flex-row justify-between">
            <strong class="text-orange-400 text-xl">Celková cena: {{ totalPrice }},- Kč</strong>
            <template v-if="transaction.finished">
                <span>Zaplaceno: <InputText v-model="paid" @click="paid=''" /></span>
                <span>Vrátit: {{ moneyBack }}</span>
            </template>
        </div>

    <h1 class="text-xl">Položky</h1>
    <table class="w-full text-right rtl:text-right text-gray-500 dark:text-gray-400 table-auto">
        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">Zboží</th>
            <th scope="col" class="px-6 py-3">Počet kusů</th>
            <th scope="col" class="px-6 py-3">Cena za kus</th>
            <th scope="col" class="px-6 py-3">Cena celkem</th>
        </tr>
        </thead>
        <tbody>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="(item, key) in transaction_items" :key="key">
            <td class="px-6 py-2">{{ item.item_name }}</td>
            <td class="px-6 py-2">{{ item.quantity }}</td>
            <td class="px-6 py-2">{{ item.price_per_unit }} Kč</td>
            <td class="px-6 py-2">{{ item.price_per_unit * parseFloat(item.quantity) }} Kč</td>
        </tr>
        </tbody>
    </table>

        <div class="py-4" v-if="transaction.note">
        <h3 class="font-bold">Poznámka</h3>
        <p>{{transaction.note}}</p>
        </div>

        <Link v-if="!transaction.finished" :href="route('tx.create', transaction.id)">Pokračovat v nákupu</Link>
    </div>
</template>

<style scoped>

</style>
