<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier
 * @since          2017-03-20
 * @version        0.1.2
 */


declare( strict_types = 1 );


namespace Messier;


/**
 * Each class that offer some specific instance info for use inside errors, should implement this interface.
 *
 * @since v0.1.2
 */
interface IErrorInfo
{


   /**
    * Gets information about the instance of the implementing class, that can be used for some error reasons.
    *
    * @return string
    */
   public function getErrorInfoString() : string;


}

