<template>
  <Layout title="Manajemen Promotor / Penjual">
    <div class="space-y-6">
      <!-- Generator Header Banner -->
      <Card padding-class="p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h2 class="font-heading text-xl text-[#657166]">Verifikasi & Generate Akun Promotor</h2>
            <p class="text-xs text-[#657166]/70">Admin dapat men-generate kredensial toko atau memverifikasi pendaftaran online promotor.</p>
          </div>
          <PrimaryButton @click="showModal = true" custom-class="text-xs font-semibold px-5 py-3 shadow">
            + Generate Akun Seller Baru
          </PrimaryButton>
        </div>
      </Card>

      <!-- Table Sellers -->
      <Card padding-class="p-6">
        <h3 class="font-heading text-xl text-[#657166] mb-4">Daftar Mitra Toko Promotor Terdaftar</h3>
        
        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="border-b border-[#CFD6C4]/50 text-[#657166]/70 uppercase">
                <th class="py-3 px-4 font-bold">Toko / Promotor</th>
                <th class="py-3 px-4 font-bold">Email Toko</th>
                <th class="py-3 px-4 font-bold">Kode Akun Unik</th>
                <th class="py-3 px-4 font-bold">Paket Langganan</th>
                <th class="py-3 px-4 font-bold">Status</th>
                <th class="py-3 px-4 text-right font-bold">Aksi Admin</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[#CFD6C4]/30">
              <tr v-for="seller in sellers" :key="seller.id">
                <td class="py-4 px-4">
                  <div class="font-semibold text-sm text-[#2D3A30]">{{ seller.store_name }}</div>
                  <span class="text-[11px] text-[#657166]/70">Pemilik: {{ seller.user?.name || '-' }}</span>
                </td>
                <td class="py-4 px-4 text-[#657166] font-mono">{{ seller.store_email }}</td>
                <td class="py-4 px-4">
                  <span class="font-mono bg-[#DAEBE3] px-2.5 py-1 rounded-[8px] text-xs font-bold text-[#1E4D38]">
                    {{ seller.account_code }}
                  </span>
                </td>
                <td class="py-4 px-4">
                  <Badge variant="default">
                    {{ seller.subscription_type || 'Free / Per-Event' }}
                  </Badge>
                </td>
                <td class="py-4 px-4">
                  <Badge :variant="seller.status === 'approved' ? 'success' : 'danger'" :dot="true">
                    {{ seller.status }}
                  </Badge>
                </td>
                <td class="py-4 px-4 text-right space-x-2">
                  <button
                    v-if="seller.status !== 'approved'"
                    type="button"
                    @click="updateStatus(seller.id, 'approved')"
                    class="px-3 py-1.5 bg-[#DAEBE3] hover:bg-[#c4ded3] text-[#1E4D38] border border-[#DAEBE3] rounded-[10px] text-[11px] font-semibold transition-colors shadow-xs"
                  >
                    Approve
                  </button>
                  <button
                    v-if="seller.status !== 'rejected'"
                    type="button"
                    @click="updateStatus(seller.id, 'rejected')"
                    class="px-3 py-1.5 bg-[#FADBD8] hover:bg-[#f5c6cb] text-[#900C3F] border border-[#F5B7B1] rounded-[10px] text-[11px] font-semibold transition-colors shadow-xs"
                  >
                    Reject
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </Card>

      <!-- Modal Generate Seller -->
      <Modal :show="showModal" title="Generate Akun Promotor Baru" @close="showModal = false">
        <p class="text-xs text-[#657166]/70 mb-4">Sistem akan membuatkan akun promotor dengan kode unik otomatis.</p>

        <form @submit.prevent="generateSeller" class="space-y-4">
          <TextInput
            id="admin-store-name"
            label="Nama Brand / Toko Promotor"
            type="text"
            v-model="form.store_name"
            required
            placeholder="Contoh: K-Pop Live Indonesia"
            :error="form.errors.store_name"
          />

          <TextInput
            id="admin-store-email"
            label="Email Toko"
            type="email"
            v-model="form.store_email"
            required
            placeholder="seller@kpoplive.com"
            :error="form.errors.store_email"
          />

          <TextInput
            id="admin-owner-name"
            label="Nama Lengkap Penanggung Jawab"
            type="text"
            v-model="form.owner_name"
            required
            placeholder="Nama Lengkap Pemilik"
            :error="form.errors.owner_name"
          />

          <div class="flex justify-end gap-3 pt-4">
            <button
              type="button"
              @click="showModal = false"
              class="px-4 py-2 rounded-[14px] border border-[#CFD6C4] bg-white text-xs font-semibold text-[#657166] hover:bg-[#DAEBE3]/30"
            >
              Batal
            </button>
            <PrimaryButton type="submit" :loading="form.processing" custom-class="text-xs font-semibold px-5 py-2">
              Generate Now 🚀
            </PrimaryButton>
          </div>
        </form>
      </Modal>
    </div>
  </Layout>
</template>

<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
  sellers: {
    type: Array,
    default: () => []
  }
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
