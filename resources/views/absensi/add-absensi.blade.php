<x-app-layout>
    <div class="bg-gray-100 flex justify-center items-center min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h1 class="text-2xl font-bold mb-4">Form Absensi</h1>
            <form method="POST" action="{{ route('absensi.store') }}" enctype="multipart/form-data">
                @csrf
                <div id="waktu_batas_pagar_depan" class="text-gray-700 mt-2">
                    Waktu Batas: <span id="waktu_batas_text" class="font-bold">00:00:00</span>
                </div>
                <!-- Foto Pagar Depan -->
                <div class="mb-4">
                    <label for="foto_pagar_depan" class="block text-gray-700 font-medium mb-2">Foto Pagar Depan</label>
                    <video id="video_pagar_depan" class="w-full h-auto border rounded mb-2"></video>
                    <canvas id="canvas_pagar_depan" class="hidden"></canvas>
                    <button type="button" id="capture_pagar_depan"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ambil Foto</button>
                    <input type="hidden" id="foto_pagar_depan" name="foto_pagar_depan">
                    <img id="foto_preview_pagar_depan" class="mt-2 w-full h-auto rounded hidden" />
                    <button type="button" id="ulang_foto_pagar_depan"
                        class="bg-gray-500 text-white px-4 py-2 rounded mt-2 hidden">Ulangi Foto</button>
                </div>

                <!-- Foto Pagar Belakang -->
                <div class="mb-4">
                    <label for="foto_pagar_belakang" class="block text-gray-700 font-medium mb-2">Foto Pagar
                        Belakang</label>
                    <video id="video_pagar_belakang" class="w-full h-auto border rounded mb-2"></video>
                    <canvas id="canvas_pagar_belakang" class="hidden"></canvas>
                    <button type="button" id="capture_pagar_belakang"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ambil Foto</button>
                    <input type="hidden" id="foto_pagar_belakang" name="foto_pagar_belakang">
                    <img id="foto_preview_pagar_belakang" class="mt-2 w-full h-auto rounded hidden" />
                    <button type="button" id="ulang_foto_pagar_belakang"
                        class="bg-gray-500 text-white px-4 py-2 rounded mt-2 hidden">Ulangi Foto</button>
                </div>

                <!-- Foto Lorong Lab -->
                <div class="mb-4">
                    <label for="foto_lorong_lab" class="block text-gray-700 font-medium mb-2">Foto Lorong Lab</label>
                    <video id="video_lorong_lab" class="w-full h-auto border rounded mb-2"></video>
                    <canvas id="canvas_lorong_lab" class="hidden"></canvas>
                    <button type="button" id="capture_lorong_lab"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ambil Foto</button>
                    <input type="hidden" id="foto_lorong_lab" name="foto_lorong_lab">
                    <img id="foto_preview_lorong_lab" class="mt-2 w-full h-auto rounded hidden" />
                    <button type="button" id="ulang_foto_lorong_lab"
                        class="bg-gray-500 text-white px-4 py-2 rounded mt-2 hidden">Ulangi Foto</button>
                </div>

                <!-- Foto Ruang Tengah -->
                <div class="mb-4">
                    <label for="foto_ruang_tengah" class="block text-gray-700 font-medium mb-2">Foto Ruang
                        Tengah</label>
                    <video id="video_ruang_tengah" class="w-full h-auto border rounded mb-2"></video>
                    <canvas id="canvas_ruang_tengah" class="hidden"></canvas>
                    <button type="button" id="capture_ruang_tengah"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ambil Foto</button>
                    <input type="hidden" id="foto_ruang_tengah" name="foto_ruang_tengah">
                    <img id="foto_preview_ruang_tengah" class="mt-2 w-full h-auto rounded hidden" />
                    <button type="button" id="ulang_foto_ruang_tengah"
                        class="bg-gray-500 text-white px-4 py-2 rounded mt-2 hidden">Ulangi Foto</button>
                </div>

                <div class="mb-4 flex justify-between">
                    <a href="{{ route('absensi.index') }}"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Kembali</a>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Simpan
                        Absensi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateTimeLimit(startTime, endTime, elementId, textElementId) {
            const interval = setInterval(() => {
                const now = new Date();

                if (now < startTime) {
                    // Jika waktu sekarang sebelum waktu mulai
                    const remainingTime = startTime - now;
                    const hours = Math.floor(remainingTime / (1000 * 60 * 60));
                    const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
                    document.getElementById(elementId).classList.remove('text-red-500');
                    document.getElementById(textElementId).textContent = `Waktu Mulai: ${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                } else if (now >= startTime && now <= endTime) {
                    // Jika waktu sekarang dalam rentang waktu
                    const remainingTime = endTime - now;
                    const hours = Math.floor(remainingTime / (1000 * 60 * 60));
                    const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
                    document.getElementById(elementId).classList.remove('text-red-500');
                    document.getElementById(textElementId).textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                } else {
                    // Jika waktu sekarang setelah waktu akhir
                    clearInterval(interval);
                    document.getElementById(elementId).classList.add('text-red-500');
                    document.getElementById(textElementId).textContent = "Waktu Habis: 16:00 - 18:00"; // Menampilkan rentang waktu
                }
            }, 1000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const startTime = new Date();
            startTime.setHours(16); // Set batas waktu mulai pada pukul 16:00
            startTime.setMinutes(0);
            startTime.setSeconds(0);

            const endTime = new Date();
            endTime.setHours(18); // Set batas waktu akhir pada pukul 18:00
            endTime.setMinutes(0);
            endTime.setSeconds(0);

            updateTimeLimit(startTime, endTime, 'waktu_batas_pagar_depan', 'waktu_batas_text');
        });

        function setupCamera(videoId, canvasId, buttonId, inputId, previewId, ulangiButtonId) {
            const video = document.getElementById(videoId);
            const canvas = document.getElementById(canvasId);
            const captureButton = document.getElementById(buttonId);
            const fotoInput = document.getElementById(inputId);
            const fotoPreview = document.getElementById(previewId);
            const ulangiButton = document.getElementById(ulangiButtonId);

            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(error => {
                    console.error('Error accessing camera:', error);
                });

            captureButton.addEventListener('click', () => {
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Dapatkan waktu saat ini
                const now = new Date();
                const timestamp = `${now.toLocaleDateString()} ${now.toLocaleTimeString()}`;

                // Dapatkan lokasi pengguna
                navigator.geolocation.getCurrentPosition(position => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Menambahkan teks timestamp dan koordinat pada gambar
                    context.font = '24px Arial';
                    context.fillStyle = 'white';
                    context.fillText(`Lat: ${latitude.toFixed(4)} Long: ${longitude.toFixed(4)}`, 10, canvas.height - 30);
                    context.fillText(`Tanggal: ${timestamp}`, 10, canvas.height - 10);

                    // Menampilkan gambar yang diambil pada elemen <img>
                    const photoData = canvas.toDataURL('image/png');
                    fotoInput.value = photoData;
                    fotoPreview.src = photoData;
                    fotoPreview.classList.remove('hidden'); // Tampilkan foto
                    captureButton.classList.add('hidden'); // Sembunyikan tombol ambil foto
                    ulangiButton.classList.remove('hidden'); // Tampilkan tombol ulangi foto
                    video.classList.add('hidden'); // Sembunyikan video
                });
            });

            ulangiButton.addEventListener('click', () => {
                // Menampilkan kembali kamera dan menyembunyikan gambar
                video.classList.remove('hidden');
                fotoPreview.classList.add('hidden');
                captureButton.classList.remove('hidden');
                ulangiButton.classList.add('hidden');
            });
        }

        // Setup cameras for each section
        setupCamera('video_pagar_depan', 'canvas_pagar_depan', 'capture_pagar_depan', 'foto_pagar_depan', 'foto_preview_pagar_depan', 'ulang_foto_pagar_depan');
        setupCamera('video_pagar_belakang', 'canvas_pagar_belakang', 'capture_pagar_belakang', 'foto_pagar_belakang', 'foto_preview_pagar_belakang', 'ulang_foto_pagar_belakang');
        setupCamera('video_lorong_lab', 'canvas_lorong_lab', 'capture_lorong_lab', 'foto_lorong_lab', 'foto_preview_lorong_lab', 'ulang_foto_lorong_lab');
        setupCamera('video_ruang_tengah', 'canvas_ruang_tengah', 'capture_ruang_tengah', 'foto_ruang_tengah', 'foto_preview_ruang_tengah', 'ulang_foto_ruang_tengah');
    </script>
</x-app-layout>