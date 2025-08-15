<script setup>
import dayjs from "dayjs";
import {computed, onMounted, ref} from "vue";
import {router, Link} from "@inertiajs/vue3";
import Textarea from "primevue/textarea";
import Message from "primevue/message";
import axios from "axios";

const props = defineProps({
    transaction: Object,
    transaction_items: Array
})

const ean = ref("");



const unknwonEan = ref("");
const eanInput = ref(null);
// const itemAssoc = array();

// const items = props.transaction_items;
const lastUpdatedItemId = ref(-1);

const reverseItemArrayKey = (key) => {
  return props.transaction_items.length - key - 1;
}

const totalPrice = computed(() => {
    let total = 0;
    props.transaction_items.forEach((it) => {
        total = total + (it.price_per_unit * it.quantity)
    });
    return total;
});

const addItem = () => {
    axios.get(route('items.find', {ean: ean.value})).then(eanResponse => {
        const itemId = eanResponse.data.item_id;

        const foundItemKey = props.transaction_items.findIndex(item => item.item_id === itemId)

        if(foundItemKey > -1) {
            const txItem = props.transaction_items[foundItemKey];
            txItem.quantity++;
            updateQuantity(foundItemKey, txItem.id, txItem.quantity);
            lastUpdatedItemId.value = foundItemKey;
        } else {
            axios.put(route('transaction-item.add', [props.transaction.id, itemId, 1])).then((response) => {
                let txItem = response.data;
                props.transaction_items.push(txItem);
                lastUpdatedItemId.value = props.transaction_items.length-1;
            });
        }

        // router.get(route('items.edit', {item: eanResponse.data.item_id}));
    }).catch(eanError => {
        console.error(eanError);
        unknwonEan.value = ean.value;
    }).finally(() => {
        ean.value = "";
    })

}

const updateQuantity = (refArrayKey, txItemId, quantity) => {
    axios.put(route('transaction-item.update', [txItemId, quantity])).then(() => {
        lastUpdatedItemId.value = refArrayKey;
    }).catch(error => {
        console.error(error);
        unknwonEan.value="none";
    })
}

const removeItem = (refArrayKey, txItemId) => {
    axios.delete(route('transaction-item.destroy', [txItemId])).then(() => {
        props.transaction_items.splice(refArrayKey, 1);
        lastUpdatedItemId.value = -1;
    })
}

onMounted(() => {
    eanInput.value.focus();

    window.addEventListener("keydown", function(e) {
        if (e.key === "/") {
            e.preventDefault()
            eanInput.value.focus();
        }
    });
})

</script>

<template>
    <div>
        <label for="ean">Sken</label>
        <input type="text" id="ean" ref="eanInput" v-model="ean" @keydown.enter.prevent="addItem" class="w-full"></input>

        <p>Objednávka z {{ dayjs(transaction.created_at).format('DD. MM. YYYY   hh:mm') }}</p>


        <div class="py-3">
            <strong class="text-orange-400 text-xl">Celková cena: {{ totalPrice }},- Kč</strong>
        </div>

        <Message severity="error" v-if="unknwonEan">Položka nenalezena <Link :href="route('items.create', {ean: unknwonEan})">{{ unknwonEan }}</Link></Message>

    <h1 class="text-xl">Položky</h1>
    <table class="w-full text-right rtl:text-right text-black dark:text-gray-400 table-auto">
        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3 text-left">Zboží</th>
            <th scope="col" class="px-6 py-3">Počet kusů</th>
            <th scope="col" class="px-6 py-3">Cena za kus</th>
            <th scope="col" class="px-6 py-3">Cena celkem</th>
        </tr>
        </thead>
        <tbody>
        <template v-for="(item, key) in [...props.transaction_items].reverse()" :key="key">
            <tr :class="(lastUpdatedItemId) === reverseItemArrayKey(key) ? 'bg-green-100' : 'bg-white'" class="border-b dark:bg-gray-800 dark:border-gray-700" >
                <td class="px-6 py-2 text-left">{{ item.item_name }}</td>
                <td class="px-6 py-2 flex flex-row justify-end">
    <!--                <Button icon="pi pi-minus"></Button> -->
                    <input type="number" class="rounded mx-2 h-10" min="1" max="1000" @change="updateQuantity(reverseItemArrayKey(key), item.id, item.quantity)" v-model="item.quantity" />
                    <Button icon="pi pi-trash" size="small" severity="danger" @click.prevent="removeItem(reverseItemArrayKey(key), item.id)"></Button>
                </td>
                <td class="px-6 py-2 text-gray-500">{{ item.price_per_unit }} Kč</td>
                <td class="px-6 py-2 font-bold">{{ item.price_per_unit * item.quantity }} Kč</td>
            </tr>
        </template>
        </tbody>
    </table>
        <div class="flex flex-col">
            <label for="note" class="font-bold">Poznámka</label>
            <Textarea id="note" v-model="transaction.note" />
            <Link class="my-2 p-2 w-24 text-center bg-primary-400 rounded text-white font-semibold" method="put" as="button"
                  :href="route('tx.update', {tx: transaction.id, note: transaction.note})">Dokončit</Link>
        </div>
    </div>
</template>

<style scoped>

</style>
