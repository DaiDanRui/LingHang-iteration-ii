<?php
use Home\Model\BudgetModel;

/**
 * Created by PhpStorm.
 * User: darxan
* Date: 2016/4/3
* Time: 21:40
*/
function test()
{
    $model = new BudgetModel();
    $array = $model->selectAdd();
    echo 'have been called<br/>';
    dump($array);
    echo 'not pass';
}


function getCurrentTime()
{
    return date('Y-m-d H:i:s',time());
}
