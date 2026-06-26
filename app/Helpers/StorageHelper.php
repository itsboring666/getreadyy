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

        return Storage::disk('public')->url($path);
    }
}
