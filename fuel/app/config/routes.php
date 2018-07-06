<?php
return [
    '_root_' => 'welcome/index',  // The default route
    '_404_' => 'welcome/404',    // The main 404 route
    
    'hello(/:name)?' => ['welcome/hello', 'name' => 'hello'],
];
