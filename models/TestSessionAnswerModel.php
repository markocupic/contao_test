<?php

/*
 * This file is part of Contao.
 *
 * (c) Leo Feyer
 *
 * @license LGPL-3.0-or-later
 */

namespace Contao;

use Contao\Model\Collection;

/**
 * Class TestSessionAnswerModel
 * @package Contao
 */
class TestSessionAnswerModel extends Model
{

	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_test_session_answer';


}

class_alias(TestSessionAnswerModel::class, 'TestSessionAnswerModel');
