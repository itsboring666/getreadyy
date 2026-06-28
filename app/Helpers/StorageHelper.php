<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('get_storage_url')) {
    /**
     * Get the correct URL for a stored file, handling both local and cloudinary disks.
     *
     * @param string|null $path
     * @return string
     */
    function get_storage_url($path)
    {
        if (empty($path)) {
            return '';
        }

        // If the path is already a full URL (e.g. from an old DB entry or an external source)
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (env('PUBLIC_STORAGE_DRIVER', 'local') === 'cloudinary' || env('CLOUDINARY_URL')) {
            $cloudName = env('CLOUDINARY_CLOUD_NAME');
            if (!$cloudName && env('CLOUDINARY_URL')) {
                $parts = parse_url(env('CLOUDINARY_URL'));
                $cloudName = $parts['host'] ?? '';
            }
            if ($cloudName) {
                // Ensure no double slashes if path has leading slash
                $cleanPath = ltrim($path, '/');
                return 'https://res.cloudinary.com/' . $cloudName . '/image/upload/' . $cleanPath;
            }
        }

        try {
            return Storage::disk('public')->url($path);
        } catch (\Exception $e) {
            return asset('storage/' . $path);
        }
    }
}
