<template>
  <div class="min-h-screen bg-daebak-cream flex items-center justify-center p-4 font-sans text-daebak-charcoal">
    <div class="w-full max-w-md">
      <!-- Logo Header -->
      <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center gap-3">
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-daebak-blue to-daebak-coral flex items-center justify-center text-white font-heading text-2xl shadow-md">
            D
          </div>
          <span class="font-heading text-3xl text-daebak-charcoal">Daebak.Tix</span>
        </a>
        <p class="text-xs text-daebak-charcoal/70 mt-2">Selamat datang kembali! Silakan masuk ke akun Anda.</p>
      </div>

      <!-- Card Container -->
      <div class="card-daebak p-8 bg-white/90 backdrop-blur-md shadow-xl border border-daebak-sage/40">
        <!-- Error Alert -->
        <div v-if="form.errors.email" class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-center gap-3">
          <span class="text-lg">⚠️</span>
          <span>{{ form.errors.email }}</span>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
          <!-- Email Field -->
          <div>
            <label class="block text-xs font-semibold text-daebak-charcoal mb-2">Email</label>
            <input
              type="email"
              v-model="form.email"
              required
              placeholder="nama@email.com"
              class="w-full input-daebak text-sm"
              :disabled="form.processing"
            />
          </div>

          <!-- Password Field -->
          <div>
            <div class="flex items-center justify-between mb-2">
              <label class="block text-xs font-semibold text-daebak-charcoal">Password</label>
            </div>
            <input
              type="password"
              v-model="form.password"
              required
              placeholder="••••••••"
              class="w-full input-daebak text-sm"
              :disabled="form.processing"
            />
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="form.processing"
            class="w-full btn-daebak-primary py-3.5 text-sm font-semibold shadow-md flex items-center justify-center gap-2"
          >
            <span v-if="form.processing" class="inline-block animate-spin">⏳</span>
            <span>{{ form.processing ? 'Memproses...' : 'Login' }}</span>
          </button>
        </form>

        <!-- Divider -->
        <div class="relative my-6 text-center">
          <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-daebak-sage/40"></div></div>
          <span class="relative bg-white px-3 text-xs text-daebak-charcoal/60">atau</span>
        </div>

        <!-- Links -->
        <div class="space-y-3 text-center text-xs">
          <p>
            Belum punya akun Pembeli?
            <a href="/signup" class="font-semibold text-daebak-blue hover:underline">Daftar Akun Pembeli</a>
          </p>
          <p class="pt-1 border-t border-daebak-sage/20">
            Calon Penjual Tiket?
            <a href="/seller/register" class="font-semibold text-daebak-coral hover:underline">Daftarkan Toko Seller</a>
          </p>
        </div>
      </div>

      <!-- Quick Demo Credentials Hint (For Evaluation/Testing) -->
      <div class="mt-6 p-4 rounded-2xl bg-white/70 border border-daebak-sage/30 text-xs space-y-1 text-daebak-charcoal/80">
        <p class="font-bold text-daebak-charcoal">💡 Test Kredensial Demo:</p>
        <p>• <strong>Admin:</strong> admin@daebaktix.com | password</p>
        <p>• <strong>Seller:</strong> seller@kpopmaster.com | password</p>
        <p>• <strong>Buyer:</strong> buyer@gmail.com | password</p>
        <p>• <strong>Staff (PWA):</strong> staff@kpopmaster.com | password</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post('/login', {
    onError: () => {
      // Handled via form.errors
    },
  });
};
</script>
