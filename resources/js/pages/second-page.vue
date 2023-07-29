<template>
    <div>
        <Breadcrumbs />
        <VCard title="Users List">
            <div class="container">
                <div class="row">
                    <DataTable
                        :columns="columns"
                        :data="tableData"
                        :options="options"
                        class="table table-hover table-bordered"
                    />
                </div>
            </div>
        </VCard>
    </div>
</template>

<script setup>
import Breadcrumbs from '@/components/Breadcrumb.vue';
import DataTablesCore from 'datatables.net-bs5';
import DataTable from 'datatables.net-vue3';

DataTable.use(DataTablesCore);

// Define the columns and their corresponding titles
const columns = [
    { title: "No.", data: "DT_RowIndex", orderable: false, searchable: false }, 
    { title: "Name", data: "name" },
    { title: "Email", data: "email" },
    { title: "Created At", data: "created_at" },
    { title: "Updated At", data: "updated_at" },
];

let tableData = ref([]);

const options = {
    processing: true,
    serverSide: true,
    autoWidth: true,
    order: [[0]],
    ajax: {
        url: "api/users",
        type: 'GET',
    },
    responsive: true,
    select: true,
    language: {
        lengthMenu: "_MENU_",
        search: "_INPUT_",
        searchPlaceholder: "Search records",
    },
};
</script>
