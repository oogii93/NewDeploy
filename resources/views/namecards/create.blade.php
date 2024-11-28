<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Create Name Card</h1>

        <div class="max-w-lg mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div id="camera-container" class="relative mb-4">
                <video id="video" class="w-full" autoplay></video>
                <canvas id="canvas" class="hidden" width="800" height="480"></canvas>

                <!-- Rectangle Guide Overlay -->
                <div id="guide-overlay" class="absolute top-0 left-0 w-full h-full pointer-events-none">
                    {{-- <div class="absolute border-4 border-green-500 opacity-75" style="top: 20%; left: 10%; width: 80%; height: 60%;"></div> --}}
                    <div class="absolute top-0 left-0 w-full text-center mt-2 text-white bg-black bg-opacity-50">
                        Place name card inside the green rectangle
                    </div>
                </div>
            </div>

            <div class="flex justify-center space-x-4 mb-4">
                <button id="capture-btn"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Capture Image
                </button>
                <button id="retake-btn"
                        class="hidden bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Retake
                </button>
            </div>

            <div id="image-preview" class="hidden mb-4">
                <img id="preview-img" class="max-w-full" src="" alt="Captured Image">
            </div>

            <form id="namecard-form" method="POST" action="{{ route('namecards.store') }}">
                @csrf
                <input type="hidden" name="image_data" id="image-data">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                           id="name" name="name" type="text">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="company">
                        Company
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                           id="company" name="company" type="text">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                           id="email" name="email" type="email">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                        Phone
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                           id="phone" name="phone" type="text">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                        Address
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                           id="address" name="address" type="text">
                </div>

                <div class="flex items-center justify-between">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                            type="submit">
                        Save Name Card
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function () {
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
    const addressInput = document.getElementById('address');

    // Access camera
    navigator.mediaDevices
        .getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
        })
        .catch((err) => {
            console.error('Camera access error:', err);
            alert('Cannot access the camera. Please check your device settings.');
        });

    // Capture image
    captureBtn.addEventListener('click', function () {
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = canvas.toDataURL('image/png');
        previewImg.src = imageData;
        imageDataInput.value = imageData;

        video.style.display = 'none';
        imagePreview.classList.remove('hidden');
        captureBtn.classList.add('hidden');
        retakeBtn.classList.remove('hidden');
        guideOverlay.style.display = 'none';

        // Send image to backend for OCR
        fetch('{{ route("namecards.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                image_data: imageData,
            }),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    // Populate fields with extracted data
                    nameInput.value = data.extractedData.name || '';
                    companyInput.value = data.extractedData.company || '';
                    emailInput.value = data.extractedData.email || '';
                    phoneInput.value = data.extractedData.phone || '';
                    addressInput.value = data.extractedData.address || '';
                } else {
                    alert('Failed to process the image: ' + data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('An error occurred while processing the image.');
            });
    });

    // Retake image
    retakeBtn.addEventListener('click', function () {
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
        addressInput.value = '';
    });
});
    </script>
</x-app-layout>
