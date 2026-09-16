<template>
  <Layout title="Kelola Petugas Gate Staf (PWA)" :profile="profile">
    <div class="space-y-6">
      <!-- Info Header Banner -->
      <Card padding-class="p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h2 class="font-heading text-xl text-[#657166]">Akun Petugas Gate Scanner PWA</h2>
            <p class="text-xs text-[#657166]/70">Petugas lapangan mengakses PWA di browser HP menggunakan kredensial toko.</p>
          </div>
          <PrimaryButton @click="showModal = true" custom-class="text-xs font-semibold px-5 py-2.5 shadow">
            + Buat Akun Staf Baru
          </PrimaryButton>
        </div>
      </Card>

      <!-- Credentials Reminder -->
      <Card padding-class="p-5" custom-class="bg-[#DAEBE3]/40 border border-[#CFD6C4]/60 space-y-2">
        <p class="font-bold text-xs text-[#2D3A30]">🔐 Kredensial Login PWA Staf Lapangan:</p>
        <div class="grid sm:grid-cols-3 gap-4 pt-1">
          <div class="p-3 rounded-[12px] bg-white border border-[#CFD6C4]/40">
            <span class="text-[10px] text-[#657166]/70 block font-semibold">Email Toko Promotor</span>
            <span class="font-mono font-bold text-xs text-[#2D3A30]">{{ profile?.store_email }}</span>
          </div>
          <div class="p-3 rounded-[12px] bg-white border border-[#CFD6C4]/40">
            <span class="text-[10px] text-[#657166]/70 block font-semibold">Kode Akun Toko</span>
            <span class="font-mono font-bold text-xs text-[#8C4E37]">{{ profile?.account_code }}</span>
          </div>
          <div class="p-3 rounded-[12px] bg-white border border-[#CFD6C4]/40">
            <span class="text-[10px] text-[#657166]/70 block font-semibold">Password Toko</span>
            <span class="font-mono font-bold text-xs text-[#2D3A30]">{{ profile?.store_email_password || '••••••••' }}</span>
          </div>
        </div>
      </Card>

      <!-- Staff List Table -->
      <Card padding-class="p-6">
        <h3 class="font-heading text-xl text-[#657166] mb-4">Daftar Akun Petugas Terdaftar</h3>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="border-b border-[#CFD6C4]/50 text-[#657166]/70 uppercase">
                <th class="py-3 px-4 font-bold">Nama Petugas</th>
                <th class="py-3 px-4 font-bold">Identifier Akun</th>
                <th class="py-3 px-4 font-bold">Status Otorisasi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[#CFD6C4]/30">
              <tr v-for="staff in staffAccounts" :key="staff.id">
                <td class="py-3.5 px-4 font-semibold text-sm text-[#2D3A30]">{{ staff.user?.name }}</td>
                <td class="py-3.5 px-4 font-mono text-[#657166]">{{ staff.user?.email }}</td>
                <td class="py-3.5 px-4">
                  <Badge variant="success" :dot="true">
                    Scoped: {{ profile?.store_name }}
                  </Badge>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </Card>

      <!-- Modal Create Staff -->
      <Modal :show="showModal" title="Tambah Akun Petugas Gate" @close="showModal = false">
        <p class="text-xs text-[#657166]/70 mb-4">Buat akun untuk petugas pintu masuk / gate pemeriksaan tiket.</p>

        <form @submit.prevent="createStaff" class="space-y-4">
          <TextInput
            id="staff-name"
            label="Nama Petugas Staf"
            type="text"
            v-model="form.staff_name"
            required
            placeholder="Contoh: Petugas Pintu Barat (Budi)"
            :error="form.errors.staff_name"
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
              Simpan Akun Staf 🚀
            </PrimaryButton>
          </div>
        </form>
      </Modal>
    </div>
  </Layout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
  profile: Object,
  staffAccounts: {
    type: Array,
    default: () => []
  },
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
