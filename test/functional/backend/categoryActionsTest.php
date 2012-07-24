<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new JobeetTestFunctional(new sfBrowser());
$browser->loadData();

$browser->
  info('1 - Authentication')->      
  get('/category')->
  click('Signin', array(
    'signin' => array('username' => 'admin', 'password' => 'admin'),
    array('_with_csrf' => true)
  ))->
        
  with('response')->isRedirected()->
  followRedirect()->
  
  info('2 - Request for module, action')->
  with('request')->begin()->      
    info('  2.1 - Request for module = category')->
    isParameter('module', 'category')->
    isParameter('action', 'index')->
  end()->
        
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;