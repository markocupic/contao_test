<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 23.03.2019
 * Time: 10:50
 */

$GLOBALS['TL_DCA']['tl_module']['palettes']['testform'] = '{title_legend},name,headline,type;{config_legend},testitem;{style_legend},checkboxClass,stateClass;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

// Add fields to tl_module
$GLOBALS['TL_DCA']['tl_module']['fields']['testitem'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_module']['testitem'],
    'exclude'          => true,
    'inputType'        => 'radio',
    'options_callback' => array('tl_module_test', 'getTests'),
    'eval'             => array('mandatory' => true, 'multiple' => false, 'tl_class' => 'clr'),
    'sql'              => "int(10) unsigned NOT NULL default '0'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['checkboxClass'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_module']['checkboxClass'],
    'exclude'          => true,
    'inputType'        => 'text',
    'eval'             => array('mandatory' => true, 'multiple' => false, 'tl_class' => 'clr'),
    'sql'       => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['stateClass'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_module']['stateClass'],
    'exclude'          => true,
    'inputType'        => 'text',
    'eval'             => array('mandatory' => true, 'multiple' => false, 'tl_class' => 'clr'),
    'sql'       => "varchar(255) NOT NULL default ''"
);
/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_module_test extends Contao\Backend
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
     * Get all tests and return them as array
     *
     * @return array
     */
    public function getTests()
    {
        $arrTests = array();
        $objTests = $this->Database->execute("SELECT id, title FROM tl_test ORDER BY title");
        while ($objTests->next())
        {
            $arrTests[$objTests->id] = $objTests->title;
        }

        return $arrTests;
    }

}
