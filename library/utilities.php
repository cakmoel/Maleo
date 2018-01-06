<?php

function base_ui($key = null)
{
    $base_ui = array(
        'css' => '/css',
        'js'  => '/js',
        'img' => '/images',
        'vendor'  => '/vendor'
    );
    
    $path = ($key) ? $base_ui[$key] : '';
    print APP_URL . DS . APP_PUBLIC . $path;
}

function get_url()
{
    $args = func_get_args();
    echo APP_URL . '/' . join('/', $args);
}

function linkbuilder($params, $sptr = null)
{
    $separator = (is_null($sptr)) ? ' &gt; ' : $sptr;
    $truncate = 25;
    
    $links = array();
    $numSteps = count($params);
    for ($i = 0; $i < $numSteps; $i++) {
        $step = $params[$i];
        
        if(strlen($step['title']) > $truncate)
            $step['title'] = substr($step['title'], 0 ,$truncate) . '...';
            
            if (strlen($step['link']) > 0 && $i < $numSteps - 1) {
                $links[] = sprintf('<a href="%s" title="%s">%s</a>',
                    htmlSpecialChars($step['link']),
                    htmlSpecialChars($step['title']),
                    htmlSpecialChars($step['title']));
            }
            else {
                $links[] = htmlSpecialChars($step['title']);
            }
    }
    
    echo join($separator, $links);
    
}