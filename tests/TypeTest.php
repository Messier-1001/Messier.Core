<?php


/**
 * Created by PhpStorm.
 * User: messier
 * Date: 21.12.16
 * Time: 20:13
 */
class TypeTest extends PHPUnit_Framework_TestCase
{

   private $instances;

   public function setUp()
   {

      $cls = new stdClass();
      $cls->foo = "1\n2\t3";

      $this->instances = [
         new \Messier\Type( null ),
         new \Messier\Type( true ),
         new \Messier\Type( false ),
         new \Messier\Type( 1234 ),
         new \Messier\Type( 123.45 ),
         new \Messier\Type( 'Foo Bar Baz' ),
         new \Messier\Type( new DateTime( '2016-12-24 21:50:45' ) ),
         new \Messier\Type( [ 1, 3, 5 ] ),
         new \Messier\Type( imagecreatetruecolor( 150, 140 ) ),
         new \Messier\Type( "Foo\nBar\t Baz" ),
         new \Messier\Type( $cls )
      ];

      parent::setUp();

   }

   /**
    * @expectedException \Messier\MessierException
    */
   public function testInvalidConstructor()
   {
      $this->assertNull( new \Messier\Type( new \Messier\Type( 1 ) ) );
   }
   public function testEquals()
   {
      $this->assertTrue( $this->instances[ 0 ]->equals( null ) );
      $this->assertTrue( $this->instances[ 1 ]->equals( true ) );
      $this->assertTrue( $this->instances[ 1 ]->equals( false ) );
      $this->assertFalse( $this->instances[ 1 ]->equals( false, true ) );
      $this->assertTrue( $this->instances[ 2 ]->equals( new \Messier\Type( false ) ) );
      $this->assertFalse( $this->instances[ 2 ]->equals( true, true ) );
      $this->assertTrue( $this->instances[ 3 ]->equals( 1234 ) );
      $this->assertTrue( $this->instances[ 4 ]->equals( 123.45 ) );
      $cls = new stdClass();
      $cls->foo = 135;
      $this->assertFalse( $this->instances[ 4 ]->equals( $cls ) );
      # equals( $value, bool $strict = false )
   }
   public function testGetValue()
   {
      $this->assertNull( $this->instances[ 0 ]->getValue() );
      $this->assertTrue( $this->instances[ 1 ]->getValue() );
      $this->assertFalse( $this->instances[ 2 ]->getValue() );
      $this->assertSame( 1234, $this->instances[ 3 ]->getValue() );
      $this->assertSame( 123.45, $this->instances[ 4 ]->getValue() );
   }
   public function testGetStringValue()
   {
      $this->assertSame( '', $this->instances[ 0 ]->getStringValue() );
      $this->assertSame( 'true', $this->instances[ 1 ]->getStringValue() );
      $this->assertSame( 'false', $this->instances[ 2 ]->getStringValue() );
      $this->assertSame( '1234', $this->instances[ 3 ]->getStringValue() );
      $this->assertSame( '123.45', $this->instances[ 4 ]->getStringValue() );
      $this->assertSame( 'Foo Bar Baz', $this->instances[ 5 ]->getStringValue() );
      $this->assertSame( '2016-12-24 21:50:45', $this->instances[ 6 ]->getStringValue() );
      $this->assertSame( serialize( [ 1, 3, 5 ] ), $this->instances[ 7 ]->getStringValue() );
      $this->assertSame( ' ', $this->instances[ 8 ]->getStringValue( ' ' ) );
   }
   public function testHasAssociatedString()
   {
      $this->assertTrue( $this->instances[ 0 ]->hasAssociatedString() );
      $this->assertTrue( $this->instances[ 1 ]->hasAssociatedString() );
      $this->assertTrue( $this->instances[ 2 ]->hasAssociatedString() );
      $this->assertTrue( $this->instances[ 3 ]->hasAssociatedString() );
      $this->assertTrue( $this->instances[ 4 ]->hasAssociatedString() );
      $this->assertTrue( $this->instances[ 5 ]->hasAssociatedString() );
      $this->assertTrue( $this->instances[ 6 ]->hasAssociatedString() );
      $this->assertTrue( $this->instances[ 7 ]->hasAssociatedString() );
      $this->assertFalse( $this->instances[ 8 ]->hasAssociatedString() );
   }
   public function testGetType()
   {
      $this->assertSame( \Messier\Type::PHP_NULL, $this->instances[ 0 ]->getType() );
      $this->assertSame( \Messier\Type::PHP_BOOLEAN, $this->instances[ 1 ]->getType() );
      $this->assertSame( \Messier\Type::PHP_BOOLEAN, $this->instances[ 2 ]->getType() );
      $this->assertSame( \Messier\Type::PHP_INTEGER, $this->instances[ 3 ]->getType() );
      $this->assertSame( \Messier\Type::PHP_FLOAT, $this->instances[ 4 ]->getType() );
      $this->assertSame( \Messier\Type::PHP_STRING, $this->instances[ 5 ]->getType() );
      $this->assertSame( 'DateTime', $this->instances[ 6 ]->getType() );
      $this->assertSame( \Messier\Type::PHP_ARRAY, $this->instances[ 7 ]->getType() );
      $this->assertSame( \Messier\Type::PHP_RESOURCE, $this->instances[ 8 ]->getType() );
   }
   public function testIsResource()
   {
      $this->assertFalse( $this->instances[ 0 ]->isResource() );
      $this->assertFalse( $this->instances[ 1 ]->isResource() );
      $this->assertFalse( $this->instances[ 2 ]->isResource() );
      $this->assertFalse( $this->instances[ 3 ]->isResource() );
      $this->assertFalse( $this->instances[ 4 ]->isResource() );
      $this->assertFalse( $this->instances[ 5 ]->isResource() );
      $this->assertFalse( $this->instances[ 6 ]->isResource() );
      $this->assertFalse( $this->instances[ 7 ]->isResource() );
      $this->assertTrue( $this->instances[ 8 ]->isResource() );
   }
   public function test__toString()
   {
      $this->assertSame( '', (string) $this->instances[ 0 ] );
      $this->assertSame( 'true', (string) $this->instances[ 1 ] );
      $this->assertSame( 'false', (string) $this->instances[ 2 ] );
      $this->assertSame( '1234', (string) $this->instances[ 3 ] );
      $this->assertSame( '123.45', (string) $this->instances[ 4 ] );
      $this->assertSame( 'Foo Bar Baz', (string) $this->instances[ 5 ] );
      $this->assertSame( '2016-12-24 21:50:45', (string) $this->instances[ 6 ] );
      $this->assertSame( serialize( [ 1, 3, 5 ] ), (string) $this->instances[ 7 ] );
      $this->assertSame( '', (string) $this->instances[ 8 ] );
   }
   public function testGetPhpCode()
   {
      $this->assertSame( 'null', $this->instances[ 0 ]->getPhpCode() );
      $this->assertSame( 'true', $this->instances[ 1 ]->getPhpCode() );
      $this->assertSame( 'false', $this->instances[ 2 ]->getPhpCode() );
      $this->assertSame( '1234', $this->instances[ 3 ]->getPhpCode() );
      $this->assertSame( '123.45', $this->instances[ 4 ]->getPhpCode() );
      $this->assertSame( "'Foo Bar Baz'", $this->instances[ 5 ]->getPhpCode() );
      $this->assertSame( '\unserialize("O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2016-12-24 21:50:45.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}")', $this->instances[ 6 ]->getPhpCode() );
      $this->assertSame( '\unserialize("a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}")', $this->instances[ 7 ]->getPhpCode() );
      $this->assertSame( 'null', $this->instances[ 8 ]->getPhpCode() );
      $this->assertSame( "\"Foo\\nBar\\t Baz\"", $this->instances[ 9 ]->getPhpCode() );
      $this->assertSame( "\\unserialize(\"O:8:\\\"stdClass\\\":1:{s:3:\\\"foo\\\";s:5:\\\"1\\n2\\t3\\\";}\")", $this->instances[ 10 ]->getPhpCode() );
   }
   public function testClone()
   {
      $clone = clone $this->instances[ 0 ];
      $this->assertEquals( $clone, $this->instances[ 0 ] );
      $clone = clone $this->instances[ 1 ];
      $this->assertEquals( $clone, $this->instances[ 1 ] );
      $clone = clone $this->instances[ 2 ];
      $this->assertEquals( $clone, $this->instances[ 2 ] );
      $clone = clone $this->instances[ 3 ];
      $this->assertEquals( $clone, $this->instances[ 3 ] );
      $clone = clone $this->instances[ 4 ];
      $this->assertEquals( $clone, $this->instances[ 4 ] );
      $clone = clone $this->instances[ 5 ];
      $this->assertEquals( $clone, $this->instances[ 5 ] );
      $clone = clone $this->instances[ 6 ];
      $this->assertEquals( $clone, $this->instances[ 6 ] );
   }

}
