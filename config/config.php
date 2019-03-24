<?php

/*
 * This file is part of Contao Test Bundle.
 *
 * (c) Marko Cupic by order of Erik Bender
 * @author Marko Cupic <https://github.com/markocupic/contao-test-bundle>
 * @license MIT
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