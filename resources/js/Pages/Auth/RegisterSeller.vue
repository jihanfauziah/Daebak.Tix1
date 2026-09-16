<template>
  <div class="min-h-screen bg-[#FDE8D3] flex items-center justify-center p-4 font-sans text-[#657166] py-12">
    <div class="w-full max-w-2xl">
      <div class="text-center mb-8">
        <Link href="/" class="inline-flex items-center gap-3 group">
          <div class="w-12 h-12 rounded-[16px] bg-[#99CDD8] flex items-center justify-center text-[#2D3A30] font-heading text-2xl shadow-[0_2px_8px_rgba(153,205,216,0.35)] group-hover:scale-105 transition-transform">
            DT
          </div>
          <span class="font-heading text-3xl text-[#657166]">Daebak.Tix</span>
        </Link>
        <h1 class="font-heading text-2xl text-[#657166] mt-2">Pendaftaran Promotor / Penjual Tiket</h1>
        <p class="text-xs text-[#657166]/70">Onboarding 3 Tahap Resmi Promotor Event Korea</p>
      </div>

      <!-- Step Indicator Header -->
      <div class="flex items-center justify-between mb-6 px-4">
        <div class="flex items-center gap-2">
          <div
            class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-colors"
            :class="step >= 1 ? 'bg-[#99CDD8] text-[#2D3A30] shadow-sm' : 'bg-white text-[#657166]/50 border border-[#CFD6C4]'"
          >
            1
          </div>
          <span class="text-xs font-semibold" :class="step >= 1 ? 'text-[#2D3A30]' : 'text-[#657166]/50'">Data Diri</span>
        </div>
        <div class="h-0.5 flex-1 bg-[#CFD6C4]/60 mx-3"></div>
        <div class="flex items-center gap-2">
          <div
            class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-colors"
            :class="step >= 2 ? 'bg-[#99CDD8] text-[#2D3A30] shadow-sm' : 'bg-white text-[#657166]/50 border border-[#CFD6C4]'"
          >
            2
          </div>
          <span class="text-xs font-semibold" :class="step >= 2 ? 'text-[#2D3A30]' : 'text-[#657166]/50'">Data Toko</span>
        </div>
        <div class="h-0.5 flex-1 bg-[#CFD6C4]/60 mx-3"></div>
        <div class="flex items-center gap-2">
          <div
            class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-colors"
            :class="step >= 3 ? 'bg-[#99CDD8] text-[#2D3A30] shadow-sm' : 'bg-white text-[#657166]/50 border border-[#CFD6C4]'"
          >
            3
          </div>
          <span class="text-xs font-semibold" :class="step >= 3 ? 'text-[#2D3A30]' : 'text-[#657166]/50'">Verifikasi</span>
        </div>
      </div>

      <Card padding-class="p-8">
        <form @submit.prevent="submit">
          <!-- Step 1: Data Diri Owner -->
          <div v-if="step === 1" class="space-y-4">
            <h2 class="font-heading text-xl text-[#657166] border-b border-[#CFD6C4]/40 pb-2">Tahap 1 — Data Diri Pemilik / Penanggung Jawab</h2>
            
            <TextInput
              id="owner-nik"
              label="NIK Pemilik (16 Digit)"
              type="text"
              v-model="form.nik"
              required
              maxlength="16"
              placeholder="3171020000000000"
              :error="form.errors.nik"
            />

            <TextInput
              id="owner-name"
              label="Nama Lengkap Penanggung Jawab"
              type="text"
              v-model="form.name"
              required
              placeholder="Park Min Young"
              :error="form.errors.name"
            />

            <div class="grid sm:grid-cols-3 gap-4">
              <TextInput
                id="owner-age"
                label="Umur"
                type="number"
                v-model="form.age"
                required
                min="17"
                placeholder="30"
                :error="form.errors.age"
              />

              <TextInput
                id="owner-dob"
                label="Tgl Lahir"
                type="date"
                v-model="form.dob"
                required
                :error="form.errors.dob"
              />

              <div>
                <label class="block text-sm font-medium text-[#657166] mb-1.5 font-sans">Gender</label>
                <select
                  v-model="form.gender"
                  required
                  class="w-full bg-white text-[#657166] border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3 py-2.5 text-[15px] font-sans focus:outline-none focus:border-[#99CDD8]"
                >
                  <option value="female">Perempuan</option>
                  <option value="male">Laki-laki</option>
                </select>
              </div>
            </div>

            <div class="pt-4 flex justify-end">
              <PrimaryButton type="button" @click="step = 2" custom-class="px-6 py-2.5">
                Lanjut ke Data Toko ➔
              </PrimaryButton>
            </div>
          </div>

          <!-- Step 2: Data Toko -->
          <div v-if="step === 2" class="space-y-4">
            <h2 class="font-heading text-xl text-[#657166] border-b border-[#CFD6C4]/40 pb-2">Tahap 2 — Identitas Perusahaan / Toko Promotor</h2>

            <TextInput
              id="store-name"
              label="Nama Brand / Toko Promotor"
              type="text"
              v-model="form.store_name"
              required
              placeholder="K-Events ID Official"
              :error="form.errors.store_name"
            />

            <div>
              <label class="block text-sm font-medium text-[#657166] mb-1.5 font-sans">Deskripsi Promotor</label>
              <textarea
                v-model="form.store_description"
                required
                rows="2"
                placeholder="Promotor resmi konser dan fanmeeting K-Pop terpercaya di Indonesia..."
                class="w-full bg-white text-[#657166] placeholder-[#657166]/40 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-[15px] font-sans focus:outline-none focus:border-[#99CDD8] focus:ring-3 focus:ring-[#99CDD8]/25"
              ></textarea>
            </div>

            <TextInput
              id="store-address"
              label="Alamat Kantor Promotor"
              type="text"
              v-model="form.store_address"
              required
              placeholder="Jl. Sudirman No. 45, Jakarta Selatan"
              :error="form.errors.store_address"
            />

            <div class="grid sm:grid-cols-2 gap-4">
              <TextInput
                id="store-email"
                label="Email Login Toko"
                type="email"
                v-model="form.store_email"
                required
                placeholder="toko@kpopmaster.com"
                :error="form.errors.store_email"
              />

              <TextInput
                id="store-password"
                label="Password Akun Toko"
                type="password"
                v-model="form.store_email_password"
                required
                placeholder="••••••••"
                :error="form.errors.store_email_password"
              />
            </div>

            <div class="pt-4 flex justify-between">
              <button
                type="button"
                @click="step = 1"
                class="px-5 py-2.5 rounded-[16px] border border-[#CFD6C4] bg-white text-sm font-semibold text-[#657166] hover:bg-[#DAEBE3]/30 transition-all"
              >
                ⬅️ Kembali
              </button>
              <PrimaryButton type="button" @click="step = 3" custom-class="px-6 py-2.5">
                Lanjut ke Verifikasi ➔
              </PrimaryButton>
            </div>
          </div>

          <!-- Step 3: Verifikasi & Ketentuan -->
          <div v-if="step === 3" class="space-y-4">
            <h2 class="font-heading text-xl text-[#657166] border-b border-[#CFD6C4]/40 pb-2">Tahap 3 — Ringkasan & Persetujuan Legal</h2>

            <div class="p-4 rounded-[16px] bg-[#DAEBE3]/60 border border-[#CFD6C4]/60 space-y-2 text-xs text-[#2D3A30]">
              <p class="font-bold text-sm">Ringkasan Data Pendaftaran:</p>
              <p>• <strong>Nama Toko Promotor:</strong> {{ form.store_name || '-' }}</p>
              <p>• <strong>Email Akun Toko:</strong> {{ form.store_email || '-' }}</p>
              <p>• <strong>Penanggung Jawab:</strong> {{ form.name || '-' }} (NIK: {{ form.nik || '-' }})</p>
              <p>• <strong>Alamat:</strong> {{ form.store_address || '-' }}</p>
            </div>

            <div class="p-4 rounded-[16px] bg-[#FDE8D3] border border-[#F3C3B2] text-xs text-[#6E2C00] space-y-2">
              <p class="font-bold">Ketentuan & Kebijakan Layanan Promotor Daebak.Tix:</p>
              <ul class="list-disc pl-4 space-y-1 text-[11px]">
                <li>Akun akan melewati proses verifikasi KYC oleh tim Admin Daebak.Tix sebelum dapat mempublikasikan event.</li>
                <li>Tersedia paket langganan Free (potongan komisi 5%) dan Pro (potongan komisi 2%).</li>
                <li>Penyelenggara bertanggung jawab penuh atas keabsahan event dan tiket yang diterbitkan.</li>
              </ul>
            </div>

            <div class="flex items-center gap-3 pt-2">
              <input
                type="checkbox"
                id="terms"
                v-model="form.terms"
                required
                class="w-4 h-4 text-[#99CDD8] rounded border-[#CFD6C4] focus:ring-[#99CDD8]"
              />
              <label for="terms" class="text-xs text-[#657166] font-semibold cursor-pointer">
                Saya menyetujui seluruh Ketentuan & Persyaratan Promotor di atas.
              </label>
            </div>
            <p v-if="form.errors.terms" class="text-xs text-[#E76F51]">{{ form.errors.terms }}</p>

            <div class="pt-4 flex justify-between">
              <button
                type="button"
                @click="step = 2"
                class="px-5 py-2.5 rounded-[16px] border border-[#CFD6C4] bg-white text-sm font-semibold text-[#657166] hover:bg-[#DAEBE3]/30 transition-all"
              >
                ⬅️ Kembali
              </button>
              <SecondaryButton
                type="submit"
                :loading="form.processing"
                custom-class="px-8 py-3 text-sm font-semibold shadow-md"
              >
                Selesaikan Pendaftaran 🚀
              </SecondaryButton>
            </div>
          </div>
        </form>
      </Card>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const step = ref(1);

const form = useForm({
  nik: '3171020000000002',
  name: 'Park Min Young',
  age: 32,
  dob: '1994-03-22',
  gender: 'female',
  store_name: 'K-Events ID Official',
  store_description: 'Promotor Resmi Konser & Fanmeeting K-Pop Terpercaya',
  store_address: 'Gedung Wisma K-Culture Lt. 5, Jakarta',
  store_email: '',
  store_email_password: '',
  terms: false,
});

const submit = () => {
  form.post('/seller/register');
};
</script>
