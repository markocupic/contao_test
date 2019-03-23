<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 22.03.2019
 * Time: 22:32
 */

$GLOBALS['TL_DCA']['tl_test_session_answer'] = array
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
                'id'                        => 'primary',
                'pid,testPageId' => 'index'
            )
        )
    ),
    // Fields
    'fields' => array
    (
        'id'            => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid'           => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp'        => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'testPageId'    => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'isCorrectAnswer'        => array
        (
            'sql' => "char(1) NOT NULL default ''"
        )
    )
);
