<script setup>
import { Head, router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import AdminLayout from '../../Layouts/AdminLayout.vue';

const props = defineProps({ schedules: Array, dates: Array });
const names = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
const rows = reactive(Object.fromEntries(props.schedules.map((schedule) => [schedule.id, { is_available: schedule.is_available, start_time: schedule.start_time?.slice(0, 5), end_time: schedule.end_time?.slice(0, 5), slot_duration: schedule.slot_duration }])));
const dateForm = reactive({ date: '', start_time: '09:00', end_time: '17:00', slot_duration: 60, is_available: true });
const saving = reactive({});
const dateSaving = ref(false);
const dateError = ref('');
const save = (schedule) => { saving[schedule.id] = true; router.put(`/admin/availability/${schedule.id}`, rows[schedule.id], { preserveScroll: true, onFinish: () => { saving[schedule.id] = false; } }); };
const addDate = () => { dateError.value = ''; dateSaving.value = true; router.post('/admin/availability/dates', dateForm, { preserveScroll: true, onError: (errors) => { dateError.value = errors.date || errors.start_time || errors.end_time || 'Please check the entered date and time.'; }, onFinish: () => { dateSaving.value = false; } }); };
const removeDate = (id) => router.delete(`/admin/availability/dates/${id}`, { preserveScroll: true });
const formatDate = (value) => {
    // Laravel serializes a cast date as an ISO timestamp.  Do not append a
    // second time component to it, otherwise the entire availability page
    // stops rendering with "Invalid time value".
    const date = new Date(value);

    if (Number.isNaN(date.getTime())) return String(value ?? 'Date unavailable');

    return new Intl.DateTimeFormat('en', {
        weekday: 'long',
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        timeZone: 'UTC',
    }).format(date);
};
</script>

<template>
    <Head title="Availability" />
    <AdminLayout>
        <div class="page-heading"><div><p class="eyebrow">Booking controls</p><h1>Availability</h1><p>Publish precise dates or use your regular weekly working pattern.</p></div></div>
        <section class="specific-availability"><p class="eyebrow">Specific dates</p><h2>Publish only the dates you choose</h2><p>Add two dates, a week, ten days, or any custom future dates. Once dates are added here, visitors see only these dates on the booking page.</p><form class="specific-form" @submit.prevent="addDate"><label>Date<input v-model="dateForm.date" :min="new Date().toISOString().slice(0, 10)" type="date" required></label><label>Start<input v-model="dateForm.start_time" type="time" required></label><label>End<input v-model="dateForm.end_time" type="time" required></label><label>Duration<select v-model.number="dateForm.slot_duration"><option :value="60">1 hour</option><option :value="90">1 hour 30 min</option><option :value="120">2 hours</option><option :value="180">3 hours</option></select></label><button class="button primary" :disabled="dateSaving">{{ dateSaving ? 'Adding…' : 'Add date' }} <span>+</span></button></form><p v-if="dateError" class="form-error">{{ dateError }}</p><div v-if="dates.length" class="specific-date-list"><article v-for="item in dates" :key="item.id"><div><strong>{{ formatDate(item.date) }}</strong><span>{{ item.start_time.slice(0, 5) }} – {{ item.end_time.slice(0, 5) }} · {{ item.slot_duration }} minutes</span></div><button class="delete-button" type="button" @click="removeDate(item.id)">Remove</button></article></div><p v-else class="specific-empty">No specific dates yet. The weekly schedule below is currently used.</p></section>
        <section class="weekly-section"><p class="eyebrow">Weekly fallback</p><h2>Regular working hours</h2><p>These hours are used only when no specific dates are published above.</p><div class="availability-list"><article v-for="schedule in schedules" :key="schedule.id" class="availability-card"><div class="availability-day"><strong>{{ names[schedule.day_of_week] }}</strong><label class="toggle"><input v-model="rows[schedule.id].is_available" type="checkbox"><span></span><em>{{ rows[schedule.id].is_available ? 'Available' : 'Unavailable' }}</em></label></div><div v-if="rows[schedule.id].is_available" class="availability-fields"><label>Start time<input v-model="rows[schedule.id].start_time" type="time"></label><label>End time<input v-model="rows[schedule.id].end_time" type="time"></label><label>Appointment duration<select v-model.number="rows[schedule.id].slot_duration"><option :value="60">1 hour</option><option :value="90">1 hour 30 minutes</option><option :value="120">2 hours</option><option :value="180">3 hours</option></select></label></div><div v-else class="unavailable-copy">Clients cannot book an appointment on this day.</div><button class="button primary availability-save" :disabled="saving[schedule.id]" @click="save(schedule)">{{ saving[schedule.id] ? 'Saving…' : 'Save changes' }} <span>→</span></button></article></div></section>
    </AdminLayout>
</template>
