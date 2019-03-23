<?php

/**
 * Contao Db Backup
 *
 * Copyright (C) 2018 Marko Cupic
 *
 * @package contao-db-backup
 * @link    http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Contao',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(

    // Modules
    'Contao\ModuleTestForm' => 'system/modules/test/modules/ModuleTestForm.php',

    // Models
    'Contao\TestModel' => 'system/modules/test/models/TestModel.php',
    'Contao\TestPageModel' => 'system/modules/test/models/TestPageModel.php',
    'Contao\TestQuestionModel' => 'system/modules/test/models/TestQuestionModel.php',
    'Contao\TestSessionModel' => 'system/modules/test/models/TestSessionModel.php',
    'Contao\TestSessionAnswerModel' => 'system/modules/test/models/TestSessionAnswerModel.php',


));
