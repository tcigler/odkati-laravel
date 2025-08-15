<script setup>
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import {Link, useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
    "ean": String
})

const copyEan = ref("");
const searchError = ref("");

const form = useForm({
    'eans': [{ean: props.ean, variant: ""}],
    'name': null,
    'quantity': 0,
    'price': null,
})

const existingItem = ref(null);

const search = () => {
    searchError.value = "";
    axios.get(route('items.find', {ean: copyEan.value})).then(eanResponse => {
        axios.get(route('items.get', {id: eanResponse.data.item_id})).then(itemResponse => {
            form.name = itemResponse.data.name;
            form.price = itemResponse.data.price;
        }).catch(error => {
            console.log(error);
            searchError.value = "Chyba! Zboží nelze zkopírovat"
        });
    }).catch(error => {
        searchError.value = "Ean " + copyEan.value + " nenalezen"
        copyEan.value = "";
    });
}

const checkExists = ($ean) => {
    axios.get(route('item-ean.get', {ean: $ean})).then(eanResponse => {
        existingItem.value = eanResponse.data.item_id;
    }).catch(error => {
        // ignore
    });
}

const buttonsDisabled = () => {
    return form.processing || existingItem.value != null;
}

</script>

<template>
    <form class="grid grid-cols-4 gap-x-2 mx-4" @submit.prevent="form.post(route('items.store'))">

        <div class="col-start-3 col-span-2">
            <label for="ean">Kopírovat z EAN</label>
            <div class="flex flex-row gap-1">
                <InputText id="ean" @keydown.enter.prevent="search" v-model="copyEan"></InputText>
                <Button icon="pi pi-search" @click="search" />
                <small v-if="searchError">{{ searchError }}</small>
            </div>
        </div>

        <template v-for="(eanModel, key) in form.eans">

            <div class="col-span-1">
                <label for="ean">EAN {{key}}</label>
                <InputText class="w-full" id="ean" @keydown.enter.prevent @blur="checkExists(eanModel.ean)" v-model="form.eans[key].ean"></InputText>
            </div>

            <div class="col-span-2">
                <label for="variant">Varianta {{key}}</label>
                <InputText class="w-full" id="variant" v-model="form.eans[key].variant"></InputText>
            </div>
            <div class="col-span-1 align-bottom">
                <Button :disabled="buttonsDisabled()" @click="form.eans.splice(key, 1);" icon="pi pi-trash" />
            </div>
        </template>
        <small v-if="form.errors.eans">{{ form.errors.eans }}</small>
        <div class="flex items-baseline col-span-3">
            <Button :disabled="buttonsDisabled()" @click="form.eans.push({})" icon="pi pi-plus" />
            <span v-if="existingItem" class="pl-2 text-red-500 font-bold">
                Zadaný EAN existuje - chceš raději
                <Link class="underline text-red-600" :href="route('items.edit', {item: existingItem})">editovat</Link>?
            </span>
        </div>

        <div class="col-span-4">
            <label for="name">Název</label>
            <InputText class="w-full" id="name" v-model="form.name"></InputText>
            <small v-if="form.errors.name">{{ form.errors.name }}</small>
        </div>

        <div class="col-span-4">
            <label for="quantity">Počet kusů</label>
            <InputText class="w-full" id="quantity" v-model="form.quantity"></InputText>
            <small v-if="form.errors.quantity">{{ form.errors.quantity }}</small>
        </div>

        <div class="col-span-4">
            <label for="price">Cena za kus</label>
            <InputText class="w-full" id="price" v-model="form.price"></InputText>
            <small v-if="form.errors.price">{{ form.errors.price }}</small>
        </div>

        <Button class="col-span-4 my-2" :disabled="buttonsDisabled()" type="submit" label="Odeslat" />

    </form>
</template>

<style scoped>

</style>
