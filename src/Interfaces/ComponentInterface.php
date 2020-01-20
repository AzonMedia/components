<?php
declare(strict_types=1);

namespace Azonmedia\Components\Interfaces;

interface ComponentInterface
{
    public static function get_name() : string ;

    /**
     * Returns the installation URL
     * @return string
     */
    public static function get_url() : string ;

    public static function get_namespace() : string ;

    public static function get_version() : string ;


    public static function get_vendor_name() : string ;

    public static function get_vendor_url() : string ;

    /**
     * @return string
     */
    public static function get_error_reference_url() : string ;

    /**
     * @return string
     */
    public static function get_composer_file() : string ;

    /**
     * @return string
     */
    public static function get_composer_package_name() : string ;
}