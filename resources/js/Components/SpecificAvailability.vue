<script setup>
import { reactive, ref } from 'vue';
import { router } from '@inertiajs/vue3';

defineProps({ dates: Array });
const form = reactive({ date: '', start_time: '09:00', end_time: '17:00', slot_duration: 60, is_available: true });
const saving = ref(false);
const error = ref('');
const format = (date) => new Intl.DateTimeFormat('en', { weekday: 'long', day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(`${date}T00:00:00`));
const add = () => { error.value = ''; saving.value = true; router.post('/admin/availability/dates', form, { preserveScroll: true, onError: (errors) => { error.value = errors.date || errors.end_time || 'Please check the entered date and time.'; }, onFinish: () => { saving.value = false; } }); };
const remove = (id) => router.delete(`/admin/availability/dates/${id}`, { preserveScroll: true });
</script>
<template><section class="specific-availability"><div class="specific-heading"><div><p class="eyebrow">Specific dates</p><h2>Publish only the dates you choose</h2><p>Add two dates, a week, ten days, or any custom future dates. When dates are added here, visitors see only these dates in booking.</p></div></div><form class="specific-form" @submit.prevent="add"><label>Date<input v-model="form.date" :min="new Date().toISOString().slice(0, 10)" type="date" required></label><label>Start<input v-model="form.start_time" type="time" required></label><label>End<input v-model="form.end_time" type="time" required></label><label>Duration<select v-model.number="form.slot_duration"><option :value="60">1 hour</option><option :value="90">1 hour 30 min</option><option :value="120">2 hours</option><option :value="180">3 hours</option></select></label><button class="button primary" :disabled="saving">{{ saving ? 'Adding…' : 'Add date' }} <span>+</span></button></form><p v-if="error" class="form-error">{{ error }}</p><div v-if="dates.length" class="specific-date-list"><article v-for="item in dates" :key="item.id"><div><strong>{{ format(item.date) }}</strong><span>{{ item.start_time.slice(0,5) }} – {{ item.end_time.slice(0,5) }} · {{ item.slot_duration }} min</span></div><button class="delete-button" type="button" @click="remove(item.id)">Remove</button></article></div><p v-else class="specific-empty">No specific dates yet. The weekly schedule is currently used for booking.</p></section></template>
