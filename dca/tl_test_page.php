<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 22.03.2019
 * Time: 22:32
 */

$GLOBALS['TL_DCA']['tl_test_page'] = array
(

    // Config
    'config'      => array
    (
        'dataContainer'     => 'Table',
        'ptable'            => 'tl_test',
        'ctable'            => array('tl_test_question'),
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
        )
    ),

    // List
    'list'        => array
    (
        'sorting'           => array
        (
            'mode'                  => 4,
            'fields'                => array('sorting'),
            'icon'                  => 'pagemounts.svg',
            //'paste_button_callback' => array('tl_test_page', 'pastePage'),
            'panelLayout'           => 'filter;search',
            'headerFields'          => array('title'),
            'child_record_callback' => array('tl_test_page', 'listPage'),
            'disableGrouping'       => true
        ),
        'label'             => array
        (
            'fields' => array('title'),
            'format' => '%s',
            //'label_callback' => array('tl_test_page', 'addIcon')
        ),
        'global_operations' => array
        (
            'toggleNodes' => array
            (
                'label'        => &$GLOBALS['TL_LANG']['MSC']['toggleAll'],
                'href'         => 'ptg=all',
                'class'        => 'header_toggle',
                'showOnSelect' => true
            ),
            'all'         => array
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
                'label' => &$GLOBALS['TL_LANG']['tl_test_page']['edit'],
                'href'  => 'table=tl_test_question',
                'icon'  => 'edit.svg'
            ),
            'editheader' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_test_page']['editheader'],
                'href'  => 'act=edit',
                'icon'  => 'header.svg',
                //'button_callback' => array('tl_calendar_container', 'editHeader')
            ),
            'copy'       => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_test_page']['copy'],
                'href'       => 'act=paste&amp;mode=copy',
                'icon'       => 'copy.svg',
                'attributes' => 'onclick="Backend.getScrollOffset()"'
            ),
            'cut'        => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_test_page']['cut'],
                'href'       => 'act=paste&amp;mode=cut',
                'icon'       => 'cut.svg',
                'attributes' => 'onclick="Backend.getScrollOffset()"'
            ),
            'delete'     => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_test_page']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                //'button_callback' => array('tl_test_page', 'deletePage')
            ),

            'show' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_test_page']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg'
            ),
        )
    ),

    // Palettes
    'palettes'    => array
    (
        //'__selector__'                => array(),
        'default' => '{testPage_legend},title,headline,htmlPre,htmlPost',
    ),

    // Subpalettes
    'subpalettes' => array
    (//
    ),

    // Fields
    'fields'      => array
    (
        'id'       => array
        (
            'label'  => array('ID'),
            'search' => true,
            'sql'    => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid'      => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting'  => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp'   => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'title'    => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_test_page']['title'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'clr'),
            'sql'       => "varchar(255) NOT NULL default ''"
        ),
        'headline' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_test_page']['headline'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => false, 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'clr'),
            'sql'       => "varchar(255) NOT NULL default ''"
        ),
        'htmlPre'  => array
        (
            'label'       => &$GLOBALS['TL_LANG']['tl_test_page']['htmlPre'],
            'exclude'     => true,
            'search'      => true,
            'inputType'   => 'textarea',
            'eval'        => array('allowHtml' => true, 'class' => 'monospace', 'rte' => 'ace|html', 'helpwizard' => true),
            'explanation' => 'insertTags',
            'sql'         => "mediumtext NULL"
        ),
        'htmlPost' => array
        (
            'label'       => &$GLOBALS['TL_LANG']['tl_test_page']['htmlPost'],
            'exclude'     => true,
            'search'      => true,
            'inputType'   => 'textarea',
            'eval'        => array('allowHtml' => true, 'class' => 'monospace', 'rte' => 'ace|html', 'helpwizard' => true),
            'explanation' => 'insertTags',
            'sql'         => "mediumtext NULL"
        ),
    )
);

/**
 * Class tl_test_page
 */
class tl_test_page extends Contao\Backend
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
    public function listPage($row)
    {
        return '<div class="tl_content_left">' . $row['title'] . '</div>';
    }

}