<?php
/**
 * Setup autoloading
 */
function GoogleCheckoutTest_Autoloader($class) 
{
    $class = ltrim($class, '\\');

    if (!preg_match('#^(GoogleCheckout(Test)?|PHPUnit)(\\\\|_)#', $class)) {
        return false;
    }

    // $segments = explode('\\', $class); // preg_split('#\\\\|_#', $class);//
    $segments = preg_split('#[\\\\_]#', $class); // preg_split('#\\\\|_#', $class);//
    $ns       = array_shift($segments);

    switch ($ns) {
        case 'GoogleCheckout':
            $file = dirname(__DIR__) . '/library/GoogleCheckout/';
            break;
        case 'GoogleCheckoutTest':
            // temporary fix for GoogleCheckoutTest namespace until we can migrate files 
            // into GoogleCheckoutTest dir
            $file = __DIR__ . '/GoogleCheckout/';
            break;
        default:
            $file = false;
            break;
    }

    if ($file) {
        $file .= implode('/', $segments) . '.php';
        if (file_exists($file)) {
            return include_once $file;
        }
    }

    $segments = explode('_', $class);
    $ns       = array_shift($segments);

    switch ($ns) {
        case 'GoogleCheckout':
            $file = dirname(__DIR__) . '/library/GoogleCheckout/';
            break;
        default:
            return false;
    }
    $file .= implode('/', $segments) . '.php';
    if (file_exists($file)) {
        return include_once $file;
    }

    return false;
}
spl_autoload_register('GoogleCheckoutTest_Autoloader', true, true);

