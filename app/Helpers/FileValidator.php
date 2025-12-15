<?php

namespace App\Helpers;

class FileValidator
{
    /**
     * Validate file using magic bytes (file signature)
     */
    public static function validateMagicBytes($file, array $allowedTypes): bool
    {
        $filePath = $file->getRealPath();
        $fileHandle = fopen($filePath, 'rb');
        $magicBytes = fread($fileHandle, 8);
        fclose($fileHandle);

        $signatures = [
            'pdf' => ['25504446'], // %PDF
            'zip' => ['504B0304', '504B0506'], // PK..
            'rar' => ['526172211A07'], // Rar!
            'png' => ['89504E47'], // PNG
            'jpg' => ['FFD8FF'], // JPEG
            'jpeg' => ['FFD8FF'],
            'gif' => ['474946'], // GIF
            'psd' => ['38425053'], // 8BPS
        ];

        $hexString = strtoupper(bin2hex($magicBytes));

        foreach ($allowedTypes as $type) {
            if (isset($signatures[$type])) {
                foreach ($signatures[$type] as $signature) {
                    if (str_starts_with($hexString, $signature)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Check if file extension is executable
     */
    public static function isExecutable($filename): bool
    {
        $dangerousExtensions = [
            'exe', 'bat', 'cmd', 'com', 'pif', 'scr', 'vbs', 'js',
            'jar', 'msi', 'app', 'deb', 'rpm', 'sh', 'php', 'asp',
            'aspx', 'jsp', 'py', 'rb', 'pl', 'cgi'
        ];

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($extension, $dangerousExtensions);
    }

    /**
     * Generate safe random filename
     */
    public static function generateSafeFilename($originalFilename, $prefix = ''): string
    {
        $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
        $randomString = bin2hex(random_bytes(16));
        $timestamp = time();
        
        return $prefix . $randomString . '_' . $timestamp . '.' . $extension;
    }

    /**
     * Validate file comprehensively
     */
    public static function validate($file, array $allowedMimes, array $allowedExtensions, int $maxSizeKB): array
    {
        $errors = [];

        // Check if file is executable
        if (self::isExecutable($file->getClientOriginalName())) {
            $errors[] = 'File executable tidak diperbolehkan';
        }

        // Check MIME type
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            $errors[] = 'Tipe file tidak valid';
        }

        // Check extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $allowedExtensions)) {
            $errors[] = 'Ekstensi file tidak diperbolehkan';
        }

        // Check magic bytes
        if (!self::validateMagicBytes($file, $allowedExtensions)) {
            $errors[] = 'File signature tidak valid (kemungkinan file palsu)';
        }

        // Check file size
        if ($file->getSize() > ($maxSizeKB * 1024)) {
            $errors[] = 'Ukuran file melebihi batas maksimal ' . $maxSizeKB . 'KB';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}
