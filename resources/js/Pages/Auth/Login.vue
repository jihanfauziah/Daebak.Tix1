<template>
  <div class="min-h-screen bg-[#FDE8D3] flex items-center justify-center p-4 font-sans text-[#657166]">
    <div class="w-full max-w-md">
      <!-- Logo Header -->
      <div class="text-center mb-8">
        <Link href="/" class="inline-flex items-center gap-3 group">
          <div class="w-12 h-12 rounded-[16px] bg-[#99CDD8] flex items-center justify-center text-[#2D3A30] font-heading text-2xl shadow-[0_2px_8px_rgba(153,205,216,0.35)] group-hover:scale-105 transition-transform">
            DT
          </div>
          <span class="font-heading text-3xl text-[#657166]">Daebak.Tix</span>
        </Link>
        <p class="text-xs text-[#657166]/70 mt-2 font-sans">Selamat datang kembali! Silakan masuk ke akun Anda.</p>
      </div>

      <!-- Card Container -->
      <Card padding-class="p-8">
        <!-- Error Alert -->
        <div v-if="form.errors.email" class="mb-6 p-4 rounded-[16px] bg-[#FADBD8] border border-[#F5B7B1] text-[#900C3F] text-xs flex items-center gap-3 font-medium">
          <span class="text-base">⚠️</span>
          <span>{{ form.errors.email }}</span>
        </div>

        <form @submit.prevent="submit" class="space-y-4">
          <!-- Email Field -->
          <TextInput
            id="login-email"
            label="Email Akun"
            type="email"
            v-model="form.email"
            required
            placeholder="nama@email.com"
            :error="form.errors.email"
            :disabled="form.processing"
          />

          <!-- Password Field -->
          <TextInput
            id="login-password"
            label="Password"
            type="password"
            v-model="form.password"
            required
            placeholder="••••••••"
            :error="form.errors.password"
            :disabled="form.processing"
          />

          <!-- Submit Button -->
          <div class="pt-2">
            <PrimaryButton
              type="submit"
              :loading="form.processing"
              custom-class="w-full py-3.5 text-base"
            >
              Masuk ke Daebak.Tix
            </PrimaryButton>
          </div>
        </form>

        <!-- Divider -->
        <div class="relative my-6 text-center">
          <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-[#CFD6C4]/50"></div></div>
          <span class="relative bg-white px-3 text-xs text-[#657166]/70">atau</span>
        </div>

        <!-- Links -->
        <div class="space-y-3 text-center text-xs">
          <p class="text-[#657166]">
            Belum punya akun Pembeli?
            <Link href="/signup" class="font-semibold text-[#2D3A30] hover:underline ml-1">Daftar Akun Pembeli</Link>
          </p>
          <p class="pt-2 border-t border-[#CFD6C4]/30 text-[#657166]">
            Ingin Menjual Tiket?
            <Link href="/seller/register" class="font-semibold text-[#8C4E37] hover:underline ml-1">Daftarkan Toko Promotor</Link>
          </p>
        </div>
      </Card>

      <!-- Quick Demo Credentials Hint (For Evaluation/Testing) -->
      <div class="mt-6 p-4 rounded-[18px] bg-white/70 border border-[#CFD6C4]/50 text-xs space-y-1.5 text-[#657166]">
        <p class="font-bold text-[#2D3A30] flex items-center gap-1.5">
          <span>💡</span> Test Akun Multi-Role (Password: <code>password</code>):
        </p>
        <div class="grid grid-cols-2 gap-1 text-[11px] pt-1">
          <div>• <strong>Admin:</strong> admin@daebaktix.com</div>
          <div>• <strong>Seller:</strong> seller@kpopmaster.com</div>
          <div>• <strong>Buyer:</strong> buyer@gmail.com</div>
          <div>• <strong>Staff:</strong> staff@kpopmaster.com</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post('/login');
};
</script>
