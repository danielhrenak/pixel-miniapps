<?php
// templates/Pages/home.php
?>
<div class="relative min-h-screen overflow-hidden bg-slate-950 px-4 py-10 text-slate-100">
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute -left-20 top-10 h-64 w-64 rounded-full bg-sky-500/20 blur-3xl"></div>
        <div class="absolute -right-24 bottom-10 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>
    </div>

    <div class="relative mx-auto flex w-full max-w-4xl items-center justify-center">
        <section class="w-full max-w-lg rounded-3xl border border-slate-700/80 bg-slate-900/80 p-7 shadow-2xl shadow-black/40 backdrop-blur md:p-10">
            <p class="text-xs uppercase tracking-[0.28em] text-sky-300/90">Pixel Miniapps</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-white md:text-4xl">Vyber si hru</h1>
            <p class="mt-3 text-sm leading-relaxed text-slate-300 md:text-base">Spusti miniappku jednym klikom a zacni hrat hned.</p>

            <div class="mt-8 grid gap-3">
                <a
                    href="/abc"
                    class="group inline-flex items-center justify-between rounded-2xl bg-gradient-to-r from-sky-400 to-cyan-300 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:scale-[1.01] hover:shadow-lg hover:shadow-sky-500/20"
                >
                    <span>ABC</span>
                    <span class="text-base transition group-hover:translate-x-0.5">-></span>
                </a>

                <a
                    href="/abcgame"
                    class="group inline-flex items-center justify-between rounded-2xl border border-slate-600 bg-slate-800/80 px-5 py-3 text-sm font-semibold text-slate-100 transition hover:scale-[1.01] hover:border-slate-500 hover:bg-slate-700/80"
                >
                    <span>ABC GAME</span>
                    <span class="text-base text-slate-300 transition group-hover:translate-x-0.5">-></span>
                </a>

                <a
                    href="/abcgame2"
                    class="group inline-flex items-center justify-between rounded-2xl border border-emerald-600/60 bg-emerald-900/30 px-5 py-3 text-sm font-semibold text-emerald-100 transition hover:scale-[1.01] hover:border-emerald-400 hover:bg-emerald-800/40"
                >
                    <span>ABC GAME 2</span>
                    <span class="text-base text-emerald-300 transition group-hover:translate-x-0.5">-></span>
                </a>
            </div>

            <p class="mt-6 text-center text-xs text-slate-400">Tip: na mobile si pridaj miniappku medzi zalozky pre rychly pristup.</p>
        </section>
    </div>
</div>
