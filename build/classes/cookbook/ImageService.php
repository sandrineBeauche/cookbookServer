<?php

class ImageService {
    
    public static $RECIPE_PHOTO = "/MyCookbook/server/images/recipes/";
    
    
    public static function validateImage($image){
        $info = pathinfo($image['name']);
        $ext = $info['extension']; // get the extension of the file
        if($ext != "jpg" && $ext != "jpeg" && $ext != "bmp" && $ext != "png"){
            return array("fichier invalide");
        }
        else{
            return true;
        }
    }
    
    
    public static function saveImage($image, $path, $name){
        $info = pathinfo($image['name']);
        $ext = $info['extension']; // get the extension of the file
            
        $newname = $path.$name.".".$ext; 
            
        move_uploaded_file($image['tmp_name'], 
                            $_SERVER['DOCUMENT_ROOT'].$newname);
        
        return $newname;
    }
    
    
    public static function deleteImage($path){
        $filename = $_SERVER['DOCUMENT_ROOT'].$path;
        unlink($filename);
    }
}

?>
