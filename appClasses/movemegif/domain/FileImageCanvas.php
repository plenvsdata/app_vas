<?php

namespace movemegif\domain;

use movemegif\exception\MovemegifException;

/**
 * @author Patrick van Bergen
 */
class FileImageCanvas extends GdCanvas
{
    /**
     * @param $filePath
     * @throws MovemegifException
     */
    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct($filePath)
    {
        if (preg_match('#\.(gif|GIF|png|PNG|jpg|JPG|jpeg|JPEG)$#', $filePath, $matches)) {

            $ext = $matches[1];

            switch ($ext) {

                case 'gif':
                case 'GIF':
                    $this->resource = imagecreatefromgif($filePath);
                    $this->transparencyColor = $this->locateTransparentColor($this->resource);
                    break;

                case 'png':
                case 'PNG':
                    $this->resource = imagecreatefrompng($filePath);
                    imagetruecolortopalette($this->resource, true, 256);
                    $this->transparencyColor = $this->locateTransparentColor($this->resource);
                    break;

                case 'jpg':
                case 'JPG':
                case 'jpeg':
                case 'JPEG':
                    $this->resource = imagecreatefromjpeg($filePath);
                    imagetruecolortopalette($this->resource, true, 256);
                    break;

            }

        } else {
            throw new MovemegifException('Unknown filetype. Choose one of gif, png or jpg.');
        }

        if (!$this->resource) {
            throw new MovemegifException('Unable to read file: ' . $filePath);
        }
    }

    private function locateTransparentColor($resource)
    {
        $colorIndex = imagecolortransparent($resource);
        if ($colorIndex != -1) {
            $rgb = imagecolorsforindex($resource, $colorIndex);
            $color = ($rgb['red'] << 16) + ($rgb['green'] << 8) + ($rgb['blue']);
        } else {
            $color = null;
        }

        return $color;
    }
}