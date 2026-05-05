<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>16 Personalities Team DNA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Špeciálne štýly pre tlač a layout */
        @media print {
            @page {
                size: A4;
                margin: 0;
            }
            body {
                background-color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .print\:hidden {
                display: none !important;
            }
            /* Každý segment na jednu A4 stranu */
            .segment-section {
                height: 297mm; /* Výška A4 */
                width: 210mm;  /* Šírka A4 */
                page-break-after: always;
                break-after: page;
                padding: 15mm !important;
                overflow: hidden;
                position: relative;
                display: flex !important;
                flex-direction: column !important;
                background-color: white !important;
            }
        }

        /* Jemné animácie pre hover */
        .person-card {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .person-card:hover {
            transform: translateY(-4px);
        }
    </style>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#fafafa] font-['Outfit',sans-serif] p-4 md:p-12 print:p-0">
    <div class="max-w-7xl mx-auto print:max-w-none">
        <!-- Hlavička -->
        <header class="mb-12 text-center relative print:hidden">
            <div class="inline-block px-4 py-1.5 rounded-full bg-slate-900 text-white text-[10px] font-black uppercase tracking-[0.3em] mb-4 shadow-xl">
                Psychological Mapping
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-slate-900 tracking-tighter italic">
                TEAM <span class="text-slate-300">DNA</span>
            </h1>
            <p class="text-slate-400 mt-4 text-xl font-medium max-w-2xl mx-auto">
                Prieskum našich kolektívnych kognitívnych funkcií a osobnostných archetypov na základe 16personalities.
            </p>
        </header>

        <!-- Hlavný graf -->
        <div id="chart-container" class="bg-white rounded-[40px] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden print:border-none print:shadow-none print:bg-transparent">
            <!-- Tu sa vygeneruje obsah cez JS -->
            <div id="segments-grid" class="grid grid-cols-1 md:grid-cols-2 gap-0 divide-x divide-y divide-slate-100 print:grid-cols-1 print:divide-none">
                <!-- Segmenty sa vložia sem -->
            </div>
        </div>

        <!-- Päta -->
        <footer class="mt-16 flex flex-col items-center gap-4 print:hidden">
            <div id="legend" class="flex flex-wrap justify-center gap-6">
                <!-- Legenda sa vloží sem -->
            </div>
            <p class="text-slate-300 text-[10px] font-bold uppercase tracking-[0.4em] mt-8">
                © 2024 Pixel Federation · Behavioral Analytics Division
            </p>
        </footer>
    </div>

    <script>
        /**
         * 16 Personalities Team Chart - Vanilla JS Logic
         */

        const teamMembers = [
            { name: "Daniel Hrenak", personality: "INTJ-T", role: "Architect", group: "Analyst", nick: "Dante", photo: "https://hr.pixelfederation.com/photo/dhrenak-hover.jpg" },
            { name: "Robert Bartovic", personality: "ENTJ-A", role: "Commander", group: "Analyst", nick: "Robo", photo: "https://hr.pixelfederation.com/photo/rbartovic-hover.jpg" },
            { name: "Barbora Hrabovcova", personality: "ENFJ-A", role: "Protagonist", group: "Diplomat", nick: "Baru", photo: "https://hr.pixelfederation.com/photo/bhrabovcova.jpg" },
            { name: "Filip Dudor", personality: "INTJ-A", role: "Architect", group: "Analyst", nick: "Fisho", photo: "https://hr.pixelfederation.com/photo/fdudor-hover.jpg" },
            { name: "Ladislav Setnicky", personality: "ENFJ-A", role: "Protagonist", group: "Diplomat", nick: "Laci", photo: "https://hr.pixelfederation.com/photo/lsetnicky-hover.jpg" },
            { name: "Martin Mickalik", personality: "ISTJ-T", role: "Logistician", group: "Sentinel", nick: "Micky", photo: "https://hr.pixelfederation.com/photo/mmickalik-hover.jpg" },
            { name: "Marek Stankovic", personality: "ISFP-T", role: "Adventurer", group: "Explorer", nick: "Stenky", photo: "https://hr.pixelfederation.com/photo/mstankovic-hover.jpg" },
            { name: "Marek Jusko", personality: "ENTJ-A", role: "Commander", group: "Analyst", nick: "Marek", photo: "https://hr.pixelfederation.com/photo/mjusko-hover.jpg" },
            { name: "Lukas Savara", personality: "ESFJ-A", role: "Consul", group: "Sentinel", nick: "Lukas", photo: "https://hr.pixelfederation.com/photo/lsavara-hover.jpg" },
            { name: "Marian Melko", personality: "INTJ-T", role: "Architect", group: "Analyst", nick: "Majo", photo: "https://hr.pixelfederation.com/photo/mmelko-hover.jpg" },
            { name: "Daniel Duranka", personality: "ENFJ-A", role: "Protagonist", group: "Diplomat", nick: "Dano", photo: "https://hr.pixelfederation.com/photo/dduranka-hover.jpg" },
            { name: "Martin Lucan", personality: "INTJ-T", role: "Architect", group: "Analyst", nick: "Luco", photo: "https://hr.pixelfederation.com/photo/mlucan-hover.jpg" },
            { name: "Vaclav Kubicek", personality: "ENTJ", role: "Commander", group: "Analyst", nick: "Vasek", photo: "https://hr.pixelfederation.com/photo/vkubicek-hover.jpg" },
            { name: "Daniel Lesko", personality: "ESFP-T", role: "Entertainer", group: "Explorer", nick: "Dando", photo: "https://hr.pixelfederation.com/photo/dlesko-hover.jpg" }
        ];

        const personalityDefinitions = {
            "INTJ": { title: "Architect", traits: ["Rational", "Independent", "Determined", "Informed"], keyTraits: ["Introverted", "Intuitive", "Thinking", "Judging"], description: "Imaginative and strategic thinkers, with a plan for everything." },
            "ENTJ": { title: "Commander", traits: ["Decisive", "Efficient", "Confident", "Strong-willed"], keyTraits: ["Extraverted", "Intuitive", "Thinking", "Judging"], description: "Bold, imaginative and strong-willed leaders, always finding a way – or making one." },
            "ENFJ": { title: "Protagonist", traits: ["Warm", "Inspiring", "Charismatic", "Altruistic"], keyTraits: ["Extraverted", "Intuitive", "Feeling", "Judging"], description: "Charismatic and inspiring leaders, able to mesmerize their listeners." },
            "ISTJ": { title: "Logistician", traits: ["Practical", "Fact-minded", "Reliable", "Responsible"], keyTraits: ["Introverted", "Observant", "Thinking", "Judging"], description: "Practical and fact-minded individuals, whose reliability cannot be doubted." },
            "ISFP": { title: "Adventurer", traits: ["Flexible", "Charming", "Artistic", "Curious"], keyTraits: ["Introverted", "Observant", "Feeling", "Prospecting"], description: "Flexible and charming artists, always ready to explore and experience something new." },
            "ESFJ": { title: "Consul", traits: ["Common-minded", "Social", "Caring", "Supportive"], keyTraits: ["Extraverted", "Observant", "Feeling", "Judging"], description: "Extraordinarily caring, social and community-minded people, eager to help." },
            "ESFP": { title: "Entertainer", traits: ["Spontaneous", "Energetic", "Enthusiastic", "Social"], keyTraits: ["Extraverted", "Observant", "Feeling", "Prospecting"], description: "Spontaneous, energetic and enthusiastic people – life is never boring around them." }
        };

        const groupConfigs = {
            "Analyst": {
                title: "Analysts",
                description: "Strategickí myslitelia, ktorí si cenia racionalitu a nestrannosť, často vynikajú v intelektuálnych alebo technologických oblastiach.",
                color: "bg-[#f1edf3]", borderColor: "border-[#88619a]/20", accentColor: "text-[#88619a]", solidColor: "bg-[#88619a]",
                icon: "sparkles", badgeColor: "bg-[#88619a]/10 text-[#88619a]"
            },
            "Diplomat": {
                title: "Diplomats",
                description: "Empatickí jedinci, ktorí sa zameriavajú na spoluprácu a harmóniu, často pôsobia ako sociálne lepidlo tímu.",
                color: "bg-[#eaf4ef]", borderColor: "border-[#33a474]/20", accentColor: "text-[#33a474]", solidColor: "bg-[#33a474]",
                icon: "compass", badgeColor: "bg-[#33a474]/10 text-[#33a474]"
            },
            "Sentinel": {
                title: "Sentinels",
                description: "Kooperatívni a praktickí, hľadajú poriadok a stabilitu, čím zabezpečujú spoľahlivé plnenie plánov.",
                color: "bg-[#ebf3f6]", borderColor: "border-[#4298b4]/20", accentColor: "text-[#4298b4]", solidColor: "bg-[#4298b4]",
                icon: "shield", badgeColor: "bg-[#4298b4]/10 text-[#4298b4]"
            },
            "Explorer": {
                title: "Explorers",
                description: "Spontánni a flexibilní, vynikajú v situáciách, ktoré si vyžadujú rýchle reakcie a praktický prístup.",
                color: "bg-[#fcf7ec]", borderColor: "border-[#e4ae3a]/20", accentColor: "text-[#e4ae3a]", solidColor: "bg-[#e4ae3a]",
                icon: "search", badgeColor: "bg-[#e4ae3a]/10 text-[#e4ae3a]"
            }
        };

        function init() {
            const grid = document.getElementById('segments-grid');
            const legend = document.getElementById('legend');
            
            // Generovanie segmentov
            Object.keys(groupConfigs).forEach(groupName => {
                const config = groupConfigs[groupName];
                const members = teamMembers.filter(m => m.group === groupName);
                
                // Zoskupenie podľa typu osobnosti
                const membersByCode = members.reduce((acc, m) => {
                    const code = m.personality.split('-')[0];
                    if (!acc[code]) acc[code] = [];
                    acc[code].push(m);
                    return acc;
                }, {});

                const segmentHtml = `
                    <div class="flex-1 min-h-[500px] p-8 ${config.color} border ${config.borderColor} flex flex-col gap-6 relative overflow-hidden segment-section">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-4">
                                <div class="p-3 rounded-2xl bg-white shadow-sm border border-slate-100 scale-125">
                                    <i data-lucide="${config.icon}" class="${config.accentColor} w-6 h-6"></i>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-black tracking-tight ${config.accentColor} uppercase italic">${config.title}</h2>
                                    <p class="text-xs font-bold text-slate-500 max-w-xl leading-snug mt-1 border-l-2 pl-3 border-current/20">
                                        ${config.description}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-xs font-black ${config.badgeColor} px-3 py-1.5 rounded-xl border bg-white border-current shadow-sm uppercase">
                                    ${members.length} Členov
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 z-10">
                            ${Object.entries(membersByCode).map(([code, pMembers]) => {
                                const info = personalityDefinitions[code];
                                return `
                                <div class="bg-white/80 rounded-2xl p-4 border border-white shadow-sm flex flex-col gap-3">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 pb-2 border-b border-slate-100">
                                        <div>
                                            <h3 class="text-sm font-black uppercase tracking-widest ${config.accentColor}">
                                                ${info?.title || code} <span class="text-slate-300 ml-1">(${code})</span>
                                            </h3>
                                            <p class="text-[10px] text-slate-500 italic mt-0.5 leading-snug">
                                                "${info?.description || ''}"
                                            </p>
                                        </div>
                                        <div class="flex flex-wrap gap-1">
                                            ${info?.keyTraits.map(trait => `
                                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-900 text-white uppercase shadow-sm">
                                                    ${trait}
                                                </span>
                                            `).join('')}
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-1">
                                        ${info?.traits.map(trait => `
                                            <span class="text-[10px] font-medium text-slate-700 bg-white border border-slate-100 px-2 py-0.5 rounded-full flex items-center gap-1.5">
                                                <div class="w-1.5 h-1.5 rounded-full ${config.solidColor}"></div>
                                                ${trait}
                                            </span>
                                        `).join('')}
                                    </div>
                                    <div class="flex flex-wrap gap-5 pt-2">
                                        ${pMembers.map(person => `
                                            <div class="flex flex-col items-center gap-1 group/person w-20 person-card">
                                                <div class="relative">
                                                    <img src="${person.photo}" alt="${person.name}" 
                                                         class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-sm ring-2 ring-slate-100/50"
                                                         onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(person.name)}&background=random'">
                                                    <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 rounded-full border-2 border-white ${config.solidColor}"></div>
                                                </div>
                                                <div class="text-center overflow-hidden w-full">
                                                    <h5 class="font-bold text-slate-800 text-[11px] truncate leading-tight">${person.nick}</h5>
                                                    <p class="text-[9px] text-slate-400 truncate uppercase tracking-tighter leading-tight">${person.role}</p>
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>
                                </div>
                                `;
                            }).join('')}
                        </div>
                        
                        <div class="absolute -bottom-20 -right-20 opacity-[0.04] rotate-12 print:hidden pointer-events-none">
                            <i data-lucide="${config.icon}" class="w-80 h-80"></i>
                        </div>
                    </div>
                `;
                grid.insertAdjacentHTML('beforeend', segmentHtml);

                // Pridanie legendy
                const legendItem = `
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full ${config.solidColor}"></div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">${config.title}</span>
                    </div>
                `;
                legend.insertAdjacentHTML('beforeend', legendItem);
            });

            // Inicializácia ikon
            lucide.createIcons();
        }

        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html>

