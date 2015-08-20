# yii2-contextmenu
yii2 Extended for bootstrap-contextmenu
===============================
yii2 Extended for bootstrap-contextmenu plugin https://github.com/sydcanem/bootstrap-contextmenu






Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
 composer require --prefer-dist liyunfang/yii2-contextmenu
```

or add

```
"liyunfang/yii2-contextmenu": "*"
```

to the require section of your `composer.json` file.

Requirements
------------
This extension require twitter-bootstrap

Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
        [
            'class' => \liyunfang\contextmenu\SerialColumn::className(),
            'contextmenu' => true,
            'contextMenuPrefixAttribute' => 'id',
            //'template' => '{view} {update}', 
        ],
 ```
