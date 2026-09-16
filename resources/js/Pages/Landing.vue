<template>
  <div class="min-h-screen bg-daebak-cream font-sans text-daebak-charcoal">
    <!-- Navbar -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-white/75 border-b border-daebak-sage/30 px-6 py-4 transition-all">
      <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-daebak-blue to-daebak-coral flex items-center justify-center text-white font-heading text-xl shadow-md">
            D
          </div>
          <span class="font-heading text-2xl tracking-wide text-daebak-charcoal">Daebak.Tix</span>
        </div>

        <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
          <a href="#cara-kerja" class="hover:text-daebak-blue transition-colors">Cara Kerja</a>
          <a href="#kategori" class="hover:text-daebak-blue transition-colors">Kategori Event</a>
          <a href="#jual-tiket" class="hover:text-daebak-coral transition-colors">Jual Tiket</a>
        </nav>

        <div class="flex items-center gap-3">
          <a href="/login" class="px-5 py-2.5 rounded-xl border border-daebak-sage text-sm font-semibold hover:bg-white transition-all shadow-sm">
            Masuk Pembeli
          </a>
          <a href="/seller/register" class="btn-daebak-secondary text-sm font-semibold shadow-sm">
            Mulai Jual Tiket
          </a>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-16 pb-24 px-6 overflow-hidden">
      <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <div class="space-y-6">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-daebak-mint text-xs font-semibold text-daebak-charcoal shadow-sm border border-daebak-sage/40">
            ✨ Platform Tiket K-Pop #1 di Indonesia
          </div>
          <h1 class="font-heading text-4xl sm:text-6xl text-daebak-charcoal leading-tight">
            Nonton Konser & Fanmeeting K-Pop Jadi <span class="bg-gradient-to-r from-daebak-blue via-daebak-coral to-daebak-mint bg-clip-text text-transparent">Lebih Praktis</span>
          </h1>
          <p class="text-base sm:text-lg text-daebak-charcoal/80 max-w-xl leading-relaxed">
            Daebak.Tix menghubungkan penggemar dengan promotor resmi secara cepat, aman, dan transparan. Tiket digital langsung terverifikasi dengan QR Code asli.
          </p>
          <div class="flex flex-wrap gap-4 pt-2">
            <a href="/login" class="btn-daebak-primary text-base px-8 py-3.5 shadow-lg hover:shadow-xl">
              Cari Tiket Event 🎫
            </a>
            <a href="#jual-tiket" class="px-8 py-3.5 rounded-2xl bg-white border border-daebak-sage font-semibold text-daebak-charcoal hover:bg-daebak-mint/30 transition-all shadow-md">
              Pelajari Fitur Penjual
            </a>
          </div>
        </div>

        <!-- Right Visual Mockup -->
        <div class="relative">
          <div class="absolute -top-10 -right-10 w-72 h-72 bg-daebak-blue/30 rounded-full blur-3xl"></div>
          <div class="absolute -bottom-10 -left-10 w-72 h-72 bg-daebak-coral/30 rounded-full blur-3xl"></div>
          
          <div class="card-daebak p-6 card-soft-gradient relative z-10">
            <div class="bg-white rounded-2xl p-5 shadow-sm space-y-4">
              <div class="relative h-48 rounded-xl overflow-hidden bg-slate-100">
                <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=800&q=80" alt="BLACKPINK Born Pink" class="w-full h-full object-cover"/>
                <span class="absolute top-3 right-3 bg-daebak-coral text-white text-xs px-3 py-1 rounded-full font-semibold shadow">
                  K-Pop Concert
                </span>
              </div>
              <div>
                <h3 class="font-heading text-xl text-daebak-charcoal">BLACKPINK WORLD TOUR [BORN PINK]</h3>
                <p class="text-xs text-daebak-charcoal/70">Stadion Utama Gelora Bung Karno (GBK)</p>
              </div>
              <div class="flex items-center justify-between pt-2 border-t border-daebak-sage/30">
                <div>
                  <span class="text-xs text-daebak-charcoal/60">Mulai dari</span>
                  <p class="font-bold text-daebak-charcoal text-lg">Rp 2.400.000</p>
                </div>
                <a href="/login" class="btn-daebak-primary text-xs py-2 px-4">Pesan Sekarang</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Categories Section -->
    <section id="kategori" class="py-16 px-6 bg-white/60 backdrop-blur-sm border-y border-daebak-sage/30">
      <div class="max-w-7xl mx-auto space-y-10">
        <div class="text-center space-y-3">
          <h2 class="font-heading text-3xl sm:text-4xl text-daebak-charcoal">Kategori Tiket Acara Korea</h2>
          <p class="text-sm text-daebak-charcoal/70">Temukan berbagai bentuk acara favorit idol K-Pop kamu</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="card-daebak p-6 hover:border-daebak-blue transition-all">
            <div class="w-12 h-12 rounded-2xl bg-daebak-mint flex items-center justify-center text-2xl mb-4">🎤</div>
            <h3 class="font-heading text-xl mb-2">Konser Idol</h3>
            <p class="text-xs text-daebak-charcoal/70 leading-relaxed">Konser panggung skala besar dengan produksi tata suara & pencahayaan kelas dunia.</p>
          </div>
          <div class="card-daebak p-6 hover:border-daebak-blue transition-all">
            <div class="w-12 h-12 rounded-2xl bg-daebak-cream flex items-center justify-center text-2xl mb-4">🤝</div>
            <h3 class="font-heading text-xl mb-2">Fanmeeting</h3>
            <p class="text-xs text-daebak-charcoal/70 leading-relaxed">Interaksi hangat, games interaktif, hi-touch, dan foto bersama idol idaman.</p>
          </div>
          <div class="card-daebak p-6 hover:border-daebak-blue transition-all">
            <div class="w-12 h-12 rounded-2xl bg-daebak-coral/40 flex items-center justify-center text-2xl mb-4">⛩️</div>
            <h3 class="font-heading text-xl mb-2">Festival Budaya</h3>
            <p class="text-xs text-daebak-charcoal/70 leading-relaxed">Festival kuliner K-Food, pameran K-Beauty, dan pertunjukan tarian tradisional Korea.</p>
          </div>
          <div class="card-daebak p-6 hover:border-daebak-blue transition-all">
            <div class="w-12 h-12 rounded-2xl bg-daebak-blue/40 flex items-center justify-center text-2xl mb-4">🍿</div>
            <h3 class="font-heading text-xl mb-2">Movie Screening</h3>
            <p class="text-xs text-daebak-charcoal/70 leading-relaxed">Nonton bareng dokumenter konser atau premiere film Korea di bioskop terpilih.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Seller Banner Section -->
    <section id="jual-tiket" class="py-20 px-6">
      <div class="max-w-7xl mx-auto card-daebak card-warm-gradient p-8 sm:p-12 relative overflow-hidden">
        <div class="grid lg:grid-cols-2 gap-8 items-center relative z-10">
          <div class="space-y-6">
            <span class="inline-block px-4 py-1.5 rounded-full bg-white/80 text-xs font-bold text-daebak-charcoal">
              Solusi Penjualan Tiket Promotor
            </span>
            <h2 class="font-heading text-3xl sm:text-5xl text-daebak-charcoal leading-tight">
              Ingin Menjual Tiket Event Korea di Daebak.Tix?
            </h2>
            <p class="text-sm sm:text-base text-daebak-charcoal/80 leading-relaxed">
              Platform multi-tenant seller profesional dengan sistem pendaftaran terverifikasi manual oleh Admin, pilihan langganan flexibel (Per-Event / Paket Berbayar), dan fitur Scan QR Staff via PWA browser tanpa ribet.
            </p>
            <div class="flex flex-wrap items-center gap-4 pt-2">
              <a href="/seller/register" class="btn-daebak-dark px-8 py-3.5 text-base shadow-lg">
                Daftar Sebagai Penjual 🚀
              </a>
              <a href="https://wa.me/6281234567890" target="_blank" class="px-6 py-3.5 rounded-2xl bg-white border border-daebak-sage font-semibold text-sm hover:bg-slate-50 transition-all shadow">
                💬 Hubungi Admin via WhatsApp
              </a>
            </div>
          </div>

          <div class="bg-white/90 backdrop-blur rounded-3xl p-6 shadow-xl space-y-4">
            <h3 class="font-heading text-xl text-daebak-charcoal border-b border-daebak-sage/30 pb-3">Keunggulan Fitur Penjual</h3>
            <ul class="space-y-3 text-sm">
              <li class="flex items-start gap-3">
                <span class="text-emerald-600 font-bold">✓</span>
                <span><strong>Verifikasi Manual Admin:</strong> Seller hanya diberikan akses setelah diverifikasi untuk mencegah penipuan tiket.</span>
              </li>
              <li class="flex items-start gap-3">
                <span class="text-emerald-600 font-bold">✓</span>
                <span><strong>Pilihan Akun Berbayar vs Per-Event:</strong> Hemat biaya dengan skema per-event 7/12 hari atau langganan bulanan tanpa batas.</span>
              </li>
              <li class="flex items-start gap-3">
                <span class="text-emerald-600 font-bold">✓</span>
                <span><strong>Scan QR Staf PWA Kamera:</strong> Petugas lapangan tinggal buka web di HP tanpa download aplikasi tambahan.</span>
              </li>
              <li class="flex items-start gap-3">
                <span class="text-emerald-600 font-bold">✓</span>
                <span><strong>Midtrans Payment Gateway:</strong> Pembayaran aman QRIS, Bank Transfer VA, dan E-Wallet instant.</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-daebak-charcoal text-white pt-12 pb-8 px-6">
      <div class="max-w-7xl mx-auto grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
        <div class="space-y-4">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-daebak-blue text-daebak-charcoal flex items-center justify-center font-heading text-lg">D</div>
            <span class="font-heading text-xl">Daebak.Tix</span>
          </div>
          <p class="text-xs text-white/70 leading-relaxed">
            Platform ticketing universal terkini khusus event Korea di Indonesia dengan pengalaman bertransaksi terpercaya.
          </p>
        </div>

        <div>
          <h4 class="font-heading text-base mb-4 text-daebak-mint">Menu Utama</h4>
          <ul class="space-y-2 text-xs text-white/70">
            <li><a href="/login" class="hover:text-white">Login Pembeli</a></li>
            <li><a href="/signup" class="hover:text-white">Daftar Akun Pembeli</a></li>
            <li><a href="/seller/register" class="hover:text-white">Pendaftaran Penjual</a></li>
          </ul>
        </div>

        <div>
          <h4 class="font-heading text-base mb-4 text-daebak-mint">Bantuan & Hubungi</h4>
          <ul class="space-y-2 text-xs text-white/70">
            <li>WhatsApp: +62 812-3456-7890</li>
            <li>Email Admin: admin@daebaktix.com</li>
            <li>Jam Operasional: 09.00 - 18.00 WIB</li>
          </ul>
        </div>

        <div>
          <h4 class="font-heading text-base mb-4 text-daebak-mint">Metode Pembayaran</h4>
          <div class="flex flex-wrap gap-2 text-xs">
            <span class="px-2.5 py-1 rounded bg-white/10">QRIS</span>
            <span class="px-2.5 py-1 rounded bg-white/10">BCA VA</span>
            <span class="px-2.5 py-1 rounded bg-white/10">Mandiri VA</span>
            <span class="px-2.5 py-1 rounded bg-white/10">GoPay / ShopeePay</span>
          </div>
        </div>
      </div>

      <div class="max-w-7xl mx-auto border-t border-white/10 pt-6 text-center text-xs text-white/50">
        &copy; 2026 Daebak.Tix. All rights reserved. Made with ❤️ for K-Pop Fans in Indonesia.
      </div>
    </footer>
  </div>
</template>

<script setup>
defineProps({
  featuredEvents: Array
});
</script>
