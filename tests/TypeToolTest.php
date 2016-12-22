<?php


/**
 * Created by PhpStorm.
 * User: messier
 * Date: 20.12.16
 * Time: 17:53
 */
class TypeToolTest extends PHPUnit_Framework_TestCase
{


   public function testIsInteger()
   {
      $this->assertTrue ( \Messier\TypeTool::IsInteger( 0 ) );
      $this->assertTrue ( \Messier\TypeTool::IsInteger( '1' ) );
      $this->assertTrue ( \Messier\TypeTool::IsInteger( '-123456' ) );
      $this->assertTrue( \Messier\TypeTool::IsInteger( 1.0 ) );
      $this->assertFalse( \Messier\TypeTool::IsInteger( '1.0' ) );
      $this->assertFalse( \Messier\TypeTool::IsInteger( '+1' ) );
   }
   public function testIsDecimal()
   {
      $this->assertTrue ( \Messier\TypeTool::IsDecimal( 987 ) );
      $this->assertTrue ( \Messier\TypeTool::IsDecimal( '1' ) );
      $this->assertTrue ( \Messier\TypeTool::IsDecimal( '-123456' ) );
      $this->assertTrue ( \Messier\TypeTool::IsDecimal( 1.0 ) );
      $this->assertTrue ( \Messier\TypeTool::IsDecimal( '1.0' ) );
      $this->assertFalse( \Messier\TypeTool::IsDecimal( '1,0' ) );
      $this->assertTrue ( \Messier\TypeTool::IsDecimal( '1,0', true ) );
      $this->assertFalse( \Messier\TypeTool::IsInteger( '+1' ) );
   }
   public function testIsBoolConvertible()
   {
      $this->assertFalse( \Messier\TypeTool::IsBoolConvertible( null, $res ) );
      $this->assertFalse( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( true, $res ) );
      $this->assertTrue ( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( false, $res ) );
      $this->assertFalse( $res );
      $fp = fopen( __DIR__ . '/test', 'wb' );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( $fp, $res ) );
      $this->assertTrue ( $res );
      fclose( $fp );
      unlink( __DIR__ . '/test' );
      $cls = new ArrayObject();
      $this->assertFalse( \Messier\TypeTool::IsBoolConvertible( $cls, $res ) );
      $this->assertFalse( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( [], $res ) );
      $this->assertFalse( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( [ 14 ], $res ) );
      $this->assertTrue ( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( 0, $res ) );
      $this->assertFalse( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( -12, $res ) );
      $this->assertFalse( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( 1, $res ) );
      $this->assertTrue ( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( 123, $res ) );
      $this->assertTrue ( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( 12.3, $res ) );
      $this->assertTrue ( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( -0.123, $res ) );
      $this->assertFalse( $res );
      $cls = new class {
         public function __toString()
         {
            return '1';
         }
      };
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( $cls, $res ) );
      $this->assertTrue ( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( 'b:0;', $res ) );
      $this->assertFalse( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( 'b:1;', $res ) );
      $this->assertTrue ( $res );
      $this->assertTrue ( \Messier\TypeTool::IsBoolConvertible( '', $res ) );
      $this->assertFalse( $res );
      $this->assertFalse( \Messier\TypeTool::IsBoolConvertible( 'blubb', $res ) );
      $this->assertFalse( $res );
   }
   public function testIsStringConvertible()
   {
      $this->assertTrue ( \Messier\TypeTool::IsStringConvertible( null, $res ) );
      $this->assertEquals( '', $res );
      $this->assertTrue ( \Messier\TypeTool::IsStringConvertible( '', $res ) );
      $this->assertEquals( '', $res );
      $this->assertTrue ( \Messier\TypeTool::IsStringConvertible( false, $res ) );
      $this->assertEquals( 'false', $res );
      $this->assertTrue ( \Messier\TypeTool::IsStringConvertible( true, $res ) );
      $this->assertEquals( 'true', $res );
      $fp = fopen( __DIR__ . '/test', 'wb' );
      $this->assertFalse( \Messier\TypeTool::IsStringConvertible( $fp, $res ) );
      $this->assertEquals( '', $res );
      fclose( $fp );
      unlink( __DIR__ . '/test' );
      $dt = new DateTime( '2016-12-24 22:00:01' );
      $this->assertTrue ( \Messier\TypeTool::IsStringConvertible( $dt, $res ) );
      $this->assertEquals( '2016-12-24 22:00:01', $res );
      $this->assertTrue ( \Messier\TypeTool::IsStringConvertible( [], $res ) );
      $this->assertEquals( serialize( [] ), $res );
      $this->assertTrue ( \Messier\TypeTool::IsStringConvertible( [ 'Foo' => false, [ 5, 3, 2 ] ], $res ) );
      $this->assertEquals( serialize( [ 'Foo' => false, [ 5, 3, 2 ] ] ), $res );
      $this->assertTrue ( \Messier\TypeTool::IsStringConvertible( 1024, $res ) );
      $this->assertEquals( '1024', $res );
      $this->assertTrue ( \Messier\TypeTool::IsStringConvertible( 10.24, $res ) );
      $this->assertEquals( '10.24', $res );
      $cls = new stdClass();
      $cls->foo = 20;
      $this->assertFalse( \Messier\TypeTool::IsStringConvertible( $cls, $res ) );
      $this->assertEquals( '', $res );
   }
   public function testStrToType()
   {
      $this->assertSame( 0, \Messier\TypeTool::StrToType( '', 'int' ) );
      $this->assertSame( 14, \Messier\TypeTool::StrToType( '14', 'int' ) );
      $this->assertSame( -987, \Messier\TypeTool::StrToType( '-987', 'integer' ) );
      $this->assertNull( \Messier\TypeTool::StrToType( 'xfoo', 'int' ) );
      $this->assertSame( 0, \Messier\TypeTool::StrToType( '', 'float' ) );
      $this->assertSame( 0.14, \Messier\TypeTool::StrToType( '0.14', 'float' ) );
      $this->assertSame( 12.34, \Messier\TypeTool::StrToType( '12,34', 'float' ) );
      $this->assertSame( '12,34', \Messier\TypeTool::StrToType( '12,34', 'string' ) );
      $this->assertSame( [], \Messier\TypeTool::StrToType( '', 'array' ) );
      $this->assertSame( [ 'foo' => true ], \Messier\TypeTool::StrToType( serialize( [ 'foo' => true ] ), 'array' ) );
      $this->assertSame( [ 'foo' => true ], \Messier\TypeTool::StrToType( json_encode( [ 'foo' => true ] ), 'array' ) );
      $this->assertSame( [ 'foo', true ], \Messier\TypeTool::StrToType( json_encode( [ 'foo', true ] ), 'array' ) );
      $this->assertSame( [ 'foo' => true ], \Messier\TypeTool::StrToType( serialize( [ 'foo' => true ] ), 'array' ) );
      $this->assertSame( [ 'a:15/14' ], \Messier\TypeTool::StrToType( 'a:15/14', 'array' ) );
      $this->assertSame( [ '{bc/ad}' ], \Messier\TypeTool::StrToType( '{bc/ad}', 'array' ) );
      $this->assertSame( [ '[bc/ad]' ], \Messier\TypeTool::StrToType( '[bc/ad]', 'array' ) );
      $this->assertNull  ( \Messier\TypeTool::StrToType( '', 'DateTime' ) );
      $cls = new DateTime();
      $this->assertEquals( $cls, \Messier\TypeTool::StrToType( serialize( $cls ), 'DateTime' ) );
      $this->assertNull  ( \Messier\TypeTool::StrToType( 'o:b/l.u$b"Foo"..', 'Foo' ) );
   }
   public function testXmlToType()
   {
      $xmlDoc = simplexml_load_string(
         '<?xml version="1.0" encoding="utf-8"?><foo><a type="integer" value="12"/>
   <b><type>float</type><value>14.5</value></b>
   <c><Type>bool</Type><Value>true</Value></c>
   <d type="string">XYZ uvw</d>
   <e>Foo</e></foo>'
      );

      $this->assertSame( 12, \Messier\TypeTool::XmlToType( $xmlDoc->a ) );
      $this->assertSame( 14.5, \Messier\TypeTool::XmlToType( $xmlDoc->b ) );
      $this->assertTrue( \Messier\TypeTool::XmlToType( $xmlDoc->c ) );
      $this->assertSame( 'XYZ uvw', \Messier\TypeTool::XmlToType( $xmlDoc->d ) );
      $this->assertNull( \Messier\TypeTool::XmlToType( $xmlDoc->e ) );

      # XmlToType( \SimpleXMLElement $xmlElement )
   }
   public function testIsNativeType()
   {
      $this->assertTrue ( \Messier\TypeTool::IsNativeType( 0 ) );
      $this->assertTrue ( \Messier\TypeTool::IsNativeType( 1.0 ) );
      $this->assertTrue ( \Messier\TypeTool::IsNativeType( true ) );
      $this->assertTrue ( \Messier\TypeTool::IsNativeType( 'a string' ) );
      $this->assertTrue ( \Messier\TypeTool::IsNativeType( [] ) );
      $cls = new stdClass();
      $this->assertFalse( \Messier\TypeTool::IsNativeType( $cls ) );
   }
   public function testGetNativeType()
   {
      $this->assertSame( \Messier\Type::PHP_STRING, \Messier\TypeTool::GetNativeType( 'a string' ) );
      $this->assertFalse( \Messier\TypeTool::GetNativeType( [] ) );
      $this->assertSame( \Messier\Type::PHP_BOOLEAN, \Messier\TypeTool::GetNativeType( true ) );
      $this->assertSame( \Messier\Type::PHP_FLOAT, \Messier\TypeTool::GetNativeType( 1234.04 ) );
      $this->assertSame( \Messier\Type::PHP_INTEGER, \Messier\TypeTool::GetNativeType( -14400 ) );
      $this->assertFalse( \Messier\TypeTool::GetNativeType( null ) );
      $fp = fopen( __DIR__ . '/test', 'wb' );
      $this->assertFalse( \Messier\TypeTool::GetNativeType( $fp ) );
      fclose( $fp );
      unlink( __DIR__ . '/test' );
      $this->assertFalse( \Messier\TypeTool::GetNativeType( new DateTime() ) );
   }
   public function testGetTypeName()
   {
      $this->assertSame( \Messier\Type::PHP_STRING, \Messier\TypeTool::GetTypeName( 'a string' ) );
      $this->assertSame( \Messier\Type::PHP_ARRAY, \Messier\TypeTool::GetTypeName( [] ) );
      $this->assertSame( \Messier\Type::PHP_BOOLEAN, \Messier\TypeTool::GetTypeName( true ) );
      $this->assertSame( \Messier\Type::PHP_FLOAT, \Messier\TypeTool::GetTypeName( 1234.04 ) );
      $this->assertSame( \Messier\Type::PHP_INTEGER, \Messier\TypeTool::GetTypeName( -14400 ) );
      $this->assertSame( \Messier\Type::PHP_NULL, \Messier\TypeTool::GetTypeName( null ) );
      $fp = fopen( __DIR__ . '/test', 'wb' );
      $this->assertSame( \Messier\Type::PHP_RESOURCE, \Messier\TypeTool::GetTypeName( $fp ) );
      fclose( $fp );
      unlink( __DIR__ . '/test' );
      $this->assertSame( 'DateTime', \Messier\TypeTool::GetTypeName( new DateTime() ) );
   }
   /**
    * @expectedException \Messier\ArgumentException
    */
   public function testConvertNative()
   {
      $this->assertNull( \Messier\TypeTool::ConvertNative( null, \Messier\Type::PHP_STRING ) );
      $this->assertSame( '1', \Messier\TypeTool::ConvertNative( 1, \Messier\Type::PHP_STRING ) );
      $this->assertSame( '0.11', \Messier\TypeTool::ConvertNative( .11, \Messier\Type::PHP_STRING ) );
      $this->assertSame( '1', \Messier\TypeTool::ConvertNative( true, \Messier\Type::PHP_STRING ) );
      $this->assertSame( '0', \Messier\TypeTool::ConvertNative( false, \Messier\Type::PHP_STRING ) );
      $this->assertSame( ':-)', \Messier\TypeTool::ConvertNative( ':-)', \Messier\Type::PHP_STRING ) );

      $this->assertNull( \Messier\TypeTool::ConvertNative( null, \Messier\Type::PHP_INTEGER ) );
      $this->assertSame( 1, \Messier\TypeTool::ConvertNative( '1', \Messier\Type::PHP_INTEGER ) );
      $this->assertSame( 0, \Messier\TypeTool::ConvertNative( .11, \Messier\Type::PHP_INTEGER ) );
      $this->assertSame( 1, \Messier\TypeTool::ConvertNative( true, \Messier\Type::PHP_INTEGER ) );
      $this->assertSame( 0, \Messier\TypeTool::ConvertNative( false, \Messier\Type::PHP_INTEGER ) );

      $this->assertNull( \Messier\TypeTool::ConvertNative( null, \Messier\Type::PHP_FLOAT ) );
      $this->assertSame( 1.0, \Messier\TypeTool::ConvertNative( '1', \Messier\Type::PHP_FLOAT ) );
      $this->assertSame( 858585, \Messier\TypeTool::ConvertNative( 858585, \Messier\Type::PHP_FLOAT ) );
      $this->assertSame( 0.11, \Messier\TypeTool::ConvertNative( .11, \Messier\Type::PHP_FLOAT ) );
      $this->assertSame( 1.0, \Messier\TypeTool::ConvertNative( true, \Messier\Type::PHP_FLOAT ) );
      $this->assertSame( 0.0, \Messier\TypeTool::ConvertNative( false, \Messier\Type::PHP_FLOAT ) );

      $this->assertNull( \Messier\TypeTool::ConvertNative( null, \Messier\Type::PHP_BOOLEAN ) );
      $this->assertTrue( \Messier\TypeTool::ConvertNative( '1', \Messier\Type::PHP_BOOLEAN ) );
      $this->assertFalse( \Messier\TypeTool::ConvertNative( -12, \Messier\Type::PHP_BOOLEAN ) );
      $this->assertTrue( \Messier\TypeTool::ConvertNative( .11, \Messier\Type::PHP_BOOLEAN ) );
      $this->assertTrue( \Messier\TypeTool::ConvertNative( 'true', \Messier\Type::PHP_BOOLEAN ) );
      $this->assertFalse( \Messier\TypeTool::ConvertNative( 'false', \Messier\Type::PHP_BOOLEAN ) );

      $this->assertNull( \Messier\TypeTool::ConvertNative( [], \Messier\Type::PHP_FLOAT ) );
      $this->assertNull( \Messier\TypeTool::ConvertNative( 12.3, \Messier\Type::PHP_ARRAY ) );
      $this->assertNull( \Messier\TypeTool::ConvertNative( false, \Messier\Type::PHP_ARRAY ) );
      # ConvertNative( $sourceValue, string $newType )
   }


}
