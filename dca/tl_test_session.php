<?php

/*
 * This file is part of Contao Test Bundle.
 *
 * (c) Marko Cupic by order of Erik Bender
 * @author Marko Cupic <https://github.com/markocupic/contao-test-bundle>
 * @license MIT
 */

$GLOBALS['TL_DCA']['tl_test_session'] = array
(

    // Config
    'config' => array
    (
        'dataContainer' => 'Table',
        'ctable'        => array('tl_test_session_page_response_log'),
        'sql'           => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'testId,memberId' => 'index'
            )
        )
    ),
    // Fields
    'fields' => array
    (
        'id'          => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp'      => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'testId'      => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'timeStart'   => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'timeEnd'     => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'hasFinished' => array
        (
            'sql' => "char(1) NOT NULL default ''"
        ),
        'memberId'    => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
    )
);
