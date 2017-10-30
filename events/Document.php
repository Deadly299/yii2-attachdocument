<?php
namespace deadly299\attachdocument\events;

use yii\base\Event;

class Document extends Event
{
    public $model;
    public $document;
}