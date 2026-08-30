<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const { services, confirmedAppointment, branding, availableDates } = defineProps({ services: Array, confirmedAppointment: Object, branding: Object, availableDates: Array });

const step = ref(confirmedAppointment ? 5 : 1);

const selectedType = ref('');
const selectedService = ref('');
const selectedDate = ref('');
const selectedTime = ref('');

const dateLabel = (date) => new Intl.DateTimeFormat('en', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(`${date}T00:00:00`));
const weekdayLabel = (date) => new Intl.DateTimeFormat('en', { weekday: 'long' }).format(new Date(`${date}T00:00:00`));
const timeLabel = (time) => new Date(`2000-01-01T${time}`).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });

const form = useForm({
    consultation_type: '',
    service_id: '',
    appointment_date: '',
    start_time: '',
    client_name: '',
    client_phone: '',
    client_email: '',
    client_message: '',
});

const consultationTypes = [
    {
        value: 'chamber',
        title: 'Chamber Consultation',
        description: 'Meet the lawyer at the office.',
    },
    {
        value: 'video',
        title: 'Video Consultation',
        description: 'Consult online through video call.',
    },
    {
        value: 'phone',
        title: 'Phone Consultation',
        description: 'Speak directly by phone.',
    },
];

const nextStep = () => {
    if ((step.value === 1 && !selectedType.value) || (step.value === 2 && !selectedService.value) || (step.value === 3 && (!selectedDate.value || !selectedTime.value))) return;
    if (step.value < 5) {
        step.value++;
    }
};

const previousStep = () => {
    if (step.value > 1) {
        step.value--;
    }
};

const selectType = (type) => {
    selectedType.value = type;
    form.consultation_type = type;
};

const selectService = (service) => {
    selectedService.value = service;
    form.service_id = service.id;
};

const selectSlot = (date, slot) => {
    selectedDate.value = date;
    selectedTime.value = slot;
    form.appointment_date = date;
    form.start_time = slot.start_time;
    step.value = 4;
};

const submitAppointment = () => {
    form.post('/appointments', {
        preserveScroll: true,
        onSuccess: (page) => { if (page.props.confirmedAppointment) step.value = 5; },
        onError: (errors) => { step.value = errors.start_time ? 3 : 4; },
    });
};
</script>

<template>
    <Head title="Book an Appointment" />

    <main class="min-h-screen bg-[#F7F5F1] text-[#22262B]">
        <!-- Header -->
        <header
            class="border-b border-[#E4DED9] bg-white/95 backdrop-blur"
        >
            <div
                class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 lg:px-8"
            >
                <Link href="/" class="flex items-center gap-3">
                    <img v-if="branding?.logo_url" :src="branding.logo_url" alt="Tax & General Services" class="h-12 w-12 rounded-xl object-contain" />
                    <div v-else
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#22262B] text-sm font-bold text-white"
                    >
                        TGS
                    </div>

                    <div class="leading-tight">
                        <div class="font-semibold">
                            Tax & General Services
                        </div>

                        <div class="text-xs text-[#77777F]">
                            Tax · Legal · Business Advisory
                        </div>
                    </div>
                </Link>

                <Link
                    href="/"
                    class="text-sm font-medium text-[#77777F] transition hover:text-[#B56E3C]"
                >
                    ← Back to home
                </Link>
            </div>
        </header>

        <!-- Hero -->
        <section
            class="mx-auto max-w-7xl px-5 pb-10 pt-12 text-center lg:px-8"
        >
            <p
                class="text-xs font-semibold uppercase tracking-[0.2em] text-[#B56E3C]"
            >
                Tax · Legal · Business Advisory
            </p>

            <h1
                class="mt-4 text-4xl font-semibold tracking-tight md:text-5xl"
            >
                Book a Consultation
            </h1>

            <p
                class="mx-auto mt-4 max-w-2xl text-base leading-7 text-[#77777F]"
            >
                Choose your consultation type, service, preferred date and
                available time. We'll take care of the rest.
            </p>
        </section>

        <!-- Booking Card -->
        <section class="mx-auto max-w-5xl px-5 pb-20 lg:px-8">
            <div
                class="overflow-hidden rounded-3xl border border-[#E4DED9] bg-white"
            >
                <!-- Progress -->
                <div
                    class="border-b border-[#E4DED9] px-6 py-5 md:px-8"
                >
                    <div
                        class="grid grid-cols-5 gap-2 text-center text-xs md:text-sm"
                    >
                        <div
                            :class="
                                step >= 1
                                    ? 'text-[#B56E3C]'
                                    : 'text-[#9CA3AF]'
                            "
                        >
                            1. Consultation
                        </div>

                        <div
                            :class="
                                step >= 2
                                    ? 'text-[#B56E3C]'
                                    : 'text-[#9CA3AF]'
                            "
                        >
                            2. Service
                        </div>

                        <div
                            :class="
                                step >= 3
                                    ? 'text-[#B56E3C]'
                                    : 'text-[#9CA3AF]'
                            "
                        >
                            3. Date & Time
                        </div>

                        <div
                            :class="
                                step >= 4
                                    ? 'text-[#B56E3C]'
                                    : 'text-[#9CA3AF]'
                            "
                        >
                            4. Details
                        </div>

                        <div
                            :class="
                                step >= 5
                                    ? 'text-[#B56E3C]'
                                    : 'text-[#9CA3AF]'
                            "
                        >
                            5. Confirm
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <!-- STEP 1 -->
                    <div v-if="step === 1">
                        <h2 class="text-2xl font-semibold">
                            How would you like to consult?
                        </h2>

                        <p class="mt-2 text-[#77777F]">
                            Select your preferred consultation type.
                        </p>

                        <div
                            class="mt-7 grid gap-4 md:grid-cols-3"
                        >
                            <button
                                v-for="type in consultationTypes"
                                :key="type.value"
                                type="button"
                                @click="selectType(type.value)"
                                class="rounded-2xl border p-5 text-left transition"
                                :class="
                                    selectedType === type.value
                                        ? 'border-[#B56E3C] bg-[#F4E8DF]'
                                        : 'border-[#E4DED9] hover:border-[#B56E3C]'
                                "
                            >
                                <h3 class="font-semibold">
                                    {{ type.title }}
                                </h3>

                                <p
                                    class="mt-2 text-sm leading-6 text-[#77777F]"
                                >
                                    {{ type.description }}
                                </p>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2 -->
                    <div v-if="step === 2">
                        <h2 class="text-2xl font-semibold">
                            What can we help you with?
                        </h2>

                        <p class="mt-2 text-[#77777F]">
                            Select the service related to your consultation.
                        </p>

                        <div
                            class="mt-7 grid gap-4 md:grid-cols-2"
                        >
                            <button
                                v-for="service in services"
                                :key="service.id"
                                type="button"
                                @click="selectService(service)"
                                class="rounded-2xl border p-5 text-left transition"
                                :class="
                                    selectedService?.id === service.id
                                        ? 'border-[#B56E3C] bg-[#F4E8DF]'
                                        : 'border-[#E4DED9] hover:border-[#B56E3C]'
                                "
                            >
                                <span
                                    class="text-xs font-semibold text-[#B56E3C]"
                                >
                                    TAX SERVICE
                                </span>

                                <h3 class="mt-2 font-semibold">
                                    {{ service.name }}
                                </h3>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3 -->
                    <div v-if="step === 3">
                        <h2 class="text-2xl font-semibold">
                            Select a Date & Time
                        </h2>

                        <p class="mt-2 text-[#77777F]">
                            Select one of the appointment times published by the lawyer.
                        </p>
                        <p v-if="form.errors.start_time" class="mt-3 rounded-xl bg-red-50 p-3 text-sm text-red-700">{{ form.errors.start_time }}</p>

                        <div v-if="availableDates.length" class="date-card-grid mt-7">
                            <article
                                v-for="availableDate in availableDates"
                                :key="availableDate.date"
                                class="date-card"
                                :class="{ selected: selectedDate === availableDate.date, unavailable: availableDate.available_slots === 0 }"
                            >
                                <span>{{ dateLabel(availableDate.date) }}</span>
                                <strong>{{ weekdayLabel(availableDate.date) }}</strong>
                                <small>{{ availableDate.available_slots }} available slot{{ availableDate.available_slots === 1 ? '' : 's' }}</small>

                                <div v-if="availableDate.slots?.length" class="mt-3 grid gap-2">
                                    <button
                                        v-for="slot in availableDate.slots"
                                        :key="slot.start_time"
                                        type="button"
                                        class="w-full rounded-lg bg-[#B56E3C] px-3 py-2 text-sm font-semibold text-white transition hover:bg-[#94552B]"
                                        @click="selectSlot(availableDate.date, slot)"
                                    >
                                        {{ timeLabel(slot.start_time) }} – {{ timeLabel(slot.end_time) }}
                                    </button>
                                </div>

                                <em v-else>Fully booked</em>
                            </article>
                        </div>
                        <p v-else class="mt-7 rounded-xl bg-[#F4E8DF] p-4 text-sm text-[#77777F]">No appointment dates are currently available. Please contact us or check again later.</p>
                    </div>

                    <!-- STEP 4 -->
                    <div v-if="step === 4">
                        <h2 class="text-2xl font-semibold">
                            Your Information
                        </h2>

                        <p class="mt-2 text-[#77777F]">
                            Please enter your contact details.
                        </p>

                        <p v-if="Object.keys(form.errors).length" class="mt-4 rounded-xl bg-red-50 p-3 text-sm text-red-700">Please correct the highlighted information and submit again.</p>

                        <div
                            class="mt-7 grid gap-5 md:grid-cols-2"
                        >
                            <div>
                                <label class="text-sm font-medium">
                                    Full Name
                                </label>

                                <input
                                    v-model="form.client_name"
                                    type="text"
                                    class="mt-2 w-full rounded-xl border border-[#E4DED9] px-4 py-3 outline-none transition focus:border-[#B56E3C]"
                                />
                                <p v-if="form.errors.client_name" class="mt-1 text-sm text-red-600">{{ form.errors.client_name }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium">
                                    Phone
                                </label>

                                <input
                                    v-model="form.client_phone"
                                    type="text"
                                    class="mt-2 w-full rounded-xl border border-[#E4DED9] px-4 py-3 outline-none transition focus:border-[#B56E3C]"
                                />
                                <p v-if="form.errors.client_phone" class="mt-1 text-sm text-red-600">{{ form.errors.client_phone }}</p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-sm font-medium">
                                    Email
                                </label>

                                <input
                                    v-model="form.client_email"
                                    type="email"
                                    class="mt-2 w-full rounded-xl border border-[#E4DED9] px-4 py-3 outline-none transition focus:border-[#B56E3C]"
                                />
                                <p v-if="form.errors.client_email" class="mt-1 text-sm text-red-600">{{ form.errors.client_email }}</p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-sm font-medium">
                                    Briefly describe your tax matter
                                </label>

                                <textarea
                                    v-model="form.client_message"
                                    rows="4"
                                    class="mt-2 w-full rounded-xl border border-[#E4DED9] px-4 py-3 outline-none transition focus:border-[#B56E3C]"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 5 -->
                    <div v-if="step === 5">
                        <div class="py-8 text-center">
                            <div
                                class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#F4E8DF] text-2xl text-[#B56E3C]"
                            >
                                ✓
                            </div>

                            <h2 class="mt-5 text-3xl font-semibold">
                                Your appointment has been successfully applied.
                            </h2>

                            <p
                                class="mx-auto mt-3 max-w-lg text-[#77777F]"
                            >
                                Thank you. Your consultation request has been
                                submitted successfully.
                            </p>

                            <p v-if="confirmedAppointment" class="mt-4 font-semibold text-[#22262B]">Reference: {{ confirmedAppointment.appointment_no }}</p>

                            <Link
                                href="/"
                                class="mt-7 inline-flex rounded-xl bg-[#22262B] px-6 py-3 font-medium text-white transition hover:bg-[#B56E3C]"
                            >
                                Back to Home
                            </Link>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div
                        v-if="step < 5"
                        class="mt-8 flex items-center justify-between border-t border-[#E4DED9] pt-6"
                    >
                        <button
                            v-if="step > 1"
                            type="button"
                            @click="previousStep"
                            class="rounded-xl border border-[#E4DED9] px-5 py-3 font-medium"
                        >
                            ← Back
                        </button>

                        <div v-else></div>

                        <button
                            v-if="step < 4"
                            type="button"
                            @click="nextStep"
                            class="rounded-xl bg-[#B56E3C] px-6 py-3 font-medium text-white transition hover:bg-[#9E5C32]"
                        >
                            Continue →
                        </button>

                        <button
                            v-else
                            type="button"
                            :disabled="form.processing"
                            @click="submitAppointment"
                            class="rounded-xl bg-[#B56E3C] px-6 py-3 font-medium text-white transition hover:bg-[#9E5C32] disabled:opacity-50"
                        >
                            {{
                                form.processing
                                    ? 'Booking...'
                                    : 'Confirm Appointment'
                            }}
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>
