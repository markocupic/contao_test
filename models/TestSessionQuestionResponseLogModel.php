<?php

/*
 * This file is part of Contao Test Bundle.
 *
 * (c) Marko Cupic by order of Erik Bender
 * @author Marko Cupic <https://github.com/markocupic/contao-test-bundle>
 * @license MIT
 */

namespace Contao;

/**
 * Class TestSessionQuestionResponseLogModel
 * @package Contao
 */
class TestSessionQuestionResponseLogModel extends Model
{

	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_test_session_question_response_log';


}

class_alias(TestSessionQuestionResponseLogModel::class, 'TestSessionQuestionResponseLogModel');
