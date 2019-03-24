<?php

/*
 * This file is part of Contao Test Bundle.
 *
 * (c) Marko Cupic by order of Erik Bender
 * @author Marko Cupic <https://github.com/markocupic/contao-test-bundle>
 * @license MIT
 */

$GLOBALS['TL_DCA']['tl_test'] = array
(

    // Config
    'config'      => array
    (
        'dataContainer'     => 'Table',
        'ctable'            => array('tl_test_page'),
        'enableVersioning'  => true,
        'onload_callback'   => array
        (),
        'oncut_callback'    => array
        (),
        'ondelete_callback' => array
        (),
        'onsubmit_callback' => array
        (),
        'sql'               => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
    ),

    // List
    'list'        => array
    (
        'sorting'           => array(
            'mode'            => 1,
            'fields'          => array('title'),
            'flag'            => 1,
            'panelLayout'     => 'filter;search,limit',
            'disableGrouping' => true
        ),
        'label'             => array
        (
            'fields' => array('title'),
            'format' => '%s',
            //'label_callback'          => array('tl_test', 'addIcon')
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations'        => array
        (
            'edit'       => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_test']['edit'],
                'href'  => 'table=tl_test_page',
                'icon'  => 'edit.svg'
            ),
            'editheader' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_test']['editheader'],
                'href'  => 'act=edit',
                'icon'  => 'header.svg',
                //'button_callback' => array('tl_calendar_container', 'editHeader')
            ),
            'copy'       => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_test']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.svg',
            ),
            'delete'     => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_test']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                //'button_callback'     => array('tl_test', 'deletePage')
            ),
            'show'       => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_test']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes'    => array
    (
        //'__selector__'                => array(),
        'default' => '{title_legend},title',
    ),

    // Subpalettes
    'subpalettes' => array
    (//
    ),

    // Fields
    'fields'      => array
    (
        'id'     => array
        (
            'label'  => array('ID'),
            'search' => true,
            'sql'    => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'title'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_test']['title'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''"
        ),
    )
);
