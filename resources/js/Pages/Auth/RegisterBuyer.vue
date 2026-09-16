<template>
  <div class="min-h-screen bg-[#FDE8D3] flex items-center justify-center p-4 font-sans text-[#657166] py-12">
    <div class="w-full max-w-lg">
      <div class="text-center mb-8">
        <Link href="/" class="inline-flex items-center gap-3 group">
          <div class="w-12 h-12 rounded-[16px] bg-[#99CDD8] flex items-center justify-center text-[#2D3A30] font-heading text-2xl shadow-[0_2px_8px_rgba(153,205,216,0.35)] group-hover:scale-105 transition-transform">
            DT
          </div>
          <span class="font-heading text-3xl text-[#657166]">Daebak.Tix</span>
        </Link>
        <h1 class="font-heading text-2xl text-[#657166] mt-2">Daftar Akun Pembeli</h1>
        <p class="text-xs text-[#657166]/70">1 NIK = 1 Akun untuk pemesanan tiket resmi dan bebas calo</p>
      </div>

      <Card padding-class="p-8">
        <form @submit.prevent="submit" class="space-y-4">
          <!-- NIK -->
          <TextInput
            id="reg-nik"
            label="NIK (16 Digit - Sesuai KTP)"
            type="text"
            v-model="form.nik"
            required
            maxlength="16"
            placeholder="3171010000000000"
            :error="form.errors.nik"
            :disabled="form.processing"
          />

          <!-- Nama Lengkap -->
          <TextInput
            id="reg-name"
            label="Nama Lengkap (Sesuai KTP)"
            type="text"
            v-model="form.name"
            required
            placeholder="Jihan Fauziah"
            :error="form.errors.name"
            :disabled="form.processing"
          />

          <div class="grid sm:grid-cols-2 gap-4">
            <!-- Username -->
            <TextInput
              id="reg-username"
              label="Username"
              type="text"
              v-model="form.username"
              required
              placeholder="jihan_fauziah"
              :error="form.errors.username"
              :disabled="form.processing"
            />

            <!-- Email -->
            <TextInput
              id="reg-email"
              label="Email"
              type="email"
              v-model="form.email"
              required
              placeholder="nama@email.com"
              :error="form.errors.email"
              :disabled="form.processing"
            />
          </div>

          <div class="grid sm:grid-cols-3 gap-4">
            <!-- Umur -->
            <TextInput
              id="reg-age"
              label="Umur"
              type="number"
              v-model="form.age"
              required
              min="12"
              max="100"
              placeholder="22"
              :error="form.errors.age"
              :disabled="form.processing"
            />

            <!-- Tanggal Lahir -->
            <TextInput
              id="reg-dob"
              label="Tgl Lahir"
              type="date"
              v-model="form.dob"
              required
              :error="form.errors.dob"
              :disabled="form.processing"
            />

            <!-- Jenis Kelamin -->
            <div>
              <label class="block text-sm font-medium text-[#657166] mb-1.5 font-sans">Gender</label>
              <select
                v-model="form.gender"
                required
                class="w-full bg-white text-[#657166] border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3 py-2.5 text-[15px] font-sans focus:outline-none focus:border-[#99CDD8] focus:ring-3 focus:ring-[#99CDD8]/25"
              >
                <option value="female">Perempuan</option>
                <option value="male">Laki-laki</option>
                <option value="other">Lainnya</option>
              </select>
            </div>
          </div>

          <div class="grid sm:grid-cols-2 gap-4">
            <!-- Password -->
            <TextInput
              id="reg-password"
              label="Password"
              type="password"
              v-model="form.password"
              required
              placeholder="••••••••"
              :error="form.errors.password"
              :disabled="form.processing"
            />

            <!-- Konfirmasi Password -->
            <TextInput
              id="reg-password-confirm"
              label="Ulangi Password"
              type="password"
              v-model="form.password_confirmation"
              required
              placeholder="••••••••"
              :disabled="form.processing"
            />
          </div>

          <div class="pt-2">
            <PrimaryButton
              type="submit"
              :loading="form.processing"
              custom-class="w-full py-3.5 text-base"
            >
              Buat Akun Pembeli 🎉
            </PrimaryButton>
          </div>
        </form>

        <p class="text-xs text-center text-[#657166]/75 mt-6">
          Sudah punya akun?
          <Link href="/login" class="font-semibold text-[#2D3A30] hover:underline ml-1">Masuk Ke Akun</Link>
        </p>
      </Card>
    </div>
  </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
  nik: '',
  name: '',
  username: '',
  email: '',
  password: '',
  password_confirmation: '',
  age: 22,
  dob: '2004-08-15',
  gender: 'female',
});

const submit = () => {
  form.post('/signup');
};
</script>
