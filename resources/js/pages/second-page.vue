<template>
    <div>
        <Breadcrumbs />
        <VCard
            v-if="users"
            id="userslist"
            title="Users List"
        >
            <VDataTable
                v-model:items-per-page="itemsPerPage"
                :headers="headersUsers"
                :items="users"
                :items-length="totalUsers"
                item-value="name"
                class="elevation-1"
                @update:options="loadItems"
            />
        </VCard>
    </div>
</template>

<script setup>
import Breadcrumbs from '@/components/Breadcrumb.vue';
import apiService from '@/services/apiService';
import { onMounted, ref } from 'vue';
import { VDataTable } from 'vuetify/labs/VDataTable';

// Define your dynamic headers to match API data structure
const headersUsers = [
    { text: 'ID', value: 'id', title: 'ID' },
    { text: 'Name', value: 'name', title: 'Name' },
    { text: 'Email', value: 'email', title: 'Email' },
];

// Define your dynamic items
let users = ref([]); 
let itemsPerPage = ref(10);
let totalUsers = ref(0);
let loading = ref(false);

// Load items method
const loadItems = async options => {
    loading.value = true;
    try {
        const response = await apiService.getUsers();

        users.value = response.results.data;
        totalUsers.value = response.results.total;

        // Check if per_page property exists before accessing it
        if (response.results.hasOwnProperty('per_page')) {
            itemsPerPage.value = response.results.per_page;
            console.log('itemsPerPage', itemsPerPage.value);
        }
    } catch (error) {
        console.error('Failed to load users:', error);
    }
    loading.value = false;
};

onMounted(() => {
    loadItems({ page: 1, itemsPerPage: itemsPerPage.value, sortBy: [] });
});
</script>
