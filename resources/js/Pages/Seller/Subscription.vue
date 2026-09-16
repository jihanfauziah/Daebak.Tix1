<template>
  <Layout title="Paket Langganan Promotor" :profile="profile">
    <div class="space-y-8">
      <!-- Current Plan Status Card -->
      <Card padding-class="p-6" custom-class="bg-gradient-to-r from-[#FDE8D3] via-white to-[#DAEBE3] border border-[#CFD6C4]/60">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
          <div>
            <span class="text-xs font-bold text-[#657166]/70 uppercase tracking-wider">Paket Aktif Saat Ini</span>
            <h2 class="font-heading text-2xl text-[#657166] mt-1">
              {{ formatPackageName(profile?.subscription_type) }}
            </h2>
            <p class="text-xs text-[#657166]/80 mt-1">
              Masa Berlaku: {{ profile?.subscription_expires_at ? new Date(profile.subscription_expires_at).toLocaleDateString('id-ID') : 'Tanpa Batas Waktu' }}
            </p>
          </div>
          <Badge variant="success" :dot="true">Status: Active</Badge>
        </div>
      </Card>

      <!-- Plan Options -->
      <div class="grid lg:grid-cols-3 gap-8">
        <!-- Option B: Akun Free (Per-Event) -->
        <Card padding-class="p-8" custom-class="flex flex-col justify-between">
          <div class="space-y-4">
            <Badge variant="default">MODEL PER-EVENT (FREE)</Badge>
            <h3 class="font-heading text-2xl text-[#657166]">Gratis / Per-Event</h3>
            <p class="text-xs text-[#657166]/75">Cocok untuk promotor yang menyelenggarakan event sesekali.</p>
            
            <div class="py-4 border-y border-[#CFD6C4]/40 space-y-2 text-xs text-[#657166]">
              <p class="font-semibold">• Komisi platform: 5% per tiket</p>
              <p class="font-semibold">• Durasi awal: 7 Hari atau 12 Hari</p>
              <p class="font-semibold">• Perpanjangan: +5 Hari / +7 Hari</p>
              <p class="text-[#E76F51]">• Event nonaktif bila durasi habis</p>
            </div>
          </div>

          <div class="pt-6">
            <DarkButton @click="selectPackage('free_per_event')" custom-class="w-full py-3 text-xs">
              Pilih Model Per-Event
            </DarkButton>
          </div>
        </Card>

        <!-- Option A: Paket 1 Bulan -->
        <Card padding-class="p-8" custom-class="border-2 border-[#99CDD8] flex flex-col justify-between relative overflow-hidden bg-white">
          <div class="space-y-4">
            <Badge variant="blue">PRO PLAN — 1 BULAN</Badge>
            <h3 class="font-heading text-2xl text-[#657166]">Paket 1 Bulan</h3>
            <div class="font-heading text-3xl text-[#657166]">
              Rp 499.000 <span class="text-xs font-sans text-[#657166]/70">/ bulan</span>
            </div>
            
            <ul class="space-y-2.5 text-xs text-[#657166] pt-2">
              <li class="flex items-center gap-2"><span class="text-[#1E4D38] font-bold">✓</span> Komisi platform lebih hemat (2%)</li>
              <li class="flex items-center gap-2"><span class="text-[#1E4D38] font-bold">✓</span> Buat event tanpa batasan kuota</li>
              <li class="flex items-center gap-2"><span class="text-[#1E4D38] font-bold">✓</span> Akses staf scanner PWA unlimited</li>
            </ul>
          </div>

          <div class="pt-6">
            <PrimaryButton @click="selectPackage('paid_1m')" custom-class="w-full py-3 text-xs shadow-md">
              Aktifkan Paket 1 Bulan
            </PrimaryButton>
          </div>
        </Card>

        <!-- Option A: Paket 3 Bulan -->
        <Card padding-class="p-8" custom-class="border-2 border-[#F3C3B2] flex flex-col justify-between relative overflow-hidden bg-white">
          <div class="absolute -top-3 -right-3 bg-[#F3C3B2] text-[#4A3525] text-[10px] font-bold px-4 py-2 rounded-bl-2xl">
            HEMAT 15%
          </div>
          <div class="space-y-4">
            <Badge variant="coral">PRO PLAN — 3 BULAN</Badge>
            <h3 class="font-heading text-2xl text-[#657166]">Paket 3 Bulan</h3>
            <div class="font-heading text-3xl text-[#657166]">
              Rp 1.299.000 <span class="text-xs font-sans text-[#657166]/70">/ 3 bulan</span>
            </div>
            
            <ul class="space-y-2.5 text-xs text-[#657166] pt-2">
              <li class="flex items-center gap-2"><span class="text-[#1E4D38] font-bold">✓</span> Komisi platform terendah (2%)</li>
              <li class="flex items-center gap-2"><span class="text-[#1E4D38] font-bold">✓</span> Masa aktif 90 hari tanpa jeda</li>
              <li class="flex items-center gap-2"><span class="text-[#1E4D38] font-bold">✓</span> Prioritas verifikasi & support</li>
            </ul>
          </div>

          <div class="pt-6">
            <SecondaryButton @click="selectPackage('paid_3m')" custom-class="w-full py-3 text-xs shadow-md">
              Aktifkan Paket 3 Bulan
            </SecondaryButton>
          </div>
        </Card>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DarkButton from '@/Components/DarkButton.vue';

defineProps({
  profile: Object,
  history: Array,
});

const formatPackageName = (type) => {
  if (type === 'paid_1m') return 'Paket Promotor Pro (1 Bulan)';
  if (type === 'paid_3m') return 'Paket Promotor Pro (3 Bulan)';
  if (type === 'free') return 'Akun Free — Skema Per-Event';
  return 'Akun Promotor Standar';
};

const selectPackage = (pkg) => {
  if (confirm(`Konfirmasi pemilihan paket langganan ${pkg}?`)) {
    router.post('/seller/subscription/purchase', { package: pkg });
  }
};
</script>
