# laravel-flash-message
[![Build Status](https://img.shields.io/travis/markdown-it/markdown-it/master.svg?style=flat)](https://github.com/kaoken/laravel-flash-message)
[![composer version](https://img.shields.io/badge/version-1.0.2-blue.svg)](https://github.com/kaoken/laravel-flash-message)
[![licence](https://img.shields.io/badge/licence-MIT-blue.svg)](https://github.com/kaoken/laravel-flash-message)
[![laravel version](https://img.shields.io/badge/Laravel%20version-≧5.5-red.svg)](https://github.com/kaoken/laravel-flash-message)

Laravelで、簡単なフラッシュメーセージを使いたい場合にどうぞ！

__コンテンツの一覧__

- [インストール](#インストール)
- [初期設定](#初期設定)
- [メソッド一覧](#メソッド一覧)
- [使用例](#使用例)
- [ライセンス](#ライセンス)

## インストール

**composer**:

```bash
composer install kaoken/laravel-flash-message
```

## 初期設定

#### **`config\app.php` に以下のように追加：**
``` config\app.php
    'providers' => [
        ...
        Kaoken\FlashMessage\FlashMessageServiceProvider::class,
    ],

    'aliases' => [
        ...
        'FlashMessage' => Kaoken\FlashMessage\Facades\FlashMessage::class,
    ],
```

### ミドルウェア
下記のミドルウェアで、`FlashMessage`をインスタンス化した`$flashMessage`という変数で、全て、または一部のBladeテンプレートで使用できるようにする為のもので、  
`view('test',['flashMessage' => FlashMessage::getInstance()])`という感じに、個々で使用したい場合は、追加しないこと。  

#### **`app\Http\Kernel.php` に以下のように追加：**

``` app\Http\Kernel.php
//-----------------------------------------------------
 * protected $middleware = [
 *    ...
 *    Kaoken\FlashMessage\FlashMessageMiddleware:class
//-----------------------------------------------------
// または
protected $middlewareGroups = [
   'web' => [
       ...
       Kaoken\FlashMessage\FlashMessageMiddleware:class
//-----------------------------------------------------
// または
protected $routeMiddleware = [
   ...
   'flash.message' => Kaoken\FlashMessage\FlashMessageMiddleware:class
```

## メソッド一覧
|メソッド一覧 |説明|
|:------|:----|
|getInstance()|自身インスタンスを返す。|
|hasSuccess()|成功メッセージがあるか？ある場合は'true'を返す。|
|hasInfo()|情報メッセージがあるか？ある場合は'true'を返す。|
|hasWarnings()|警告メッセージがあるか？ある場合は'true'を返す。|
|hasError()|エラーメッセージがあるか？ある場合は'true'を返す。|
|successes()|成功メッセージを配列で取得する。|
|info()|情報メッセージを配列で取得する。|
|warnings()|警告メッセージを配列で取得する。|
|errors()|エラーメッセージを配列で取得する。|
|pushSuccess($msg)|成功メッセージを加える。`$msg`の型は何でも良い。通常は、文字列を使用する。|
|pushInfo($msg)|情報メッセージを加える。`$msg`の型は何でも良い。通常は、文字列を使用する。|
|pushWarning($msg)|警告メッセージを加える。`$msg`の型は何でも良い。通常は、文字列を使用する。|
|pushError($msg)|エラーメッセージを加える。`$msg`の型は何でも良い。通常は、文字列を使用する。|

## 使用例
`Test`コントローラー
``` php
<?php
namespace app\Http\Controllers;

use FlashMessage;
use App\Library\Http\Controllers\Controller;

class Test extends Controller
{
    public function getTest01()
    {
        // 文字列のみ
        FlashMessage::pushSuccess('This is test messege');
        // 任意のオブジェクト
        $o = new \stdClass();
        $o->title = 'title 01';
        $o->text = 'text 01';
        FlashMessage::pushError($o);
        $o = new \stdClass();
        $o->title = 'title 02';
        $o->text = 'text 02';
        FlashMessage::pushError($o);

        return redirect('test02');
    }
    public function getTest02()
    {
        return view('test');
    }
}

```

`test.blade.php`テスト用テンプレート
``` php
@php
  $errorMessages = $flashMessage->errors();
  $successMessages = $flashMessage->successes();
@endphp

{{--成功メッセージ--}}
@if( $flashMessage->hasSuccess() )
  <h1>成功メッセージ</h1>
  @for($i=0;$i<count($successMessages);$i++)
    <hr />
    {{$successMessages[$i]}}
  @endfor
  <hr />
@endif

{{--エラーメッセージ--}}
@if( $flashMessage->hasError() )
  <h1>エラーメッセージ-</h1>
  @for($i=0;$i<count($errorMessages);$i++)
    <hr />
    {{ $errorMessages[$i]->title }}<br />
    {{ $errorMessages[$i]->text }}<br />
  @endfor
  <hr />
@endif
```


例えば、最初の接続で`http://hoge/test01`,`Test@getTest01`呼び出した場合、`FlashMessage`でメッセージが保存される。  
次の接続で、`http://hoge/test02`,`Test@getTest02`呼び出した場合、テスト用テンプレート`test.blade.php`が表示され、
このとき下記のように表示される。
```html
<h1>成功メッセージ</h1>
<hr />
This is test messege
<hr />


<h1>エラーメッセージ-</h1>
<hr />
title 01<br />
text 01<br />
<hr />
title 02<br />
text 02<br />
<hr />
```
更新ボタンを押すと、`FlashMessage`内の全てのメッセージ削除され、表示されなくなる。


## ライセンス

[MIT](https://github.com/markdown-it/markdown-it/blob/master/LICENSE)

