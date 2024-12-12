<x-app-layout>
    <div class="flex justify-center items-center min-h-screen mt-2 w-full">
        <div
            class="w-full md:w-2/3 border border-gray-300 p-12 rounded-lg bg-white shadow-md dark:bg-gray-800 dark:border-gray-600">
            <h2 class="mb-4 mt-2 text-xl font-bold text-center text-gray-900 dark:text-white">Form Absensi</h2>

            <form action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Stepper Progress -->
                <div class="flex mb-4 justify-between items-center">
                    <!-- Step 1 -->
                    <div class="stepper-step w-1/8 text-center relative">
                        <div class="stepper-circle bg-blue-500 text-white mx-auto p-1.5 rounded-full text-sm">1</div>
                        <p class="mt-2 text-sm">Waktu Masuk</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="stepper-step w-1/8 text-center relative">
                        <div class="stepper-circle bg-gray-300 text-white mx-auto p-1.5 rounded-full text-sm">2</div>
                        <p class="mt-2 text-sm">Foto Pagar Depan</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="stepper-step w-1/8 text-center relative">
                        <div class="stepper-circle bg-gray-300 text-white mx-auto p-1.5 rounded-full text-sm">3</div>
                        <p class="mt-2 text-sm">Foto Lorong Lab</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="stepper-step w-1/8 text-center relative">
                        <div class="stepper-circle bg-gray-300 text-white mx-auto p-1.5 rounded-full text-sm">4</div>
                        <p class="mt-2 text-sm">Foto Ruang Tengah</p>
                    </div>

                    <!-- Step 5 -->
                    <div class="stepper-step w-1/8 text-center">
                        <div class="stepper-circle bg-gray-300 text-white mx-auto p-1.5 rounded-full text-sm">5</div>
                        <p class="mt-2 text-sm">Foto Pagar Belakang</p>
                    </div>
                </div>

                <!-- Step 1: Waktu Masuk -->
                <div class="step" id="step-1">
                    <div class="mb-4">
                        <label for="waktu_masuk" class="font-semibold">Waktu Masuk</label>
                        <input type="datetime-local" name="waktu_masuk" id="waktu_masuk"
                            class="w-full p-2 mt-2 border rounded-md"
                            value="{{ old('waktu_masuk', now('Asia/Jakarta')->format('Y-m-d\TH:i')) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="latitude" class="font-semibold">Latitude</label>
                        <input type="text" name="latitude" id="latitude" class="w-full p-2 mt-2 border rounded-md"
                            required readonly>
                    </div>
                    <div class="mb-4">
                        <label for="longitude" class="font-semibold">Longitude</label>
                        <input type="text" name="longitude" id="longitude" class="w-full p-2 mt-2 border rounded-md"
                            required readonly>
                    </div>
                </div>

                <!-- Foto Pagar Depan -->
                <div class="step" id="step-2">
                    <div class="mb-4">
                        <label for="foto_pagar_depan" class="font-semibold">Foto Pagar Depan</label>
                        <div class="mt-2 p-2 bg-white rounded-md flex-shrink-0">
                            <video id="video_pagar_depan" width="100%" class="border-none mt-3 bg-white px-4 md:px-0"
                                style="max-height: 300px;">
                                Browser tidak mendukung tag video.
                            </video>
                            <canvas id="canvas_pagar_depan" class="mt-3 w-full px-4"
                                style="display:none; max-height: 300px;"></canvas>
                            <input type="hidden" name="foto_pagar_depan" id="foto_pagar_depan">
                            <input type="hidden" name="latitude" id="latitude_pagar_depan">
                            <input type="hidden" name="longitude" id="longitude_pagar_depan">
                            <input type="hidden" name="timestamp" id="timestamp_pagar_depan">
                            <div class="flex flex-col gap-2 mt-2">
                                <button type="button" id="takePhoto_pagar_depan"
                                    class="mx-4 my-2 py-2 bg-[#3490dc] text-white rounded-sm font-semibold">
                                    Ambil Foto
                                </button>
                                <button type="button" id="retakePhoto_pagar_depan"
                                    class="mx-4 my-2 py-2 bg-[#FF5733] text-white rounded-sm font-semibold"
                                    style="display:none;">
                                    Ulangi Foto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Foto Lorong Lab -->
                <div class="step" id="step-3">
                    <div class="mb-4">
                        <label for="foto_lorong_lab" class="font-semibold">Foto Lorong Lab</label>
                        <div class="mt-2 p-2 bg-white rounded-md flex-shrink-0">
                            <video id="video_lorong_lab" width="100%" class="border-none mt-3 bg-white px-4 md:px-0"
                                style="max-height: 300px;">
                                Browser tidak mendukung tag video.
                            </video>
                            <canvas id="canvas_lorong_lab" class="mt-3 w-full px-4"
                                style="display:none; max-height: 300px;"></canvas>
                            <input type="hidden" name="foto_lorong_lab" id="foto_lorong_lab">
                            <input type="hidden" name="latitude" id="latitude_lorong_lab">
                            <input type="hidden" name="longitude" id="longitude_lorong_lab">
                            <input type="hidden" name="timestamp" id="timestamp_lorong_lab">
                            <div class="flex flex-col gap-2 mt-2">
                                <button type="button" id="takePhoto_lorong_lab"
                                    class="mx-4 my-2 py-2 bg-[#3490dc] text-white rounded-sm font-semibold">
                                    Ambil Foto
                                </button>
                                <button type="button" id="retakePhoto_lorong_lab"
                                    class="mx-4 my-2 py-2 bg-[#FF5733] text-white rounded-sm font-semibold"
                                    style="display:none;">
                                    Ulangi Foto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Foto Ruang Tengah -->
                <div class="step" id="step-4" style="display: none;">
                    <div class="mb-4">
                        <label for="foto_ruang_tengah" class="font-semibold">Foto Ruang Tengah</label>
                        <div class="mt-2 p-2 bg-white rounded-md flex-shrink-0">
                            <video id="video_ruang_tengah" width="100%"
                                class="border-none mt-3 bg-white px-4 md:px-0" style="max-height: 300px;">
                                Browser tidak mendukung tag video.
                            </video>
                            <canvas id="canvas_ruang_tengah" class="mt-3 w-full px-4"
                                style="display:none; max-height: 300px;"></canvas>
                            <input type="hidden" name="foto_ruang_tengah" id="foto_ruang_tengah">
                            <input type="hidden" name="latitude" id="latitude_pagar_depan">
                            <input type="hidden" name="longitude" id="longitude_pagar_depan">
                            <input type="hidden" name="timestamp" id="timestamp_ruang_tengah">
                            <div class="flex flex-col gap-2 mt-2">
                                <button type="button" id="takePhoto_ruang_tengah"
                                    class="mx-4 my-2 py-2 bg-[#3490dc] text-white rounded-sm font-semibold">
                                    Ambil Foto
                                </button>
                                <button type="button" id="retakePhoto_ruang_tengah"
                                    class="mx-4 my-2 py-2 bg-[#FF5733] text-white rounded-sm font-semibold"
                                    style="display:none;">
                                    Ulangi Foto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 5: Foto Pagar Belakang -->
                <div class="step" id="step-5" style="display: none;">
                    <div class="mb-4">
                        <label for="foto_pagar_belakang" class="font-semibold">Foto Pagar Belakang</label>
                        <div class="mt-2 p-2 bg-white rounded-md flex-shrink-0">
                            <video id="video_pagar_belakang" width="100%"
                                class="border-none mt-3 bg-white px-4 md:px-0" style="max-height: 300px;">
                                Browser tidak mendukung tag video.
                            </video>
                            <canvas id="canvas_pagar_belakang" class="mt-3 w-full px-4"
                                style="display:none; max-height: 300px;"></canvas>
                            <input type="hidden" name="foto_pagar_belakang" id="foto_pagar_belakang">
                            <input type="hidden" name="latitude" id="latitude_pagar_depan">
                            <input type="hidden" name="longitude" id="longitude_pagar_depan">
                            <input type="hidden" name="timestamp" id="timestamp_pagar_belakang">
                            <div class="flex flex-col gap-2 mt-2">
                                <button type="button" id="takePhoto_pagar_belakang"
                                    class="mx-4 my-2 py-2 bg-[#3490dc] text-white rounded-sm font-semibold">
                                    Ambil Foto
                                </button>
                                <button type="button" id="retakePhoto_pagar_belakang"
                                    class="mx-4 my-2 py-2 bg-[#FF5733] text-white rounded-sm font-semibold"
                                    style="display:none;">
                                    Ulangi Foto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step Navigation Buttons -->
                <div class="flex justify-between mt-6">
                    <button type="button" id="prevButton"
                        class="px-4 py-2 bg-gray-300 text-white rounded-sm font-semibold"
                        style="display: none;">Kembali</button>
                    <button type="button" id="nextButton"
                        class="px-4 py-2 bg-blue-500 text-white rounded-sm font-semibold">Lanjutkan</button>
                    <button type="submit" id="submitButton"
                        class="px-4 py-2 bg-green-500 text-white rounded-sm font-semibold"
                        style="display: none;">Kirim</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        let currentStep = 1;
        const totalSteps = 5;

        const showStep = (step) => {
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById('step-' + i).style.display = i === step ? 'block' : 'none';
                document.querySelectorAll('.stepper-circle')[i - 1].classList.remove('bg-blue-500');
                document.querySelectorAll('.stepper-circle')[i - 1].classList.add('bg-gray-300');
            }
            document.querySelectorAll('.stepper-circle')[step - 1].classList.remove('bg-gray-300');
            document.querySelectorAll('.stepper-circle')[step - 1].classList.add('bg-blue-500');

            if (step === 1) {
                document.getElementById('prevButton').style.display = 'none';
                document.getElementById('submitButton').style.display = 'none';
            } else if (step === totalSteps) {
                document.getElementById('nextButton').style.display = 'none';
                document.getElementById('submitButton').style.display = 'block';
            } else {
                document.getElementById('nextButton').style.display = 'block';
                document.getElementById('prevButton').style.display = 'block';
            }
        };

        document.getElementById('nextButton').addEventListener('click', () => {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        });

        document.getElementById('prevButton').addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        showStep(currentStep);

        // Fungsi untuk mengatur kamera
        async function setupCamera(videoElement) {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
                videoElement.srcObject = stream;
                videoElement.play();
            } catch (error) {
                alert("Gagal mengakses kamera");
            }
        }

        //Fungsi untuk mengambil foto
        function takePhoto(videoElement, canvasElement, fotoInput, retakeButton, latitudeInput, longitudeInput,
            timestampInput) {
            const context = canvasElement.getContext('2d');
            const timestamp = new Date().toISOString();

            // Menampilkan canvas dan mengatur ukurannya sesuai video
            canvasElement.style.display = 'block';
            canvasElement.width = videoElement.videoWidth;
            canvasElement.height = videoElement.videoHeight;
            context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);

            // Menyimpan gambar dalam format base64
            const photoData = canvasElement.toDataURL('image/png');
            fotoInput.value = photoData; // Menyimpan foto di input hidden
            timestampInput.value = timestamp; // Menyimpan timestamp pada hidden input

            // Mengambil geolokasi jika diizinkan
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    latitudeInput.value = latitude; // Menyimpan latitude
                    longitudeInput.value = longitude; // Menyimpan longitude
                }, function(error) {
                    // Handle error jika geolokasi gagal
                    console.warn('Geolocation failed', error);
                    latitudeInput.value = 'unknown';
                    longitudeInput.value = 'unknown';
                });
            } else {
                console.warn('Geolocation is not supported by this browser');
            }

            // Menampilkan tombol "Ulangi Foto"
            videoElement.style.display = 'none';
            canvasElement.style.display = 'block';
            retakeButton.style.display = 'block'; // Tampilkan tombol ulangi foto
        }

        // Fungsi untuk mengulang pengambilan foto
        function retakePhoto(videoElement, canvasElement, retakeButton) {
            canvasElement.style.display = 'none';
            videoElement.style.display = 'block';
            retakeButton.style.display = 'none';
        }

        // Setup kamera untuk setiap video
        const videoElements = {
            pagarDepan: document.getElementById('video_pagar_depan'),
            lorongLab: document.getElementById('video_lorong_lab'),
            ruangTengah: document.getElementById('video_ruang_tengah'),
            pagarBelakang: document.getElementById('video_pagar_belakang')
        };
        Object.values(videoElements).forEach(videoElement => setupCamera(videoElement));

        // Mengambil foto untuk setiap elemen
        document.getElementById('takePhoto_pagar_depan').addEventListener('click', () => takePhoto(videoElements.pagarDepan,
            document.getElementById('canvas_pagar_depan'), document.getElementById('foto_pagar_depan'), 
            document.getElementById('latitude_pagar_depan'), document.getElementById('longitude_pagar_depan'), document.getElementById('timestamp_pagar_depan')));

        document.getElementById('takePhoto_lorong_lab').addEventListener('click', () => takePhoto(videoElements.lorongLab,
            document.getElementById('canvas_lorong_lab'), document.getElementById('foto_lorong_lab'), 
            document.getElementById('latitude_lorong_lab'), document.getElementById('longitude_lorong_lab'), document.getElementById('timestamp_lorong_lab')));

        document.getElementById('takePhoto_ruang_tengah').addEventListener('click', () => takePhoto(videoElements
            .ruangTengah, document.getElementById('canvas_ruang_tengah'), document.getElementById(
                'foto_ruang_tengah'), document.getElementById('latitude_ruang_tengah'), document.getElementById('longitude_ruang_tengah'), 
                document.getElementById('timestamp_ruang_tengah')));

        document.getElementById('takePhoto_pagar_belakang').addEventListener('click', () => takePhoto(videoElements
            .pagarBelakang, document.getElementById('canvas_pagar_belakang'), document.getElementById(
                'foto_pagar_belakang'), document.getElementById('latitude_pagar_belakang'), document.getElementById('longitude_pagar_belakang'), 
                document.getElementById('timestamp_pagar_belakang')));

        // Mengulang foto
        document.getElementById('retakePhoto_pagar_depan').addEventListener('click', () => retakePhoto(videoElements
            .pagarDepan, document.getElementById('canvas_pagar_depan'), document.getElementById('foto_pagar_depan'), 
            document.getElementById('latitude_pagar_depan'), document.getElementById('longitude_pagar_depan'), document.getElementById(
                'retakePhoto_pagar_depan')));

        document.getElementById('retakePhoto_lorong_lab').addEventListener('click', () => retakePhoto(videoElements
            .lorongLab, document.getElementById('canvas_lorong_lab'), document.getElementById('foto_lorong_lab'), 
            document.getElementById('latitude_lorong_lab'), document.getElementById('longitude_lorong_lab'), document.getElementById(
                'retakePhoto_lorong_lab')));

        document.getElementById('retakePhoto_ruang_tengah').addEventListener('click', () => retakePhoto(videoElements
            .ruangTengah, document.getElementById('canvas_ruang_tengah'),  document.getElementById(
                'foto_ruang_tengah'), document.getElementById('latitude_ruang_tengah'), document.getElementById('longitude_ruang_tengah'), 
                document.getElementById('retakePhoto_ruang_tengah')));

        document.getElementById('retakePhoto_pagar_belakang').addEventListener('click', () => retakePhoto(videoElements
            .pagarBelakang, document.getElementById('canvas_pagar_belakang'), document.getElementById(
                'foto_pagar_belakang'), document.getElementById('latitude_pagar_belakang'), document.getElementById('longitude_pagar_belakang'), 
                document.getElementById('retakePhoto_pagar_belakang')));

        // Enable submit button setelah semua foto diambil
        function enableSubmitButton() {
            const allPhotosTaken = document.querySelectorAll('input[type="hidden"][value!=""]').length === 4;
            document.getElementById('submitBtn').disabled = !allPhotosTaken;
        }

        // Mengawasi pengambilan foto
        const fotoElements = ['foto_pagar_depan', 'foto_lorong_lab', 'foto_ruang_tengah', 'foto_pagar_belakang'];
        fotoElements.forEach(id => {
            document.getElementById(id).addEventListener('change', enableSubmitButton);
        });

        // Mengambil lokasi pengguna dan mengisi input latitude dan longitude
        function getLocationAndSetCoords() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Mengisi field latitude dan longitude
                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;
                }, function() {
                    alert("Tidak dapat mendeteksi lokasi Anda.");
                });
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }
        }

        // Menjalankan fungsi untuk mendapatkan lokasi saat halaman dimuat
        window.onload = function() {
            getLocationAndSetCoords();
        };
    </script>
</x-app-layout>
