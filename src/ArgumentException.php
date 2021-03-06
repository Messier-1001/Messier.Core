<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier
 * @since          2016-12-16
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Messier;


/**
 * Is thrown if an method/function argument error should be triggered
 */
class ArgumentException extends MessierException
{


   // <editor-fold desc="// – – –   P R O T E C T E D   F I E L D S   – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * The argument name.
    *
    * @var string
    */
   protected $argumentName;

   /**
    * The function or method name.
    *
    * @var string
    */
   protected $functionName;

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   /**
    * Init a new instance.
    *
    * @param string          $argName  The argument/parameter name
    * @param mixed           $argValue The argument/parameter value
    * @param string|null     $message  The error message (default=null)
    * @param int|string      $code     The error code (default=\E_USER_ERROR)
    * @param \Throwable|null $previous A optional previous exception
    */
   public function __construct(
      string $argName, $argValue, ?string $message = null, $code = 256, ?\Throwable $previous = null )
   {

      // Getting the debug backtrace to find out the method/function that is called with an bad argument.
      $trace = \debug_backtrace();

      // Getting the index of the last trace element.
      $lIdx  = \count( $trace ) - 1;

      // Getting the method or function name.
      $fn = ( empty( $trace[ $lIdx ][ 'class' ] )    ? '' : $trace[ $lIdx ][ 'class' ] )
          . ( empty( $trace[ $lIdx ][ 'type' ] )     ? '' : $trace[ $lIdx ][ 'type' ] )
          . ( empty( $trace[ $lIdx ][ 'function' ] ) ? '' : $trace[ $lIdx ][ 'function' ] );

      // Init with parent constructor
      parent::__construct(
         'Argument $' . \ltrim( $argName, '$' )
         .  ( empty( $fn ) ? '' : ' of ' . $fn . '(…)' )
         .  ' is Invalid! It uses a value of type '
         .  static::GetTypeStr( $argValue )
         .  static::appendMessage( $message ),
         $code,
         $previous
      );

      // Remember the parameter name and the function/method name
      $this->argumentName = $argName;
      $this->functionName = $fn;

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   // <editor-fold desc="// - - -   G E T T E R   - - - - - - - - - - - - - - - - - - - - - -">

   /**
    * Returns the name of the error argument/parameter.
    *
    * @return string
    */
   public final function getArgumentName() : string
   {

      return $this->argumentName;

   }

   /**
    * Returns the value of the error argument/parameter.
    *
    * @return mixed
    */
   public final function getFunctionName() : string
   {

      return $this->functionName;

   }

   // </editor-fold>

   // </editor-fold>


   // <editor-fold desc="// – – –   P R O T E C T E D   S T A T I C   M E T H O D S   – – – – – – – – – – – – – –">

   /**
    * Returns a string, representing the permitted value.
    *
    * @param  mixed $value
    * @return string
    */
   protected static function GetTypeStr( $value ) : string
   {

      if ( null === $value )
      {
         return 'NULL';
      }

      if ( \is_resource( $value ) )
      {
         return \get_resource_type( $value ) . '-Resource';
      }

      if ( \is_string( $value ) )
      {

         if ( \strlen( $value ) > 128 )
         {
            return 'string with value (' . \substr( $value, 0, 126 ) . '…)';
         }

         return 'string with value (' . $value . ')';

      }

      if ( \is_bool( $value ) )
      {
         return 'boolean with value (' . ( $value ? 'true' : 'false' ) . ')';
      }

      if ( \is_int( $value ) )
      {
         return 'integer with value (' . $value . ')';
      }

      if ( \is_float( $value ) )
      {
         return 'float with value (' . $value . ')';
      }

      if ( \is_array( $value ) )
      {
         return 'Array: ' . \json_encode( $value );
      }

      if ( \is_object( $value ) )
      {
         return \get_class( $value ) . ' object: ' . \json_encode( $value );
      }

      return \gettype( $value );

   }

   // </editor-fold>


}

