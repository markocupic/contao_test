<?php

/*
 * This file is part of Contao.
 *
 * (c) Leo Feyer
 *
 * @license LGPL-3.0-or-later
 */

namespace Contao;

use Contao\CoreBundle\Exception\InternalServerErrorException;
use Patchwork\Utf8;

/**
 * Front end module "testform".
 *
 * @property string $strTemplate
 * @property object $form
 * @property array $arrFields
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class ModuleTestForm extends Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_testform';

    /**
     * Form
     * @var
     */
    protected $form;

    /**
     * @var
     */
    protected $arrFields;

    /**
     * Display a wildcard in the back end
     *
     * @throws InternalServerErrorException
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['testform'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $this->generateForm();

        $this->Template->form = $this->form;
        $this->Template->arrFields = $this->arrFields;
        $this->Template->x = $this->checkboxClass;
    }

    protected function generateForm()
    {
        $this->form = new \Haste\Form\Form('testform', 'POST', function ($objHaste) {
            return \Input::post('FORM_SUBMIT') === $objHaste->getFormId();
        });

        $arrFields = [];
        if (($objTestPage = $this->getTestPage()) !== null)
        {
            $objQuestions = Database::getInstance()->prepare('SELECT * FROM tl_test_question WHERE pid=? ORDER BY sorting')->execute($objTestPage->id);
            while ($objQuestions->next())
            {
                $ffname = 'test_question_' . $objQuestions->id;

                $arrFields[] = $ffname;
                $this->form->addFormField($ffname, array(
                    'label'     => array('', $objQuestions->questionText),
                    //'label'     => array('This is the legend', 'This is the label'),
                    'inputType' => 'checkbox',
                    'eval'      => array('template' => 'form_checkbox_pretty', 'checkboxClass' => $this->checkboxClass, 'stateClass' => $this->stateClass, 'mandatory' => false),

                ));
            }
        }
        $this->arrFields = $arrFields;

        $this->form->addContaoHiddenFields();
        $this->form->addSubmitFormField('submit', 'weiter');

        // validate() also checks whether the form has been submitted
        if ($this->form->validate())
        {
            $blnHasError = false;

            $arrFormFields = $this->form->getFormFields();

            foreach ($arrFormFields as $fieldname => $value)
            {
                if (($questionId = (integer)str_replace('test_question_', '', $fieldname)) > 0)
                {
                    $objWidget = $this->form->getWidget($fieldname);

                    if ($this->isAnswerRight($objWidget, $questionId))
                    {
                    }
                    else
                    {
                        $objWidget->addError('Falsche Antwort!');
                        $blnHasError = true;
                    }
                }
            }

            if (!$blnHasError)
            {
                $this->reload();
            }
        }
    }

    /**
     * @return CalendarEventsModel|null
     */
    protected function getTestPage()
    {
        $objTestPage = Database::getInstance()->prepare('SELECT id FROM tl_test_page WHERE pid=?')->limit(1)->execute($this->testitem);
        if ($objTestPage->numRows)
        {
            return TestPageModel::findByPk($objTestPage->id);
        }
        return null;
    }

    /**
     * @param $objWidget
     * @param $questionId
     * @return bool
     * @throws \Exception
     */
    protected function isAnswerRight($objWidget, $questionId)
    {
        $answer = Input::post($objWidget->name);
        $objQuestion = TestQuestionModel::findByPk($questionId);
        if ($objQuestion !== null)
        {
            if ($objQuestion->questionAnswer == 'true' && $answer == '1')
            {
                return true;
            }
            elseif ($objQuestion->questionAnswer == 'false' && $answer == '')
            {
                return true;
            }
        }

        else
        {
            throw new \Exception(sprintf('Question tl_test_question with id=%s does not exist.', $questionId));
        }
        return false;
    }
}

class_alias(ModuleTestForm::class, 'ModuleTestForm');
