import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

// Initialize Dropzone
const dropzoneElement = document.getElementById('imageDropzone');
if (dropzoneElement) {
    const dropzone = new Dropzone('#imageDropzone', {
        acceptedFiles: 'image/*',
        maxFiles: 1,
        uploadMultiple: false,
        url: '/images',
        paramName: "file",
        maxFilesize: 5, // MB
        clickable: false, // Disable default click behavior
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });

    // DOM Elements
    const imageUploadBtn = document.getElementById('imageUploadBtn');
    const imageInput = document.getElementById('imageInput');
    const imageStatusText = document.getElementById('imageStatusText');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const removeImageBtn = document.getElementById('removeImageBtn');

    // Click on icon button to open file selector
    if (imageUploadBtn) {
        imageUploadBtn.addEventListener('click', () => {
            // Create a temporary file input
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'image/*';
            fileInput.style.display = 'none';

            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    dropzone.addFile(file);
                }
                document.body.removeChild(fileInput);
            });

            document.body.appendChild(fileInput);
            fileInput.click();
        });
    }

    // Handle file upload start
    dropzone.on('addedfile', (file) => {
        console.log('Archivo agregado:', file.name);
        if (imageStatusText) {
            imageStatusText.textContent = 'Subiendo...';
        }
    });

    // Handle successful upload
    dropzone.on('success', (file, response) => {
        console.log('Imagen subida exitosamente:', response);

        // Save filename to hidden input
        if (imageInput && response.filename) {
            imageInput.value = response.filename;
        }

        // Update button text
        if (imageStatusText) {
            imageStatusText.textContent = 'Imagen agregada';
        }

        // Show image preview
        if (imagePreviewContainer && imagePreview) {
            imagePreview.src = response.path || `/uploads/${response.filename}`;
            imagePreviewContainer.classList.remove('hidden');
        }

        // Remove file from dropzone (we handle preview manually)
        dropzone.removeFile(file);
    });

    // Handle upload error
    dropzone.on('error', (file, errorMessage) => {
        console.error('Error al subir imagen:', errorMessage);

        let message = "Error al subir la imagen";
        if (typeof errorMessage === 'object' && errorMessage.error) {
            message = errorMessage.error;
        } else if (typeof errorMessage === 'string') {
            message = errorMessage;
        }

        alert(message);

        // Reset button text
        if (imageStatusText) {
            imageStatusText.textContent = 'Agregar imagen';
        }

        // Remove file from dropzone
        dropzone.removeFile(file);
    });

    // Handle remove image button
    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', () => {
            // Clear hidden input
            if (imageInput) {
                imageInput.value = '';
            }

            // Hide preview
            if (imagePreviewContainer) {
                imagePreviewContainer.classList.add('hidden');
            }

            // Reset button text
            if (imageStatusText) {
                imageStatusText.textContent = 'Agregar imagen';
            }
        });
    }

    // Check for existing image on page load (for edit mode)
    if (imageInput && imageInput.value) {
        const filename = imageInput.value;
        if (imagePreviewContainer && imagePreview) {
            imagePreview.src = `/uploads/${filename}`;
            imagePreviewContainer.classList.remove('hidden');
        }
        if (imageStatusText) {
            imageStatusText.textContent = 'Imagen agregada';
        }
    }
}