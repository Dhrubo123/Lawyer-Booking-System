<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '../../Layouts/AdminLayout.vue';
defineProps({ title: String, description: String, services: Array });
</script>
<template><Head :title="title" /><AdminLayout><div class="page-heading"><div><p class="eyebrow">Administration</p><h1>{{ title }}</h1><p>{{ description }}</p></div></div><div class="content-card feature-placeholder"><span>✦</span><h2>{{ title }} workspace</h2><p>This Vue workspace is ready for its Laravel-backed management tools.</p></div></AdminLayout></template>
