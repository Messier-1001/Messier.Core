<?php


/**
 * Created by PhpStorm.
 * User: messier
 * Date: 17.12.16
 * Time: 22:06
 */
class GlobalFunctionTest extends PHPUnit_Framework_TestCase
{

   public function testSubstring()
   {
      $this->assertEquals( 'ä'  , \Messier\substring( 'ä…', 0, 1 )                        , 'Assert 1 fails' );
      $this->assertEquals( 'ä'  , \Messier\substring( 'ä…', 0, -1 )                       , 'Assert 2 fails' );
      $this->assertEquals( '…'  , \Messier\substring( 'ä…', 1 )                           , 'Assert 3 fails' );
      $this->assertEquals( '…'  , \Messier\substring( 'ä…', 1, 2 )                        , 'Assert 4 fails' );
      $this->assertEquals( 'äAö', \Messier\substring( 'äAöÖüÜß', 0, -4 )                  , 'Assert 5 fails' );
      $this->assertEquals( 'ö'  , \Messier\substring( 'äAöÖüÜß', 2, -4 )                  , 'Assert 6 fails' );
      $this->assertEquals( '·…' , \Messier\substring( '»«¢„“”µ·…–ĸŋđðſæ@ł€¶ŧ←↓→øþ', 7, 2 ), 'Assert 7 fails' );
   }

   public function testStrPos()
   {
      $this->assertSame ( 3,  \Messier\strPos( '-äx…ü', '…' )                       , 'Assert 1 fails' );
      $this->assertSame ( 1,  \Messier\strPos( 'äAöÖüÜß', 'AÖ', true )              , 'Assert 2 fails' );
      $this->assertSame ( 9,  \Messier\strPos( '»«¢„“”µ·…–ĸŋđðſæ@ł€¶ŧ←↓→øþ', '–ĸŋ' ), 'Assert 3 fails' );
      $this->assertSame ( -1, \Messier\strPos( 'äAöÖüÜß', 'AÖ' )                    , 'Assert 4 fails' );
   }

   public function testStrLastPos()
   {
      $this->assertSame ( 5 , \Messier\strLastPos( '-äx…ü…', '…' )                         , 'Assert 1 fails' );
      $this->assertSame ( 5 , \Messier\strLastPos( 'äAöÖüaÖÜß', 'AÖ', true )               , 'Assert 2 fails' );
      $this->assertSame ( 18, \Messier\strLastPos( '»«¢„“”µ·…–ĸŋđðſæ@ł–ĸŋ€¶ŧ←↓→øþ', '–ĸŋ' ), 'Assert 3 fails' );
      $this->assertSame ( -1, \Messier\strLastPos( 'äAöÖüÜß', 'AÖ' )                       , 'Assert 4 fails' );
   }

   public function testStrPositions()
   {
      $this->assertEquals( [ 3, 5 ],  \Messier\strPositions( '-äx…ü…', '…' ), 'Assert 1 fails' );
      $this->assertNull  (            \Messier\strPositions( 'äAöÖüÜß', 'AÖ' ), 'Assert 2 fails' );
      $this->assertEquals( [ 1, 5 ],  \Messier\strPositions( 'äAöÖüaÖÜß', 'AÖ', true ), 'Assert 3 fails' );
      $this->assertEquals( [ 9, 18 ], \Messier\strPositions( '»«¢„“”µ·…–ĸŋđðſæ@ł–ĸŋ€¶ŧ←↓→øþ', '–ĸŋ' ), 'Assert 4 fails' );
   }

   public function testStrStartsWith()
   {
      $this->assertTrue ( \Messier\strStartsWith( '·-äx…ü…', '·-' )                     , 'Assert 1 fails' );
      $this->assertFalse( \Messier\strStartsWith( 'AöÖüÜß', 'AÖ' )                      , 'Assert 2 fails' );
      $this->assertTrue ( \Messier\strStartsWith( 'AöÖüaÖÜß', 'AÖ', true )              , 'Assert 3 fails' );
      $this->assertTrue ( \Messier\strStartsWith( '»«¢„“”µ·…–ĸŋđðſæ@ł–ĸŋ€¶ŧ←↓→øþ', '»' ), 'Assert 4 fails' );
      $this->assertTrue ( \Messier\strStartsWith( 'ł–ĸŋ€¶ŧ←↓→øþ', 'ł' )                 , 'Assert 5 fails' );
   }

   public function testStrEndsWith()
   {
      $this->assertTrue ( \Messier\strEndsWith( '·-äx…ü…', 'ü…' )                     , 'Assert 1 fails' );
      $this->assertFalse( \Messier\strEndsWith( 'AöÖüÜß', 'üß' )                      , 'Assert 2 fails' );
      $this->assertTrue ( \Messier\strEndsWith( 'AöÖüaÖÜß', 'üß', true )              , 'Assert 3 fails' );
      $this->assertTrue ( \Messier\strEndsWith( '»«¢„“”µ·…–ĸŋđðſæ@ł–ĸŋ€¶ŧ←↓→øþ', 'þ' ), 'Assert 4 fails' );
      $this->assertTrue ( \Messier\strEndsWith( 'ł–ĸŋ€¶ŧ←↓→øþ', '→øþ' )               , 'Assert 5 fails' );
   }

   public function testStrContains()
   {
      $this->assertTrue ( \Messier\strContains( '·-äx…ü…', 'äx…' )                    , 'Assert 1 fails' );
      $this->assertFalse( \Messier\strContains( 'AöÖüÜß', 'ööÜ' )                     , 'Assert 2 fails' );
      $this->assertTrue ( \Messier\strContains( 'AöÖüaÖÜß', 'ööÜ', true )             , 'Assert 3 fails' );
      $this->assertTrue ( \Messier\strContains( '»«¢„“”µ·…–ĸŋđðſæ@ł–ĸŋ€¶ŧ←↓→øþ', 'æ' ), 'Assert 4 fails' );
      $this->assertTrue ( \Messier\strContains( 'ł–ĸŋ€¶ŧ←↓→øþ', '←↓→' )               , 'Assert 5 fails' );
   }

   public function testEscapeXML()
   {
      $this->assertEquals(
         '&lt;foo id="12"&gt; &amp;äöü',
         \Messier\escapeXML( '<foo id="12"> &äöü' ),
         'Assert 1 fails' );
   }

   public function testEscapeXMLArg()
   {
      $this->assertEquals(
         '&lt;foo id=&quot;12&quot; b=&#39;0&#39;&gt; &amp;äöü',
         \Messier\escapeXMLArg( '<foo id="12" b=\'0\'> &äöü' ),
         'Assert 1 fails' );
   }

   public function testEscape()
   {
      $this->assertEquals(
         '&lt;foo id=&quot;12&quot; b=&#39;0&#39;&gt; &amp;äöü',
         \Messier\escape( '<foo id="12" b=\'0\'> &äöü', \Messier\ESCAPE_HTML_ALL ),
         'Assert 1 fails' );
      $this->assertEquals(
         '%3Cfoo+id%3D%2212%22+b%3D%270%27%3E+%3Fx%3D%E2%80%A6%26%C3%A4%C3%B6%C3%BC%26a14%3D1',
         \Messier\escape( '<foo id="12" b=\'0\'> ?x=…&äöü&a14=1', \Messier\ESCAPE_URL ),
         'Assert 2 fails' );
      $this->assertEquals(
         '"Foo bar baz \"\" Bl\u00fcb \u2026\u00b7\u201d\u201c\u201e\u00a2\u00ab\u00bb|\u00e6\u017f\u00f0\u0111\u014b\u0127"',
         \Messier\escape( 'Foo bar baz "" Blüb …·”“„¢«»|æſðđŋħ', \Messier\ESCAPE_JSON ),
         'Assert 3 fails' );
      $this->assertEquals(
         '&lt;foo id="12" b=\'0\'&gt; &amp;äöü',
         \Messier\escape( '<foo id="12" b=\'0\'> &äöü', \Messier\ESCAPE_HTML ),
         'Assert 4 fails' );
   }

   public function testUnescapeXML()
   {
      $this->assertEquals(
         '<foo id="12" b=\'0\'> &äöü',
         \Messier\unescapeXML( '&lt;foo id=&quot;12&quot; b=&#39;0&#39;&gt; &amp;äöü' ),
         'Assert 1 fails' );
   }

   public function testStrMax()
   {
      $this->assertEquals(
         'aÖ»«¢„…',
         \Messier\strMax( 'aÖ»«¢„“”µ·…–ĸŋđðſæ@ł€¶ŧ←↓→øþ', 7, '…' ),
         'Assert 1 fails' );
      $this->assertEquals(
         'aÖ»«¢„',
         \Messier\strMax( 'aÖ»«¢„“”µ·…–ĸŋđðſæ@ł€¶ŧ←↓→øþ', 6, '' ),
         'Assert 2 fails' );
   }

   public function testStrIReplace()
   {
      $this->assertEquals(
         'a--øþ',
         \Messier\strIReplace( 'Ö»«¢„“”µ·…–ĸŋđðſæ@ł€¶ŧ←↓→', '--', 'aÖ»«¢„“”µ·…–ĸŋđðſæ@ł€¶ŧ←↓→øþ' ),
         'Assert 1 fails' );
      $this->assertEquals(
         'äÄÜß',
         \Messier\strIReplace( 'öÖÜ', '', 'äÄöÖüÜß' ),
         'Assert 2 fails' );
      $this->assertEquals(
         'äÄøÆöÖüÜß',
         \Messier\strIReplace( 'øÆ', '', 'äÄøØæÆöøæÖüÜß' ),
         'Assert 3 fails' );
      $this->assertEquals(
         'äÄøØæÆöÖüÜß',
         \Messier\strIReplace( 'øÆ', '', 'äÄøØæÆöÖüÜß', false ),
         'Assert 4 fails' );
   }

   public function testStripTags()
   {
      $this->assertEquals( 'Foo x', \Messier\stripTags( '<b>Foo</b> x' ), 'Assert 1 fails' );
      $this->assertEquals( 'Foo', \Messier\stripTags( '<!-- Blub --><strong>Foo</strong>' ), 'Assert 2 fails' );
      $this->assertEquals( 'Foo', \Messier\stripTags( '<script>foo();</script>Foo' ), 'Assert 3 fails' );
   }

   public function testSplitLines()
   {
      $this->assertEquals(
         [ '»«¢„“”', 'µ·…–ĸ', 'ŋđðſæ@ł–ĸŋ', '€¶ŧ←↓→øþ' ],
         \Messier\splitLines( "»«¢„“”\nµ·…–ĸ\r\nŋđðſæ@ł–ĸŋ\r€¶ŧ←↓→øþ" ),
         'Assert 1 fails' );
   }


}

