<?php
namespace Wilddog;
class WilddogStubTest extends \PHPUnit_Framework_TestCase
{
  protected $_wilddogStub;
  const DEFAULT_URL = 'https://testing.wilddogio.com/';
  const DEFAULT_TOKEN = 'xVUeUTLjTye5cS4ugiG6C5BStV0deHgfsCi6SG6W';
  const DEFAULT_TIMEOUT = 10;
  const DEFAULT_PATH = 'example/path';
  const DEFAULT_DATA = '{"firstName": "Howdy", "lastName": "Doody"}';
  const DEFAULT_PUSH_DATA = '{"firstName": "1skdSDdksdlisS"}';
  const UPDATED_URI= 'https://testing.wilddogio.com/';
  const UPDATED_TOKEN = 'xVUeUTLjTye5cS4ugiG6C5BStV0deHgfsCi6SG6W';
  const UPDATED_TIMEOUT = 30;
  const INSECURE_URL = 'http://testing.wilddogio.com';
  const INVALID_DATA = '"firstName" "Howdy", "lastName": "Doody" "": ';
  const MISSING_DATA = '';
  const NULL_DATA = null;
  public function setUp()
  {
      $this->_wilddogStub = new WilddogStub(self::DEFAULT_URL, self::DEFAULT_TOKEN);
  }
  public function testBaseURIInitializationOnInstantiation()
  {
      $this->assertEquals(self::DEFAULT_TOKEN, $this->_wilddogStub->_token);
  }
  public function testSetBaseURI()
  {
      $actualResponse = $this->_wilddogStub->setBaseURI(self::UPDATED_URI);
      $this->assertEquals(null, $actualResponse);
      $this->assertEquals(self::UPDATED_URI, $this->_wilddogStub->_baseURI);
  }
  public function testTokenInitializationOnInstantiation()
  {
      $this->assertEquals(self::DEFAULT_TOKEN, $this->_wilddogStub->_token);
  }
  public function testSetToken()
  {
      $actualResponse = $this->_wilddogStub->setToken(self::UPDATED_TOKEN);
      $this->assertEquals(null, $actualResponse);
      $this->assertEquals(self::UPDATED_TOKEN, $this->_wilddogStub->_token);
  }
  public function testTimeoutInitializationOnInstantiation()
  {
      $this->assertEquals(self::DEFAULT_TIMEOUT, $this->_wilddogStub->_timeout);
  }
  public function testSetTimeout()
  {
      $actualResponse = $this->_wilddogStub->setTimeout(self::UPDATED_TIMEOUT);
      $this->assertEquals(null, $actualResponse);
      $this->assertEquals(self::UPDATED_TIMEOUT, $this->_wilddogStub->_timeout);
  }
  public function testSet()
  {
      $this->_wilddogStub->setResponse(self::DEFAULT_DATA);
      $actualResponse = $this->_wilddogStub->set(self::DEFAULT_PATH, self::DEFAULT_DATA);
      $this->assertEquals(self::DEFAULT_DATA, $actualResponse);
  }
  public function testPush()
  {
      $this->_wilddogStub->setResponse(self::DEFAULT_PUSH_DATA);
      $actualResponse = $this->_wilddogStub->push(self::DEFAULT_PATH, self::DEFAULT_DATA);
      $this->assertEquals(self::DEFAULT_PUSH_DATA, $actualResponse);
  }
  public function testUpdate()
  {
      $this->_wilddogStub->setResponse(self::DEFAULT_DATA);
      $actualResponse = $this->_wilddogStub->update(self::DEFAULT_PATH, self::DEFAULT_DATA);
      $this->assertEquals(self::DEFAULT_DATA, $actualResponse);
  }
  public function testDelete()
  {
      $actualResponse = $this->_wilddogStub->delete(self::DEFAULT_PATH, self::DEFAULT_DATA);
      $this->assertEquals(null, $actualResponse);
  }
  public function testInvalidBaseUri()
  {
    $wilddog = new WilddogStub(self::INSECURE_URL);
    $response = $wilddog->set(self::DEFAULT_PATH, self::DEFAULT_DATA);
    $this->assertEquals($this->_getErrorMessages('INSECURE_URL'), $response);
  }
  public function testInvalidData()
  {
    $response = $this->_wilddogStub->set(self::DEFAULT_PATH, self::INVALID_DATA);
    $this->assertEquals($this->_getErrorMessages('INVALID_JSON'), $response);
  }
  public function testMissingData()
  {
    $response = $this->_wilddogStub->set(self::DEFAULT_PATH, self::MISSING_DATA);
    $this->assertEquals($this->_getErrorMessages('NO_DATA'), $response);
  }
  public function testNullData()
  {
    $response = $this->_wilddogStub->set(self::DEFAULT_PATH, self::NULL_DATA);
    $this->assertEquals($this->_getErrorMessages('NO_DATA'), $response);
  }
  private function _getErrorMessages($errorCode) {
    $errorMessages = Array(
      'INSECURE_URL' => 'Wilddog does not support non-ssl traffic. Please try your request again over https.',
      'INVALID_JSON' => 'Invalid data; couldn\'t parse JSON object, array, or value. Perhaps you\'re using invalid characters in your key names.',
      'NO_DATA' => 'Missing data; Perhaps you forgot to send the data.'
    );
    return $errorMessages[$errorCode];
  }
}