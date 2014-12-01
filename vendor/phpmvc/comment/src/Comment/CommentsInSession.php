<?php

namespace Phpmvc\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentsInSession implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Add a new comment.
     *
     * @param array $comment with all details.
     * 
     * @return void
     */
    public function add($comment, $pageId)
    {
        $comments = $this->session->get('comments(' . $pageId . ')', []);
        $comments[] = $comment;
        $this->session->set('comments(' . $pageId . ')', $comments);
    }



    /**
     * Update a comment.
     *
     * @param array comment with all details.
     * @param string pageId
     * @param int commentId
     *
     * @return void
     */
    public function update($comment, $pageId, $commentId)
    {
    	$comments = $this->session->get('comments(' . $pageId . ')', []);
    	$comments[$commentId] = array_merge($comments[$commentId], $comment);
    	$this->session->set('comments(' . $pageId . ')', $comments);
    }
    
    
    
    /**
     * Find and return all comments.
     *
     * @return array with all comments.
     */
    public function findAll($pageId)
    {
        return $this->session->get('comments(' . $pageId . ')', []);
    }



    /**
     * Delete all comments.
     *
     * @return void
     */
    public function deleteAll($pageId)
    {
        $this->session->set('comments(' . $pageId . ')', []);
    }
    
    
    
    /**
     * Delete single comment.
     * 
     * @param string page id (md5 url)
     * @param int comment id
     * 
     * @return void
     */
    public function delete($pageId, $commentId)
    {
    	$comments = $this->session->get('comments(' . $pageId . ')', []);
    	unset($comments[$commentId]);
    	$comments = array_values($comments);
    	$this->session->set('comments(' . $pageId . ')', $comments);
    }
}
