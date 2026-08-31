<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Pindai QR Koleksi — MUSEWANGI</title>
    <meta name="description" content="Pindai QR Code etalase Museum Blambangan langsung dari kamera smartphone.">

    <!-- Favicon HD Multi-Resolution -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Vite Compiled Assets (Tailwind & Alpine) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- html5-qrcode Library -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #000000;
            color: #ffffff;
            margin: 0;
            padding: 0;
            overflow: hidden;
            -webkit-user-select: none;
            user-select: none;
            -webkit-font-smoothing: antialiased;
        }

        /* Fullscreen Video Viewport */
        #qr-reader {
            width: 100% !important;
            height: 100% !important;
            border: none !important;
            position: absolute !important;
            inset: 0 !important;
            background: #000000;
        }

        #qr-reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            position: absolute !important;
            inset: 0 !important;
        }

        #qr-reader__scan_region {
            min-height: 100% !important;
        }

        #qr-reader__dashboard {
            display: none !important;
        }

        /* Scanning Laser Animation ala DANA QRIS */
        @keyframes scanLaser {
            0% {
                top: 4%;
                opacity: 0.2;
            }
            50% {
                opacity: 1;
            }
            100% {
                top: 94%;
                opacity: 0.2;
            }
        }

        .scanning-laser-dana {
            position: absolute;
            left: 2%;
            right: 2%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #FFD86B, #FFFFFF, #FFD86B, transparent);
            box-shadow: 0 0 14px 3px rgba(255, 216, 107, 0.9), 0 0 25px 6px rgba(201, 152, 28, 0.6);
            animation: scanLaser 2s infinite ease-in-out;
            pointer-events: none;
            z-index: 25;
            border-radius: 9999px;
        }

        /* Success Pulse Effect */
        .scan-success-glow {
            box-shadow: 0 0 40px 10px rgba(16, 185, 129, 0.9) !important;
            border-color: #10B981 !important;
        }
    </style>
</head>

<body class="fixed inset-0 w-full h-full bg-black flex flex-col justify-between overflow-hidden">

    <!-- ================= 1. CAMERA VIDEO CONTAINER (FULLSCREEN) ================= -->
    <div class="absolute inset-0 w-full h-full bg-black z-0">
        <div id="qr-reader" class="w-full h-full"></div>
    </div>

    <!-- ================= 2. DANA QRIS DARK OVERLAY WITH CUTOUT ================= -->
    <div class="absolute inset-0 z-10 pointer-events-none flex flex-col justify-between items-center">

        <!-- Top Dark Mask -->
        <div class="w-full bg-black/60 backdrop-blur-2xs flex-1"></div>

        <!-- Middle Row: Left Mask | Center Scanning Cutout | Right Mask -->
        <div class="w-full flex items-center justify-center shrink-0">
            <div class="bg-black/60 backdrop-blur-2xs flex-1 h-[270px] sm:h-[300px]"></div>

            <!-- THE SCANNING SQUARE (VIEWFINDER) -->
            <div id="viewfinder-box" class="w-[270px] sm:w-[300px] h-[270px] sm:h-[300px] relative shrink-0 transition duration-300">
                <!-- Laser Sweep -->
                <div id="laser-bar" class="scanning-laser-dana"></div>

                <!-- 4 Gilded Glowing Corner Brackets (DANA QRIS Style) -->
                <!-- Top-Left -->
                <div class="corner-bracket absolute -top-1 -left-1 w-9 h-9 border-t-[5px] border-l-[5px] border-[#FFD86B] rounded-tl-2xl shadow-sm transition-colors duration-300"></div>
                <!-- Top-Right -->
                <div class="corner-bracket absolute -top-1 -right-1 w-9 h-9 border-t-[5px] border-r-[5px] border-[#FFD86B] rounded-tr-2xl shadow-sm transition-colors duration-300"></div>
                <!-- Bottom-Left -->
                <div class="corner-bracket absolute -bottom-1 -left-1 w-9 h-9 border-b-[5px] border-l-[5px] border-[#FFD86B] rounded-bl-2xl shadow-sm transition-colors duration-300"></div>
                <!-- Bottom-Right -->
                <div class="corner-bracket absolute -bottom-1 -right-1 w-9 h-9 border-b-[5px] border-r-[5px] border-[#FFD86B] rounded-br-2xl shadow-sm transition-colors duration-300"></div>

                <!-- Subtle Grid / Crosshair in Center -->
                <div class="absolute inset-0 flex items-center justify-center opacity-20 pointer-events-none">
                    <div class="w-10 h-0.5 bg-white/70"></div>
                    <div class="h-10 w-0.5 bg-white/70 absolute"></div>
                </div>
            </div>

            <div class="bg-black/60 backdrop-blur-2xs flex-1 h-[270px] sm:h-[300px]"></div>
        </div>

        <!-- Bottom Dark Mask -->
        <div class="w-full bg-black/60 backdrop-blur-2xs flex-1 flex flex-col items-center justify-start pt-4 px-6 text-center">
            <p class="text-xs sm:text-sm font-medium text-white/90 drop-shadow-md">
                Arahkan kamera ke QR Code di etalase museum
            </p>
            <p id="camera-status-text" class="text-[11px] text-[#FFD86B] font-semibold mt-1 flex items-center gap-1.5 drop-shadow-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Memindai otomatis secara langsung...</span>
            </p>
        </div>

    </div>

    <!-- ================= 3. TOP BAR (TRANSPARENT MINIMALIST) ================= -->
    <header class="relative z-30 w-full pt-4 pb-2 px-5 flex items-center justify-between text-white select-none">
        <!-- Back Button -->
        <a href="{{ route('home') }}"
            class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-md hover:bg-black/60 border border-white/15 text-white flex items-center justify-center transition active:scale-95 shadow-lg"
            aria-label="Kembali">
            <i class="fa-solid fa-arrow-left text-base"></i>
        </a>

        <!-- Title Pill -->
        <div class="px-4 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/15 flex items-center gap-2 shadow-lg">
            <i class="fa-solid fa-qrcode text-[#FFD86B] text-xs"></i>
            <span class="text-xs sm:text-sm font-bold text-white tracking-wide">
                Pindai QR Koleksi Museum
            </span>
        </div>

        <!-- Flashlight / Torch Button -->
        <button type="button" id="btn-torch"
            class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-md hover:bg-black/60 border border-white/15 text-[#FFD86B] flex items-center justify-center transition active:scale-95 shadow-lg"
            title="Nyalakan Senter">
            <i id="torch-icon" class="fa-solid fa-bolt text-sm"></i>
        </button>
    </header>

    <!-- ================= 4. BOTTOM ACTION BAR (DANA STYLE) ================= -->
    <footer class="relative z-30 w-full pb-8 pt-3 px-6 select-none flex flex-col items-center gap-4">

        <!-- Quick Action Buttons Row (Galeri, Kamera HP, Putar Kamera) -->
        <div class="flex items-center justify-center gap-4 sm:gap-6">

            <!-- 1. Tombol Galeri Foto (DANA Style) -->
            <label for="gallery-input"
                class="flex flex-col items-center gap-1.5 cursor-pointer group active:scale-95 transition">
                <div class="w-12 h-12 rounded-full bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 flex items-center justify-center text-white text-lg shadow-lg group-hover:border-[#FFD86B] transition">
                    <i class="fa-regular fa-image text-white group-hover:text-[#FFD86B]"></i>
                </div>
                <span class="text-[11px] font-semibold text-white/90 group-hover:text-[#FFD86B]">Galeri</span>
                <input type="file" id="gallery-input" accept="image/*" class="hidden">
            </label>

            <!-- 2. Tombol Kamera Jepret Cadangan (Native Capture) -->
            <label for="native-cam-input"
                class="flex flex-col items-center gap-1.5 cursor-pointer group active:scale-95 transition">
                <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-[#C9981C] to-[#FFD86B] p-0.5 shadow-xl shadow-[#C9981C]/30 flex items-center justify-center">
                    <div class="w-full h-full rounded-full bg-[#162544] flex items-center justify-center text-[#FFD86B] text-xl group-hover:bg-[#1D2F54] transition">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                </div>
                <span class="text-[11px] font-extrabold text-[#FFD86B]">Foto QR</span>
                <input type="file" id="native-cam-input" accept="image/*" capture="environment" class="hidden">
            </label>

            <!-- 3. Tombol Ganti Kamera Depan/Belakang -->
            <button type="button" id="btn-switch-camera"
                class="flex flex-col items-center gap-1.5 group active:scale-95 transition">
                <div class="w-12 h-12 rounded-full bg-white/15 backdrop-blur-md hover:bg-white/25 border border-white/20 flex items-center justify-center text-white text-lg shadow-lg group-hover:border-[#FFD86B] transition">
                    <i class="fa-solid fa-camera-rotate text-white group-hover:text-[#FFD86B]"></i>
                </div>
                <span class="text-[11px] font-semibold text-white/90 group-hover:text-[#FFD86B]">Putar</span>
            </button>

        </div>

    </footer>

    <!-- ================= 5. SCANNER ENGINE JAVASCRIPT ================= -->
    <script>
        let html5QrCode = null;
        let isProcessing = false;
        let currentFacingMode = "environment";
        let isTorchOn = false;
        let videoTrack = null;

        // Audio Beep Effect (Web Audio API Synthesizer ala Mesin Kasir / DANA)
        function playBeepSound() {
            try {
                const AudioContext = window.AudioContext || window.webkitAudioContext;
                if (!AudioContext) return;
                const ctx = new AudioContext();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();

                osc.type = 'sine';
                osc.frequency.setValueAtTime(1760, ctx.currentTime); // High pitch crisp tone (A6)
                gain.gain.setValueAtTime(0.3, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.15);

                osc.connect(gain);
                gain.connect(ctx.destination);

                osc.start();
                osc.stop(ctx.currentTime + 0.15);
            } catch (e) {
                console.warn('AudioContext beep error:', e);
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) return;
            isProcessing = true;

            // 1. Play Instant DANA Beep Sound
            playBeepSound();

            // 2. Trigger Haptic Vibration
            if (navigator.vibrate) {
                navigator.vibrate([60, 30, 60]);
            }

            // 3. Visual Success Animation (Glow Emerald Green)
            const brackets = document.querySelectorAll('.corner-bracket');
            brackets.forEach(b => {
                b.style.borderColor = '#10B981';
            });

            const laser = document.getElementById('laser-bar');
            if (laser) laser.style.display = 'none';

            const statusText = document.getElementById('camera-status-text');
            if (statusText) {
                statusText.innerHTML = '<span class="text-emerald-400 font-bold"><i class="fa-solid fa-circle-check"></i> QR Code Berhasil Dideteksi! Membuka...</span>';
            }

            // 4. Stop Camera stream
            if (html5QrCode && html5QrCode.isScanning) {
                html5QrCode.stop().catch(err => console.error(err));
            }

            // 5. Extract Unique Code from Scanned URL
            let kodeUnik = decodedText.trim();
            if (kodeUnik.includes('/koleksi/')) {
                const parts = kodeUnik.split('/koleksi/');
                if (parts[1]) {
                    kodeUnik = parts[1].split('?')[0].split('#')[0];
                }
            }

            // 6. Smooth Transition to Verification Transition Screen
            setTimeout(() => {
                window.location.href = "{{ url('/scan/verify') }}/" + encodeURIComponent(kodeUnik);
            }, 300);
        }

        function onScanFailure(error) {
            // Keep scanning frame by frame continuously
        }

        function startContinuousScanner(facingMode) {
            try {
                if (!html5QrCode) {
                    html5QrCode = new Html5Qrcode("qr-reader");
                }

                const config = {
                    fps: 24, // Fast 24 FPS scanning ala DANA
                    qrbox: function(viewfinderWidth, viewfinderHeight) {
                        const minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                        const size = Math.floor(minEdge * 0.72);
                        return { width: size, height: size };
                    },
                    aspectRatio: window.innerHeight / window.innerWidth,
                    disableFlip: false
                };

                // Find optimal back camera
                Html5Qrcode.getCameras().then(devices => {
                    if (devices && devices.length > 0) {
                        let selectedCameraId = devices[0].id;
                        for (const dev of devices) {
                            const label = dev.label.toLowerCase();
                            if (facingMode === "environment") {
                                if (label.includes('back') || label.includes('rear') || label.includes('belakang') || label.includes('environment')) {
                                    selectedCameraId = dev.id;
                                    break;
                                }
                            } else {
                                if (label.includes('front') || label.includes('user') || label.includes('depan')) {
                                    selectedCameraId = dev.id;
                                    break;
                                }
                            }
                        }

                        html5QrCode.start(selectedCameraId, config, onScanSuccess, onScanFailure)
                            .then(() => {
                                updateStatusActive();
                                captureVideoTrack();
                            })
                            .catch(err => {
                                fallbackFacingMode(facingMode, config);
                            });
                    } else {
                        fallbackFacingMode(facingMode, config);
                    }
                }).catch(err => {
                    fallbackFacingMode(facingMode, config);
                });
            } catch (e) {
                console.error("Scanner exception:", e);
            }
        }

        function fallbackFacingMode(facingMode, config) {
            html5QrCode.start({ facingMode: facingMode }, config, onScanSuccess, onScanFailure)
                .then(() => {
                    updateStatusActive();
                    captureVideoTrack();
                })
                .catch(err => {
                    console.warn("Live stream restricted:", err);
                    const statusText = document.getElementById('camera-status-text');
                    if (statusText) {
                        statusText.innerHTML = '<span class="text-amber-300 font-bold"><i class="fa-solid fa-camera"></i> Gunakan tombol "Foto QR" di bawah</span>';
                    }
                });
        }

        function updateStatusActive() {
            const statusText = document.getElementById('camera-status-text');
            if (statusText) {
                statusText.innerHTML = '<span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span><span>Memindai otomatis secara langsung...</span>';
            }
        }

        function captureVideoTrack() {
            try {
                const videoEl = document.querySelector('#qr-reader video');
                if (videoEl && videoEl.srcObject) {
                    const tracks = videoEl.srcObject.getVideoTracks();
                    if (tracks && tracks.length > 0) {
                        videoTrack = tracks[0];
                    }
                }
            } catch (e) {}
        }

        // Toggle Flashlight (Torch)
        function toggleTorch() {
            if (!videoTrack) {
                captureVideoTrack();
            }

            if (videoTrack && typeof videoTrack.getCapabilities === 'function') {
                const capabilities = videoTrack.getCapabilities();
                if (capabilities.torch) {
                    isTorchOn = !isTorchOn;
                    videoTrack.applyConstraints({
                        advanced: [{ torch: isTorchOn }]
                    }).then(() => {
                        const icon = document.getElementById('torch-icon');
                        const btn = document.getElementById('btn-torch');
                        if (isTorchOn) {
                            icon.classList.remove('fa-bolt');
                            icon.classList.add('fa-lightbulb');
                            btn.classList.add('bg-[#FFD86B]', 'text-[#162544]');
                            btn.classList.remove('bg-black/40', 'text-[#FFD86B]');
                        } else {
                            icon.classList.remove('fa-lightbulb');
                            icon.classList.add('fa-bolt');
                            btn.classList.remove('bg-[#FFD86B]', 'text-[#162544]');
                            btn.classList.add('bg-black/40', 'text-[#FFD86B]');
                        }
                    }).catch(e => {
                        console.warn('Torch constraint error:', e);
                    });
                    return;
                }
            }

            alert('Lampu senter (flash) tidak didukung pada browser/kamera perangkat ini.');
        }

        function processFile(file) {
            const statusText = document.getElementById('camera-status-text');
            if (statusText) {
                statusText.innerHTML = '<span class="text-amber-300 font-bold"><i class="fa-solid fa-spinner fa-spin"></i> Memproses foto QR...</span>';
            }

            const scanner = new Html5Qrcode("qr-reader");
            scanner.scanFile(file, true)
                .then(decodedText => {
                    onScanSuccess(decodedText, null);
                })
                .catch(err => {
                    if (statusText) {
                        statusText.innerHTML = '<span class="text-rose-400 font-bold"><i class="fa-solid fa-circle-xmark"></i> QR Code tidak terdeteksi dari foto</span>';
                    }
                    alert("QR Code tidak dapat terbaca dari foto tersebut. Silakan coba bidik lebih dekat dan jelas.");
                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Auto start scanner
            startContinuousScanner(currentFacingMode);

            // Senter / Torch Toggle
            const btnTorch = document.getElementById('btn-torch');
            if (btnTorch) {
                btnTorch.addEventListener('click', toggleTorch);
            }

            // Ganti Kamera Depan/Belakang
            const btnSwitch = document.getElementById('btn-switch-camera');
            if (btnSwitch) {
                btnSwitch.addEventListener('click', function () {
                    if (html5QrCode && html5QrCode.isScanning) {
                        html5QrCode.stop().then(() => {
                            currentFacingMode = (currentFacingMode === "environment") ? "user" : "environment";
                            startContinuousScanner(currentFacingMode);
                        }).catch(() => {
                            currentFacingMode = (currentFacingMode === "environment") ? "user" : "environment";
                            startContinuousScanner(currentFacingMode);
                        });
                    } else {
                        currentFacingMode = (currentFacingMode === "environment") ? "user" : "environment";
                        startContinuousScanner(currentFacingMode);
                    }
                });
            }

            // Galeri Foto Input
            const galleryInput = document.getElementById('gallery-input');
            if (galleryInput) {
                galleryInput.addEventListener('change', function (e) {
                    if (e.target.files && e.target.files.length > 0) {
                        processFile(e.target.files[0]);
                    }
                });
            }

            // Native Camera Input
            const nativeCamInput = document.getElementById('native-cam-input');
            if (nativeCamInput) {
                nativeCamInput.addEventListener('change', function (e) {
                    if (e.target.files && e.target.files.length > 0) {
                        processFile(e.target.files[0]);
                    }
                });
            }
        });
    </script>

</body>

</html>
