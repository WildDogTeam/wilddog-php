# Wilddog PHP Client

[![Build Status](https://drone.io/github.com/wilddogteam/wilddog-php/status.png)](https://drone.io/github.com/wilddogteam/wilddog-php/latest)


基于 [Wilddog REST API](https://z.wilddog.com/rest/quickstart).

### 示例
```php
const DEFAULT_URL = 'https://testing.wilddogio.com/';
const DEFAULT_TOKEN = 'xVUeUTLjTye5cS4ugiG6C5BStV0deHgfsCi6SG6W';
const DEFAULT_PATH = '/wilddog/example';

$wilddog = new \Wilddog\WilddogLib(DEFAULT_URL, DEFAULT_TOKEN);

// --- storing an array ---
$test = array(
    "foo" => "bar",
    "i_love" => "lamp",
    "id" => 42
);
$dateTime = new DateTime();
$wilddog->set(DEFAULT_PATH . '/' . $dateTime->format('c'), $test);

// --- storing a string ---
$wilddog->set(DEFAULT_PATH . '/name/contact001', "John Doe");

// --- reading the stored string ---
$name = $wilddog->get(DEFAULT_PATH . '/name/contact001');
```

### API列表
```php

// -- Wilddog API
$wilddog->set($path, $value);   // 存储数据
$value = $wilddog->get($path);  // 读取数据
$wilddog->delete($path);        // 删除数据
$wilddog->update($path, $data); // 更新数据
$wilddog->push($path, $data);   // push数据

// -- Wilddog PHP Library API
$wilddog->setToken($token);     // 设置用户token
$wilddog->setBaseURI($uri);     // 设置uri路径
$wilddog->setTimeOut($seconds); // 设置超时时间
```

详细的Rest API接口描述，请参考 [Wilddog REST API 文档](https://z.wilddog.com/rest/quickstart).

### Wilddog PHP Stub
Wilddog PHP Stub使得我们在集成phpunit做单元测试的时候，无需真正和Wilddog云端交互，它相当于一个mock。

要使用wilddogStub进行测试，需要让wilddog引用对象作为参数被传递进去，以便于在测试的时候可以很方便的替换为wilddogStub。

例如，如果代码是这样的：

```php
public function setWilddogValue($path, $value) {
  $wilddog = new Wilddog('https://testing.wilddogio.com', 'xVUeUTLjTye5cS4ugiG6C5BStV0deHgfsCi6SG6W');
  $wilddog->set($path, $value);
}
```

可以改为这样：

```php
public function setWilddogValue($path, $value, $wilddog) {
  $wilddog->set($path, $value);
}
```

进行phpunit单元测试：

```php
<?php
  require_once '<path>/lib/wilddogInterface.php';
  require_once '<path>/lib/wilddogStub.php';

  class MyClass extends PHPUnit_Framework_TestCase
  {
    public function testSetWilddogValue() {
      $myClass = new MyClass();
      $wilddogStub = new WilddogStub($uri, $token);
      $myClass->setWilddogValue($path, $value, $wilddogStub);
    }
  }
?>
```

### 单元测试
单元测试代码在/test目录下。测试运行方式如下：

```bash
$ phpunit test/wilddogTest.php
```

```bash
$ phpunit test/wilddogStubTest.php
```

### License
MIT
http://wilddog.mit-license.org/