<script setup>
  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  import {Link, router} from "@inertiajs/vue3";
  // import InputText from "primevue/inputtext";
  import {onMounted, ref} from "vue";

  const props = defineProps({
    items: Array
  })

  const ean = ref("");
  const eanData = ref("");

  const find = () => {
      axios.get(route('items.find', {ean: ean.value})).then(eanResponse => {
          console.log(eanResponse.data);
          router.get(route('items.edit', {item: eanResponse.data.item_id}));
      }).catch(eanError => {
          console.error(eanError);
          router.get(route('items.create', {ean: ean.value}));
      })
  }

  const eanInput = ref(null);

  defineExpose({eanInput});

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
    <label for="ean">Načti EAN pro přímou úpravu nebo vytvoření</label>
    <input type="text" id="ean" ref="eanInput" v-model="ean" @keydown.enter.prevent="find" class="w-full"></input>
      <pre>{{eanData}}</pre>
    <DataTable :value="props.items" tableStyle="min-width: 50rem">
      <template #header>
        <div class="flex flex-wrap items-center justify-between gap-2">
            <span class="text-xl text-surface-900 dark:text-surface-0 font-bold">Zboží</span>
            <span>
                <Link :href="route('items.create')" class="bg-primary-700 rounded-full p-2 border-2 text-primary-50"><i class="pi pi-plus"></i></Link>
                <Link :href="route('items.search')" class="bg-primary-700 rounded-full p-2 border-2 text-primary-50"><i class="pi pi-search"></i></Link>
            </span>
        </div>
      </template>
        <Column field="id" header="Akce">
            <template #body="slotProps">
                <Link :href="route('items.show', slotProps.data.id)" class="bg-primary-600 rounded-full p-2 border-2 text-primary-50"><i class="pi pi-eye"></i></Link>&nbsp
                <Link :href="route('items.edit', slotProps.data.id)" class="bg-primary-700 rounded-full p-2 border-2 text-primary-50"><i class="pi pi-pencil"></i></Link>&nbsp
                <Link :href="route('items.destroy', slotProps.data.id)" method="delete" as="button" class="bg-red-500 rounded-full p-2 border-2 text-primary-50"><i class="pi pi-trash"></i></Link>&nbsp
            </template>
        </Column>
<!--      <Column field="ean" header="EAN Code"></Column>-->
      <Column field="name" header="Název"></Column>
      <Column field="price" header="Cena"></Column>
      <Column field="quantity" header="Počet"></Column>

      <template #footer> Celkem {{ items ? items.length : 0 }} položek. </template>
    </DataTable>

  </div>
</template>

<style scoped>

</style>
