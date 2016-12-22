<?php


/**
 * Created by PhpStorm.
 * User: messier
 * Date: 17.12.16
 * Time: 23:42
 */
class ArrayHelperTest extends PHPUnit_Framework_TestCase
{


   public function testParseAttributes()
   {

      # ParseAttributes( string $attributeStr, bool $lowerKeys = false, bool $autoBoolean = true ) : array
      $this->assertEquals(
         [
            'a'    => '20',
            'b'    => 'foo bar',
            'cdEf' => true
         ],
         \Messier\ArrayHelper::ParseAttributes( 'a="20" b="foo bar" cdEf="true"', false, true )
      );

      $this->assertEquals(
         [
            'a'    => '20',
            'b'    => 'foo bar',
            'cdef' => true
         ],
         \Messier\ArrayHelper::ParseAttributes( 'a="20" b="foo bar" cdEf="true"', true, true )
      );

      $this->assertEquals(
         [
            'a'    => '20',
            'b'    => 'foo bar',
            'cdef' => 'true'
         ],
         \Messier\ArrayHelper::ParseAttributes( 'a="20" b="foo bar" cdEf="true"', true, false )
      );

      $this->assertEquals(
         [],
         \Messier\ArrayHelper::ParseAttributes( '', true, false )
      );

      $this->assertEquals(
         [
            'a'        => '20',
            'b'        => 'foo bar',
            'required' => true
         ],
         \Messier\ArrayHelper::ParseAttributes( 'a="20" b=\'foo bar\' required="required"', true, true )
      );

   }

   public function testParseHtmlAttributes()
   {

      $this->assertEquals(
         [
            'foo'      => '10',
            'b'        => 'true',
            'required' => '',
            'bar'      => 'foo & bar'
         ],
         \Messier\ArrayHelper::ParseHtmlAttributes( 'foo=10 bAr="foo &amp; bar" b=true required', false )
      );
      $this->assertEquals(
         [
            'foo' => '10',
            'bar' => 'foo bar',
            'required' => ''
         ],
         \Messier\ArrayHelper::ParseHtmlAttributes( 'foo=10 bAr="foo bar" required', false )
      );
      $this->assertEquals(
         [
            'foo'      => '10',
            'bar'      => 'foo bar',
            'b'        => true,
            'c'        => false,
            'required' => ''
         ],
         \Messier\ArrayHelper::ParseHtmlAttributes( 'foo=10 bAr="foo bar" b=true c=Off required', true )
      );
      $this->assertEquals(
         [],
         \Messier\ArrayHelper::ParseHtmlAttributes( 'fo+o=10 bAr=foo bar b=true c=Off required', true )
      );
      $this->assertEquals(
         [],
         \Messier\ArrayHelper::ParseHtmlAttributes( '', false )
      );
      # $element->hasAttributes()

   }

   public function testIsNumericIndicated()
   {

      $this->assertTrue( \Messier\ArrayHelper::IsNumericIndicated( [ 'Foo' ] ) );
      $this->assertTrue( \Messier\ArrayHelper::IsNumericIndicated( [ 'Foo', 'bar', 'baz' ] ) );
      $this->assertTrue( \Messier\ArrayHelper::IsNumericIndicated( [ 0 => 'Foo', 1 => 'bar', 2 => 'baz' ] ) );
      $this->assertFalse( \Messier\ArrayHelper::IsNumericIndicated( [ 0 => 'Foo', 1 => 'bar', 3 => 'baz' ] ) );
      $this->assertFalse( \Messier\ArrayHelper::IsNumericIndicated( [ 'Foo' => 0 ] ) );
      $this->assertFalse( \Messier\ArrayHelper::IsNumericIndicated( [ 0 => 'Foo', 1 => 'bar', 'Baz' => 0 ] ) );
      $this->assertTrue( \Messier\ArrayHelper::IsNumericIndicated( [] ) );

   }

   public function testCreateAttributeString()
   {

      $this->assertEquals(
         ' foo="10" bAr="foo &amp; bar" b="1"',
         \Messier\ArrayHelper::CreateAttributeString( [ 'foo' => 10, 'bAr' => 'foo & bar', 'b' => true ] )
      );
      $this->assertEquals(
         '',
         \Messier\ArrayHelper::CreateAttributeString( [] )
      );
      $this->assertEquals(
         '',
         \Messier\ArrayHelper::CreateAttributeString( [ 12, true ] )
      );
      $this->assertEquals(
         ' foo="10" _1="foo &amp; bar" b="1"',
         \Messier\ArrayHelper::CreateAttributeString( [ 'foo' => 10, 1 => 'foo & bar', 'b' => true ] )
      );

   }

   public function testInsert()
   {

      # Insert( array $array, $element, int $index )
      $this->assertEquals(
         [ 'foo', 'baz', 'bar' ],
         \Messier\ArrayHelper::Insert( [ 'foo', 'bar' ], 'baz', 1 )
      );
      $this->assertEquals(
         [ 'foo', 'bar', 'baz' ],
         \Messier\ArrayHelper::Insert( [ 'foo', 'bar' ], 'baz', 10 )
      );
      $this->assertEquals(
         [ 'baz', 'foo', 'bar' ],
         \Messier\ArrayHelper::Insert( [ 'foo', 'bar' ], 'baz', -1 )
      );
      $this->assertEquals(
         [ 'baz', 'foo', 'bar' ],
         \Messier\ArrayHelper::Insert( [ 'foo', 'bar' ], [ 'baz' ], 0 )
      );
      $this->assertEquals(
         [ 'foo', 'baz', 'blub', 'bar' ],
         \Messier\ArrayHelper::Insert( [ 'foo', 'bar' ], [ 'baz', 'blub' ], 1 )
      );
      $this->assertEquals(
         [ 'foo', 'bar', 'baz', 'blub' ],
         \Messier\ArrayHelper::Insert( [ 'foo', 'bar' ], [ 'baz', 'blub' ], 5 )
      );
      # if ( $index === $cnt ) if ( \is_array( $element ) )


   }

   public function testRemove()
   {

      # Remove( array $array, int $index )
      $this->assertEquals(
         [ 'foo', 'baz' ],
         \Messier\ArrayHelper::Remove( [ 'foo', 'bar', 'baz' ], 1 )
      );
      $this->assertEquals(
         [ 'bar', 'baz' ],
         \Messier\ArrayHelper::Remove( [ 'foo', 'bar', 'baz' ], 0 )
      );
      $this->assertEquals(
         [ 'foo', 'bar', 'baz' ],
         \Messier\ArrayHelper::Remove( [ 'foo', 'bar', 'baz' ], 4 )
      );
      $this->assertEquals(
         [ 'foo', 'bar' ],
         \Messier\ArrayHelper::Remove( [ 'foo', 'bar', 'baz' ], 2 )
      );

   }

   public function testRemoveRange()
   {

      # RemoveRange( array $array, int $indexStart, int $length = null )
      $this->assertEquals(
         [ 'foo', 'bar' ],
         \Messier\ArrayHelper::RemoveRange( [ 'foo', 'bar', 'baz', 'blub', 'blob' ], 2 )
      );
      $this->assertEquals(
         [ 'foo', 'bar', 'blob' ],
         \Messier\ArrayHelper::RemoveRange( [ 'foo', 'bar', 'baz', 'blub', 'blob' ], 2, 2 )
      );
      $this->assertEquals(
         [ 'bar', 'baz', 'blub', 'blob' ],
         \Messier\ArrayHelper::RemoveRange( [ 'foo', 'bar', 'baz', 'blub', 'blob' ], -1, 1 )
      );
      $this->assertEquals(
         [ 'foo', 'bar', 'baz', 'blub', 'blob' ],
         \Messier\ArrayHelper::RemoveRange( [ 'foo', 'bar', 'baz', 'blub', 'blob' ], 5, 1 )
      );
      $this->assertEquals(
         [ 'blub', 'blob' ],
         \Messier\ArrayHelper::RemoveRange( [ 'foo', 'bar', 'baz', 'blub', 'blob' ], 0, -2 )
      );
      $this->assertEquals(
         [ 'blub', 'blob' ],
         \Messier\ArrayHelper::RemoveRange( [ 'foo', 'bar', 'baz', 'blub', 'blob' ], 0, -2 )
      );

   }

   public function testGetMaxDepth()
   {

      # GetMaxDepth( array $array )
      $this->assertSame(
         1,
         \Messier\ArrayHelper::GetMaxDepth( [ 'foo', 'bar', 'baz' ] )
      );
      $this->assertSame(
         0,
         \Messier\ArrayHelper::GetMaxDepth( [] )
      );
      $this->assertSame(
         2,
         \Messier\ArrayHelper::GetMaxDepth( [ 'foo', [ 1 ], 'baz' ] )
      );
      $this->assertSame(
         1,
         \Messier\ArrayHelper::GetMaxDepth( [ 'foo', [], 'baz' ] )
      );
      $this->assertSame(
         4,
         \Messier\ArrayHelper::GetMaxDepth( [ 'foo', [ 1, [ 'x' => [ 1, 3 ] ] ], 'baz' ] )
      );

   }

   public function testIsSingleDepth()
   {

      # IsSingleDepth( array $array )
      $this->assertFalse( \Messier\ArrayHelper::IsSingleDepth( [] ) );
      $this->assertTrue ( \Messier\ArrayHelper::IsSingleDepth( [ 1 ] ) );
      $this->assertTrue ( \Messier\ArrayHelper::IsSingleDepth( [ 1, 'foo' => 2 ] ) );
      $this->assertFalse( \Messier\ArrayHelper::IsSingleDepth( [ [ 1 ] ] ) );
      $this->assertTrue ( \Messier\ArrayHelper::IsSingleDepth( [ [] ] ) );

   }

   public function testExtract()
   {

      # Extract( array $array, int $startIndex, int $length = null )
      $this->assertEquals(
         [ 'foo','bar', 'baz', 'blub', 'blob' ],
         \Messier\ArrayHelper::Extract( [ 'foo','bar', 'baz', 'blub', 'blob' ], 0 )
      );
      $this->assertEquals(
         [ 'baz', 'blub', 'blob' ],
         \Messier\ArrayHelper::Extract( [ 'foo','bar', 'baz', 'blub', 'blob' ], 2 )
      );
      $this->assertEquals(
         [ 'baz', 'blub' ],
         \Messier\ArrayHelper::Extract( [ 'foo','bar', 'baz', 'blub', 'blob' ], 2, 2 )
      );
      $this->assertEquals(
         [],
         \Messier\ArrayHelper::Extract( [], 2, 2 )
      );
      $this->assertEquals(
         [],
         \Messier\ArrayHelper::Extract( [ 'foo','bar', 'baz', 'blub', 'blob' ], 5, 2 )
      );
      $this->assertEquals(
         [ 'blob' ],
         \Messier\ArrayHelper::Extract( [ 'foo','bar', 'baz', 'blub', 'blob' ], 4, 2 )
      );
      # $length == 0   $length < 0
      $this->assertEquals(
         [],
         \Messier\ArrayHelper::Extract( [ 'foo','bar', 'baz', 'blub', 'blob' ], 0, 0 )
      );
      $this->assertEquals(
         [ 'foo','bar', 'baz' ],
         \Messier\ArrayHelper::Extract( [ 'foo','bar', 'baz', 'blub', 'blob' ], 0, -2 )
      );

   }


}
