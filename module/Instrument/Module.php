<?php
namespace Instrument;

use Instrument\Model\Feature;
use Instrument\Model\FeatureTable;
use Instrument\Model\Category;
use Instrument\Model\CategoryTable;
use Instrument\Model\Equiptype;
use Instrument\Model\EquiptypeTable;
use Instrument\Model\Equipment;
use Instrument\Model\EquipmentTable;
use Instrument\Model\Equipfeat;
use Instrument\Model\EquipfeatTable;
use Instrument\Model\EFMulti;
use Instrument\Model\EFMultiEquip;
use Instrument\Model\Booking;
use Instrument\Model\BookingTable;
use Instrument\Model\BookFeat;
use Instrument\Model\BookFeatTable;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module {
    public function getAutoLoaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig() {
        return array(
            'factories' => array(
                /*
                 * Features
                 */
                'Instrument\Model\FeatureTable' => function($sm) {
                  $tableGateway = $sm->get('FeatureTableGateway');
                  $table = new FeatureTable($tableGateway);
                  return $table;
                },
                'FeatureTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Feature());
                    return new TableGateway('ibafea', $dbAdapter, null, $resultSetPrototype);
                },
                /*
                 * Categories
                 */
                'Instrument\Model\CategoryTable' => function($sm) {
                  $tableGateway = $sm->get('CategoryTableGateway');
                  $table = new CategoryTable($tableGateway);
                  return $table;
                },
                'CategoryTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Category());
                    return new TableGateway('iabcat', $dbAdapter, null, $resultSetPrototype);
                },
                /*
                 * Equipment Types
                 */
                'Instrument\Model\EquiptypeTable' => function($sm) {
                  $tableGateway = $sm->get('EquiptypeTableGateway');
                  $table = new EquiptypeTable($tableGateway);
                  return $table;
                },
                'EquiptypeTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Equiptype());
                    return new TableGateway('iaceqt', $dbAdapter, null, $resultSetPrototype);
                },
                /*
                 * Equipment
                 */
                'Instrument\Model\equipmentTable' => function($sm) {
                  $tableGateway = $sm->get('EquipmentTableGateway');
                  $table = new EquipmentTable($tableGateway);
                  return $table;
                },
                'EquipmentTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Equipment());
                    return new TableGateway('iadins', $dbAdapter, null, $resultSetPrototype);
                },

                /*
                 * Equipment features
                 */
                'Instrument\Model\equipfeatTable' => function($sm) {
                  $tableGateway = $sm->get('EquipfeatTableGateway');
                  $table = new EquipfeatTable($tableGateway);
                  return $table;
                },
                'EquipfeatTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Equipfeat());
                    return new TableGateway('ibbife', $dbAdapter, null, $resultSetPrototype);
                },
                        
                /*
                 * Bookings
                 */
                'Instrument\Model\bookingTable' => function($sm) {
                  $tableGateway = $sm->get('BookingTableGateway');
                  $table = new BookingTable($tableGateway);
                  return $table;
                },
                'BookingTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Booking());
                    return new TableGateway('ibcibk', $dbAdapter, null, $resultSetPrototype);
                },
                'Instrument\Model\bookfeatTable' => function($sm) {
                  $tableGateway = $sm->get('BookFeatTableGateway');
                  $table = new BookFeatTable($tableGateway);
                  return $table;
                },
                'BookFeatTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new BookFeat());
                    return new TableGateway('ibdbfe', $dbAdapter, null, $resultSetPrototype);
                },

                        
                /*
                 * Adapter injections
                 */
                'Instrument\Model\Equipment' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $v_equipment = new \Instrument\Model\Equipment();
                    $v_equipment->setDbAdapter($dbAdapter);
                    return $v_equipment;
                },
                 'Instrument\Model\Equipment' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $v_equipment = new \Instrument\Model\Booking();
                    $v_equipment->setDbAdapter($dbAdapter);
                    return $v_equipment;
                },
               'Instrument\Model\Equipfeat' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $v_equipfeat = new \Instrument\Model\Equipfeat();
                    $v_equipfeat->setDbAdapter($dbAdapter);
                    return $v_equipfeat;
                },
                'Instrument\Model\EFMultiEquip' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $v_equipment = new \Instrument\Model\EFMultiEquip();
                    $v_equipment->setDbAdapter($dbAdapter);
                    return $v_equipment;
                },
                'Instrument\Model\EFMulti' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $v_equipment = new \Instrument\Model\EFMulti();
                    $v_equipment->setDbAdapter($dbAdapter);
                    return $v_equipment;
                },
                'Instrument\Model\Booking' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $v_booking = new \Instrument\Model\Booking();
                    $v_booking->setDbAdapter($dbAdapter);
                    return $v_booking;
                },
                'Instrument\Form\BookingFieldset' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $v_booking = new \Instrument\Form\BookingFieldset();
                    $v_booking->setDbAdapter($dbAdapter);
                    return $v_booking;
                },
               'Instrument\Model\BookFeat' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $v_bookfeat = new \Instrument\Model\BookFeat();
                    $v_bookfeat->setDbAdapter($dbAdapter);
                    return $v_bookfeat;
                },
            ),
        );
    }

}