<?php
namespace Wilddog;
use Exception;
class WilddogTest extends \PHPUnit_Framework_TestCase
{
  protected $_wilddog;
  protected $_todoMilk = array(
    'name' => 'Pick the milk',
    'priority' => 1
  );
  protected $_todoBeer = array(
    'name' => 'Pick the beer',
    'priority' => 2
  );
  protected $_todoLEGO = array(
    'name' => 'Pick the LEGO',
    'priority' => 3
  );
  // --- set up your own database here
  const DEFAULT_URL = 'https://testing.wilddogio.com/';
  const DEFAULT_TOKEN = 'xVUeUTLjTye5cS4ugiG6C5BStV0deHgfsCi6SG6W';
  const DEFAULT_TODO_PATH = '/sample/todo';
  const DELETE_PATH = '/sample';
  const DEFAULT_SET_RESPONSE = '{"name":"Pick the milk","priority":1}';
  const DEFAULT_UPDATE_RESPONSE = '{"name":"Pick the beer","priority":2}';
  const DEFAULT_PUSH_RESPONSE = '{"name":"Pick the LEGO","priority":3}';
  const DEFAULT_DELETE_RESPONSE = 'null';
  const DEFAULT_URI_ERROR = 'You must provide a baseURI variable.';
  public function setUp()
  {
    $this->_wilddog = new WilddogLib(self::DEFAULT_URL, self::DEFAULT_TOKEN);
  }
  public function testNoBaseURI()
  {
    $errorMessage = null;
    try {
      new WilddogLib();
    } catch (Exception $e) {
      $errorMessage = $e->getMessage();
    }
    $this->assertEquals(self::DEFAULT_URI_ERROR, $errorMessage);
  }
  public function testSet()
  {
    $response = $this->_wilddog->set(self::DEFAULT_TODO_PATH, $this->_todoMilk);
    $this->assertEquals(self::DEFAULT_SET_RESPONSE, $response);
  }
  public function testGetAfterSet()
  {
    $response = $this->_wilddog->get(self::DEFAULT_TODO_PATH);
    $this->assertEquals(self::DEFAULT_SET_RESPONSE, $response);
  }
  public function testUpdate()
  {
    $response = $this->_wilddog->update(self::DEFAULT_TODO_PATH, $this->_todoBeer);
    $this->assertEquals(self::DEFAULT_UPDATE_RESPONSE, $response);
  }
  public function testGetAfterUpdate()
  {
    $response = $this->_wilddog->get(self::DEFAULT_TODO_PATH);
    $this->assertEquals(self::DEFAULT_UPDATE_RESPONSE, $response);
  }
  public function testPush()
  {
    $response = $this->_wilddog->push(self::DEFAULT_TODO_PATH, $this->_todoLEGO);
    $this->assertRegExp('/{"name"\s?:\s?".*?}/', $response);
    return $this->parsePushResponse($response);
  }
  /**
   * @depends testPush
  */
  public function testGetAfterPush($responseName)
  {
    $response = $this->_wilddog->get(self::DEFAULT_TODO_PATH . '/' . $responseName);
    $this->assertEquals(self::DEFAULT_PUSH_RESPONSE, $response);
  }
  public function testDelete()
  {
    $response = $this->_wilddog->delete(self::DELETE_PATH);
    $this->assertEquals(self::DEFAULT_DELETE_RESPONSE, $response);
  }
  public function testGetAfterDELETE()
  {
    $response = $this->_wilddog->get(self::DEFAULT_TODO_PATH);
    $this->assertEquals(self::DEFAULT_DELETE_RESPONSE, $response);
  }
  private function parsePushResponse($response) {
    $responseObj = json_decode($response);
    return $responseObj->name;
  }
}