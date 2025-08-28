import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#imageDropzone', {
    dictDefaultMessage: 'Arrastra y suelta una imagen aquí o haz click para cargar',
    acceptedFiles: 'image/*',
    maxFiles: 1,
    addRemoveLinks: true,
    dictRemoveFile: 'Eliminar archivo',
    uploadMultiple: false,
    url: '/images', // Cambiar a la ruta correcta para subir imágenes
    paramName: "file",
    maxFilesize: 5, // MB
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    init: function(){
        // Verificar si hay una imagen precargada en el input hidden
        const imageInput = document.getElementById('imageInput');
        if (imageInput && imageInput.value) {
            // Crear un mock file object para mostrar la imagen precargada
            const mockFile = {
                name: imageInput.value,
                size: 0,
                accepted: true,
                status: Dropzone.ADDED,
                dataURL: `/uploads/${imageInput.value}` // Asumiendo que las imágenes se guardan en /uploads/
            };
            
            // Agregar la imagen al dropzone
            this.emit('addedfile', mockFile);
            this.emit('thumbnail', mockFile, mockFile.dataURL);
            this.emit('complete', mockFile);
            this.emit('success', mockFile, { filename: imageInput.value });
            
            // Marcar que ya no es el mensaje por defecto
            this.options.dictDefaultMessage = "Imagen precargada: " + imageInput.value;
        }
        
        // Interceptar el envío del formulario para preservar la imagen
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', (e) => {
                // Prevenir el envío si no hay imagen
                if (!imageInput || !imageInput.value) {
                    e.preventDefault();
                    alert('Por favor, selecciona una imagen antes de crear el post');
                    return false;
                }
                
                // Si hay imagen, permitir el envío normal
                // La imagen ya está en el input hidden, así que se enviará con el formulario
            });
        }
    }
})

dropzone.on('sending', (file, xhr, formData) => {
    console.log('Enviando archivo:', file.name);
})

dropzone.on('success', (file, response) => {
    console.log('Imagen subida exitosamente:', response);
    
    // Guardar el nombre de la imagen en el input hidden del formulario de posts
    const imageInput = document.getElementById('imageInput');
    if (imageInput && response.filename) {
        imageInput.value = response.filename;
    }
    
    // Mostrar mensaje de éxito
    dropzone.options.dictDefaultMessage = "Imagen subida: " + response.filename;
})

dropzone.on('error', (file, errorMessage, xhr) => {
    console.error('Error al subir imagen:', errorMessage);
    let message = "Error al subir la imagen";
    
    if (xhr && xhr.responseJSON) {
        message = xhr.responseJSON.error || xhr.responseJSON.message || message;
    }
    
    alert(message);
})

dropzone.on('removedfile', (file) => {
    console.log('Archivo eliminado');
    
    // Limpiar el input hidden cuando se elimina la imagen
    const imageInput = document.getElementById('imageInput');
    if (imageInput) {
        imageInput.value = '';
    }
    
    // Restaurar mensaje original
    dropzone.options.dictDefaultMessage = 'Arrastra y suelta una imagen aquí o haz click para cargar';
})