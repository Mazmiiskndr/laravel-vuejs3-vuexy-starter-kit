<template>
    <!-- <Breadcrumbs /> -->
    <VCard
        v-if="users"
        id="userslist"
    >
        <VDataTable
            v-model:items-per-page="itemsPerPage"
            :headers="headersUsers"
            :items="users"
            item-value="name"
            class="elevation-1"
        />
    </VCard>
</template>

<script setup>
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

const loadItems = async () => {
    try {
        const response = await apiService.getUsers();

        users.value = response.results.data;
        itemsPerPage.value = response.results.per_page;
    } catch (error) {
        console.error('Failed to load users:', error);
    }
};

onMounted(loadItems);
</script>
