<?php
namespace Marcin\SiteBundle\Libs;
class Utils {
    
    static public function removeImage($pathToImage, $img) {
        if(file_exists($pathToImage.$img)) {
           unlink($pathToImage.$img);
        }
    }
    
}