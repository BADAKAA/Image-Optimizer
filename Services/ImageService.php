<?php

namespace App\Services;

use Error;

class ImageService {
    static private function replace_extension($filename, $new_extension) {
        $info = pathinfo($filename);
        return ($info['dirname'] ? $info['dirname'] . DIRECTORY_SEPARATOR : '')
            . $info['filename']
            . '.'
            . $new_extension;
    }

    // https://polyetilen.lt/en/resize-and-crop-image-from-center-with-php
    static public function resize_image(string $file_path, int $w, int $h, string $target_format='jpg', string|null $target_path = null, int $quality = 80) {
        $imgsize = getimagesize($file_path);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];

        $src_img = match ($mime) {
            'image/png' => imagecreatefrompng($file_path),
            'image/gif' => imagecreatefromgif($file_path),
            'image/avif' => imagecreatefromavif($file_path),
            'image/webp' => imagecreatefromwebp($file_path),
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($file_path),
            default => throw new Error('Filetype unsupported', 417)
        };
        $dst_img = imagecreatetruecolor($w, $h);
        $width_new = $height * $w / $h;
        $height_new = $width * $h / $w;
        if ($width_new > $width) {
            $h_point = (($height - $height_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $w, $h, $width, $height_new);
        } else {
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $w, $h, $width_new, $height);
        }
        if ($target_format === 'webp') {
            $output = self::replace_extension($target_path ?? $file_path, 'webp');
            imagewebp($dst_img, $output, $quality);
        } else {
            $output = self::replace_extension($target_path ?? $file_path, 'jpg');
            imagejpeg($dst_img, $output, $quality);
        }

        if ($dst_img) imagedestroy($dst_img);
        if ($src_img) imagedestroy($src_img);

        return $output;
    }
}
