<template>
  <div class="min-h-screen bg-daebak-cream flex items-center justify-center p-4 font-sans text-daebak-charcoal py-12">
    <div class="w-full max-w-lg">
      <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center gap-3">
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-daebak-blue to-daebak-coral flex items-center justify-center text-white font-heading text-2xl shadow-md">
            D
          </div>
          <span class="font-heading text-3xl text-daebak-charcoal">Daebak.Tix</span>
        </a>
        <h1 class="font-heading text-2xl text-daebak-charcoal mt-2">Daftar Akun Pembeli</h1>
        <p class="text-xs text-daebak-charcoal/70">Buat akun untuk berburu tiket konser K-Pop impianmu</p>
      </div>

      <div class="card-daebak p-8 bg-white/95 backdrop-blur-md shadow-xl border border-daebak-sage/40">
        <form @submit.prevent="submit" class="space-y-4">
          <!-- NIK -->
          <div>
            <label class="block text-xs font-semibold text-daebak-charcoal mb-1">NIK (16 Digit - 1 Orang 1 Akun)</label>
            <input
              type="text"
              v-model="form.nik"
              required
              maxlength="16"
              placeholder="3171010000000000"
              class="w-full input-daebak text-sm"
              :class="{ 'border-rose-400': form.errors.nik }"
            />
            <p v-if="form.errors.nik" class="text-xs text-rose-600 mt-1">{{ form.errors.nik }}</p>
          </div>

          <!-- Nama Lengkap -->
          <div>
            <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Nama Lengkap (Sesuai KTP)</label>
            <input
              type="text"
              v-model="form.name"
              required
              placeholder="Jihan Fauziah"
              class="w-full input-daebak text-sm"
            />
          </div>

          <div class="grid sm:grid-cols-2 gap-4">
            <!-- Username -->
            <div>
              <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Username</label>
              <input
                type="text"
                v-model="form.username"
                required
                placeholder="jihan_fauziah"
                class="w-full input-daebak text-sm"
              />
              <p v-if="form.errors.username" class="text-xs text-rose-600 mt-1">{{ form.errors.username }}</p>
            </div>

            <!-- Email -->
            <div>
              <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Email</label>
              <input
                type="email"
                v-model="form.email"
                required
                placeholder="nama@email.com"
                class="w-full input-daebak text-sm"
              />
              <p v-if="form.errors.email" class="text-xs text-rose-600 mt-1">{{ form.errors.email }}</p>
            </div>
          </div>

          <div class="grid sm:grid-cols-3 gap-4">
            <!-- Umur -->
            <div>
              <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Umur</label>
              <input
                type="number"
                v-model="form.age"
                required
                min="12"
                max="100"
                placeholder="22"
                class="w-full input-daebak text-sm"
              />
            </div>

            <!-- Tanggal Lahir -->
            <div>
              <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Tgl Lahir</label>
              <input
                type="date"
                v-model="form.dob"
                required
                class="w-full input-daebak text-sm"
              />
            </div>

            <!-- Jenis Kelamin -->
            <div>
              <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Gender</label>
              <select v-model="form.gender" required class="w-full input-daebak text-sm bg-white">
                <option value="female">Perempuan</option>
                <option value="male">Laki-laki</option>
                <option value="other">Lainnya</option>
              </select>
            </div>
          </div>

          <div class="grid sm:grid-cols-2 gap-4">
            <!-- Password -->
            <div>
              <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Password</label>
              <input
                type="password"
                v-model="form.password"
                required
                placeholder="••••••••"
                class="w-full input-daebak text-sm"
              />
              <p v-if="form.errors.password" class="text-xs text-rose-600 mt-1">{{ form.errors.password }}</p>
            </div>

            <!-- Konfirmasi Password -->
            <div>
              <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Ulangi Password</label>
              <input
                type="password"
                v-model="form.password_confirmation"
                required
                placeholder="••••••••"
                class="w-full input-daebak text-sm"
              />
            </div>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full btn-daebak-primary py-3.5 text-sm font-semibold shadow-md mt-4 flex items-center justify-center gap-2"
          >
            <span v-if="form.processing" class="inline-block animate-spin">⏳</span>
            <span>{{ form.processing ? 'Memproses...' : 'Buat Akun Pembeli' }}</span>
          </button>
        </form>

        <p class="text-xs text-center text-daebak-charcoal/70 mt-6">
          Sudah punya akun?
          <a href="/login" class="font-semibold text-daebak-blue hover:underline">Masuk Ke Aplikasi</a>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

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
