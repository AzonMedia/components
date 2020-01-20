<?php
declare(strict_types=1);

namespace Azonmedia\Components\Traits;

/**
 * Trait ComponentTrait
 * @package Azonmedia\Components\Traits
 * This trait provides methods for Azonmedia\Interfaces\ComponentInterface.
 * The following constants are expected to be defined in the class implementing the trait:
 * COMPONENT_NAME
 * COMPONENT_URL
 * COMPONENT_NAMESPACE
 * COMPONENT_VERSION
 * VENDOR_NAME
 * VENDOR_URL
 * ERROR_REFERENCE_URL
 */
trait ComponentTrait
{

    /**
     * @return string
     */
    public static function get_name() : string
    {
        return self::COMPONENT_NAME;
    }

    /**
     * Returns the URL of the component where information, source and installation instructions can be found.
     * @return string
     */
    public static function get_url() : string
    {
        return self::COMPONENT_URL;
    }

    /**
     * Returns the PHP namespace of the component
     * @return string
     */
    public static function get_namespace() : string
    {
        return self::COMPONENT_NAMESPACE;
    }

    /**
     * @return string
     */
    public static function get_version() : string
    {
        return self::COMPONENT_VERSION;
    }

    /**
     * @return string
     */
    public static function get_vendor_name() : string
    {
        return self::VENDOR_NAME;
    }

    /**
     * @return string
     */
    public static function get_vendor_url() : string
    {
        return self::VENDOR_URL;
    }

    /**
     * Returns a base URL where error reference can be found.
     * To this URL the exception UUID will be appended.
     * @return string
     */
    public static function get_error_reference_url() : string
    {
        return self::ERROR_REFERENCE_URL;
    }

    /**
     * Returns the path to the composer.json file of the component.
     * @return string
     * @throws \ReflectionException
     */
    public static function get_composer_file() : string
    {
        $ret = '';
        //todo improve this
        //go up until composer.json is found
        $called_class = get_called_class();
        $component_file = (new \ReflectionClass($called_class))->getFileName();
        //remove the protocol if there is such
        preg_match("#^(.*)\://#", $component_file, $matches);
        if (!empty($matches[1])) {
            $protocol = $matches[1];
            $component_file = str_replace($protocol.'://', '', $component_file);
        }

        $path = $component_file;
        do {
            $path = dirname($path);
            $file = $path.'/composer.json';
            if (file_exists($file) && is_readable($file)) {
                $ret = $file;
                break;
            }
        } while ($path !== '/');
        return $ret;
    }

    /**
     * Returns the package name as found in the composer.json file.
     * @return string
     * @throws \ReflectionException
     */
    public static function get_composer_package_name() : string
    {
        $ret = '';
        $composer_file = self::get_composer_file();
        if ($composer_file) {
            $json = json_decode(file_get_contents($composer_file));
            $ret = $json->name ?? $ret;
        }

        return $ret;
    }
}