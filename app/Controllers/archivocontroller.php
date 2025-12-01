<?php

namespace App\Controllers;

class archivocontroller{

    private static string $basePath = __DIR__ . '/../../public/build/documentos';

    public static function descargarExcel()
    {
        $nombre = $_GET['file'] ?? 'importar productos.xlsx';
        $ruta = self::$basePath . '/' . $nombre;

        if (!file_exists($ruta)) {
            http_response_code(404);
            echo "Archivo Excel no encontrado.";
            return;
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=\"" . basename($ruta) . "\"");
        header("Content-Length: " . filesize($ruta));
        
        readfile($ruta);
        exit;
    }


    public static function descargarInstrucciones()
    {
        $nombre = $_GET['file'] ?? 'instrucciones_importar_productos.png';
        $ruta = self::$basePath . '/' . $nombre;

        if (!file_exists($ruta)) {
            http_response_code(404);
            echo "Archivo no encontrado.";
            return;
        }

        if(ob_get_level())ob_end_clean();

        header("Content-Type: image/png");
        //header("Content-Disposition: attachment; filename=\"" . basename($ruta) . "\"");
        header("Content-Length: " . filesize($ruta));
        //header("Cache-Control: no-cache");
        
        readfile($ruta);
        exit;
    }
}