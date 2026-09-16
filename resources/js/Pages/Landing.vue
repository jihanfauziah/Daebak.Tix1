<template>
  <div class="min-h-screen bg-[#FDE8D3] font-sans text-[#657166]">
    <!-- Navbar (Fixed 72px equivalent) -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-white/85 border-b border-[#CFD6C4]/50 px-6 sm:px-8 py-4 transition-all">
      <div class="max-w-7xl mx-auto flex items-center justify-between">
        <Link href="/" class="flex items-center gap-3 group">
          <div class="w-10 h-10 rounded-[14px] bg-[#99CDD8] flex items-center justify-center font-heading text-xl text-[#2D3A30] shadow-[0_2px_8px_rgba(153,205,216,0.35)] group-hover:scale-105 transition-transform">
            DT
          </div>
          <span class="font-heading text-2xl tracking-wide text-[#657166]">Daebak.Tix</span>
        </Link>

        <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-[#657166]">
          <a href="#event-unggulan" class="hover:text-[#2D3A30] transition-colors">Event Konser</a>
          <a href="#kategori" class="hover:text-[#2D3A30] transition-colors">Kategori</a>
          <a href="#jual-tiket" class="hover:text-[#2D3A30] transition-colors">Untuk Promotor</a>
        </nav>

        <div class="flex items-center gap-3">
          <Link href="/login" class="px-5 py-2.5 rounded-[16px] border border-[#CFD6C4] bg-white text-sm font-semibold text-[#657166] hover:bg-[#DAEBE3]/40 transition-all shadow-[0_2px_8px_rgba(101,113,102,0.06)]">
            Masuk
          </Link>
          <PrimaryButton href="/seller/register" custom-class="text-sm">
            Mulai Jual Tiket
          </PrimaryButton>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-12 pb-20 px-6 overflow-hidden">
      <!-- Decorative Pastel Blobs -->
      <div class="absolute -top-20 -right-20 w-96 h-96 bg-[#99CDD8]/30 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-[#F3C3B2]/30 rounded-full blur-3xl pointer-events-none"></div>

      <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center relative z-10">
        <div class="space-y-6">
          <Badge variant="mint" :dot="true">
            Platform Tiket Konser & Fanmeeting K-Pop #1
          </Badge>
          
          <h1 class="font-heading text-4xl sm:text-6xl text-[#657166] leading-[1.15]">
            Nonton Idol Favorit Jadi <span class="text-[#2D3A30] underline decoration-[#99CDD8] decoration-wavy decoration-4">Lebih Praktis</span> & Aman
          </h1>
          
          <p class="text-base sm:text-lg text-[#657166]/85 max-w-xl leading-relaxed font-normal">
            Daebak.Tix menghadirkan pengalaman ticketing konser K-Pop resmi berstandar LOKET.com dengan E-Ticket digital ber-QR Code asli dan pencegahan calo (1 Akun = 1 NIK).
          </p>

          <div class="flex flex-wrap gap-4 pt-2">
            <PrimaryButton href="/login" custom-class="text-base px-8 py-3.5 shadow-md">
              Cari Tiket Konser 🎫
            </PrimaryButton>
            <SecondaryButton href="#jual-tiket" variant="mint" custom-class="text-base px-7 py-3.5">
              Portal Promotor (Seller)
            </SecondaryButton>
          </div>

          <!-- Feature highlight capsules -->
          <div class="flex flex-wrap gap-3 pt-4 border-t border-[#CFD6C4]/50">
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-white border border-[#CFD6C4]/50 shadow-xs">
              🔒 100% Promotor Terverifikasi
            </span>
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-white border border-[#CFD6C4]/50 shadow-xs">
              ⚡ Midtrans Instant Payment
            </span>
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-white border border-[#CFD6C4]/50 shadow-xs">
              📱 PWA QR Staff Scanner
            </span>
          </div>
        </div>

        <!-- Right Featured Hero Card -->
        <div class="relative">
          <div class="card-daebak p-6 bg-gradient-to-br from-[#DAEBE3] to-[#99CDD8]/40 border border-[#CFD6C4]/60">
            <div class="bg-white rounded-[20px] p-5 shadow-sm space-y-4">
              <div class="relative h-56 rounded-[16px] overflow-hidden bg-[#DAEBE3]/50">
                <img
                  src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=800&q=80"
                  alt="BLACKPINK Born Pink"
                  class="w-full h-full object-cover"
                />
                <div class="absolute top-3 left-3">
                  <Badge variant="coral">WORLD TOUR</Badge>
                </div>
                <div class="absolute top-3 right-3">
                  <Badge variant="success">Tiket Tersedia</Badge>
                </div>
              </div>

              <div>
                <h3 class="font-heading text-2xl text-[#657166]">BLACKPINK WORLD TOUR [BORN PINK]</h3>
                <p class="text-sm text-[#657166]/75 mt-0.5">📍 Stadion Utama Gelora Bung Karno, Jakarta</p>
                <p class="text-xs text-[#657166]/60 mt-0.5">📅 25 - 26 November 2026 • 19:00 WIB</p>
              </div>

              <div class="flex items-center justify-between pt-3 border-t border-[#CFD6C4]/40">
                <div>
                  <span class="text-xs text-[#657166]/70">Harga Tiket Mulai</span>
                  <p class="font-bold text-[#657166] text-xl font-sans">Rp 1.350.000</p>
                </div>
                <PrimaryButton href="/login" custom-class="text-xs px-5 py-2.5">
                  Beli Tiket
                </PrimaryButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Categories Section -->
    <section id="kategori" class="py-16 px-6 bg-white/70 backdrop-blur-sm border-y border-[#CFD6C4]/40">
      <div class="max-w-7xl mx-auto space-y-10">
        <div class="text-center space-y-2">
          <Badge variant="mint">Eksplorasi Acara</Badge>
          <h2 class="font-heading text-3xl sm:text-4xl text-[#657166]">Kategori Event Korea</h2>
          <p class="text-sm text-[#657166]/70">Temukan pengalaman terbaik bersama artis & idol favoritmu</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <Card hoverable padding-class="p-6">
            <div class="w-12 h-12 rounded-[16px] bg-[#DAEBE3] flex items-center justify-center text-2xl mb-4 shadow-xs">🎤</div>
            <h3 class="font-heading text-xl mb-1 text-[#657166]">Konser Idol</h3>
            <p class="text-xs text-[#657166]/75 leading-relaxed">Konser panggung spektakuler dengan produksi audio visual & lighting kelas dunia.</p>
          </Card>
          <Card hoverable padding-class="p-6">
            <div class="w-12 h-12 rounded-[16px] bg-[#FDE8D3] flex items-center justify-center text-2xl mb-4 shadow-xs">🤝</div>
            <h3 class="font-heading text-xl mb-1 text-[#657166]">Fanmeeting</h3>
            <p class="text-xs text-[#657166]/75 leading-relaxed">Momen akrab, sesi games interaktif, hi-touch, dan foto bersama sang idola.</p>
          </Card>
          <Card hoverable padding-class="p-6">
            <div class="w-12 h-12 rounded-[16px] bg-[#F3C3B2]/50 flex items-center justify-center text-2xl mb-4 shadow-xs">⛩️</div>
            <h3 class="font-heading text-xl mb-1 text-[#657166]">Festival K-Culture</h3>
            <p class="text-xs text-[#657166]/75 leading-relaxed">Pameran kuliner K-Food, fashion, K-Beauty, dan pertunjukan tarian tradisional.</p>
          </Card>
          <Card hoverable padding-class="p-6">
            <div class="w-12 h-12 rounded-[16px] bg-[#99CDD8]/50 flex items-center justify-center text-2xl mb-4 shadow-xs">🍿</div>
            <h3 class="font-heading text-xl mb-1 text-[#657166]">Live Screening</h3>
            <p class="text-xs text-[#657166]/75 leading-relaxed">Nonton bareng dokumenter konser atau live broadcast di layar bioskop pilihan.</p>
          </Card>
        </div>
      </div>
    </section>

    <!-- Seller Banner Section -->
    <section id="jual-tiket" class="py-20 px-6">
      <div class="max-w-7xl mx-auto card-daebak p-8 sm:p-12 relative overflow-hidden bg-gradient-to-br from-[#FDE8D3] via-white to-[#F3C3B2]/30 border border-[#CFD6C4]/60">
        <div class="grid lg:grid-cols-2 gap-10 items-center relative z-10">
          <div class="space-y-6">
            <Badge variant="coral">Solusi Promotor & EO</Badge>
            <h2 class="font-heading text-3xl sm:text-5xl text-[#657166] leading-tight">
              Mitra Penjualan Tiket K-Event Terpercaya
            </h2>
            <p class="text-sm sm:text-base text-[#657166]/85 leading-relaxed">
              Platform multi-tenant seller profesional dengan proses verifikasi KYC admin, skema langganan fleksibel (Free vs Pro), dan alat Scanner Gate berbasis kamera web browser HP.
            </p>
            <div class="flex flex-wrap items-center gap-4 pt-2">
              <DarkButton href="/seller/register" custom-class="text-base px-8 py-3.5 shadow-md">
                Daftar Sebagai Promotor 🚀
              </DarkButton>
              <a
                href="https://wa.me/6281234567890"
                target="_blank"
                class="px-6 py-3.5 rounded-[16px] bg-white border border-[#CFD6C4] font-semibold text-sm text-[#657166] hover:bg-[#DAEBE3]/30 transition-all shadow-xs"
              >
                💬 Hubungi Kami via WhatsApp
              </a>
            </div>
          </div>

          <div class="bg-white/95 rounded-[24px] p-6 sm:p-8 border border-[#CFD6C4]/50 shadow-[0_4px_20px_rgba(101,113,102,0.08)] space-y-4">
            <h3 class="font-heading text-xl text-[#657166] border-b border-[#CFD6C4]/30 pb-3">Keunggulan Ekosistem Daebak.Tix</h3>
            <ul class="space-y-3.5 text-sm text-[#657166]">
              <li class="flex items-start gap-3">
                <span class="w-6 h-6 rounded-full bg-[#DAEBE3] text-[#1E4D38] flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                <span><strong>Verifikasi Promotor Terpusat:</strong> Admin memastikan legalitas penyelenggara untuk melindungi reputasi dan pembeli.</span>
              </li>
              <li class="flex items-start gap-3">
                <span class="w-6 h-6 rounded-full bg-[#DAEBE3] text-[#1E4D38] flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                <span><strong>Komisi Rendah & Model Subscription:</strong> Hemat biaya dengan skema Pro 2% atau Free 5% per tiket.</span>
              </li>
              <li class="flex items-start gap-3">
                <span class="w-6 h-6 rounded-full bg-[#DAEBE3] text-[#1E4D38] flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                <span><strong>Staff Scanner PWA:</strong> Petugas gerbang cukup scan tiket lewat kamera browser tanpa instal aplikasi rumit.</span>
              </li>
              <li class="flex items-start gap-3">
                <span class="w-6 h-6 rounded-full bg-[#DAEBE3] text-[#1E4D38] flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                <span><strong>Payment Gateway Midtrans:</strong> Dukungan QRIS, Virtual Account BCA/BNI/Mandiri, dan E-Wallet otomatis.</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#657166] text-white pt-12 pb-8 px-6">
      <div class="max-w-7xl mx-auto grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
        <div class="space-y-4">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-[10px] bg-[#99CDD8] text-[#2D3A30] flex items-center justify-center font-heading text-lg">DT</div>
            <span class="font-heading text-xl">Daebak.Tix</span>
          </div>
          <p class="text-xs text-white/75 leading-relaxed font-sans">
            Platform ticketing universal terkini khusus konser & fanmeeting Korea di Indonesia dengan pengalaman bertransaksi terpercaya.
          </p>
        </div>

        <div>
          <h4 class="font-heading text-base mb-4 text-[#DAEBE3]">Menu Utama</h4>
          <ul class="space-y-2 text-xs text-white/75 font-sans">
            <li><Link href="/login" class="hover:text-[#99CDD8] transition-colors">Login Pengguna</Link></li>
            <li><Link href="/signup" class="hover:text-[#99CDD8] transition-colors">Daftar Akun Pembeli</Link></li>
            <li><Link href="/seller/register" class="hover:text-[#99CDD8] transition-colors">Pendaftaran Promotor</Link></li>
          </ul>
        </div>

        <div>
          <h4 class="font-heading text-base mb-4 text-[#DAEBE3]">Bantuan & Kontak</h4>
          <ul class="space-y-2 text-xs text-white/75 font-sans">
            <li>WhatsApp: +62 812-3456-7890</li>
            <li>Email: admin@daebaktix.com</li>
            <li>Jam Operasional: 09.00 - 18.00 WIB</li>
          </ul>
        </div>

        <div>
          <h4 class="font-heading text-base mb-4 text-[#DAEBE3]">Metode Pembayaran</h4>
          <div class="flex flex-wrap gap-2 text-xs font-sans">
            <span class="px-3 py-1 rounded-[8px] bg-white/15">QRIS</span>
            <span class="px-3 py-1 rounded-[8px] bg-white/15">BCA VA</span>
            <span class="px-3 py-1 rounded-[8px] bg-white/15">Mandiri VA</span>
            <span class="px-3 py-1 rounded-[8px] bg-white/15">GoPay / ShopeePay</span>
          </div>
        </div>
      </div>

      <div class="max-w-7xl mx-auto border-t border-white/15 pt-6 text-center text-xs text-white/60 font-sans">
        &copy; 2026 Daebak.Tix. All rights reserved. Made with ❤️ for K-Pop Fans in Indonesia.
      </div>
    </footer>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';

defineProps({
  featuredEvents: {
    type: Array,
    default: () => []
  }
});
</script>
