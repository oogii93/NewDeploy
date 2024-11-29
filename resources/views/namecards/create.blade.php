<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <div class="container mx-auto p-6">


        <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">

            <h1 class="text-xl font-semibold mb-4 flex justify-center text-white bg-sky-400 px-2 py-2 ">名刺新規登録</h1>

            <div id="camera-container" class="relative mb-4">
                <video id="video" class="w-full" autoplay></video>
                <canvas id="canvas" class="hidden" width="800" height="480"></canvas>

                <!-- Rectangle Guide Overlay -->
                <div id="guide-overlay" class="absolute top-0 left-0 w-full h-full pointer-events-none">
                    <div class="absolute border-2 border-dashed border-sky-300 rounded-lg" style="top: 20%; left: 10%; width: 80%; height: 70%;"></div>

                    <div class="absolute top-0 left-0 w-full text-center mt-2 text-white bg-black bg-opacity-50">
                        青い四角の中に名刺を入れてください
                    </div>
                </div>
            </div>

            <div class="flex justify-center space-x-4 mb-4">

                <a id="capture-btn" class="bg-sky-400 hover:bg-sky-600 w-20 h-20 rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-semibold">キャプチャ</span>
                </a>
                <a id="retake-btn" class="bg-orange-400 hover:bg-orange-600 w-20 h-20 rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-semibold">取り直す</span>
                </a>






            </div>

            <div id="image-preview" class="hidden mb-4">
                <img id="preview-img" class="max-w-full" src="" alt="Captured Image">
            </div>

            <form id="namecard-form" method="POST" action="{{ route('namecards.storeConfirmedData') }}"
           >
          @csrf
          <input type="hidden" name="image_data" id="image-data">

          <div class="grid grid-cols-1 gap-1">
              <div>
                  <label for="name" class="block text-sm font-semibold text-gray-600 mb-1">
                      名前
                  </label>
                  <input
                      type="text"
                      id="name"
                      name="name"
                      placeholder=""
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                  >
              </div>

              <div>
                  <label for="company" class="block text-sm font-semibold text-gray-600 mb-1">
                    会社名
                  </label>
                  <input
                      type="text"
                      id="company"
                      name="company"
                      placeholder=""
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                  >
              </div>


                  <div>
                      <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">
                          メールアドレス
                      </label>
                      <input
                          type="email"
                          id="email"
                          name="email"
                          placeholder=""
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                      >
                  </div>
                  <div>
                      <label for="phone" class="block text-sm font-semibold text-gray-600 mb-1">
                            電話番号
                      </label>
                      <input
                          type="tel"
                          id="phone"
                          name="phone"
                          placeholder=""
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                      >
                  </div>
              </div>

                  <div>
                      <label for="mobile" class="block text-sm font-semibold text-gray-600 mb-1">
                        携帯電話
                      </label>
                      <input
                          type="tel"
                          id="mobile"
                          name="mobile"
                          placeholder=""
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                      >
                  </div>
                  <div>
                      <label for="fax" class="block text-sm font-semibold text-gray-600 mb-1">
                       FAX
                      </label>
                      <input
                          type="tel"
                          id="fax"
                          name="fax"
                          placeholder=""
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                      >
                  </div>

              <div>
                  <label for="address" class="block text-sm font-semibold text-gray-600 mb-1">
                     住所
                  </label>
                  <input
                      type="text"
                      id="address"
                      name="address"
                      placeholder=""
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                  >
              </div>

              <div class="pt-4">
                  <button
                      type="submit"
                      class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 rounded-lg hover:from-blue-600 hover:to-blue-700 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                  >
                   登録保存
                  </button>
              </div>
          </div>
      </form>
        </div>
    </div>



    <script>

    document.addEventListener('DOMContentLoaded', function() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture-btn');
        const retakeBtn = document.getElementById('retake-btn');
        const imagePreview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        const imageDataInput = document.getElementById('image-data');
        const guideOverlay = document.getElementById('guide-overlay');

        const nameInput = document.getElementById('name');
        const companyInput = document.getElementById('company');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const mobileInput = document.getElementById('mobile');
        const faxInput = document.getElementById('fax');

        const addressInput = document.getElementById('address');

        // Prefer back camera (environment facing camera)
        const constraints = {
            video: {
                facingMode: { ideal: 'environment' },
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        };

        // Access camera
        navigator.mediaDevices.getUserMedia(constraints)
            .then((stream) => {
                video.srcObject = stream;
                video.play();
            })
            .catch((err) => {
                console.error('Camera access error:', err);
                // Fallback to any available camera if environment camera fails
                return navigator.mediaDevices.getUserMedia({ video: true });
            })
            .then((stream) => {
                if (!video.srcObject) {
                    video.srcObject = stream;
                    video.play();
                }
            })
            .catch((err) => {
                console.error('Camera access error:', err);
                alert('Cannot access the camera. Please check your device settings.');
            });

        // Extract text from image
        captureBtn.addEventListener('click', function() {
            const context = canvas.getContext('2d');

            // Apply image preprocessing
            context.filter = 'brightness(1.2) contrast(1.4)';
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            context.filter = 'none';

            // Crop the image
            const cropX = canvas.width * 0.1;
            const cropY = canvas.height * 0.1;
            const cropWidth = canvas.width * 0.8;
            const cropHeight = canvas.height * 0.8;
            const croppedImageData = context.getImageData(cropX, cropY, cropWidth, cropHeight);
            const croppedCanvas = document.createElement('canvas');
            croppedCanvas.width = cropWidth;
            croppedCanvas.height = cropHeight;
            const croppedContext = croppedCanvas.getContext('2d');
            croppedContext.putImageData(croppedImageData, 0, 0);

            // Convert the cropped canvas to a data URL
            const imageData = croppedCanvas.toDataURL('image/png');
            previewImg.src = imageData;
            imageDataInput.value = imageData;

            video.style.display = 'none';
            imagePreview.classList.remove('hidden');
            captureBtn.classList.add('hidden');
            retakeBtn.classList.remove('hidden');
            guideOverlay.style.display = 'none';

            // Process the image using the server-side OCR
            processImageWithOCR(imageData);
        });

        async function processImageWithOCR(imageData) {
            try {
                const response = await fetch('{{ route("namecards.process") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        image_data: imageData,
                    }),
                });

                const data = await response.json();
                if (data.extractedData) {
                    // Populate fields with extracted data
                    nameInput.value = data.extractedData.name || '';
                    companyInput.value = data.extractedData.company || '';
                    emailInput.value = data.extractedData.email || '';
                    phoneInput.value = data.extractedData.phone || '';
                    mobileInput.value = data.extractedData.mobile || '';
                    faxInput.value = data.extractedData.fax || '';
                    addressInput.value = data.extractedData.address || '';
                } else {
                    alert('Failed to extract data from the image');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while processing the image.');
            }
        }

        // Retake image
        retakeBtn.addEventListener('click', function() {
            video.style.display = 'block';
            imagePreview.classList.add('hidden');
            previewImg.src = '';
            imageDataInput.value = '';
            captureBtn.classList.remove('hidden');
            retakeBtn.classList.add('hidden');
            guideOverlay.style.display = 'block';

            // Clear input fields
            nameInput.value = '';
            companyInput.value = '';
            emailInput.value = '';
            phoneInput.value = '';
            mobileInput.value = '';
            faxInput.value = '';
            addressInput.value = '';
        });
    });
    </script>
</x-app-layout>
