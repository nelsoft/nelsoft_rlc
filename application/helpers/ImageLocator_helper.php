<?php

class ImageLocator
{
    static $allowedMimeTypes = array(
        "jpg" => "image/jpeg",
        "png" => "image/png",
        "gif" => "image/gif",
        "jpeg"=> "image/jpeg"
    );

    static function ValidateImagePath($basepath, $filename)
    {
        if (!isset($filename)) {
            ImageLocator::SendErrorHeader(404);
        }
        if (strlen($filename) <= 4) {
            ImageLocator::SendErrorHeader(404);
        }
        $pathParts = pathinfo($filename);
        if (! array_key_exists(strtolower($pathParts["extension"]), ImageLocator::$allowedMimeTypes)) {
            ImageLocator::SendErrorHeader(404);
        }
        $bLastChar = substr($basepath, -1, 1) == "/" ? true : false;
        $bFirstChar = substr($filename, 0, 1) == "/" ? true : false;

        if ($bLastChar && $bFirstChar) {
            $imagepath = substr($basepath, 0, strlen($basepath)-1) . $filename;
        } elseif (!$bLastChar && !$bFirstChar) {
            $imagepath = $basepath . "/" . $filename;
        } else {
            $imagepath = $basepath . $filename;
        }
        if (!file_exists($imagepath)) {
            ImageLocator::SendErrorHeader(404);
        }
        return($imagepath);
    }

    static function SendErrorHeader($error)
    {
        switch($error) {
            case 400:
                header("HTTP/1.0 400 Bad Request");
                break;
            case 401:
                header("HTTP/1.0 401 Unauthorized");
                break;
            case 403:
                header("HTTP/1.0 403 Forbidden");
                break;
            case 404:
            default:
                header("HTTP/1.0 404 Not Found");
                break;
        }
        exit;
    }

    static function SendImageHeader($imagepath)
    {
        if (exif_imagetype($imagepath) == IMAGETYPE_JPEG) {
            $extension = "jpg";
        } elseif (exif_imagetype($imagepath) == IMAGETYPE_PNG) {
            $extension = "png";
        } else {
            $extension = "gif";
        }
        $mimeType = ImageLocator::$allowedMimeTypes[$extension];
        header("Content-type: image/" . $mimeType);
        readfile($imagepath);
    }
}
