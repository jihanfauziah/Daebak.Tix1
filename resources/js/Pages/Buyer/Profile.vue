<template>
  <Layout>
    <div class="card-daebak p-8 bg-white max-w-xl mx-auto space-y-4">
      <h1 class="font-heading text-xl text-daebak-charcoal mb-4">Profil Akun Pembeli</h1>

      <div class="space-y-4 text-xs">
        <div>
          <label class="block font-semibold text-daebak-charcoal/70 mb-1">NIK (1 Orang = 1 Akun)</label>
          <input type="text" :value="user.nik" class="w-full input-daebak text-sm bg-slate-50 font-mono" readonly />
        </div>

        <div>
          <label class="block font-semibold text-daebak-charcoal/70 mb-1">Nama Lengkap</label>
          <input type="text" :value="user.name" class="w-full input-daebak text-sm bg-slate-50" readonly />
        </div>

        <div>
          <label class="block font-semibold text-daebak-charcoal/70 mb-1">Username & Email</label>
          <input type="text" :value="`@${user.username} (${user.email})`" class="w-full input-daebak text-sm bg-slate-50" readonly />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold text-daebak-charcoal/70 mb-1">Umur</label>
            <input type="text" :value="`${user.age} Tahun`" class="w-full input-daebak text-sm bg-slate-50" readonly />
          </div>
          <div>
            <label class="block font-semibold text-daebak-charcoal/70 mb-1">Gender</label>
            <input type="text" :value="user.gender" class="w-full input-daebak text-sm bg-slate-50 capitalize" readonly />
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';

defineProps({
  user: Object
});
</script>
