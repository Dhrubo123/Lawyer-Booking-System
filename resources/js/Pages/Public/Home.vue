<script setup>
import { Head, Link } from '@inertiajs/vue3';

const { contact, branding } = defineProps({ contact: Object, branding: Object });
const whatsappUrl = (number) => `https://wa.me/${String(number || '').replace(/\D/g, '')}`;

const services = [
    {
        number: '01',
        title: 'Income Tax Consultation',
        text: 'Clear and practical guidance for personal and professional tax matters.',
    },
    {
        number: '02',
        title: 'VAT & Compliance',
        text: 'Support with VAT obligations, compliance, and regulatory requirements.',
    },
    {
        number: '03',
        title: 'Tax Assessment & Appeal',
        text: 'Professional assistance with tax assessments, disputes, and appeals.',
    },
    {
        number: '04',
        title: 'Corporate Tax Advisory',
        text: 'Strategic tax advice for companies, entrepreneurs, and organizations.',
    },
    {
        number: '05',
        title: 'Tax Notice Response',
        text: 'Professional support for understanding and responding to tax notices.',
    },
    {
        number: '06',
        title: 'Business Advisory',
        text: 'Practical legal and business guidance tailored to your circumstances.',
    },
];

const features = [
    {
        title: 'Confidential Advice',
        text: 'Every consultation is handled with discretion and professionalism.',
    },
    {
        title: 'Tax-Focused Guidance',
        text: 'Focused support for tax, VAT, corporate, and business-related matters.',
    },
    {
        title: 'Clear Communication',
        text: 'Complex tax issues explained in a practical and understandable way.',
    },
    {
        title: 'Personal Attention',
        text: 'Direct access to your tax lawyer without unnecessary layers.',
    },
];
</script>

<template>
    <Head title="Tax & General Services" />

    <main class="min-h-screen bg-[#F7F5F1] text-[#22262B]">

        <!-- ========================================= -->
        <!-- NAVBAR -->
        <!-- ========================================= -->

        <header
            class="sticky top-0 z-50 border-b border-[#E4DED9] bg-[#F7F5F1]/95 backdrop-blur"
        >
            <div
                class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8"
            >
                <!-- Brand -->
                <Link href="/" class="flex items-center gap-3">
                    <img v-if="branding?.logo_url" :src="branding.logo_url" alt="Tax & General Services" class="h-12 w-12 rounded-xl object-contain" />
                    <div v-else class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#B56E3C] text-white shadow-sm" aria-hidden="true">
                        <svg viewBox="0 0 48 48" class="h-8 w-8 fill-none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2">
                            <path d="M24 8v27" />
                            <path d="M15 14h18" />
                            <path d="M10 18h10l-5 10-5-10Z" />
                            <path d="M28 18h10l-5 10-5-10Z" />
                            <path d="M16 35h16" />
                            <path d="M20 40h8" />
                        </svg>
                    </div>

                    <div class="leading-tight">
                        <div class="font-semibold tracking-tight">
                            Tax & General Services
                        </div>

                        <div class="text-xs text-[#77777F]">
                            Tax · Legal · Business Advisory
                        </div>
                    </div>
                </Link>

                <!-- Desktop Navigation -->
                <nav class="hidden items-center gap-8 lg:flex">
                    <Link
                        href="/"
                        class="text-sm font-medium text-[#22262B] transition hover:text-[#B56E3C]"
                    >
                        Home
                    </Link>

                    <Link
                        href="/about"
                        class="text-sm font-medium text-[#77777F] transition hover:text-[#B56E3C]"
                    >
                        About
                    </Link>

                    <Link
                        href="/services"
                        class="text-sm font-medium text-[#77777F] transition hover:text-[#B56E3C]"
                    >
                        Services
                    </Link>

                    <Link
                        href="/tax-insights"
                        class="text-sm font-medium text-[#77777F] transition hover:text-[#B56E3C]"
                    >
                        Tax Insights
                    </Link>

                    <Link
                        href="/contact"
                        class="text-sm font-medium text-[#77777F] transition hover:text-[#B56E3C]"
                    >
                        Contact
                    </Link>
                </nav>

                <!-- Main CTA -->
                <Link
                    href="/book-appointment"
                    class="rounded-xl bg-[#B56E3C] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#9E5C32] sm:px-5"
                >
                    <span class="hidden sm:inline">
                        Book Consultation
                    </span>

                    <span class="sm:hidden">
                        Book
                    </span>
                </Link>
            </div>
        </header>

        <!-- ========================================= -->
        <!-- HERO -->
        <!-- ========================================= -->

        <section class="overflow-hidden">
            <div
                class="mx-auto grid max-w-7xl items-center gap-12 px-5 py-14 lg:grid-cols-[1.05fr_.95fr] lg:px-8 lg:py-24"
            >
                <!-- Hero Content -->
                <div>
                    <p
                        class="text-xs font-semibold uppercase tracking-[0.22em] text-[#B56E3C]"
                    >
                        Tax · Legal · Business Advisory
                    </p>

                    <h1
                        class="mt-6 max-w-3xl text-4xl font-semibold leading-[1.08] tracking-tight sm:text-5xl lg:text-6xl"
                    >
                        Strategic Tax Guidance

                        <span class="block text-[#B56E3C]">
                            for Better Decisions.
                        </span>
                    </h1>

                    <p
                        class="mt-6 max-w-xl text-base leading-7 text-[#77777F] md:text-lg"
                    >
                        Professional and confidential tax, legal, and business
                        advisory services for individuals, professionals, and
                        organizations.
                    </p>

                    <!-- Hero Actions -->
                    <div class="mt-8 flex flex-wrap gap-3">
                        <Link
                            href="/services"
                            class="inline-flex items-center gap-2 rounded-xl bg-[#B56E3C] px-6 py-3.5 font-semibold text-white transition hover:bg-[#9E5C32]"
                        >
                            Explore Our Services

                            <span>→</span>
                        </Link>

                        <Link
                            href="/book-appointment"
                            class="inline-flex items-center gap-2 rounded-xl border border-[#CFC7C0] bg-white px-6 py-3.5 font-semibold text-[#22262B] transition hover:border-[#B56E3C] hover:text-[#B56E3C]"
                        >
                            Book Consultation
                        </Link>
                    </div>

                    <!-- Trust Points -->
                    <div
                        class="mt-10 grid max-w-2xl grid-cols-1 gap-5 border-t border-[#E4DED9] pt-7 sm:grid-cols-3"
                    >
                        <div>
                            <div class="font-semibold">
                                Confidential
                            </div>

                            <div class="mt-1 text-sm text-[#77777F]">
                                Professional advice
                            </div>
                        </div>

                        <div>
                            <div class="font-semibold">
                                Practical
                            </div>

                            <div class="mt-1 text-sm text-[#77777F]">
                                Clear next steps
                            </div>
                        </div>

                        <div>
                            <div class="font-semibold">
                                Personal
                            </div>

                            <div class="mt-1 text-sm text-[#77777F]">
                                Direct lawyer access
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================= -->
                <!-- LAWYER HERO IMAGE -->
                <!-- ========================================= -->

                <div class="relative pb-5 md:pb-0">
                    <div
                        class="relative min-h-[440px] overflow-hidden rounded-[28px] bg-[#DDD4CD] sm:min-h-[520px] sm:rounded-[32px]"
                    >
                        <!--
                            IMPORTANT:
                            Image must exist at:

                            public/images/law.jpg

                            Do NOT import this image in script setup.
                        -->

                        <img
                            :src="'/images/law.jpg'"
                            alt="Tax Lawyer - Tax & General Services"
                            class="absolute inset-0 h-full w-full object-cover object-top"
                        />

                        <!-- Bottom gradient -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-[#22262B]/95 via-[#22262B]/15 to-transparent"
                        ></div>

                        <!-- Lawyer Information -->
                        <div
                            class="absolute inset-x-0 bottom-0 p-6 text-white sm:p-7"
                        >
                            <p class="text-sm text-white/65">
                                Tax & General Services
                            </p>

                            <h2 class="mt-1 text-2xl font-semibold">
                                Lawyer Name
                            </h2>

                            <p class="mt-2 text-sm text-white/65">
                                Tax · VAT · Corporate · Business Advisory
                            </p>
                        </div>
                    </div>

                    <!-- Floating Card -->
                    <div
                        class="relative mx-4 -mt-4 rounded-2xl border border-[#E4DED9] bg-white px-5 py-4 shadow-sm sm:absolute sm:-bottom-5 sm:-left-5 sm:mx-0 sm:mt-0"
                    >
                        <p
                            class="text-xs font-medium uppercase tracking-[0.15em] text-[#B56E3C]"
                        >
                            Professional Approach
                        </p>

                        <p class="mt-1 font-semibold">
                            Clarity. Trust. Confidentiality.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================= -->
        <!-- CLIENT TYPE STRIP -->
        <!-- ========================================= -->

        <section class="border-y border-[#E4DED9] bg-white">
            <div
                class="mx-auto grid max-w-7xl gap-7 px-5 py-9 md:grid-cols-3 lg:px-8"
            >
                <div>
                    <p
                        class="text-xs uppercase tracking-[0.15em] text-[#77777F]"
                    >
                        For Individuals
                    </p>

                    <p class="mt-2 font-semibold">
                        Personal tax guidance and representation
                    </p>
                </div>

                <div
                    class="border-t border-[#E4DED9] pt-6 md:border-l md:border-t-0 md:pl-8 md:pt-0"
                >
                    <p
                        class="text-xs uppercase tracking-[0.15em] text-[#77777F]"
                    >
                        For Businesses
                    </p>

                    <p class="mt-2 font-semibold">
                        Corporate tax, VAT, and compliance support
                    </p>
                </div>

                <div
                    class="border-t border-[#E4DED9] pt-6 md:border-l md:border-t-0 md:pl-8 md:pt-0"
                >
                    <p
                        class="text-xs uppercase tracking-[0.15em] text-[#77777F]"
                    >
                        For Professionals
                    </p>

                    <p class="mt-2 font-semibold">
                        Strategic tax and business advisory
                    </p>
                </div>
            </div>
        </section>

        <!-- ========================================= -->
        <!-- SERVICES -->
        <!-- ========================================= -->

        <section class="mx-auto max-w-7xl px-5 py-20 lg:px-8">
            <div
                class="flex flex-col justify-between gap-6 md:flex-row md:items-end"
            >
                <div class="max-w-2xl">
                    <p
                        class="text-xs font-semibold uppercase tracking-[0.2em] text-[#B56E3C]"
                    >
                        Areas of Practice
                    </p>

                    <h2
                        class="mt-4 text-3xl font-semibold tracking-tight sm:text-4xl"
                    >
                        Tax and business matters deserve clear guidance.
                    </h2>

                    <p class="mt-4 leading-7 text-[#77777F]">
                        Professional advisory services designed to help clients
                        understand their obligations, manage risk, and make
                        confident decisions.
                    </p>
                </div>

                <Link
                    href="/services"
                    class="inline-flex text-sm font-semibold text-[#B56E3C]"
                >
                    View all services →
                </Link>
            </div>

            <div
                class="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-3"
            >
                <article
                    v-for="service in services"
                    :key="service.number"
                    class="group flex min-h-[250px] flex-col rounded-2xl border border-[#E4DED9] bg-white p-6 transition duration-200 hover:-translate-y-1 hover:border-[#B56E3C]"
                >
                    <span
                        class="text-sm font-semibold text-[#B56E3C]"
                    >
                        {{ service.number }}
                    </span>

                    <div class="mt-auto pt-12">
                        <h3
                            class="text-xl font-semibold leading-snug"
                        >
                            {{ service.title }}
                        </h3>

                        <p
                            class="mt-3 text-sm leading-6 text-[#77777F]"
                        >
                            {{ service.text }}
                        </p>

                        <Link
                            href="/services"
                            class="mt-5 inline-flex text-sm font-semibold transition group-hover:text-[#B56E3C]"
                        >
                            Learn more →
                        </Link>
                    </div>
                </article>
            </div>
        </section>

        <!-- ========================================= -->
        <!-- ABOUT LAWYER -->
        <!-- ========================================= -->

        <section class="bg-[#22262B]">
            <div
                class="mx-auto grid max-w-7xl gap-12 px-5 py-20 lg:grid-cols-[.9fr_1.1fr] lg:px-8"
            >
                <!-- Lawyer Photo -->
                <div class="relative">
                    <div
                        class="relative min-h-[460px] overflow-hidden rounded-[28px] bg-[#353A3F]"
                    >
                        <img
                            :src="'/images/law.jpg'"
                            alt="Tax Lawyer Professional Profile"
                            class="absolute inset-0 h-full w-full object-cover object-top"
                        />

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-[#22262B]/80 via-transparent to-transparent"
                        ></div>
                    </div>

                    <!-- Profile Overlay -->
                    <div
                        class="absolute bottom-5 left-5 right-5 rounded-2xl border border-white/10 bg-[#22262B]/80 p-5 text-white backdrop-blur"
                    >
                        <p class="text-sm text-white/55">
                            Professional Profile
                        </p>

                        <p class="mt-1 font-semibold">
                            Qualifications and memberships can be displayed here.
                        </p>
                    </div>
                </div>

                <!-- About Content -->
                <div class="flex items-center">
                    <div>
                        <p
                            class="text-xs font-semibold uppercase tracking-[0.2em] text-[#D39A72]"
                        >
                            About the Lawyer
                        </p>

                        <h2
                            class="mt-5 text-3xl font-semibold leading-tight text-white md:text-4xl"
                        >
                            Professional advice built around clarity,
                            confidence, and trust.
                        </h2>

                        <p
                            class="mt-6 max-w-xl leading-7 text-white/65"
                        >
                            Tax matters can become complex quickly. The goal is
                            to provide clients with clear explanations,
                            practical options, and professional support
                            throughout the process.
                        </p>

                        <p
                            class="mt-4 max-w-xl leading-7 text-white/65"
                        >
                            The lawyer's professional biography,
                            qualifications, memberships, and areas of expertise
                            can later be managed from the admin panel.
                        </p>

                        <Link
                            href="/about"
                            class="mt-8 inline-flex items-center gap-2 font-semibold text-[#D39A72]"
                        >
                            Read the full profile

                            <span>→</span>
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================= -->
        <!-- WHY CHOOSE US -->
        <!-- ========================================= -->

        <section class="mx-auto max-w-7xl px-5 py-20 lg:px-8">
            <div
                class="grid gap-12 lg:grid-cols-[.75fr_1.25fr]"
            >
                <div>
                    <p
                        class="text-xs font-semibold uppercase tracking-[0.2em] text-[#B56E3C]"
                    >
                        Why Tax & General Services
                    </p>

                    <h2
                        class="mt-4 max-w-md text-3xl font-semibold leading-tight sm:text-4xl"
                    >
                        Professional guidance without unnecessary complexity.
                    </h2>

                    <p
                        class="mt-5 max-w-md leading-7 text-[#77777F]"
                    >
                        Clients should feel informed and confident about the
                        decisions they make.
                    </p>
                </div>

                <div
                    class="grid gap-x-8 sm:grid-cols-2"
                >
                    <article
                        v-for="feature in features"
                        :key="feature.title"
                        class="border-t border-[#D9D1CB] py-7"
                    >
                        <h3
                            class="text-lg font-semibold"
                        >
                            {{ feature.title }}
                        </h3>

                        <p
                            class="mt-3 text-sm leading-6 text-[#77777F]"
                        >
                            {{ feature.text }}
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <!-- ========================================= -->
        <!-- TAX INSIGHTS -->
        <!-- ========================================= -->

        <section
            class="border-y border-[#E4DED9] bg-white"
        >
            <div
                class="mx-auto max-w-7xl px-5 py-20 lg:px-8"
            >
                <div
                    class="flex flex-col justify-between gap-6 md:flex-row md:items-end"
                >
                    <div>
                        <p
                            class="text-xs font-semibold uppercase tracking-[0.2em] text-[#B56E3C]"
                        >
                            Tax Insights
                        </p>

                        <h2
                            class="mt-4 text-3xl font-semibold sm:text-4xl"
                        >
                            Updates and practical guidance.
                        </h2>

                        <p
                            class="mt-4 max-w-xl leading-7 text-[#77777F]"
                        >
                            Helpful insights about taxation, VAT, compliance,
                            and business matters.
                        </p>
                    </div>

                    <Link
                        href="/tax-insights"
                        class="text-sm font-semibold text-[#B56E3C]"
                    >
                        View all insights →
                    </Link>
                </div>

                <div
                    class="mt-10 grid gap-5 md:grid-cols-3"
                >
                    <!-- Article 1 -->
                    <article
                        class="group rounded-2xl border border-[#E4DED9] bg-[#F7F5F1] p-6 transition hover:border-[#B56E3C]"
                    >
                        <p
                            class="text-xs uppercase tracking-wider text-[#B56E3C]"
                        >
                            Income Tax
                        </p>

                        <h3
                            class="mt-8 text-xl font-semibold"
                        >
                            Understanding your tax obligations
                        </h3>

                        <p
                            class="mt-3 text-sm leading-6 text-[#77777F]"
                        >
                            Article content from your admin panel will appear
                            here.
                        </p>

                        <Link
                            href="/tax-insights"
                            class="mt-6 inline-flex text-sm font-semibold transition group-hover:text-[#B56E3C]"
                        >
                            Read article →
                        </Link>
                    </article>

                    <!-- Article 2 -->
                    <article
                        class="group rounded-2xl border border-[#E4DED9] bg-[#F7F5F1] p-6 transition hover:border-[#B56E3C]"
                    >
                        <p
                            class="text-xs uppercase tracking-wider text-[#B56E3C]"
                        >
                            VAT
                        </p>

                        <h3
                            class="mt-8 text-xl font-semibold"
                        >
                            Staying compliant with VAT requirements
                        </h3>

                        <p
                            class="mt-3 text-sm leading-6 text-[#77777F]"
                        >
                            Publish useful updates and professional tax
                            resources.
                        </p>

                        <Link
                            href="/tax-insights"
                            class="mt-6 inline-flex text-sm font-semibold transition group-hover:text-[#B56E3C]"
                        >
                            Read article →
                        </Link>
                    </article>

                    <!-- Article 3 -->
                    <article
                        class="group rounded-2xl border border-[#E4DED9] bg-[#F7F5F1] p-6 transition hover:border-[#B56E3C]"
                    >
                        <p
                            class="text-xs uppercase tracking-wider text-[#B56E3C]"
                        >
                            Business
                        </p>

                        <h3
                            class="mt-8 text-xl font-semibold"
                        >
                            Tax considerations for business owners
                        </h3>

                        <p
                            class="mt-3 text-sm leading-6 text-[#77777F]"
                        >
                            Build authority by sharing relevant business tax
                            information.
                        </p>

                        <Link
                            href="/tax-insights"
                            class="mt-6 inline-flex text-sm font-semibold transition group-hover:text-[#B56E3C]"
                        >
                            Read article →
                        </Link>
                    </article>
                </div>
            </div>
        </section>

        <!-- ========================================= -->
        <!-- CONSULTATION CTA -->
        <!-- ========================================= -->

        <section
            class="mx-auto max-w-7xl px-5 py-20 lg:px-8"
        >
            <div
                class="grid items-center gap-8 rounded-[30px] bg-[#B56E3C] px-6 py-10 text-white md:grid-cols-[1fr_auto] md:px-10 md:py-12"
            >
                <div>
                    <p
                        class="text-xs font-semibold uppercase tracking-[0.2em] text-white/65"
                    >
                        Need Professional Advice?
                    </p>

                    <h2
                        class="mt-3 text-3xl font-semibold"
                    >
                        Book a confidential consultation.
                    </h2>

                    <p
                        class="mt-3 max-w-2xl leading-7 text-white/75"
                    >
                        Select the service, preferred date, and available time
                        that works for you.
                    </p>
                </div>

                <Link
                    href="/book-appointment"
                    class="inline-flex justify-center rounded-xl bg-white px-6 py-3.5 font-semibold text-[#22262B] transition hover:bg-[#F7F5F1]"
                >
                    Book Consultation →
                </Link>
            </div>
        </section>

        <!-- ========================================= -->
        <!-- FOOTER -->
        <!-- ========================================= -->

        <footer
            class="bg-[#22262B] text-white"
        >
            <div
                class="mx-auto grid max-w-7xl gap-10 px-5 py-14 md:grid-cols-2 lg:grid-cols-4 lg:px-8"
            >
                <!-- Company -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#B56E3C] text-sm font-bold"
                        >
                            TGS
                        </div>

                        <div>
                            <div class="font-semibold">
                                Tax & General Services
                            </div>

                            <div
                                class="text-xs text-white/45"
                            >
                                Tax · Legal · Business Advisory
                            </div>
                        </div>
                    </div>

                    <p
                        class="mt-5 max-w-md text-sm leading-6 text-white/55"
                    >
                        Professional and confidential tax, legal, and business
                        advisory services.
                    </p>
                </div>

                <!-- Navigation -->
                <div>
                    <h3 class="text-sm font-semibold">
                        Navigation
                    </h3>

                    <div
                        class="mt-4 grid gap-3 text-sm text-white/55"
                    >
                        <Link
                            href="/about"
                            class="transition hover:text-white"
                        >
                            About
                        </Link>

                        <Link
                            href="/services"
                            class="transition hover:text-white"
                        >
                            Services
                        </Link>

                        <Link
                            href="/tax-insights"
                            class="transition hover:text-white"
                        >
                            Tax Insights
                        </Link>

                        <Link
                            href="/book-appointment"
                            class="transition hover:text-white"
                        >
                            Book Consultation
                        </Link>

                        <Link
                            href="/contact"
                            class="transition hover:text-white"
                        >
                            Contact
                        </Link>
                    </div>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-sm font-semibold">
                        Contact
                    </h3>

                    <div
                        class="mt-4 space-y-3 text-sm text-white/55"
                    >
                        <p>{{ contact?.phone || 'Phone number to be added' }}</p>

                        <p>{{ contact?.whatsapp || 'WhatsApp number to be added' }}</p>

                        <p>
                            Email address
                        </p>

                        <p>
                            Office address
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-white/10">
                <div
                    class="mx-auto flex max-w-7xl flex-col justify-between gap-3 px-5 py-5 text-xs text-white/40 sm:flex-row lg:px-8"
                >
                    <p>
                        © {{ new Date().getFullYear() }}
                        Tax & General Services. All rights reserved.
                    </p>

                    <div class="flex gap-5">
                        <Link
                            href="/privacy-policy"
                            class="transition hover:text-white"
                        >
                            Privacy Policy
                        </Link>

                        <Link
                            href="/terms"
                            class="transition hover:text-white"
                        >
                            Terms
                        </Link>
                    </div>
                </div>
            </div>
        </footer>

        <!-- ========================================= -->
        <!-- FLOATING CONTACT BUTTONS -->
        <!-- ========================================= -->

        <div
            class="fixed bottom-5 right-4 z-40 flex flex-col gap-3 sm:right-5"
        >
            <!-- WhatsApp -->
            <a
                v-if="contact?.whatsapp"
                :href="whatsappUrl(contact.whatsapp)"
                target="_blank"
                rel="noopener"
                aria-label="Contact on WhatsApp"
                class="flex h-12 w-12 items-center justify-center rounded-full bg-[#25D366] text-xs font-bold text-white shadow-lg transition hover:scale-105"
            >
                WA
            </a>

            <!-- Call -->
            <a
                v-if="contact?.phone"
                :href="`tel:${contact.phone}`"
                aria-label="Call Tax and General Services"
                class="flex h-12 w-12 items-center justify-center rounded-full bg-[#B56E3C] text-lg text-white shadow-lg transition hover:scale-105"
            >
                ☎
            </a>
        </div>
    </main>
</template>
