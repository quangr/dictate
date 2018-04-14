<?php
$app->get('/', function(){
    return 'asd';
});
$app->get('word/{word}', 'WordController@show');
