<?php

class TagService{
    
    public static function processTags($stringTags){
        $tags = explode(", ", $stringTags);
        foreach($tags as $currentTag){
            $tag = tagNamesQuery::create()->findOneByname($currentTag);
            if(!isset($tag)){
                $tag = new tagNames();
                $tag->setname($currentTag);
                $tag->save();
            }
            $result[] = $tag;
        }
        
        return $result;
    }
            
}


?>
