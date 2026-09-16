<template>
  <Layout title="Kelola Akun Staf Lapangan (PWA)" :profile="profile">
    <div class="space-y-6">
      <!-- Info Header Banner -->
      <div class="card-daebak p-6 bg-white">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h2 class="font-heading text-lg text-daebak-charcoal">Buat & Kelola Akun Staf Scanner Tiket</h2>
            <p class="text-xs text-daebak-charcoal/70">Petugas lapangan mengakses web PWA via kamera HP dengan Kredensial Toko (Email Toko + Password Toko + Kode Akun Toko).</p>
          </div>
          <button @click="showModal = true" class="btn-daebak-primary text-xs font-semibold px-5 py-2.5 shadow">
            + Buat Akun Staf Baru
          </button>
        </div>
      </div>

      <!-- Credentials Reminder -->
      <div class="card-daebak p-5 bg-daebak-mint/40 border border-daebak-sage/40 text-xs space-y-2">
        <p class="font-bold text-daebak-charcoal">🔐 Informasi Login PWA Staf Lapangan:</p>
        <div class="grid sm:grid-cols-3 gap-4 pt-1">
          <div class="p-3 rounded-xl bg-white">
            <span class="text-[10px] text-daebak-charcoal/60 block">Email Toko</span>
            <span class="font-mono font-bold">{{ profile?.store_email }}</span>
          </div>
          <div class="p-3 rounded-xl bg-white">
            <span class="text-[10px] text-daebak-charcoal/60 block">Kode Akun Toko</span>
            <span class="font-mono font-bold text-daebak-coral">{{ profile?.account_code }}</span>
          </div>
          <div class="p-3 rounded-xl bg-white">
            <span class="text-[10px] text-daebak-charcoal/60 block">Password Toko</span>
            <span class="font-mono font-bold">{{ profile?.store_email_password || '••••••••' }}</span>
          </div>
        </div>
      </div>

      <!-- Staff List Table -->
      <div class="card-daebak p-6 bg-white">
        <h3 class="font-heading text-base text-daebak-charcoal mb-4">Daftar Akun Petugas Staf Terdaftar</h3>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="border-b border-daebak-sage/40 text-daebak-charcoal/60 uppercase">
                <th class="py-3 px-4">Nama Petugas Staf</th>
                <th class="py-3 px-4">Identifier Staf</th>
                <th class="py-3 px-4">Status Akses PWA</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-daebak-sage/20">
              <tr v-for="staff in staffAccounts" :key="staff.id">
                <td class="py-3.5 px-4 font-semibold">{{ staff.user?.name }}</td>
                <td class="py-3.5 px-4 font-mono text-daebak-charcoal/70">{{ staff.user?.email }}</td>
                <td class="py-3.5 px-4">
                  <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                    Akses Kamera Aktif (Scoped to {{ profile?.store_name }})
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal Create Staff -->
      <div v-if="showModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="card-daebak bg-white p-8 max-w-md w-full shadow-2xl">
          <h3 class="font-heading text-xl text-daebak-charcoal mb-2">Buat Akun Staf Baru</h3>
          <p class="text-xs text-daebak-charcoal/70 mb-6">Masukkan nama petugas gate/scan untuk event Anda.</p>

          <form @submit.prevent="createStaff" class="space-y-4">
            <div>
              <label class="block text-xs font-semibold mb-1">Nama Petugas Staf</label>
              <input type="text" v-model="form.staff_name" required placeholder="Contoh: Staff Gate 1 (Budi)" class="w-full input-daebak text-sm" />
            </div>

            <div class="flex justify-end gap-3 pt-4">
              <button type="button" @click="showModal = false" class="px-4 py-2 rounded-xl border border-daebak-sage text-xs font-semibold">
                Batal
              </button>
              <button type="submit" :disabled="form.processing" class="btn-daebak-primary text-xs font-semibold px-5 py-2">
                Simpan Akun Staf 🚀
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Layout from './Layout.vue';

defineProps({
  profile: Object,
  staffAccounts: Array,
});

const showModal = ref(false);

const form = useForm({
  staff_name: '',
});

const createStaff = () => {
  form.post('/seller/staff/create', {
    onSuccess: () => {
      showModal.value = false;
      form.reset();
    }
  });
};
</script>
