<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const open = ref(false);
const page = usePage();
const links = [
    ['Dashboard', 'admin.dashboard', '/admin/dashboard'], ['Appointments', 'admin.appointments', '/admin/appointments'],
    ['Calendar', 'admin.calendar', '/admin/calendar'], ['Availability', 'admin.availability', '/admin/availability'],
    ['Clients', 'admin.clients', '/admin/clients'], ['Services', 'admin.services', '/admin/services'],
    ['Tax Insights', 'admin.insights', '/admin/tax-insights'], ['Settings', 'admin.settings', '/admin/settings'],
];
const current = (url) => page.url.startsWith(url);
</script>

<template>
    <div class="admin-shell">
        <button class="admin-overlay" :class="{ visible: open }" aria-label="Close navigation" @click="open = false" />
        <aside class="admin-sidebar" :class="{ open }">
            <Link href="/" class="admin-brand"><span>TGS</span><small>Tax & General<br>Services</small></Link>
            <nav aria-label="Admin navigation">
                <Link v-for="([label, _name, href]) in links" :key="href" :href="href" class="nav-link" :class="{ active: current(href) }" @click="open = false">{{ label }}</Link>
            </nav>
            <Link href="/" class="admin-exit">← View website</Link>
        </aside>
        <main class="admin-main">
            <header class="admin-topbar"><button class="menu-button" aria-label="Open navigation" @click="open = true">☰</button><div><p>Tax & General Services</p><strong>Administration</strong></div><div class="admin-avatar">A</div></header>
            <section class="admin-content"><slot /></section>
        </main>
    </div>
</template>
