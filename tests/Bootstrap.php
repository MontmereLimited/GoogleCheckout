<?php

error_reporting( E_ALL | E_STRICT );

$gcRoot        = realpath(dirname(__DIR__));
$gcCoreLibrary = "$gcRoot/library";
$gcCoreTests   = "$gcRoot/tests";

$path = array(
    $gcCoreLibrary,
    $gcCoreTests,
    get_include_path(),
);
set_include_path(implode(PATH_SEPARATOR, $path));

include __DIR__ . '/_autoload.php';


if (defined('TESTS_GENERATE_REPORT') 
    && TESTS_GENERATE_REPORT === true 
    && version_compare(PHPUnit_Runner_Version::id(), '3.1.6', '>=')
) {
    $codeCoverageFilter = PHP_CodeCoverage_Filter::getInstance();
        
    /*
     * Omit from code coverage reports the contents of the tests directory
     */
    foreach (array('.php', '.phtml', '.csv', '.inc') as $suffix) {
        $codeCoverageFilter->addDirectoryToBlacklist($gcCoreTests, $suffix);
    }

    $codeCoverageFilter->addDirectoryToBlacklist(PEAR_INSTALL_DIR);
    $codeCoverageFilter->addDirectoryToBlacklist(PHP_LIBDIR);

    unset($codeCoverageFilter);
}


/**
 * Start output buffering, if enabled
 */
if (defined('TESTS_ZEND_OB_ENABLED') && constant('TESTS_ZEND_OB_ENABLED')) {
    ob_start();
}

/*
 * Unset global variables that are no longer needed.
 */
unset($gcRoot, $gcCoreLibrary, $gcCoreTests, $path);
