<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>16 Personalities - Individual Cards</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .person-card-container {
            break-inside: avoid;
        }

        @media print {
            @page {
                size: A4;
                margin: 8mm;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .print-header {
                display: none !important;
            }
            .no-print {
                display: none !important;
            }
            /* Grid: 3 stĺpce, kompaktné karty → 6 kartičiek na A4 */
            .cards-grid {
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 4mm !important;
                width: 100% !important;
            }
            .person-card-container {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
                font-size: 9pt !important;
            }
            /* Kompaktné rozmery karty */
            .card-header {
                padding: 4mm !important;
            }
            .card-header img {
                width: 14mm !important;
                height: 14mm !important;
                border-radius: 2mm !important;
            }
            .card-header h2 {
                font-size: 13pt !important;
                line-height: 1.1 !important;
            }
            .card-header p {
                font-size: 7.5pt !important;
                margin-top: 0.5mm !important;
            }
            .card-body {
                padding: 3mm 4mm !important;
            }
            .card-section {
                padding-bottom: 2mm !important;
                margin-bottom: 2mm !important;
            }
            .card-section-label {
                font-size: 6.5pt !important;
                margin-bottom: 1mm !important;
            }
            .card-section h3 {
                font-size: 10pt !important;
                margin-bottom: 1mm !important;
            }
            .card-section p {
                font-size: 7pt !important;
                line-height: 1.3 !important;
                margin: 0 !important;
            }
            .card-section .badge {
                font-size: 7pt !important;
                padding: 0.5mm 2mm !important;
            }
            .card-section .trait-badge {
                font-size: 6.5pt !important;
                padding: 0.5mm 1.5mm !important;
            }

        }
    </style>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Hlavička -->
        <header class="print-header mb-12 text-center">
            <div class="inline-block px-4 py-1.5 rounded-full bg-slate-900 text-white text-[10px] font-black uppercase tracking-[0.3em] mb-4 shadow-xl">
                Psychological Mapping
            </div>
            <h1 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter italic mb-2">
                INDIVIDUAL <span class="text-slate-300">CARDS</span>
            </h1>
            <p class="text-slate-400 text-lg font-medium max-w-2xl mx-auto">
                Osobné personality profily tímových členov
            </p>
        </header>

        <!-- Grid kartičiek -->
        <div class="cards-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-max">
            <!-- Kartičky sa vložia tu -->
        </div>
    </div>

    <script>
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
                color: "bg-[#f1edf3]", 
                borderColor: "border-[#88619a]", 
                accentColor: "text-[#88619a]", 
                solidColor: "bg-[#88619a]",
                icon: "sparkles", 
                badgeColor: "bg-[#88619a]/10 text-[#88619a]"
            },
            "Diplomat": {
                title: "Diplomats",
                color: "bg-[#eaf4ef]", 
                borderColor: "border-[#33a474]", 
                accentColor: "text-[#33a474]", 
                solidColor: "bg-[#33a474]",
                icon: "compass", 
                badgeColor: "bg-[#33a474]/10 text-[#33a474]"
            },
            "Sentinel": {
                title: "Sentinels",
                color: "bg-[#ebf3f6]", 
                borderColor: "border-[#4298b4]", 
                accentColor: "text-[#4298b4]", 
                solidColor: "bg-[#4298b4]",
                icon: "shield", 
                badgeColor: "bg-[#4298b4]/10 text-[#4298b4]"
            },
            "Explorer": {
                title: "Explorers",
                color: "bg-[#fcf7ec]", 
                borderColor: "border-[#e4ae3a]", 
                accentColor: "text-[#e4ae3a]", 
                solidColor: "bg-[#e4ae3a]",
                icon: "search", 
                badgeColor: "bg-[#e4ae3a]/10 text-[#e4ae3a]"
            }
        };

        function init() {
            const container = document.querySelector('.grid');

            teamMembers.forEach(person => {
                const personalityCode = person.personality.split('-')[0];
                const personalityInfo = personalityDefinitions[personalityCode];
                const groupConfig = groupConfigs[person.group];

                const cardHtml = `
                    <div class="person-card-container rounded-2xl shadow-lg overflow-hidden border-2 ${groupConfig.borderColor} hover:shadow-xl transition-all duration-300">
                        <!-- Farebný header -->
                        <div class="card-header ${groupConfig.color} ${groupConfig.borderColor} border-b-4 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <h2 class="text-2xl font-black ${groupConfig.accentColor} tracking-tight leading-none">${person.nick}</h2>
                                    <p class="text-xs text-slate-600 font-bold mt-0.5 truncate">${person.name}</p>
                                    <div class="flex items-center gap-1.5 mt-2">
                                        <span class="font-black text-[11px] ${groupConfig.accentColor} bg-white/80 px-2 py-0.5 rounded-md border border-current/20">
                                            ${person.personality}
                                        </span>
                                        <span class="inline-flex items-center gap-1 ${groupConfig.badgeColor} px-2 py-0.5 rounded-md font-bold text-[11px] border">
                                            <i data-lucide="${groupConfig.icon}" class="w-3 h-3"></i>
                                            ${groupConfig.title}
                                        </span>
                                    </div>
                                </div>
                                <img src="${person.photo}" alt="${person.name}" 
                                     class="w-16 h-16 rounded-xl object-cover border-4 border-white shadow-md flex-shrink-0"
                                     onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(person.name)}&background=random'">
                            </div>
                        </div>

                        <!-- Obsah -->
                        <div class="card-body p-4 bg-white flex flex-col gap-3">
                            <!-- Personality typ -->
                            <div class="card-section pb-3 border-b border-slate-100">
                                <p class="card-section-label text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Personality</p>
                                <h3 class="text-base font-black ${groupConfig.accentColor} leading-none mb-1">${personalityInfo?.title || personalityCode}</h3>
                                <p class="text-[11px] text-slate-500 italic leading-snug">
                                    "${personalityInfo?.description || ''}"
                                </p>
                            </div>

                            <!-- Kľúčové rysy -->
                            <div class="card-section pb-3 border-b border-slate-100">
                                <p class="card-section-label text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Key Traits</p>
                                <div class="flex flex-wrap gap-1">
                                    ${personalityInfo?.keyTraits.map(trait => `
                                        <span class="trait-badge text-[10px] font-bold px-2 py-0.5 rounded border-2 ${groupConfig.borderColor} text-slate-700 bg-white">
                                            ${trait}
                                        </span>
                                    `).join('')}
                                </div>
                            </div>

                            <!-- Vlastnosti -->
                            <div class="card-section">
                                <p class="card-section-label text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Characteristics</p>
                                <div class="flex flex-wrap gap-1">
                                    ${personalityInfo?.traits.map(trait => `
                                        <span class="trait-badge text-[10px] font-medium px-2 py-0.5 rounded-md ${groupConfig.solidColor} text-white">
                                            ${trait}
                                        </span>
                                    `).join('')}
                                </div>
                            </div>
                        </div>

                    </div>
                `;

                container.insertAdjacentHTML('beforeend', cardHtml);
            });

            // Inicializácia ikon
            lucide.createIcons();
        }

        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html>
