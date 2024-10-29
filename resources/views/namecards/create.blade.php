

<x-app-layout>
    <div class="mt-10 mb-5">
<div class="container px-5 content-center rounded-lg">
    <div id="camera-container px-5 mt-5 flex justify-center ">
        <video id="video" width="640" height="480" autoplay></video>
        <canvas id="canvas" width="640" height="480" style="display: none;"></canvas>


        <div class="controls mt-5">
            <x-button type="button" id="snap" purpose="search">Capture Image</x-button>
            <button type="button" id="retake" class="btn btn-secondary" style="display: none;">Retake</button>
        </div>
        <div id="preview" style="display: none;">
            <img id="captured-image" src="" alt="Captured image" style="max-width: 100%;">
        </div>
    </div>

    <form id="namecard-form" class="mt-4">
        @csrf
        <input type="hidden" name="image_data" id="image_data">

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control">
            <small class="text-muted">OCR Detected: <span id="detected-name"></span></small>
        </div>

        <div class="form-group">
            <label for="company">Company:</label>
            <input type="text" name="company" id="company" class="form-control">
            <small class="text-muted">OCR Detected: <span id="detected-company"></span></small>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" class="form-control">
            <small class="text-muted">OCR Detected: <span id="detected-address"></span></small>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" class="form-control">
            <small class="text-muted">OCR Detected: <span id="detected-phone"></span></small>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control">
            <small class="text-muted">OCR Detected: <span id="detected-email"></span></small>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Name Card</button>
    </form>

    <div id="ocr-text" class="mt-4">
        <h4>Full OCR Text:</h4>
        <pre id="full-ocr-text" style="white-space: pre-wrap;"></pre>
    </div>
</div>
</div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const snap = document.getElementById('snap');
    const retake = document.getElementById('retake');
    const preview = document.getElementById('preview');
    const capturedImage = document.getElementById('captured-image');
    const form = document.getElementById('namecard-form');
    const context = canvas.getContext('2d');
    const imageDataInput = document.getElementById('image_data');

    // Access the camera
    navigator.mediaDevices.getUserMedia({
        video: {
            width: { ideal: 1920 },
            height: { ideal: 1080 },
            facingMode: 'environment'
        }
    })
    .then((stream) => {
        video.srcObject = stream;
        video.style.display = 'block';
    })
    .catch((err) => {
        console.error("Error accessing camera:", err);
        alert("Error accessing camera. Please make sure you have granted camera permissions.");
    });

    // Capture image and process OCR
    snap.addEventListener('click', function() {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/png');
        imageDataInput.value = imageData;

        capturedImage.src = imageData;
        video.style.display = 'none';
        preview.style.display = 'block';
        snap.style.display = 'none';
        retake.style.display = 'block';

        // Process OCR
        const formData = new FormData();
        formData.append('image_data', imageData);
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('ocr_only', 'true');  // Add this flag

        fetch('{{ route("namecards.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateFormWithOCRData(data.extracted_data);
                document.getElementById('full-ocr-text').textContent = data.full_text;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error processing OCR');
        });
    });

    // Retake photo
    retake.addEventListener('click', function() {
        video.style.display = 'block';
        preview.style.display = 'none';
        snap.style.display = 'block';
        retake.style.display = 'none';
        imageDataInput.value = '';
        clearOCRResults();
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!imageDataInput.value) {
            alert('Please capture an image first');
            return;
        }

        const formData = new FormData(form);

        fetch('{{ route("namecards.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                // Optional: redirect to index or clear form
                window.location.href = '{{ route("namecards.index") }}';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving name card');
        });
    });

    function updateFormWithOCRData(data) {
        for (const [field, value] of Object.entries(data)) {
            if (value) {
                document.getElementById(`detected-${field}`).textContent = value;
                document.getElementById(field).value = value;
            } else {
                document.getElementById(`detected-${field}`).textContent = 'Not detected';
            }
        }
    }

    function clearOCRResults() {
        document.querySelectorAll('.text-muted span').forEach(el => {
            el.textContent = '';
        });
        document.querySelectorAll('input[type="text"], input[type="email"]').forEach(el => {
            el.value = '';
        });
        document.getElementById('full-ocr-text').textContent = '';
    }
});
</script>

</x-app-layout>

