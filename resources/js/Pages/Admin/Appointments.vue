<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '../../Layouts/AdminLayout.vue';
defineProps({ appointments: Object });
const accept = (id) => router.patch(`/admin/appointments/${id}/status`, { status: 'confirmed' }, { preserveScroll: true });
</script>
<template>
    <Head title="Appointments" />
    <AdminLayout>
        <div class="page-heading"><div><p class="eyebrow">Consultations</p><h1>Appointments</h1><p>Review, confirm, and manage every client booking.</p></div><button class="button primary">Add appointment <span>+</span></button></div>
        <div class="content-card"><div class="filters"><input aria-label="Search appointments" placeholder="Search client, phone, or appointment no."><select aria-label="Filter by status"><option>All statuses</option><option>Pending</option><option>Confirmed</option><option>Completed</option></select><button class="filter-button">Filters</button></div>
            <div class="table-wrap"><table><thead><tr><th>Appointment</th><th>Client</th><th>Service</th><th>Date & time</th><th>Status</th><th></th></tr></thead><tbody><tr v-for="item in appointments.data" :key="item.id"><td><strong>{{ item.appointment_no }}</strong><small>{{ item.consultation_type }}</small></td><td><strong>{{ item.client_name }}</strong><small>{{ item.client_phone }}</small></td><td>{{ item.service?.name }}</td><td>{{ item.appointment_date }}<small>{{ item.start_time?.slice(0, 5) }} – {{ item.end_time?.slice(0, 5) }}</small></td><td><span :class="`badge ${item.status}`">{{ item.status }}</span></td><td class="table-actions"><button v-if="item.status === 'pending'" class="accept-button" @click="accept(item.id)">Accept</button><Link :href="`/admin/appointments/${item.id}`" class="row-action">View →</Link></td></tr></tbody></table></div>
            <div v-if="!appointments.data.length" class="empty-state"><span>○</span><h3>No appointments found</h3><p>New consultation requests will appear here.</p></div>
        </div>
    </AdminLayout>
</template>
