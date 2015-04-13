<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'MemListing\Controller\Index' => 'MemListing\Controller\IndexController'
        )
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'mem' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/mem[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'MemListing\Controller\Index',
                        'action' => 'index',
                        'cache' => false
                    )
                )
            )

        )
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'memlisting' => __DIR__ . '/../view'
        ),
        /*'template_map' => array(
            'MemListing/layout' => __DIR__ . '/../view/layout/layout_pages.phtml'
        )*/
    )
);