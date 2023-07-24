<template>
  <div>
    <VBreadcrumbs
      :items="breadcrumbs"
      divider="/"
    />
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import titles from '../../js/navigation/vertical/index';

const breadcrumbs = ref([]);

onMounted(() => {
  setBreadcrumbs();
});

const setBreadcrumbs = () => {
  const route = useRoute();
  
  breadcrumbs.value = titles.filter(item => item.title === 'Home' || item.to.name === route.name);
};
</script>
