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
 * Class TestQuestionModel
 * @package Contao
 */
class TestQuestionModel extends Model
{

	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_test_question';


}

class_alias(TestQuestionModel::class, 'TestQuestionModel');
