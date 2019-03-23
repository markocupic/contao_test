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
 * Class TestSessionModel
 * @package Contao
 */
class TestSessionModel extends Model
{

	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_test_session';


}

class_alias(TestSessionModel::class, 'TestSessionModel');
