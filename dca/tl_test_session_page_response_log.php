<?php

/*
 * This file is part of Contao Test Bundle.
 *
 * (c) Marko Cupic by order of Erik Bender
 * @author Marko Cupic <https://github.com/markocupic/contao-test-bundle>
 * @license MIT
 */

$GLOBALS['TL_DCA']['tl_test_session_page_response_log'] = array
(

    // Config
    'config' => array
    (
        'dataContainer' => 'Table',
        'ptable'        => 'tl_test_session',
        'sql'           => array
        (
            'keys' => array
            (
                'id'             => 'primary',
                'pid,testPageId' => 'index'
            )
        )
    ),
    // Fields
    'fields' => array
    (
        'id'              => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid'             => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp'          => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'testPageId'      => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'trueAnswers'  => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'falseAnswers' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
    )
);
