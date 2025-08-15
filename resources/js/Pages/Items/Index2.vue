<script setup>
  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  import {Link, router} from "@inertiajs/vue3";
  // import InputText from "primevue/inputtext";
  import {onMounted, ref} from "vue";

  const props = defineProps({
    items: Array
  })


</script>

<template>
  <div>
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
<!--      <Column field="ean" header="EAN Code"></Column>-->
      <Column field="name" header="Název"></Column>
      <Column field="price" header="Cena">
          <template #body="slotProps">
              {{ slotProps.data.price }},- Kč
          </template>
      </Column>

      <template #footer> Celkem {{ items ? items.length : 0 }} položek. </template>
    </DataTable>

  </div>
</template>

<style scoped>

</style>
