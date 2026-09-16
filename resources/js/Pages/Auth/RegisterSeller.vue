<template>
  <div class="min-h-screen bg-daebak-cream flex items-center justify-center p-4 font-sans text-daebak-charcoal py-12">
    <div class="w-full max-w-2xl">
      <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center gap-3">
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-daebak-blue to-daebak-coral flex items-center justify-center text-white font-heading text-2xl shadow-md">
            D
          </div>
          <span class="font-heading text-3xl text-daebak-charcoal">Daebak.Tix</span>
        </a>
        <h1 class="font-heading text-2xl text-daebak-charcoal mt-2">Pendaftaran Toko Penjual (Seller)</h1>
        <p class="text-xs text-daebak-charcoal/70">Onboarding 3 Tahap Resmi Promotor Event Korea</p>
      </div>

      <!-- Step Indicator Header -->
      <div class="flex items-center justify-between mb-6 px-4">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shadow" :class="step >= 1 ? 'bg-daebak-coral text-white' : 'bg-white text-daebak-charcoal/50'">1</div>
          <span class="text-xs font-semibold" :class="step >= 1 ? 'text-daebak-charcoal' : 'text-daebak-charcoal/50'">Data Diri</span>
        </div>
        <div class="h-0.5 flex-1 bg-daebak-sage/40 mx-3"></div>
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shadow" :class="step >= 2 ? 'bg-daebak-coral text-white' : 'bg-white text-daebak-charcoal/50'">2</div>
          <span class="text-xs font-semibold" :class="step >= 2 ? 'text-daebak-charcoal' : 'text-daebak-charcoal/50'">Data Toko</span>
        </div>
        <div class="h-0.5 flex-1 bg-daebak-sage/40 mx-3"></div>
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shadow" :class="step >= 3 ? 'bg-daebak-coral text-white' : 'bg-white text-daebak-charcoal/50'">3</div>
          <span class="text-xs font-semibold" :class="step >= 3 ? 'text-daebak-charcoal' : 'text-daebak-charcoal/50'">Verifikasi</span>
        </div>
      </div>

      <div class="card-daebak p-8 bg-white/95 backdrop-blur-md shadow-xl border border-daebak-sage/40">
        <form @submit.prevent="submit">
          <!-- Step 1: Data Diri Owner -->
          <div v-if="step === 1" class="space-y-4">
            <h2 class="font-heading text-lg text-daebak-charcoal border-b border-daebak-sage/30 pb-2">Tahap 1 — Data Diri Pemilik</h2>
            
            <div>
              <label class="block text-xs font-semibold text-daebak-charcoal mb-1">NIK Pemilik (16 Digit)</label>
              <input type="text" v-model="form.nik" required maxlength="16" placeholder="3171020000000000" class="w-full input-daebak text-sm" />
              <p v-if="form.errors.nik" class="text-xs text-rose-600 mt-1">{{ form.errors.nik }}</p>
            </div>

            <div>
              <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Nama Pemilik Toko</label>
              <input type="text" v-model="form.name" required placeholder="Park Min Young" class="w-full input-daebak text-sm" />
            </div>

            <div class="grid sm:grid-cols-3 gap-4">
              <div>
                <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Umur</label>
                <input type="number" v-model="form.age" required min="17" placeholder="30" class="w-full input-daebak text-sm" />
              </div>
              <div>
                <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Tgl Lahir</label>
                <input type="date" v-model="form.dob" required class="w-full input-daebak text-sm" />
              </div>
              <div>
                <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Gender</label>
                <select v-model="form.gender" required class="w-full input-daebak text-sm bg-white">
                  <option value="female">Perempuan</option>
                  <option value="male">Laki-laki</option>
                </select>
              </div>
            </div>

            <div class="pt-4 flex justify-end">
              <button type="button" @click="step = 2" class="btn-daebak-primary text-sm px-6 py-2.5">
                Lanjut ke Tahap 2 ➔
              </button>
            </div>
          </div>

          <!-- Step 2: Data Toko -->
          <div v-if="step === 2" class="space-y-4">
            <h2 class="font-heading text-lg text-daebak-charcoal border-b border-daebak-sage/30 pb-2">Tahap 2 — Data Toko Event</h2>

            <div>
              <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Nama Toko / Promotor</label>
              <input type="text" v-model="form.store_name" required placeholder="K-Events ID Official" class="w-full input-daebak text-sm" />
            </div>

            <div>
              <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Deskripsi Singkat Toko</label>
              <textarea v-model="form.store_description" required rows="2" placeholder="Promotor resmi konser dan fanmeeting K-Pop terpercaya..." class="w-full input-daebak text-sm"></textarea>
            </div>

            <div>
              <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Alamat Kantor / Toko</label>
              <input type="text" v-model="form.store_address" required placeholder="Jl. Sudirman No. 45, Jakarta Selatan" class="w-full input-daebak text-sm" />
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Email Toko</label>
                <input type="email" v-model="form.store_email" required placeholder="toko@kpopmaster.com" class="w-full input-daebak text-sm" />
                <p v-if="form.errors.store_email" class="text-xs text-rose-600 mt-1">{{ form.errors.store_email }}</p>
              </div>
              <div>
                <label class="block text-xs font-semibold text-daebak-charcoal mb-1">Password Email Toko</label>
                <input type="password" v-model="form.store_email_password" required placeholder="••••••••" class="w-full input-daebak text-sm" />
              </div>
            </div>

            <div class="pt-4 flex justify-between">
              <button type="button" @click="step = 1" class="px-5 py-2.5 rounded-xl border border-daebak-sage text-sm font-semibold">
                ⬅️ Kembali
              </button>
              <button type="button" @click="step = 3" class="btn-daebak-primary text-sm px-6 py-2.5">
                Lanjut ke Tahap 3 ➔
              </button>
            </div>
          </div>

          <!-- Step 3: Verifikasi & Ketentuan -->
          <div v-if="step === 3" class="space-y-4">
            <h2 class="font-heading text-lg text-daebak-charcoal border-b border-daebak-sage/30 pb-2">Tahap 3 — Verifikasi & Persetujuan Syarat</h2>

            <div class="p-4 rounded-2xl bg-daebak-mint/50 border border-daebak-sage/40 space-y-2 text-xs">
              <p class="font-bold text-daebak-charcoal">Ringkasan Pendaftaran Toko:</p>
              <p>• <strong>Nama Toko:</strong> {{ form.store_name || '-' }}</p>
              <p>• <strong>Email Toko:</strong> {{ form.store_email || '-' }}</p>
              <p>• <strong>Pemilik:</strong> {{ form.name || '-' }} (NIK: {{ form.nik || '-' }})</p>
            </div>

            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-900 space-y-2">
              <p class="font-bold">Ketentuan & Syarat Layanan Penjual Daebak.Tix:</p>
              <ul class="list-disc pl-4 space-y-1">
                <li>Penjual wajib menyajikan event Korea yang valid dan dapat dipertanggungjawabkan.</li>
                <li>Penjual memilih sistem paket berbayar bulanan atau sistem per-event (7/12 hari) yang dapat diperpanjang (5/7 hari).</li>
                <li>Tiket event yang telah kadaluarsa akan dinonaktifkan otomatis oleh sistem Daebak.Tix.</li>
                <li>Penyalahgunaan data atau penipuan tiket akan diproses hukum sesuai regulasi UU ITE Indonesia.</li>
              </ul>
            </div>

            <div class="flex items-center gap-3 pt-2">
              <input type="checkbox" id="terms" v-model="form.terms" required class="w-4 h-4 text-daebak-coral rounded border-daebak-sage" />
              <label for="terms" class="text-xs text-daebak-charcoal font-semibold">
                Saya menyetujui seluruh Ketentuan & Persyaratan Penjual di atas.
              </label>
            </div>
            <p v-if="form.errors.terms" class="text-xs text-rose-600">{{ form.errors.terms }}</p>

            <div class="pt-4 flex justify-between">
              <button type="button" @click="step = 2" class="px-5 py-2.5 rounded-xl border border-daebak-sage text-sm font-semibold">
                ⬅️ Kembali
              </button>
              <button type="submit" :disabled="form.processing" class="btn-daebak-secondary text-sm px-8 py-3 font-semibold shadow-md">
                <span v-if="form.processing">Memproses...</span>
                <span v-else>Selesaikan & Buat Toko Seller 🎉</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

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
