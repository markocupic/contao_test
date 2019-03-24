<?php /** @noinspection PhpUndefinedMethodInspection */

/*
 * This file is part of Contao Test Bundle.
 *
 * (c) Marko Cupic by order of Erik Bender
 * @author Marko Cupic <https://github.com/markocupic/contao-test-bundle>
 * @license MIT
 */

namespace Contao;

use Patchwork\Utf8;

/**
 * Front end module "testform".
 *
 * @property string $strTemplate
 * @property object $form
 * @property object $objUser
 * @property array $arrQuestionFields
 * @property object $objActiveTestSession
 * @property object $objActiveTestPage
 * @property object $objFirstTestPage
 * @property object $objLastTestPage
 * @property int $activeTestPageIndex
 * @property int $pagesTotal
 *
 * @author Marko Cupic <https://github.com/markocupic>
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
    protected $objUser;

    /**
     * @var
     */
    protected $arrQuestionFields;

    /**
     * @var
     */
    protected $objActiveTestSession;

    /**
     * @var
     */
    protected $objActiveTestPage;

    /**
     * @var
     */
    protected $objFirstTestPage;

    /**
     * @var
     */
    protected $objLastTestPage;

    /**
     * @var
     */
    protected $activeTestPageIndex;

    /**
     * @var
     */
    protected $pagesTotal;

    /**
     * @return string
     * @throws \Exception
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

        if (FE_USER_LOGGED_IN)
        {
            $objUser = FrontendUser::getInstance();
            $this->objUser = MemberModel::findByPk($objUser->id);
        }
        else
        {
            return '';
        }

        // Keep this order: call $this->getActiveTestSession() before $this->getActiveTestPage();
        // Set class property $objActiveTestSession
        $this->getActiveTestSession();

        // Set class property $objActiveTestPage;
        if ($this->getActiveTestPage() === null)
        {
            return '';
        }

        // Set class property $this->activePageIndex. Attention: first index is 0
        $this->getActivePageIndex();

        // Set class property $this->pagesTotal
        $this->getPagesTotal();

        // Set class property $this->firstTestPage
        $this->getFirstTestPage();

        // Set class property $this->LastTestPage
        $this->getLastTestPage();

        // Set class property $this->pagesTotal
        $this->getPagesTotal();

        return parent::generate();
    }

    /**
     * @throws \Exception
     */
    protected function compile()
    {
        $this->generateForm();

        $this->Template->form = $this->form;
        $this->Template->arrQuestionFields = $this->arrQuestionFields;
        $this->Template->objActiveTestPage = $this->objActiveTestPage;
        $this->Template->objActiveTestSession = $this->objActiveTestSession;
        $this->Template->activeTestPageIndex = $this->activeTestPageIndex;
        $this->Template->pagesTotal = $this->pagesTotal;

        if (Message::hasMessages(TL_MODE))
        {
            $this->Template->messages = Message::generate();
        }
    }

    /**
     * @throws \Exception
     */
    protected function generateForm()
    {
        //Set class property $this->form
        $this->form = new \Haste\Form\Form('testform', 'POST', function ($objHaste) {
            return \Input::post('FORM_SUBMIT') === $objHaste->getFormId();
        });

        $arrQuestionFields = [];
        if ($this->objActiveTestPage !== null)
        {
            $objQuestions = Database::getInstance()->prepare(/** @lang mysql */
                'SELECT * FROM tl_test_question WHERE pid=? ORDER BY sorting')->execute($this->objActiveTestPage->id);
            while ($objQuestions->next())
            {
                $ffname = 'test_question_' . $objQuestions->id;

                $arrQuestionFields[] = $ffname;
                $this->form->addFormField($ffname, array(
                    'label'     => array('', $objQuestions->questionText),
                    //'label'     => array('This is the legend', 'This is the label'),
                    'inputType' => 'checkbox',
                    'eval'      => array('htmlPre' => $objQuestions->htmlPre, 'htmlPost' => $objQuestions->htmlPost, 'template' => 'form_checkbox_pretty', 'checkboxClass' => $this->checkboxClass, 'stateClass' => $this->stateClass, 'mandatory' => false),

                ));
            }
        }

        // Set class property $this->arrQuestionFields
        $this->arrQuestionFields = $arrQuestionFields;

        // Add hidden fields
        $this->form->addContaoHiddenFields();

        // Add a submit button
        $this->form->addSubmitFormField('submit', $GLOBALS['TL_LANG']['MSC']['testFormSubmitBtn']);

        // validate() also checks whether the form has been submitted
        if ($this->form->validate())
        {
            // Count wrong & correct answers
            $intWrongAnswers = 0;
            $intCorrectAnswers = 0;

            foreach ($this->arrQuestionFields as $fieldname)
            {
                if (($questionId = (integer)str_replace('test_question_', '', $fieldname)) > 0)
                {
                    // Log each answer to tl_session_question_response_log
                    $objSessionQuestionResponseLog = new TestSessionQuestionResponseLogModel();
                    $objSessionQuestionResponseLog->pid = $this->objActiveTestSession->id;
                    $objSessionQuestionResponseLog->tstamp = time();
                    $objSessionQuestionResponseLog->testQuestionId = $questionId;

                    $objWidget = $this->form->getWidget($fieldname);
                    if (!$this->isCorrectAnswer($objWidget, $questionId))
                    {
                        // Display error msg
                        Message::addError($GLOBALS['TL_LANG']['MSC']['oneOrMoreFalseAnswers'], TL_MODE);
                        if ($this->displayErrMsg)
                        {
                            $objWidget->addError($GLOBALS['TL_LANG']['MSC']['wrongAnswer']);
                        }
                        $intWrongAnswers++;
                    }
                    else
                    {
                        $intCorrectAnswers++;
                    }
                    $objSessionQuestionResponseLog->save();
                }
            }

            // Save data to tl_test_session_page_response_log
            $objSessionPageResponseLog = new TestSessionPageResponseLogModel();
            $objSessionPageResponseLog->pid = $this->objActiveTestSession->id;
            $objSessionPageResponseLog->tstamp = time();
            $objSessionPageResponseLog->testPageId = $this->objActiveTestPage->id;
            $objSessionPageResponseLog->trueAnswers = $intCorrectAnswers;
            $objSessionPageResponseLog->falseAnswers = $intWrongAnswers;
            $objSessionPageResponseLog->save();

            // Save data to tl_test_session
            $this->objActiveTestSession->tstamp = time();
            $this->objActiveTestSession->save();

            // Redirect and close test session if all questions have been correctly answered for at least 1x
            if ($intWrongAnswers === 0 && $this->objLastTestPage !== null)
            {
                if ($this->objLastTestPage->id === $this->objActiveTestPage->id)
                {
                    $this->objActiveTestSession->hasFinished = '1';
                    $this->objActiveTestSession->timeEnd = time();
                    $this->objActiveTestSession->save();

                    // Jump to test evaluation page or reload
                    if (($objPage = PageModel::findPublishedById($this->jumpToTestEvaluation)) !== null)
                    {
                        $url = $objPage->getFrontendUrl() . '?testsessionid=' . base64_encode($this->objActiveTestSession->id);
                        $this->redirect($url);
                    }
                }
            }

            // Only lead to next test page, if all questions were answered correctly
            if ($intWrongAnswers === 0)
            {
                $this->reload();
            }
        }
    }

    /**
     * @param $objWidget
     * @param $questionId
     * @return bool
     * @throws \Exception
     */
    protected function isCorrectAnswer($objWidget, $questionId)
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

    /**
     * Set class property $this->objActiveTestSession
     * @return TestSessionModel
     */
    protected function getActiveTestSession()
    {
        $objTestPage = Database::getInstance()->prepare(/** @lang mysql */
            'SELECT id FROM tl_test_session WHERE hasFinished=? AND memberId=?')->limit(1)->execute('', $this->objUser->id);
        if ($objTestPage->numRows)
        {
            $this->objActiveTestSession = TestSessionModel::findByPk($objTestPage->id);
            $this->objActiveTestSession->tstamp = time();
            $this->objActiveTestSession->save();
        }
        else
        {
            $this->objActiveTestSession = new TestSessionModel();
            $this->objActiveTestSession->tstamp = time();
            $this->objActiveTestSession->testId = $this->testitem;
            $this->objActiveTestSession->timeStart = time();
            $this->objActiveTestSession->memberId = $this->objUser->id;
            $this->objActiveTestSession->save();
        }
        return $this->objActiveTestSession;
    }

    /**
     * Set class property $this->objActiveTestPage
     * @return TestPageModel|null
     * @throws \Exception
     */
    protected function getActiveTestPage()
    {
        if ($this->objActiveTestSession === null)
        {
            $this->getActiveTestSession();
        }

        if ($this->objActiveTestSession === null)
        {
            throw new \Exception('$this->>objActiveTestSession can not be null.');
        }

        $objTestPages = Database::getInstance()->prepare(/** @lang mysql */
            'SELECT * FROM tl_test_page WHERE pid=? ORDER BY sorting ASC')->execute($this->testitem);
        while ($objTestPages->next())
        {
            $objTestPage = Database::getInstance()->prepare(/** @lang mysql */
                'SELECT * FROM tl_test_session_page_response_log WHERE falseAnswers=? AND pid=? AND testPageId=?')->execute(0, $this->objActiveTestSession->id, $objTestPages->id);
            if (!$objTestPage->numRows)
            {
                $this->objActiveTestPage = TestPageModel::findByPk($objTestPages->id);
                return $this->objActiveTestPage;
            }
        }

        $objTestPage = Database::getInstance()->prepare(/** @lang mysql */
            'SELECT * FROM tl_test_page WHERE pid=? ORDER BY sorting ASC')->limit(1)->execute($this->testitem);
        if ($objTestPage->numRows)
        {
            $this->objActiveTestPage = TestPageModel::findByPk($objTestPage->id);
            return $this->objActiveTestPage;
        }

        return null;
    }

    /**
     * Set class property $this->activeTestPageIndex
     * @return int|null
     * @throws \Exception
     */
    protected function getActivePageIndex()
    {
        if ($this->objActiveTestPage === null)
        {
            $this->getActiveTestPage();
        }

        if ($this->objActiveTestPage === null)
        {
            throw new \Exception('$this->>objActiveTestPage can not be null.');
        }

        $i = 0;

        $objTestPages = Database::getInstance()->prepare(/** @lang mysql */
            'SELECT * FROM tl_test_page WHERE pid=? ORDER BY sorting ASC')->execute($this->testitem);
        while ($objTestPages->next())
        {
            if ($objTestPages->id === $this->objActiveTestPage->id)
            {
                $this->activeTestPageIndex = $i;
                return $this->activeTestPageIndex;
            }
            $i++;
        }
        return null;
    }

    /**
     * Set class property $this->pagesTotal
     * @return int
     */
    protected function getPagesTotal()
    {
        $objTestPages = Database::getInstance()->prepare(/** @lang mysql */
            'SELECT id FROM tl_test_page WHERE pid=? ORDER BY sorting ASC')->execute($this->testitem);
        $this->pagesTotal = $objTestPages->numRows;
        return $this->pagesTotal;
    }

    /**
     * Set class property $this->objLastTestPage
     * @return TestPageModel|null
     */
    protected function getLastTestPage()
    {
        $objTestPage = Database::getInstance()->prepare(/** @lang mysql */
            'SELECT * FROM tl_test_page WHERE pid=? ORDER BY sorting DESC')->limit(1)->execute($this->testitem);
        if ($objTestPage->numRows)
        {
            $this->objLastTestPage = TestPageModel::findByPk($objTestPage->id);
            return $this->objLastTestPage;
        }

        return null;
    }

    /**
     * Set class property $this->objFirstTestPage
     * @return TestPageModel|null
     */
    protected function getFirstTestPage()
    {
        $objTestPage = Database::getInstance()->prepare(/** @lang mysql */
            'SELECT * FROM tl_test_page WHERE pid=? ORDER BY sorting ASC')->limit(1)->execute($this->testitem);
        if ($objTestPage->numRows)
        {
            $this->objFirstTestPage = TestPageModel::findByPk($objTestPage->id);
            return $this->objFirstTestPage;
        }

        return null;
    }

    /**
     * @param $intIndex
     * @return TestPageModel|null
     */
    protected function getTestPageByPageIndex($intIndex)
    {
        $objTestPage = Database::getInstance()->prepare(/** @lang mysql */
            'SELECT * FROM tl_test_page WHERE pid=? ORDER BY sorting ASC LIMIT 1 OFFSET ?')->execute($this->testitem, $intIndex);
        if ($objTestPage->numRows)
        {
            return TestPageModel::findByPk($objTestPage->id);
        }
        return null;
    }
}

class_alias(ModuleTestForm::class, 'ModuleTestForm');
