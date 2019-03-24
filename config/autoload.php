<?php

/*
 * This file is part of Contao Test Bundle.
 *
 * (c) Marko Cupic by order of Erik Bender
 * @author Marko Cupic <https://github.com/markocupic/contao-test-bundle>
 * @license MIT
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
    'Contao\ModuleTestForm'                      => 'system/modules/test/modules/ModuleTestForm.php',

    // Models
    'Contao\TestModel'                           => 'system/modules/test/models/TestModel.php',
    'Contao\TestPageModel'                       => 'system/modules/test/models/TestPageModel.php',
    'Contao\TestQuestionModel'                   => 'system/modules/test/models/TestQuestionModel.php',
    'Contao\TestSessionModel'                    => 'system/modules/test/models/TestSessionModel.php',
    'Contao\TestSessionPageResponseLogModel'     => 'system/modules/test/models/TestSessionPageResponseLogModel.php',
    'Contao\TestSessionQuestionResponseLogModel' => 'system/modules/test/models/TestSessionQuestionResponseLogModel.php',

));
