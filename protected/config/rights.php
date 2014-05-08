<?php

return array(
    // Гость может только авторизоваться
    'guest' => array(
      'users' => array('login'),
      'cp' => array('error'),
      'files' => array('admin' => array('download')),    
      'site',
    ),

'administrator' => array(
      'cp',
      'banners',
      'feedback',
      'files',
      'pages',
      'settings',
      'users',
    ),

);