<?php
declare(strict_types=1);

namespace Azonmedia\Components\Traits;

use Guzaba2\Base\Exceptions\RunTimeException;

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
        $called_class = get_called_class();
        if (!defined($called_class.'::COMPONENT_NAME')) {
            throw new \RuntimeException(sprintf('The class/component %s does not define the COMPONENT_NAME constant.'));
        }
        return static::COMPONENT_NAME;
    }

    /**
     * Returns the URL of the component where information, source and installation instructions can be found.
     * @return string
     */
    public static function get_url() : string
    {
        $called_class = get_called_class();
        if (!defined($called_class.'::COMPONENT_URL')) {
            throw new \RuntimeException(sprintf('The class/component %s does not define the COMPONENT_URL constant.'));
        }
        return static::COMPONENT_URL;
    }

    /**
     * Returns the PHP namespace of the component
     * @return string
     */
    public static function get_namespace() : string
    {
        $called_class = get_called_class();
        if (!defined($called_class.'::COMPONENT_NAMESPACE')) {
            throw new \RuntimeException(sprintf('The class/component %s does not define the COMPONENT_NAMESPACE constant.'));
        }
        return static::COMPONENT_NAMESPACE;
    }

    /**
     * @return string
     */
    public static function get_version() : string
    {
        $called_class = get_called_class();
        if (!defined($called_class.'::COMPONENT_VERSION')) {
            throw new \RuntimeException(sprintf('The class/component %s does not define the COMPONENT_VERSION constant.'));
        }
        return static::COMPONENT_VERSION;
    }

    /**
     * @return string
     */
    public static function get_vendor_name() : string
    {
        $called_class = get_called_class();
        if (!defined($called_class.'::VENDOR_NAME')) {
            throw new \RuntimeException(sprintf('The class/component %s does not define the VENDOR_NAME constant.'));
        }
        return static::VENDOR_NAME;
    }

    /**
     * @return string
     */
    public static function get_vendor_url() : string
    {
        $called_class = get_called_class();
        if (!defined($called_class.'::VENDOR_URL')) {
            throw new \RuntimeException(sprintf('The class/component %s does not define the VENDOR_URL constant.'));
        }
        return static::VENDOR_URL;
    }

    /**
     * Returns a base URL where error reference can be found.
     * To this URL the exception UUID will be appended.
     * @return string
     */
    public static function get_error_reference_url() : string
    {
        $called_class = get_called_class();
        if (!defined($called_class.'::ERROR_REFERENCE_URL')) {
            throw new \RuntimeException(sprintf('The class/component %s does not define the ERROR_REFERENCE_URL constant.'));
        }
        return static::ERROR_REFERENCE_URL;
    }

    ///////////////////////////////////////////////////////////
    //composer.json related methods follow
    ///////////////////////////////////////////////////////////

    /**
     * @return string
     */
    public static function get_source_url() : string
    {
        $ret = '';
        $composer_file = self::get_composer_file();
        if ($composer_file) {
            $ret = self::get_composer_json_object($composer_file)->homepage ?? $ret;
        }
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
            $ret = self::get_composer_json_object($composer_file)->name ?? $ret;
        }
        return $ret;
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


    private static function get_composer_json_object(string $composer_file) : object
    {
        $json = json_decode(file_get_contents($composer_file));
        if ($json === NULL) {
            //print sprintf('The %s contains invalid json: %s.', $composer_file, json_last_error_msg() );
            throw new \RuntimeException(sprintf('The %s contains invalid json: %s.', $composer_file, json_last_error_msg() ) );
        }
        return $json;
    }
}