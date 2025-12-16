<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validar que se haya enviado un archivo
            if (!$request->hasFile('file')) {
                return response()->json(['error' => 'No se ha enviado ningún archivo'], 400);
            }

            $image = $request->file('file');

            // Validar que sea una imagen válida
            if (!$image->isValid()) {
                return response()->json(['error' => 'El archivo no es válido'], 400);
            }

            // Validar el tipo de archivo
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($image->getMimeType(), $allowedTypes)) {
                return response()->json(['error' => 'Tipo de archivo no permitido. Solo se permiten imágenes (JPEG, PNG, GIF, WebP)'], 400);
            }

            // Verificar y crear el directorio si no existe
            $uploadPath = public_path('uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generar nombre único para la imagen
            $nameImage = Str::uuid() . '.' . $image->getClientOriginalExtension();

            // Redimensionar la imagen
            $imageManager = ImageManager::gd();
            $imageServer = $imageManager->read($image);
            // $imageServer->cover(1000, 1000);

            // Guardar la imagen
            $imagePath = $uploadPath . '/' . $nameImage;
            $imageServer->save($imagePath);

            // Retornar respuesta exitosa con la información de la imagen
            return response()->json([
                'success' => true,
                'filename' => $nameImage,
                'path' => '/uploads/' . $nameImage,
                'message' => 'Imagen subida exitosamente'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al subir imagen: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Error interno del servidor al procesar la imagen',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
