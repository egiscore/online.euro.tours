<?php

class Thumbnail {
    const METHOD_SCALE_MAX = 0;
    const METHOD_SCALE_MIN = 1;
    const METHOD_CROP = 2;
    const METHOD_BOX = 3;
    const METHOD_ROTATE = 4;
    const ALIGN_CENTER = 0;
    const ALIGN_LEFT = -1;
    const ALIGN_RIGHT = 1;
    const ALIGN_TOP = -1;
    const ALIGN_BOTTOM = 1;

    public function imageCreate($input) {
        $type = IMAGETYPE_JPEG;
        if ( @is_file($input) ) {
            $input = $this->imageCreateFromFile($input);
            if (is_array($input)) {
                list($input, $type) = $input;
            }
        } else if ( is_string($input) ) {
            $input = $this->imageCreateFromString($input);
        }
        imagealphablending($input, false);
        imagesavealpha($input, true);
        return array($input, $type);
    }

    static public function checkMemory($filename) {
        $imageInfo = getimagesize($filename);
        $TWEAKFACTOR = 2;
        $memoryNeeded = round(($imageInfo[0] * $imageInfo[1] * $imageInfo['bits'] * $imageInfo['channels'] / 8 + 65536) * $TWEAKFACTOR);
        $mem = Samo_Utils::convert_bytes(ini_get('memory_limit'));
        if ($mem - memory_get_usage() <= $memoryNeeded) {
            return false;
        }
        return $imageInfo;
    }

    public function imageCreateFromFile($filename) {
        if ( ! is_file($filename) || ! is_readable($filename) ) {
            user_error('Unable to open file "' . $filename . '"', E_USER_NOTICE);
            return false;
        }
        if (false === ($imageInfo = self::checkMemory($filename))) {
            return $this->imageCreateEmpty();
        }

        $type = $imageInfo[2];
        $result = false;
        switch ($type) {
            case IMAGETYPE_JPEG:
                $result = array(imagecreatefromjpeg($filename), $type);
                break;
            case IMAGETYPE_PNG:
                $result = array(imagecreatefrompng($filename), $type);
                break;
            case IMAGETYPE_GIF:
                $result = array(imagecreatefromgif($filename), $type);
                break;
            default:
                user_error('Unsupported image type', E_USER_NOTICE);
                break;
        }
        return $result;
    }

    public function imageCreateFromString($string) {
        if ( ! is_string($string) || empty($string) ) {
            user_error('Invalid image value in string', E_USER_NOTICE);
            return false;
        }
        return imagecreatefromstring($string);
    }

    public function imageCreateEmpty() {
        if ($image = @imagecreate(100, 75)) {
            imagecolorallocate($image, 255, 255, 255);
            imagestring($image, 5, 38, 25,  "...", imagecolorallocate($image, 167, 167, 167));
            return $image;
        } else {
            user_error('Error rendering image', E_USER_NOTICE);
            return false;
        }
    }

    public function output($input, $output=null, $options=array()) {
        
        $renderImage = $this->render($input, $options);
        if ( ! $renderImage ) {
            user_error('Error rendering image', E_USER_NOTICE);
            return false;
        } else {
            list($renderImage, $type) = $renderImage;
        }
        
        if ( empty($output) ) {
            $content_type = image_type_to_mime_type($type);
            if ( ! headers_sent() ) {
                header('Content-Type: ' . $content_type);
            } else {
                user_error('Headers have already been sent. Could not display image.', E_USER_NOTICE);
                return false;
            }
        } else {
            switch (strtolower(preg_replace('~^.+\.([a-z]{3,4})$~', '$1', trim($output)))) {
                case 'gif':
                    $type = IMAGETYPE_GIF;
                break;
                case 'jpg':
                case 'jpeg':
                    $type = IMAGETYPE_JPEG;
                break;
                case 'png':
                    $type = IMAGETYPE_PNG;
                break;
            }
        }
        
        switch ($type) {
            case IMAGETYPE_PNG:
                $result = empty($output) ? imagepng($renderImage) : imagepng($renderImage, $output);
            break;
            case IMAGETYPE_JPEG:
                $result = empty($output) ? imagejpeg($renderImage, null, 95) : imagejpeg($renderImage, $output, 95);
            break;
            case IMAGETYPE_GIF:
                $result = empty($output) ? imagegif($renderImage) : imagegif($renderImage, $output);
            break;
            default:
                throw new E_USER_NOTICE('Image type ' . $type . ' not supported by PHP');
        }
        
        if ( ! $result ) {
            user_error('Error output image', E_USER_NOTICE);
            return false;
        }
        
        imagedestroy($renderImage);
        if ($output) {
            $umask = umask(0);
            chmod($output, 0666);
            umask($umask);
        }

        return true;
    }

    public function render($input, $options=array()) {
        list($sourceImage, $type) = $this->imageCreate($input);
        if ( ! is_resource($sourceImage) ) {
            user_error('Invalid image resource', E_USER_NOTICE);
            return false;
        }
        $sourceWidth  = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);
        
        static $defOptions = array(
            'width'   => 150,
            'height'  => 150,
            'method'  => self::METHOD_SCALE_MAX,
            'percent' => 0,
            'rotate'  => 0,
            'halign'  => self::ALIGN_CENTER,
            'valign'  => self::ALIGN_CENTER,
        );
        foreach ($defOptions as $k => $v) {
            if ( ! isset($options[$k]) ) {
                $options[$k] = $v;
            }
        }
        if ( $options['method'] == self::METHOD_CROP ) {
            if ( $options['percent'] ) {
                $W = floor($options['percent'] * $sourceWidth);
                $H = floor($options['percent'] * $sourceHeight);
            } else {
                $W = $options['width'];
                $H = $options['height'];
            }
            
            $width  = $W;
            $height = $H;
            
            if (isset($options['align'])) {
                $Y = $options['valign'];
                $X = $options['halign'];
            } else {
                $Y = $this->coord($options['valign'], $sourceHeight, $H);
                $X = $this->coord($options['halign'], $sourceWidth,  $W);
            }
        } elseif ( $options['method'] == self::METHOD_ROTATE) {
            $width  = $sourceWidth;
            $height = $sourceHeight;
            $rotate = -$options['rotate'];
        } else {
            $X = 0;
            $Y = 0;
            
            $W = $sourceWidth;
            $H = $sourceHeight;
            
            if ( $options['percent'] ) {
                $width  = floor($options['percent'] * $W);
                $height = floor($options['percent'] * $H);
            } else {
                $width  = $options['width'];
                $height = $options['height'];
                
                if ($width && $height) {
                    if ( $options['method'] == self::METHOD_SCALE_MIN ) {
                        $Ww = $W / $width;
                        $Hh = $H / $height;
                        if ( $Ww > $Hh ) {
                            $W = floor($width * $Hh);
                            $X = $this->coord($options['halign'], $sourceWidth,  $W);
                        } else {
                            $H = floor($height * $Ww);
                            $Y = $this->coord($options['valign'], $sourceHeight, $H);
                        }
                    } elseif ($options['method'] == self::METHOD_BOX) {
                        if ( $H > $W) {
                            $width  = floor($height / $H * $W);
                            if ($width > $options['width']) {
                                $width  = $options['width'];
                                $height = floor($width / $W * $H);
                            }
                        } else {
                            $height = floor($width / $W * $H);
                            if ($height > $options['height']) {
                                $height  = $options['height'];
                                $width  = floor($height / $H * $W);
                            }
                        }
                    } else {
                        if ( $H > $W ) {
                            $width  = floor($height / $H * $W);
                        } else {
                            $height = floor($width / $W * $H);
                        }
                    }
                } else {
                    $width  = $W;
                    $height = $H;
                }
            }
        }
        
        if ( function_exists('imagecreatetruecolor') ) {
            $targetImage = imagecreatetruecolor($width, $height);
            imagealphablending($targetImage, false);
            imagesavealpha($targetImage, true);
        } else {
            $targetImage = imagecreate($width, $height);
        }
        if ( ! is_resource($targetImage) ) {
            user_error('Cannot initialize new GD image stream', E_USER_NOTICE);
            return false;
        }
        if (!empty($options['rotate'])) {
            $sourceImage = imagerotate($sourceImage, -$options['rotate'], imagecolorallocatealpha($sourceImage, 0, 0, 0, 127));
        }
        
        if ( $options['method'] == self::METHOD_CROP ) {
            $result = imagecopy($targetImage, $sourceImage, 0, 0, $X, $Y, $W, $H);
        } elseif ( function_exists('imagecopyresampled') ) {
            $result = imagecopyresampled($targetImage, $sourceImage, 0, 0, $X, $Y, $width, $height, $W, $H);
        } else {
            $result = imagecopyresized($targetImage, $sourceImage, 0, 0, $X, $Y, $width, $height, $W, $H);
        }
        if ( ! $result ) {
            user_error('Cannot resize image', E_USER_NOTICE);
            return false;
        }
        
        imagedestroy($sourceImage);
        
        return array($targetImage, $type);
    }
    
    public function coord($align, $param, $src) {
        if ( $align < self::ALIGN_CENTER ) {
            $result = 0;
        } elseif ( $align > self::ALIGN_CENTER ) {
            $result = $param - $src;
        } else {
            $result = ($param - $src) >> 1;
        }
        return $result;
    }

}
