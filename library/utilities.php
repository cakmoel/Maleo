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

function find_url()
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

// Konversi format tanggal dd/mm/yyyy -> yyyy/mm/dd
function tgl_ind_to_eng($tgl)
{
    $tgl_eng = substr($tgl, 6, 4) . "-" . substr($tgl, 3, 2) . "-" . substr($tgl, 0, 2);
    return $tgl_eng;
}

// Konversi format tanggal yyyy/mm/dd -> dd/mm/yyyy
function tgl_eng_to_ind($tgl)
{
    $tgl_ind = substr($tgl, 8, 2) . "-" . substr($tgl, 5, 2) . "-" . substr( $tgl, 0, 4);
    return $tgl_ind;
}

function makeDate($value)
{
    $day = substr( $value, 8, 2 );
    $month = getMonth( substr( $value, 5, 2 ) );
    $year = substr( $value, 0, 4 );
    return $month . ' ' . $day . ', ' . $year;
}

function getMonth($value)
{
    switch ($value) {
        case 1 :
            return "January";
            break;
        case 2 :
            return "February";
            break;
        case 3 :
            return "March";
            break;
        case 4 :
            return "April";
            break;
        case 5 :
            return "May";
            break;
        case 6 :
            return "June";
            break;
        case 7 :
            return "July";
            break;
        case 8 :
            return "August";
            break;
        case 9 :
            return "September";
            break;
        case 10 :
            return "October";
            break;
        case 11 :
            return "November";
            break;
        case 12 :
            return "December";
            break;
    }
    
}


// format size unit
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }
    
    return $bytes;
}

// function redirect page
function directPage($page = '')
{
    
    $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === false ? 'http' : 'https';
    $host     = $_SERVER['HTTP_HOST'];
    
    // defining url
    $url = $protocol . '://' . $host . dirname($_SERVER['PHP_SELF']);
    
    // remove any trailing slashes
    $url = rtrim($url, '/\\');
    
    // add the page
    $url .= '/' . $page;
    
    // redirect the user
    header("Location: $url");
    
}

// is integer
function isInteger($input)
{
    if (!ctype_digit(strval($input))) {
        
        return false;
        
    } else {
        
        return true;
    }
    
}

// imeago - thanks to Bennet Stone devtips.com
function timeAgo($date)
{
    
    if (empty($date))
    {
        return "No date provided";
    }
    
    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
    
    $now = time();
    
    $unix_date = strtotime( $date );
    
    
    if ( empty( $unix_date ) )
    {
        return "Bad date";
    }
    
    // is it future date or past date
    
    if ( $now > $unix_date )
    {
        $difference = $now - $unix_date;
        $tense = "ago";
    }
    else
    {
        $difference = $unix_date - $now;
        $tense = "from now";
    }
    
    for ( $j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++ )
    {
        $difference /= $lengths[$j];
    }
    
    $difference = round( $difference );
    
    if ( $difference != 1 )
    {
        $periods[$j].= "s";
    }
    
    return "$difference $periods[$j] {$tense}";
    
}

// value size validation
function valueSizeValidation($form_fields)
{
    
    foreach ($form_fields as $k => $v) {
        
        if(!empty($_POST[$k]) && isset($_POST[$k]{$v + 1})) {
            
            throw new Exception("{$k} </b> is longer then allowed {$v} byte length");
            
        }
        
    }
}

#################################################################################
# RFC 822/2822/5322 Email Parser
#
# By Cal Henderson <cal@iamcal.com>
#
# This code is dual licensed:
# CC Attribution-ShareAlike 2.5 - http://creativecommons.org/licenses/by-sa/2.5/
# GPLv3 - http://www.gnu.org/copyleft/gpl.html

##################################################################################

function is_valid_email_address($email, $options=array()){
    
    #
    # you can pass a few different named options as a second argument,
    # but the defaults are usually a good choice.
    #
    
    $defaults = array(
        'allow_comments'	=> true,
        'public_internet'	=> true, # turn this off for 'strict' mode
    );
    
    $opts = array();
    foreach ($defaults as $k => $v) $opts[$k] = isset($options[$k]) ? $options[$k] : $v;
    $options = $opts;
    
    
    $no_ws_ctl	= "[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x7f]";
    $alpha		= "[\\x41-\\x5a\\x61-\\x7a]";
    $digit		= "[\\x30-\\x39]";
    $cr		= "\\x0d";
    $lf		= "\\x0a";
    $crlf		= "(?:$cr$lf)";
    
   
    
    $obs_char	= "[\\x00-\\x09\\x0b\\x0c\\x0e-\\x7f]";
    $obs_text	= "(?:$lf*$cr*(?:$obs_char$lf*$cr*)*)";
    $text		= "(?:[\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f]|$obs_text)";
    
   
    
    $text		= "(?:$lf*$cr*$obs_char$lf*$cr*)";
    $obs_qp		= "(?:\\x5c[\\x00-\\x7f])";
    $quoted_pair	= "(?:\\x5c$text|$obs_qp)";
    
      
    $wsp		= "[\\x20\\x09]";
    $obs_fws	= "(?:$wsp+(?:$crlf$wsp+)*)";
    $fws		= "(?:(?:(?:$wsp*$crlf)?$wsp+)|$obs_fws)";
    $ctext		= "(?:$no_ws_ctl|[\\x21-\\x27\\x2A-\\x5b\\x5d-\\x7e])";
    $ccontent	= "(?:$ctext|$quoted_pair)";
    $comment	= "(?:\\x28(?:$fws?$ccontent)*$fws?\\x29)";
    $cfws		= "(?:(?:$fws?$comment)*(?:$fws?$comment|$fws))";
      
    $outer_ccontent_dull	= "(?:$fws?$ctext|$quoted_pair)";
    $outer_ccontent_nest	= "(?:$fws?$comment)";
    $outer_comment		= "(?:\\x28$outer_ccontent_dull*(?:$outer_ccontent_nest$outer_ccontent_dull*)+$fws?\\x29)";
     
    $atext		= "(?:$alpha|$digit|[\\x21\\x23-\\x27\\x2a\\x2b\\x2d\\x2f\\x3d\\x3f\\x5e\\x5f\\x60\\x7b-\\x7e])";
    $atom		= "(?:$cfws?(?:$atext)+$cfws?)";
    
    $qtext		= "(?:$no_ws_ctl|[\\x21\\x23-\\x5b\\x5d-\\x7e])";
    $qcontent	= "(?:$qtext|$quoted_pair)";
    $quoted_string	= "(?:$cfws?\\x22(?:$fws?$qcontent)*$fws?\\x22$cfws?)";
    
    $quoted_string	= "(?:$cfws?\\x22(?:$fws?$qcontent)+$fws?\\x22$cfws?)";
    $word		= "(?:$atom|$quoted_string)";
    
    $obs_local_part	= "(?:$word(?:\\x2e$word)*)";
    $obs_domain	= "(?:$atom(?:\\x2e$atom)*)";
    
    $dot_atom_text	= "(?:$atext+(?:\\x2e$atext+)*)";
    $dot_atom	= "(?:$cfws?$dot_atom_text$cfws?)";
    
    $dtext		= "(?:$no_ws_ctl|[\\x21-\\x5a\\x5e-\\x7e])";
    $dcontent	= "(?:$dtext|$quoted_pair)";
    $domain_literal	= "(?:$cfws?\\x5b(?:$fws?$dcontent)*$fws?\\x5d$cfws?)";
    
    $local_part	= "(($dot_atom)|($quoted_string)|($obs_local_part))";
    $domain		= "(($dot_atom)|($domain_literal)|($obs_domain))";
    $addr_spec	= "$local_part\\x40$domain";
    
    if (strlen($email) > 254) return 0;
    
    if ($options['allow_comments']){
        
        $email = email_strip_comments($outer_comment, $email, "(x)");
    }
        
    if (!preg_match("!^$addr_spec$!", $email, $m)){
        
        return 0;
    }
    
    $bits = array(
        'local'			=> isset($m[1]) ? $m[1] : '',
        'local-atom'		=> isset($m[2]) ? $m[2] : '',
        'local-quoted'		=> isset($m[3]) ? $m[3] : '',
        'local-obs'		=> isset($m[4]) ? $m[4] : '',
        'domain'		=> isset($m[5]) ? $m[5] : '',
        'domain-atom'		=> isset($m[6]) ? $m[6] : '',
        'domain-literal'	=> isset($m[7]) ? $m[7] : '',
        'domain-obs'		=> isset($m[8]) ? $m[8] : '',
    );
   
    if ($options['allow_comments']){
        $bits['local']	= email_strip_comments($comment, $bits['local']);
        $bits['domain']	= email_strip_comments($comment, $bits['domain']);
    }
    
    if (strlen($bits['local']) > 64) return 0;
    if (strlen($bits['domain']) > 255) return 0;
    
    if (strlen($bits['domain-literal'])){
        
        $Snum			= "(\d{1,3})";
        $IPv4_address_literal	= "$Snum\.$Snum\.$Snum\.$Snum";
        
        $IPv6_hex		= "(?:[0-9a-fA-F]{1,4})";
        
        $IPv6_full		= "IPv6\:$IPv6_hex(?:\:$IPv6_hex){7}";
        
        $IPv6_comp_part		= "(?:$IPv6_hex(?:\:$IPv6_hex){0,7})?";
        $IPv6_comp		= "IPv6\:($IPv6_comp_part\:\:$IPv6_comp_part)";
        
        $IPv6v4_full		= "IPv6\:$IPv6_hex(?:\:$IPv6_hex){5}\:$IPv4_address_literal";
        
        $IPv6v4_comp_part	= "$IPv6_hex(?:\:$IPv6_hex){0,5}";
        $IPv6v4_comp		= "IPv6\:((?:$IPv6v4_comp_part)?\:\:(?:$IPv6v4_comp_part\:)?)$IPv4_address_literal";
        
        
        if (preg_match("!^\[$IPv4_address_literal\]$!", $bits['domain'], $m)){
            
            if (intval($m[1]) > 255) return 0;
            if (intval($m[2]) > 255) return 0;
            if (intval($m[3]) > 255) return 0;
            if (intval($m[4]) > 255) return 0;
            
        } else {
            
            while (1){
                
                if (preg_match("!^\[$IPv6_full\]$!", $bits['domain'])){
                    break;
                }
                
                if (preg_match("!^\[$IPv6_comp\]$!", $bits['domain'], $m)){
                    list($a, $b) = explode('::', $m[1]);
                    $folded = (strlen($a) && strlen($b)) ? "$a:$b" : "$a$b";
                    $groups = explode(':', $folded);
                    if (count($groups) > 7) return 0;
                    break;
                }
                
                if (preg_match("!^\[$IPv6v4_full\]$!", $bits['domain'], $m)){
                    
                    if (intval($m[1]) > 255) return 0;
                    if (intval($m[2]) > 255) return 0;
                    if (intval($m[3]) > 255) return 0;
                    if (intval($m[4]) > 255) return 0;
                    break;
                }
                
                if (preg_match("!^\[$IPv6v4_comp\]$!", $bits['domain'], $m)){
                    list($a, $b) = explode('::', $m[1]);
                    $b = substr($b, 0, -1); # remove the trailing colon before the IPv4 address
                    $folded = (strlen($a) && strlen($b)) ? "$a:$b" : "$a$b";
                    $groups = explode(':', $folded);
                    if (count($groups) > 5) return 0;
                    break;
                }
                
                return 0;
            }
        }
        
    } else{
            
        $labels = explode('.', $bits['domain']);
        
        if ($options['public_internet']){
            if (count($labels) == 1) return 0;
        }
              
        foreach ($labels as $label){
            
            if (strlen($label) > 63) return 0;
            if (substr($label, 0, 1) == '-') return 0;
            if (substr($label, -1) == '-') return 0;
        }
            
        if ($options['public_internet']){
            if (preg_match('!^[0-9]+$!', array_pop($labels))) return 0;
        }
    }
    
    
    return 1;
}

##################################################################################
## part of Email Parser is_valid_email_address
function email_strip_comments($comment, $email, $replace=''){
    
    while (1){
        $new = preg_replace("!$comment!", $replace, $email);
        if (strlen($new) == strlen($email)){
            return $email;
        }
        $email = $new;
    }
}

##################################################################################
