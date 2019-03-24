<?php

/*
 * This file is part of Contao Test Bundle.
 *
 * (c) Marko Cupic by order of Erik Bender
 * @author Marko Cupic <https://github.com/markocupic/contao-test-bundle>
 * @license MIT
 */

$GLOBALS['TL_DCA']['tl_test_question'] = array
(

    // Config
    'config'      => array
    (
        'dataContainer'     => 'Table',
        'ptable'            => 'tl_test_page',
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
                'id'  => 'primary',
                'pid' => 'index'
            )
        ),
    ),

    // List
    'list'        => array
    (
        'sorting'           => array
        (
            'mode'                  => 4,
            'fields'                => array('sorting'),
            'icon'                  => 'pagemounts.svg',
            //'paste_button_callback' => array('tl_test_question', 'pastePage'),
            'panelLayout'           => 'filter;search',
            'headerFields'          => array('title'),
            'child_record_callback' => array('tl_test_question', 'listTest'),
            'disableGrouping'       => true
        ),
        'label'             => array
        (
            'fields' => array('question'),
            'format' => '%s',
            //'label_callback' => array('tl_test_question', 'addIcon')
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
            'edit'   => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_test_question']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.svg',
                //'button_callback' => array('tl_test_question', 'editPage')
            ),
            'copy'   => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_content']['copy'],
                'href'       => 'act=paste&amp;mode=copy',
                'icon'       => 'copy.svg',
                'attributes' => 'onclick="Backend.getScrollOffset()"'
            ),
            'cut'    => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_content']['cut'],
                'href'       => 'act=paste&amp;mode=cut',
                'icon'       => 'cut.svg',
                'attributes' => 'onclick="Backend.getScrollOffset()"'
            ),
            'delete' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_test_question']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                //'button_callback' => array('tl_test_question', 'deletePage')
            ),

            'show' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_test_question']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes'    => array
    (
        //'__selector__'                => array(),
        'default' => '{question_legend},headline,questionText,questionAnswer,htmlPre,htmlPost'
    ),

    // Subpalettes
    'subpalettes' => array
    (//
    ),

    // Fields
    'fields'      => array
    (
        'id'             => array
        (
            'label'  => array('ID'),
            'search' => true,
            'sql'    => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid'            => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting'        => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp'         => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'headline'       => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_test_question']['headline'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => false, 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''"
        ),
        'htmlPre'        => array
        (
            'label'       => &$GLOBALS['TL_LANG']['tl_test_question']['htmlPre'],
            'exclude'     => true,
            'search'      => true,
            'inputType'   => 'textarea',
            'eval'        => array('allowHtml' => true, 'class' => 'monospace', 'rte' => 'tinyMCE', 'helpwizard' => true),
            'explanation' => 'insertTags',
            'sql'         => "mediumtext NULL"
        ),
        'htmlPost'       => array
        (
            'label'       => &$GLOBALS['TL_LANG']['tl_test_question']['htmlPost'],
            'exclude'     => true,
            'search'      => true,
            'inputType'   => 'textarea',
            'eval'        => array('allowHtml' => true, 'class' => 'monospace', 'rte' => 'tinyMCE', 'helpwizard' => true),
            'explanation' => 'insertTags',
            'sql'         => "mediumtext NULL"
        ),
        'questionText'   => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_test_question']['questionText'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'clr'),
            'sql'       => "varchar(255) NOT NULL default ''"
        ),
        'questionAnswer' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_test_question']['questionAnswer'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'select',
            'options'   => array('true' => 'wahr', 'false' => 'falsch'),
            'eval'      => array('decodeEntities' => true, 'tl_class' => 'clr'),
            'sql'       => "varchar(255) NOT NULL default ''"
        ),

    )
);

/**
 * Class tl_test_question
 */
class tl_test_question extends Contao\Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('Contao\BackendUser', 'User');
    }

    /**
     * List a page layout
     *
     * @param array $row
     *
     * @return string
     */
    public function listTest($row)
    {
        return '<div class="tl_content_left">' . $row['questionText'] . '</div>';
    }
}
