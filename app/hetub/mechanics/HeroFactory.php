<?php
namespace hetub\mechanics;
use hetub\heroes;
use hetub\skills;

class HeroFactory
{
    public static function create($heroType, $heroName)
    {
        if (class_exists('hetub\\heroes\\'.$heroType)) {
            $properties = static::getProperties($heroType);
            if (is_array($properties)) {
                $heroType = 'hetub\\heroes\\'.$heroType;
                $hero = new $heroType;
                if(isset($properties['skills'])) {
                    foreach($properties['skills'] as $skillName => $skill) {
                        if(class_exists('hetub\\skills\\'.$skillName)) {
                            $skillName = 'hetub\\skills\\'.$skillName;
                            $skillObject = new $skillName($skill['factor'], $skill['probability']);
                            $hero->addSkill($skill['type'], $skillObject);
                        }
                    }
                    unset($properties['skills']);
                }
                foreach($properties as $name => $value) {
                    $hero->$name = rand($value['min'], $value['max']);
                }
                $hero->name = $heroName;
                return $hero;
            }
        }
        return null;
    }

    private static function getProperties($heroType)
    {
        if (file_exists('app/hetub/profiles/'. strtolower($heroType))) {
            return json_decode(file_get_contents('app/hetub/profiles/'. strtolower($heroType)), true);
        }
    }
}