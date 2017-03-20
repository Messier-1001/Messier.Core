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
 * Each class that implement this interface is marked to be able to get all instance data as a associative array.
 *
 * @since v0.1.2
 */
interface IArrayable
{


   /**
    * Returns all instance data as an associative array.
    *
    * @return array
    */
   public function toArray() : array;


}

