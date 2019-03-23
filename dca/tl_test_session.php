<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 22.03.2019
 * Time: 22:32
 */

$GLOBALS['TL_DCA']['tl_test_session'] = array
(

    // Config
    'config' => array
    (
        'dataContainer' => 'Table',
        'ctable'        => array('tl_test_session_answer'),
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
