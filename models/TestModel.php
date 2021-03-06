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
 * Class TestModel
 * @package Contao
 */
class TestModel extends Model
{

	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_test';


}

class_alias(TestModel::class, 'TestModel');
