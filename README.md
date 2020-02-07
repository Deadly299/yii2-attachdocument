yii2-attachdocument
===================
yii2-attach document add document to your model

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist deadly299/yii2-attachdocument "*"
```

or add

```
"deadly299/yii2-attachdocument": "*"
```

php yii migrate --migrationPath=vendor/deadly299/yii2-attachdocument/migrations


to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \deadly299\attachdocument\widgets\UploadFiles::widget(['model' => $model, 'dataOptionsLink' => ['data-fancybox' => 'single']]) ?>
