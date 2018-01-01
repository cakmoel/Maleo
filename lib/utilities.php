<?php
function baseUrl($key = null)
{
    $base = array(
        'css' => '/css',
        'js'  => '/js',
        'img' => '/images'
    );
    
    $path = ($key) ? $base[$key] : '';
    echo APP_URL . '/views' . $path;
}

function getUrl()
{
    $args = func_get_args();
    echo APP_URL . '/' . join('/', $args);
}

function breadcrumbs($params, $sptr = null)
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