<?php
namespace hetub\mechanics;

class HeroFactory
{
    public static function create($heroType)
    {
        if (class_exists($heroType)) {
            $properties = static::getProperties($heroType);
            if (is_array($properties)) {
                $hero = new $heroType;
                foreach($properties as $name => $value) {
                    $hero->$name = rand($value['mine'], $value['max']);
                }
                return $hero;
            }
        }
        return null;
    }

    private static function getProperties($heroType)
    {
        if (file_exists('profiles/'. strtolower($heroType))) {
            return json_decode(file_get_contents('profiles/'. strtolower($heroType)), true);
        }
    }
}