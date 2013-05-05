<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Instrument\Controller\Instrument'   => 'Instrument\Controller\InstrumentController',
            'Instrument\Controller\Feature'      => 'Instrument\Controller\FeatureController',
            'Instrument\Controller\Category'     => 'Instrument\Controller\CategoryController',
            'Instrument\Controller\Equiptype'    => 'Instrument\Controller\EquiptypeController',
            'Instrument\Controller\Equipment'    => 'Instrument\Controller\EquipmentController',
            'Instrument\Controller\Equipfeat'    => 'Instrument\Controller\EquipfeatController',
            'Instrument\Controller\EFMultiEquip' => 'Instrument\Controller\EFMultiEquipController',
            'Instrument\Controller\Booking'      => 'Instrument\Controller\BookingController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'instrument' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/instrument[/:action][/:ibacode]',
                    'constraints' => array(
                        'action' => '[a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Instrument\Controller\Instrument',
                        'action' => 'index',
                    ),
                ),
            ),
            'feature' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/feature[/:action][/:ibacode]',
                    'constraints' => array(
                        'action' => '[a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Instrument\Controller\Feature',
                        'action' => 'index',
                    ),
                ),
            ),
            'category' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/category[/:action][/:iabcode]',
                    'constraints' => array(
                        'action' => '[a-zA-Z0-9_-]*',
                        'iabcode' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Instrument\Controller\Category',
                        'action' => 'index',
                    ),
                ),
            ),
            'equiptype' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/equiptype[/:action][/:iaccode]',
                    'constraints' => array(
                        'action' => '[a-zA-Z0-9_-]*',
                        'iaccode' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Instrument\Controller\Equiptype',
                        'action' => 'index',
                    ),
                ),
            ),
            'equipment' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/equipment[/:action][/:iadid]',
                    'constraints' => array(
                        'action' => '[a-zA-Z0-9_-]*',
                        'iadid' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Instrument\Controller\Equipment',
                        'action' => 'index',
                    ),
                ),
            ),

            /*
             * Equipment features
             */
            'equipfeat' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/equipfeat[/:action][/:ibbfeacode][/:ibbinsid]',
                    'constraints' => array(
                        'action' => '[a-zA-Z0-9_-]*',
                        'ibbfeacode' => '[a-zA-Z0-9_-]*',
                        'ibbinsid' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Instrument\Controller\Equipfeat',
                        'action' => 'index',
                    ),
                ),
            ),

            /*
             * Equipment features - multi entry
             */
            'efmultiequip' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/efmultiequip[/:action][/:instrumentcode]',
                    'constraints' => array(
                        'action' => '[a-zA-Z0-9_-]*',
                        'instrumentcode' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Instrument\Controller\EFMultiEquip',
                        'action' => 'addefme',
                    ),
                ),
            ),
            
            'booking' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/booking[/:action][/:ibcbookno]',
                    'constraints' => array(
                        'action' => '[a-zA-Z0-9_-]*',
                        'ibcbookno' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Instrument\Controller\Booking',
                        'action' => 'index',
                    ),
                ),
            ),
            
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'instrument' => __DIR__ . '/../view',
        ),
    ),
    
    'di' => array(
      'Instrument\Model\Equipment' => array(
        'parameters' => array(
          'adapter'  => 'Zend\Db\Adapter\Adapter',
        ),
      ),
    ),

);