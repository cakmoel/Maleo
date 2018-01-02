<?php
/**
 * class Post extends DomainObject
 * @author maoelana
 *
 */
class Post extends DomainObject
{
    
public function __construct(array $data, $exceptionHandling)
{
 parent::__construct($data, $exceptionHandling);
}

public static function findFieldNames()
{
 return array('postID', 'post_image', 'post_author', 'date_created', 'date_modified', 
             'post_title', 'post_slug', 'post_content', 'post_status', 'post_type', 'comment_status');
 
}

public function jsonSerialize()
{
 return ['id' => $this->postID, 'title' => $this->post_title];
}

}