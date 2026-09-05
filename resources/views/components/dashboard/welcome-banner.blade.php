@props(['user'])

<div class="relative overflow-hidden rounded-[20px] bg-gradient-to-r from-primary-container via-secondary to-primary-container p-space-xl text-on-primary shadow-md">
<!-- Subtle ambient circle blur inside -->
<div class="absolute -right-16 -top-20 w-80 h-80 rounded-full bg-secondary-container/20 blur-3xl pointer-events-none"></div>
<div class="absolute -left-12 -bottom-16 w-60 h-60 rounded-full bg-tertiary-container/30 blur-2xl pointer-events-none"></div>
<div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-space-lg">
<div class="flex-1 space-y-space-sm">
<div class="flex items-center gap-space-xs">
<span class="px-space-sm py-0.5 rounded-full bg-white/15 backdrop-blur-md text-on-primary font-label-sm text-label-sm tracking-wide uppercase font-semibold">
                Administrator Panel
              </span>
</div>
<h1 class="font-headline-lg text-headline-lg text-white font-bold tracking-tight">
              Halo Super Admin! 👋
            </h1>
<p class="font-body-md text-body-md text-on-primary-container max-w-lg leading-relaxed">
              Selamat datang di Asalink Edu. Pantau seluruh aktivitas pembelajaran, kelola data sekolah, dan manajemen pengguna dari satu pusat kendali.
            </p>
</div>
<!-- Graphic Representation on Right -->
<div class="w-full md:w-56 flex-shrink-0 flex justify-center">
<div class="relative w-48 h-40 bg-white/10 backdrop-blur-sm rounded-2xl p-space-sm flex flex-col justify-between shadow-inner">
<div class="flex items-center justify-between">
<div class="flex items-center gap-1">
<span class="w-2.5 h-2.5 rounded-full bg-red-400"></span>
<span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>
<span class="w-2.5 h-2.5 rounded-full bg-green-400"></span>
</div>
<span class="font-caption text-caption text-white/70">Asalink Edu</span>
</div>
<div class="flex items-center justify-center my-auto">
<div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-white shadow-lg">
<span class="material-symbols-outlined text-4xl">school</span>
</div>
</div>
<div class="space-y-1">
<div class="flex justify-between text-caption font-caption text-white/80">
<span>Status Sistem</span>
<span class="font-bold text-success">Online</span>
</div>
<div class="w-full h-1.5 rounded-full bg-white/20 overflow-hidden">
<div class="h-full bg-success rounded-full w-full"></div>
</div>
</div>
</div>
</div>
</div>
</div>