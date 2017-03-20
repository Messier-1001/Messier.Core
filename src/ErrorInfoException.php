<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier
 * @since          2017-03-20
 * @version        0.1.2 rel. Baerbel
 */


declare( strict_types = 1 );


namespace Messier;


/**
 * This is the Messier {@see \Messier\IErrorInfo} depending base exception.
 *
 * @since v0.1.2
 */
class ErrorInfoException extends MessierException
{


   // <editor-fold desc="// – – –   P R O T E C T E D   F I E L D S   – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * The back trace.
    *
    * @type \Messier\IErrorInfo
    */
   protected $_info;

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   C O N S T R U C T O R   = = = = = = = = = = = = = = = = = = = = =">

   /**
    * Init a new ErrorInfoException instance.
    *
    * @param \Messier\IErrorInfo $obj      The Object that implements the IErrorInfo interface.
    * @param string|null         $message  The error message.
    * @param int                 $code     The optional error code.
    * @param \Throwable|null     $previous Optional previous throwable.
    */
   public function __construct ( IErrorInfo $obj, ?string $message = null, $code = 0, \Throwable $previous = null )
   {

      parent::__construct(
         ( ! empty( $message ) ? ( $message . ' - ' ) : '' ) . $obj->getErrorInfoString(),
         $code,
         $previous
      );

      $this->_info  = $obj;

   }

   // </editor-fold>


   // <editor-fold desc="// = = = =   P U B L I C   M E T H O D S   = = = = = = = = = = = = = = = = = = = = = = = = =">

   /**
    * @return \Messier\IErrorInfo
    */
   public function getErrorInfo() : IErrorInfo
   {

      return $this->_info;

   }

   // </editor-fold>


}

