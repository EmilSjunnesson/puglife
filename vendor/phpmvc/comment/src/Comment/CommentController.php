<?php

namespace Phpmvc\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
    	$this->comments = new \Anax\Comments\Comment();
    	$this->comments->setDI($this->di);
    }
    
    
    
    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction($pageId)
    {
        $all = $this->comments->query()
		->where('page_id = ?')
		->execute([$pageId]);
        
        $timeAgo = function ($time) {return $this->ago($time);};

        $this->views->add('comment/comments', [
            'comments' => $all,
        	'timeAgo' => $timeAgo,
        	'pageId'  => $pageId	
        ]);
    }



    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction()
    {
        $isPosted = $this->request->getPost('doCreate');
        
        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
        	'page_id'   => $this->request->getPost('pageId'),
        ];
        
        $this->comments->save($comment);
        $redirectId = $this->comments->lastInsertId();

        $this->response->redirect($this->request->getPost('redirect') . "#" . $redirectId);
    }



    /**
     * Update comment.
     *
     * @return void
     */
    public function updateAction()
    {
    	$isPosted = $this->request->getPost('doUpdate');
    
    	if (!$isPosted) {
    		$this->response->redirect($this->request->getPost('redirect'));
    	}

    	$comment = [
    			'content'   => $this->request->getPost('content'),
    			'name'      => $this->request->getPost('name'),
    			'web'       => $this->request->getPost('web'),
    			'mail'      => $this->request->getPost('mail'),
    			'id'		=> $this->request->getPost('commentId'),
    	];
    
    	$this->comments->save($comment);
        $redirectId = $this->request->getPost('commentId');

        $this->response->redirect($this->request->getPost('redirect') . "#" . $redirectId);
    }
    
    
    
    /**
     * Edit comment.
     *
     * @return void
     */
    public function editAction($commentId)
    {
    	$comment = $this->comments->find($commentId);
    	
    	
    	$form = new \Mos\HTMLForm\CForm(['legend' => 'Redigera kommentar'], [
				'redirect' => [
						'type'        => 'hidden',
						'value'		  => $this->request->getLastUrl(),
				],
				'commentId' => [
						'type'        => 'hidden',
						'value'		  => $commentId,
				],
				'pageId' => [
						'type'        => 'hidden',
						'value'		  => $comment->page_id,
				],
				'content' => [
						'type'        => 'textarea',
						'label'		  => 'Kommentar:',
						'required'    => true,
						'value'		  => $comment->content,
				],
				'name' => [
						'type'        => 'text',
						'label'		  => 'Namn:',
						'required'    => true,
						'value'		  => $comment->name,
				],
    			'web' => [
    					'type'        => 'text',
    					'label'		  => 'Hemsida:',
    					'value'		  => $comment->web,
    			],
    			'mail' => [
    					'type'        => 'text',
    					'label'		  => 'Email: (för att visa din gravatar bild)',
    					'value'		  => $comment->mail,
    			],
				'doUpdate' => [
						'type'      => 'submit',
						'value'		=> 'Uppdatera',
						'onclick' 	=> 'this.form.action = "' . $this->url->create('comment/update'). '"',
				],
		]);
    	
    	if (isset($comment)) {
    		$this->views->add('comment/form', [
				'get'		=> true,
    			'form'		=> $form->getHTML(),	
			]);
    	} else {
    		$this->response->redirect($this->request->getLastUrl() . "#comments");
    	}
    }
    
    
    
    /**
     * Remove all comments.
     *
     * @return void
     */
    public function removeAllAction($pageId)
    {
        $isPosted = $this->request->getPost('doRemoveAll');
        
        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $this->comments->deleteAll($pageId);

        $this->response->redirect($this->request->getPost('redirect') . "#comments");
    }
    
    
    
    /**
     * Remove single comment.
     *
     * @return void
     */
    public function removeAction($commentId)
    {
    	$this->comments->delete($commentId);
    
    	$this->response->redirect($this->request->getLastUrl() . "#comments");
    }



    /**
     * Get time ago from unix-timestap.
     *
     * @return string
     */
	function ago($time)
	{
   		$periods = array("sekund", "minut", "timme", "dag", "vecka", "månad", "år", "årtionde");
   		$lengths = array("60","60","24","7","4.35","12","10");

   		$now = time();

       	$difference     = $now - $time;
       	$tense         = "sedan";
       	
       	if($difference < 10) {
       		return "alldeles nyss";	
       	}

   		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       		$difference /= $lengths[$j];
   		}

   		$difference = round($difference);

   		if($difference != 1) {
   			if ($periods[$j] == "timme") {
       			$periods[$j] = "timmar";
   			} elseif($periods[$j] == "dag") {
   				$periods[$j].= "ar";
   			} elseif($periods[$j] == "vecka") {
   				$periods[$j] = "veckor";
   			} elseif($periods[$j] == "år") {
   				
   			} elseif($periods[$j] == "årtionde") {
   				$periods[$j].= "n";
   			} else {
   				$periods[$j].= "er";
   			}
   		}

   		return "för $difference $periods[$j] $tense ";
	}
    
}
