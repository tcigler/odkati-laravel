<script setup>
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import {Link, useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
    item: Object,
    eans: Array
})

const form = useForm({
    'name': props.item.name,
    'quantity': props.item.quantity,
    'price': props.item.price,
    'eans': props.eans
})

const update = () => {
    form.put(route('items.update', {item: props.item.id}))
}

const remove = (ean, key) => {
    axios.delete(route('item-ean.destroy', {ean: ean})).then(() => { // todo: just mark for delete and process after saving
        form.eans.splice(key, 1);
    }).catch((error) => {
        console.log(error);
    })
}

const existingItem = ref(null);

const checkExists = ($ean) => {
    axios.get(route('item-ean.get', {ean: $ean})).then(eanResponse => {
        existingItem.value = eanResponse.data.item_id;
    }).catch(error => {
        // ignore
    });
}

</script>

<template>
    <form class="grid grid-cols-4 gap-x-2 mx-4" @submit.prevent="update">

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
                    <Button :disabled="form.processing" @click="remove(eanModel.ean, key)" icon="pi pi-trash" />
                </div>
            </template>

        <div class="flex items-baseline col-span-3">
            <Button :disabled="form.processing" @click="form.eans.push({})" icon="pi pi-plus" />
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

        <Button class="col-span-4 my-2" :disabled="form.processing" type="submit" label="Odeslat" />

    </form>
</template>

<style scoped>

</style>
