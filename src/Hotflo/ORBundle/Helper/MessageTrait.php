<?php

namespace Hotflo\ORBundle\Helper;

use Symfony\Component\Yaml\Yaml;

trait MessageTrait
{
    /**
     * Get error message by key
     *
     * @param string $key
     * @return string mixed
     * @throws \Exception
     */
    public function getConfigMessage($key)
    {
        $errorsFile = __DIR__ . "/../../../../app/config/messages.yml";

        if (!is_readable($errorsFile)){
            throw new \Exception("Expected file $errorsFile is missing");
        }

        $errors = Yaml::parse(file_get_contents($errorsFile));

        return $errors[$key];
    }
}