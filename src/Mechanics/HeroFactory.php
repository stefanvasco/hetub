<?php

namespace VaneaVasco\Hetub\Mechanics;

use VaneaVasco\Hetub\Heroes;
use VaneaVasco\Hetub\Skills;

class HeroFactory
{
    public static function create($heroType, $heroName)
    {
        if (class_exists('VaneaVasco\\Hetub\\Heroes\\' . $heroType)) {
            $properties = static::getProperties($heroType);
            if (is_array($properties)) {
                $heroType = 'VaneaVasco\\Hetub\\Heroes\\' . $heroType;
                $hero     = new $heroType;
                if (isset($properties['skills'])) {
                    foreach ($properties['skills'] as $skillName => $skill) {
                        if (class_exists('VaneaVasco\\Hetub\\Skills\\' . $skillName)) {
                            $skillName   = 'VaneaVasco\\Hetub\\Skills\\' . $skillName;
                            $skillObject = new $skillName($skill['factor'], $skill['probability']);
                            $hero->addSkill($skill['type'], $skillObject);
                        }
                    }
                    unset($properties['skills']);
                }
                foreach ($properties as $name => $value) {
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
        if (file_exists('data/Profiles/' . strtolower($heroType))) {
            return json_decode(file_get_contents('data/Profiles/' . strtolower($heroType)), true);
        }
    }
}
