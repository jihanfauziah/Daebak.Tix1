<template>
  <Layout title="Manajemen Penjual (Sellers)">
    <!-- Generator Header Banner -->
    <div class="card-daebak p-6 bg-white mb-8">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h2 class="font-heading text-xl text-daebak-charcoal">Generate Kode & Kredensial Akun Seller Baru</h2>
          <p class="text-xs text-daebak-charcoal/70">Admin dapat secara langsung men-generate Email, Password Default, dan Kode Akun Seller yang terverifikasi.</p>
        </div>
        <button @click="showModal = true" class="btn-daebak-primary text-xs font-semibold px-5 py-3 shadow">
          + Generate Akun Seller Baru
        </button>
      </div>
    </div>

    <!-- Table Sellers -->
    <div class="card-daebak p-6 bg-white">
      <h3 class="font-heading text-lg text-daebak-charcoal mb-4">Daftar Mitra Toko Seller Terdaftar</h3>
      
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead>
            <tr class="border-b border-daebak-sage/40 text-daebak-charcoal/60 uppercase">
              <th class="py-3 px-4">Toko / Promotor</th>
              <th class="py-3 px-4">Email Toko</th>
              <th class="py-3 px-4">Kode Akun Unik</th>
              <th class="py-3 px-4">Langganan</th>
              <th class="py-3 px-4">Status Verifikasi</th>
              <th class="py-3 px-4 text-right">Aksi Admin</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-daebak-sage/20">
            <tr v-for="seller in sellers" :key="seller.id">
              <td class="py-4 px-4 font-semibold">
                <div>{{ seller.store_name }}</div>
                <span class="text-[10px] text-daebak-charcoal/60">Pemilik: {{ seller.user?.name || '-' }}</span>
              </td>
              <td class="py-4 px-4 text-daebak-charcoal/80 font-mono">{{ seller.store_email }}</td>
              <td class="py-4 px-4">
                <span class="font-mono bg-daebak-mint/70 px-2.5 py-1 rounded-lg text-xs font-bold text-daebak-charcoal">
                  {{ seller.account_code }}
                </span>
              </td>
              <td class="py-4 px-4">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-daebak-cream text-daebak-charcoal border border-daebak-sage/40">
                  {{ seller.subscription_type || 'Belum Ada' }}
                </span>
              </td>
              <td class="py-4 px-4">
                <span class="px-3 py-1 rounded-full text-[10px] font-bold" :class="seller.status === 'approved' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'">
                  {{ seller.status }}
                </span>
              </td>
              <td class="py-4 px-4 text-right space-x-2">
                <button v-if="seller.status !== 'approved'" @click="updateStatus(seller.id, 'approved')" class="px-3 py-1.5 bg-emerald-600 text-white rounded-xl text-[11px] font-semibold hover:bg-emerald-700">
                  Approve
                </button>
                <button v-if="seller.status !== 'rejected'" @click="updateStatus(seller.id, 'rejected')" class="px-3 py-1.5 bg-rose-500 text-white rounded-xl text-[11px] font-semibold hover:bg-rose-600">
                  Reject
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Generate Seller -->
    <div v-if="showModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <div class="card-daebak bg-white p-8 max-w-md w-full shadow-2xl">
        <h3 class="font-heading text-xl text-daebak-charcoal mb-2">Generate Akun Seller Baru</h3>
        <p class="text-xs text-daebak-charcoal/70 mb-6">Sistem akan membuat email toko, password default, dan kode akun seller unik.</p>

        <form @submit.prevent="generateSeller" class="space-y-4">
          <div>
            <label class="block text-xs font-semibold mb-1">Nama Toko / Promotor</label>
            <input type="text" v-model="form.store_name" required placeholder="Contoh: K-Pop Live Indonesia" class="w-full input-daebak text-sm" />
          </div>

          <div>
            <label class="block text-xs font-semibold mb-1">Email Toko</label>
            <input type="email" v-model="form.store_email" required placeholder="seller@kpoplive.com" class="w-full input-daebak text-sm" />
          </div>

          <div>
            <label class="block text-xs font-semibold mb-1">Nama Pemilik Toko</label>
            <input type="text" v-model="form.owner_name" required placeholder="Nama Lengkap Penanggung Jawab" class="w-full input-daebak text-sm" />
          </div>

          <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-4 py-2 rounded-xl border border-daebak-sage text-xs font-semibold">
              Batal
            </button>
            <button type="submit" :disabled="form.processing" class="btn-daebak-primary text-xs font-semibold px-5 py-2">
              Generate Now 🚀
            </button>
          </div>
        </form>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import Layout from './Layout.vue';

defineProps({
  sellers: Array
});

const showModal = ref(false);

const form = useForm({
  store_name: '',
  store_email: '',
  owner_name: '',
});

const generateSeller = () => {
  form.post('/admin/sellers/generate', {
    onSuccess: () => {
      showModal.value = false;
      form.reset();
    }
  });
};

const updateStatus = (id, status) => {
  router.post(`/admin/sellers/${id}/status`, { status });
};
</script>
