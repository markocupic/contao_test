<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 22.03.2019
 * Time: 20:45
 */

// Back end modules
$GLOBALS['BE_MOD']['testmodules'] = array
    (
        'test' => array
        (
            'tables'      => array('tl_test','tl_test_page', 'tl_test_question')
        )
    );

// Front end modules
array_insert($GLOBALS['FE_MOD'], 2, array
(
    'testmodules' => array
    (
        'testform'    => 'Contao\ModuleTestForm',
    )
));