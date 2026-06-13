<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Produktivitas Mahasiswa | Smart Totebag</title>
    <meta name="description" content="Dashboard produktivitas mahasiswa terintegrasi dengan Pomodoro Timer dan To-Do List untuk pengguna Smart Totebag.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            primary: '#4f46e5',   // Solid Indigo
                            primaryHover: '#4338ca',
                            success: '#10b981',   // Solid Emerald
                        },
                        light: {
                            bg: '#f9fafb',        // Soft gray-white background
                            card: '#ffffff',      // Pure white cards
                            border: '#e5e7eb',    // Clean light border
                            textMain: '#1f2937',  // Charcoal text
                            textMuted: '#4b5563', // Muted text
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            background-color: #f9fafb;
            color: #1f2937;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        .study-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .study-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
            border-color: #d1d5db;
        }

        /* Checkbox Styling */
        .task-checkbox {
            position: relative;
            cursor: pointer;
            width: 1.35rem;
            height: 1.35rem;
            border-radius: 6px;
            border: 2px solid #d1d5db;
            background-color: #ffffff;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkbox-container:hover .task-checkbox {
            border-color: #4f46e5;
        }

        .checkbox-container.checked .task-checkbox {
            background-color: #10b981;
            border-color: #10b981;
        }

        /* Hide scrollbars */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- Header / Navbar -->
    <header class="border-b border-light-border bg-white sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-primary flex items-center justify-center shadow-sm">
                    <i class="fas fa-graduation-cap text-lg text-white"></i>
                </div>
                <div>
                    <h1 class="font-outfit text-base font-bold text-light-textMain tracking-tight leading-none">Smart Totebag</h1>
                    <span class="text-[10px] text-brand-primary font-semibold tracking-wider uppercase">Productivity Dashboard</span>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold px-3 py-1.5 rounded-lg bg-emerald-50 border border-emerald-200 text-brand-success flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-brand-success animate-pulse"></span>
                    NFC Synced
                </span>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl w-full mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-12 gap-6 flex-grow">
        
        <!-- SISI KIRI: POMODORO TIMER (4 Columns) -->
        <section class="lg:col-span-4 flex flex-col">
            <div class="study-card rounded-2xl p-6 flex flex-col justify-between h-full">
                <div>
                    <h2 class="text-xs font-bold text-light-textMuted tracking-widest uppercase mb-4">Timer Pomodoro</h2>
                    
                    <!-- Mode Selection -->
                    <div class="grid grid-cols-3 bg-slate-100 p-1 rounded-xl border border-light-border text-center mb-8">
                        <button id="mode-pomodoro" class="py-2 text-xs font-semibold rounded-lg bg-white text-light-textMain shadow-sm border border-light-border/80 font-medium transition-all" onclick="setMode('pomodoro')">
                            Focus
                        </button>
                        <button id="mode-short" class="py-2 text-xs font-semibold rounded-lg text-light-textMuted hover:text-light-textMain transition-all" onclick="setMode('short')">
                            Short Break
                        </button>
                        <button id="mode-long" class="py-2 text-xs font-semibold rounded-lg text-light-textMuted hover:text-light-textMain transition-all" onclick="setMode('long')">
                            Long Break
                        </button>
                    </div>

                    <!-- Circular Display -->
                    <div class="relative w-48 h-48 flex items-center justify-center mx-auto my-4">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <!-- Background Track -->
                            <circle cx="50" cy="50" r="45" fill="transparent" stroke="#f3f4f6" stroke-width="2.5"></circle>
                            <!-- Active Track -->
                            <circle id="timer-progress" cx="50" cy="50" r="45" fill="transparent" stroke="#4f46e5" stroke-width="2.5" stroke-dasharray="283" stroke-dashoffset="0" stroke-linecap="round" class="transition-all duration-1000 ease-linear"></circle>
                        </svg>
                        <div class="absolute text-center">
                            <span id="timer-display" class="font-outfit text-4xl font-extrabold text-light-textMain tracking-tight">25:00</span>
                            <p id="timer-status" class="text-[9px] font-bold tracking-widest text-brand-primary uppercase mt-1.5">Fokus Belajar</p>
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <div class="flex gap-3 items-center justify-center mt-6">
                    <button id="btn-reset" class="px-4 py-2 bg-white border border-light-border hover:bg-slate-50 text-light-textMuted hover:text-light-textMain rounded-xl text-xs font-semibold transition-all shadow-sm" onclick="resetTimer()">
                        Reset
                    </button>
                    
                    <button id="btn-toggle" class="px-6 py-2 bg-brand-primary hover:bg-brand-primaryHover text-white rounded-xl text-xs font-bold transition-all transform hover:scale-[1.02] active:scale-95 shadow-sm flex items-center gap-2" onclick="toggleTimer()">
                        <i id="play-icon" class="fas fa-play text-[10px]"></i> <span id="btn-text">Mulai</span>
                    </button>
                    
                    <button id="btn-edit-time" class="p-2.5 bg-white border border-light-border text-light-textMuted hover:text-light-textMain rounded-xl text-xs shadow-sm" title="Ubah Durasi Waktu" onclick="toggleTimeSettings()">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>

                <!-- Time Settings Panel (Collapsible) -->
                <div id="time-settings" class="hidden w-full mt-4 p-4 bg-slate-50 border border-light-border rounded-xl">
                    <h3 class="text-[10px] font-bold text-light-textMain mb-3 uppercase tracking-wider">Kustomisasi Durasi (Menit)</h3>
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between text-xs font-medium text-light-textMuted">
                            <span>Focus Time:</span>
                            <input type="number" id="custom-pomodoro" min="1" max="180" value="25" class="w-14 text-center bg-white border border-light-border rounded-lg py-1 text-light-textMain focus:outline-none focus:border-brand-primary">
                        </div>
                        <div class="flex items-center justify-between text-xs font-medium text-light-textMuted">
                            <span>Short Break:</span>
                            <input type="number" id="custom-short" min="1" max="180" value="5" class="w-14 text-center bg-white border border-light-border rounded-lg py-1 text-light-textMain focus:outline-none focus:border-brand-primary">
                        </div>
                        <div class="flex items-center justify-between text-xs font-medium text-light-textMuted">
                            <span>Long Break:</span>
                            <input type="number" id="custom-long" min="1" max="180" value="15" class="w-14 text-center bg-white border border-light-border rounded-lg py-1 text-light-textMain focus:outline-none focus:border-brand-primary">
                        </div>
                    </div>
                    <button onclick="saveCustomTimes()" class="w-full mt-4 py-2 bg-brand-primary hover:bg-brand-primaryHover text-white rounded-xl text-xs font-bold tracking-wide transition-all shadow-sm">
                        Simpan Konfigurasi
                    </button>
                </div>
            </div>
        </section>

        <!-- TENGAH: TOTEBAG SPEC CONTAINER (3 Columns) -->
        <section class="lg:col-span-3 flex flex-col">
            <div class="study-card rounded-2xl p-6 flex flex-col justify-between h-full">
                <div>
                    <h2 class="text-xs font-bold text-light-textMuted tracking-widest uppercase mb-4">Spesifikasi Totebag</h2>

                    <!-- Modern Light Placeholder / Image Container -->
                    <div class="w-full aspect-square rounded-xl bg-slate-50 border border-light-border flex flex-col items-center justify-center text-slate-400 mb-5 relative overflow-hidden shadow-inner">
                        @if(file_exists(public_path('images/totebag.jpg')))
                            <img src="{{ asset('images/totebag.jpg') }}" alt="Smart Totebag Product" class="w-full h-full object-cover">
                        @elseif(file_exists(public_path('images/totebag.jpeg')))
                            <img src="{{ asset('images/totebag.jpeg') }}" alt="Smart Totebag Product" class="w-full h-full object-cover">
                        @elseif(file_exists(public_path('images/totebag.png')))
                            <img src="{{ asset('images/totebag.png') }}" alt="Smart Totebag Product" class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 opacity-[0.08] bg-[linear-gradient(to_right,#8b949e_1px,transparent_1px),linear-gradient(to_bottom,#8b949e_1px,transparent_1px)] bg-[size:16px_16px]"></div>
                            <div class="z-10 text-center px-4">
                                <div class="w-12 h-12 rounded-full bg-white border border-light-border flex items-center justify-center mx-auto mb-3 text-brand-primary shadow-sm">
                                    <i class="fas fa-shopping-bag text-base"></i>
                                </div>
                                <span class="text-xs font-bold text-light-textMain">Foto Produk Totebag</span>
                                <p class="text-[9px] text-light-textMuted mt-1 leading-relaxed">Simpan foto produk Anda di: <br><span class="font-mono bg-slate-200/80 px-1 py-0.5 rounded text-[8px] text-brand-primary">public/images/totebag.jpg</span></p>
                            </div>
                        @endif
                    </div>

                    <!-- Spec Rows -->
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between items-center p-2.5 rounded-lg bg-slate-50 border border-light-border">
                            <span class="text-light-textMuted">Tipe Produk</span>
                            <span class="font-semibold text-light-textMain">Smart Canvas Bag</span>
                        </div>
                        <div class="flex justify-between items-center p-2.5 rounded-lg bg-slate-50 border border-light-border">
                            <span class="text-light-textMuted">No. Seri</span>
                            <span class="font-mono text-light-textMain">STB-883-X9</span>
                        </div>
                        <div class="flex justify-between items-center p-2.5 rounded-lg bg-slate-50 border border-light-border">
                            <span class="text-light-textMuted">Modul QR</span>
                            <span class="text-brand-success font-semibold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-success"></span> Terverifikasi
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="p-3 bg-indigo-50/50 border border-indigo-100 rounded-xl text-center">
                        <p class="text-[9px] font-bold text-brand-primary uppercase tracking-wider">Terhubung melalui QR Totebag</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SISI KANAN: TO-DO LIST (5 Columns) -->
        <section class="lg:col-span-5 flex flex-col">
            <div class="study-card rounded-2xl p-6 flex flex-col h-full">
                
                <!-- Header & Progress -->
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xs font-bold text-light-textMuted tracking-widest uppercase">Agenda Belajar</h2>
                        <p class="text-[10px] text-light-textMuted mt-0.5">Kelola tugas akademik dan jadwal belajar</p>
                    </div>
                    @php
                        $completedCount = $todos->where('is_completed', true)->count();
                        $totalCount = $todos->count();
                        $progressPercent = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;
                    @endphp
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded bg-slate-50 border border-light-border text-brand-primary">
                        {{ $completedCount }}/{{ $totalCount }} Tugas ({{ $progressPercent }}%)
                    </span>
                </div>

                <!-- Linear Progress Bar -->
                <div class="w-full bg-slate-100 rounded-full h-1.5 mb-5 border border-light-border p-[1px]">
                    <div class="bg-brand-success h-full rounded-full transition-all duration-300" style="width: {{ $progressPercent }}%"></div>
                </div>

                <!-- Add Task Form -->
                <form action="{{ route('todo.store') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="flex gap-2">
                        <input type="text" name="task" id="input-todo" placeholder="Tambah rencana belajar baru..." required class="flex-grow bg-white border border-light-border rounded-xl px-4 py-2.5 text-light-textMain placeholder-slate-400 focus:outline-none focus:border-brand-primary text-xs transition-all shadow-sm">
                        <button type="submit" class="px-5 py-2 bg-brand-primary hover:bg-brand-primaryHover text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                            Tambah
                        </button>
                    </div>
                </form>

                <!-- Tasks Listing -->
                <div class="flex-grow overflow-y-auto max-h-[300px] pr-1 no-scrollbar">
                    @if ($todos->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12 text-slate-400 text-center">
                            <div class="w-12 h-12 rounded-full bg-slate-100 border border-light-border flex items-center justify-center mb-3 text-slate-400">
                                <i class="fas fa-list-ul"></i>
                            </div>
                            <p class="text-xs font-semibold text-light-textMuted">Agenda belajarmu masih kosong</p>
                            <p class="text-[9px] text-slate-400 mt-1">Gunakan formulir di atas untuk mencatat tugas</p>
                        </div>
                    @else
                        @foreach ($todos as $todo)
                            <div class="flex items-center justify-between p-3.5 bg-slate-50 border border-light-border rounded-xl mb-2.5 hover:border-slate-300 transition-all duration-150 group">
                                <div class="flex items-center gap-3.5 flex-grow mr-2">
                                    <!-- Checked Status form submit -->
                                    <form action="{{ route('todo.update', $todo->id) }}" method="POST" id="form-update-{{ $todo->id }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_completed" value="{{ $todo->is_completed ? 0 : 1 }}">
                                        <button type="button" class="checkbox-container {{ $todo->is_completed ? 'checked' : '' }} focus:outline-none" onclick="document.getElementById('form-update-{{ $todo->id }}').submit()">
                                            <div class="task-checkbox">
                                                @if ($todo->is_completed)
                                                    <i class="fas fa-check text-[9px] text-white"></i>
                                                @endif
                                            </div>
                                        </button>
                                    </form>

                                    <!-- Task Title -->
                                    <span class="text-xs font-medium transition-all duration-150 {{ $todo->is_completed ? 'line-through text-slate-400' : 'text-light-textMain' }}">
                                        {{ $todo->task }}
                                    </span>
                                </div>

                                <!-- Delete Action -->
                                <form action="{{ route('todo.destroy', $todo->id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-red-500 p-1.5 rounded hover:bg-red-50 transition-all">
                                        <i class="far fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="border-t border-light-border py-4 bg-white text-center text-[10px] text-light-textMuted">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-3">
            <p>&copy; 2026 Campus Productivity Dashboard. Hak Cipta Dilindungi.</p>
            <div class="flex items-center gap-2">
                <span>Diakses via scan QR Code produk</span>
                <i class="fas fa-qrcode text-brand-primary"></i>
            </div>
        </div>
    </footer>

    <!-- Vanilla Javascript: Pomodoro Logic -->
    <script>
        // Durations in seconds
        const modeDurations = {
            pomodoro: 25 * 60,
            short: 5 * 60,
            long: 15 * 60
        };

        let currentMode = 'pomodoro';
        let timeLeft = modeDurations[currentMode];
        let totalDuration = modeDurations[currentMode];
        let timerInterval = null;
        const strokeDashArray = 283;

        // Dom Elements
        const timerDisplay = document.getElementById('timer-display');
        const timerStatus = document.getElementById('timer-status');
        const timerProgress = document.getElementById('timer-progress');
        const btnToggle = document.getElementById('btn-toggle');
        const btnText = document.getElementById('btn-text');
        const playIcon = document.getElementById('play-icon');

        // Toggle time settings panel
        function toggleTimeSettings() {
            const panel = document.getElementById('time-settings');
            panel.classList.toggle('hidden');
        }

        // Save customized time intervals
        function saveCustomTimes() {
            const focusMin = parseInt(document.getElementById('custom-pomodoro').value);
            const shortMin = parseInt(document.getElementById('custom-short').value);
            const longMin = parseInt(document.getElementById('custom-long').value);

            if (isNaN(focusMin) || focusMin < 1 || focusMin > 180 ||
                isNaN(shortMin) || shortMin < 1 || shortMin > 180 ||
                isNaN(longMin) || longMin < 1 || longMin > 180) {
                alert('Durasi waktu harus di antara 1 sampai 180 menit.');
                return;
            }

            modeDurations.pomodoro = focusMin * 60;
            modeDurations.short = shortMin * 60;
            modeDurations.long = longMin * 60;

            // Apply new time directly to the current mode
            timeLeft = modeDurations[currentMode];
            totalDuration = modeDurations[currentMode];
            
            updateTimerDisplay();
            pauseTimer();
            
            // Hide the settings panel
            document.getElementById('time-settings').classList.add('hidden');
            
            // Show custom toast notification
            showJSToast('Konfigurasi durasi waktu berhasil diperbarui!');
        }

        // Dynamic client-side toast notification helper
        function showJSToast(message) {
            const existing = document.getElementById('js-toast-notification');
            if (existing) existing.remove();

            const toast = document.createElement('div');
            toast.id = 'js-toast-notification';
            toast.className = 'fixed bottom-5 right-5 z-50 flex items-center gap-3 bg-white border border-light-border px-4 py-3.5 rounded-xl shadow-lg transition-all duration-350 transform translate-y-2 opacity-0 max-w-sm';
            toast.innerHTML = `
                <div class="w-7 h-7 rounded-full bg-emerald-50 text-brand-success flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check text-[10px]"></i>
                </div>
                <div class="flex-grow mr-2">
                    <p class="text-xs font-bold text-light-textMain">Notifikasi</p>
                    <p class="text-[11px] text-light-textMuted mt-0.5 leading-relaxed">${message}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-650 transition-colors ml-1.5 focus:outline-none">
                    <i class="fas fa-times text-xs"></i>
                </button>
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            }, 50);

            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-2', 'opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 350);
            }, 3500);
        }

        // Set Pomodoro Mode
        function setMode(mode) {
            currentMode = mode;
            timeLeft = modeDurations[mode];
            totalDuration = modeDurations[mode];
            
            // Toggle active buttons
            ['pomodoro', 'short', 'long'].forEach(m => {
                const btn = document.getElementById(`mode-${m}`);
                if (m === mode) {
                    btn.className = 'py-2 text-xs font-semibold rounded-lg bg-white text-light-textMain shadow-sm border border-light-border/80 font-medium transition-all';
                } else {
                    btn.className = 'py-2 text-xs font-semibold rounded-lg text-light-textMuted hover:text-light-textMain transition-all';
                }
            });

            // Update sub-label
            if (mode === 'pomodoro') {
                timerStatus.textContent = 'Fokus Belajar';
                timerStatus.className = 'text-[9px] font-bold tracking-widest text-brand-primary uppercase mt-1.5';
                timerProgress.setAttribute('stroke', '#4f46e5');
            } else if (mode === 'short') {
                timerStatus.textContent = 'Istirahat Pendek';
                timerStatus.className = 'text-[9px] font-bold tracking-widest text-brand-success uppercase mt-1.5';
                timerProgress.setAttribute('stroke', '#10b981');
            } else {
                timerStatus.textContent = 'Istirahat Panjang';
                timerStatus.className = 'text-[9px] font-bold tracking-widest text-brand-primary uppercase mt-1.5';
                timerProgress.setAttribute('stroke', '#4f46e5');
            }

            pauseTimer();
            updateTimerDisplay();
        }

        // Render Timer Display
        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            document.title = `(${timerDisplay.textContent}) ${timerStatus.textContent} | Campus Productivity`;

            const percent = (timeLeft / totalDuration);
            const offset = percent * strokeDashArray;
            timerProgress.style.strokeDashoffset = strokeDashArray - offset;
        }

        // Toggle timer play/pause
        function toggleTimer() {
            if (timerInterval) {
                pauseTimer();
            } else {
                startTimer();
            }
        }

        function startTimer() {
            playIcon.className = 'fas fa-pause text-[10px]';
            btnText.textContent = 'Jeda';
            
            timerInterval = setInterval(() => {
                if (timeLeft > 0) {
                    timeLeft--;
                    updateTimerDisplay();
                } else {
                    clearInterval(timerInterval);
                    timerInterval = null;
                    if (currentMode === 'pomodoro') {
                        showJSToast('Sesi fokus selesai! Silakan ambil istirahat sejenak.');
                        setMode('short');
                    } else {
                        showJSToast('Istirahat selesai! Waktunya kembali fokus belajar.');
                        setMode('pomodoro');
                    }
                }
            }, 1000);
        }

        function pauseTimer() {
            clearInterval(timerInterval);
            timerInterval = null;
            playIcon.className = 'fas fa-play text-[10px]';
            btnText.textContent = 'Mulai';
        }

        function resetTimer() {
            pauseTimer();
            timeLeft = modeDurations[currentMode];
            updateTimerDisplay();
        }

        // Initialize state
        updateTimerDisplay();
    </script>

    <!-- Toast Notifications -->
    @if (session('success'))
        <div id="toast-notification" class="fixed bottom-5 right-5 z-50 flex items-center gap-3 bg-white border border-light-border px-4 py-3.5 rounded-xl shadow-lg transition-all duration-350 transform translate-y-0 opacity-100 max-w-sm">
            <div class="w-7 h-7 rounded-full bg-emerald-50 text-brand-success flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check text-[10px]"></i>
            </div>
            <div class="flex-grow mr-2">
                <p class="text-xs font-bold text-light-textMain">Notifikasi</p>
                <p class="text-[11px] text-light-textMuted mt-0.5 leading-relaxed">{{ session('success') }}</p>
            </div>
            <button onclick="dismissToast()" class="text-slate-400 hover:text-slate-600 transition-colors ml-1.5 focus:outline-none">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <script>
            // Auto dismiss toast after 3.5s
            setTimeout(() => {
                dismissToast();
            }, 3500);

            function dismissToast() {
                const toast = document.getElementById('toast-notification');
                if (toast) {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-2', 'opacity-0');
                    setTimeout(() => {
                        toast.remove();
                    }, 350);
                }
            }
        </script>
    @endif
</body>
</html>
