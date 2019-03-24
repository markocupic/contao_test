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
