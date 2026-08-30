<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '../../Layouts/AdminLayout.vue';
defineProps({ stats: Array, todayAppointments: Array });
const badge = (status) => `badge ${status}`;
</script>

<template>
    <Head title="Admin dashboard" />
    <AdminLayout>
        <div class="page-heading"><div><p class="eyebrow">Overview</p><h1>Good morning.</h1><p>Here’s what’s happening with your consultations today.</p></div><Link href="/admin/appointments" class="button primary">View appointments <span>→</span></Link></div>
        <div class="stat-grid"><article v-for="stat in stats" :key="stat.label" class="stat-card" :class="stat.tone"><p>{{ stat.label }}</p><strong>{{ stat.value }}</strong><span>Current schedule</span></article></div>
        <div class="content-card schedule-card"><div class="card-header"><div><p class="eyebrow">Today’s schedule</p><h2>Appointments</h2></div><Link href="/admin/calendar" class="text-link">Open calendar →</Link></div>
            <div v-if="todayAppointments.length" class="schedule-list"><div v-for="appointment in todayAppointments" :key="appointment.id" class="schedule-row"><time>{{ appointment.start_time?.slice(0, 5) }}</time><div><strong>{{ appointment.client_name }}</strong><p>{{ appointment.service?.name }} · {{ appointment.consultation_type }}</p></div><span :class="badge(appointment.status)">{{ appointment.status }}</span></div></div>
            <div v-else class="empty-state"><span>○</span><h3>No appointments today</h3><p>Your schedule is clear. You can manage availability or review upcoming bookings.</p><Link href="/admin/availability" class="text-link">Manage availability →</Link></div>
        </div>
    </AdminLayout>
</template>
