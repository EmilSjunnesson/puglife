<?php

namespace Emsf14\Comments;

class CComments
{
	
	private $app = null;
	
	public function __construct($app)
	{
		$this->app = $app;
	}
	
	public function displayComments($pageId)
	{
		$app = $this->app;
		$app->theme->addStylesheet('css/comments.css');
		$app->theme->addStylesheet('css/form.css');

		$app->dispatcher->forward([
				'controller' => 'comment',
				'action'     => 'view',
				'params'	 => [$pageId],
		]);
		
		$form = new \Mos\HTMLForm\CForm(['legend' => 'Skriv en kommentar'], [
				'redirect' => [
						'type'        => 'hidden',
						'value'		  => $app->request->getCurrentUrlWithoutQuery(),
				],
				'pageId' => [
						'type'        => 'hidden',
						'value'		  => $pageId,
				],
				'content' => [
						'type'        => 'textarea',
						'label'		  => 'Kommentar:',
						'required'    => true,
				],
				'name' => [
						'type'        => 'text',
						'label'		  => 'Namn:',
						'required'    => true,
				],
				'web' => [
						'type'        => 'text',
						'label'		  => 'Hemsida:',
				],
				'mail' => [
						'type'        => 'text',
						'label'		  => 'Email: (för att visa din gravatar bild)',
				],
				'doCreate' => [
						'type'      => 'submit',
						'value'		=> 'Kommentera',
						'onclick' 	=> 'this.form.action = "' . $app->url->create('comment/add'). '"',
				],
				'doRemoveAll' => [
						'type'      => 'submit',
						'value'		=> 'Radera alla',
						'novalidate' => true,
						'onclick' 	=> 'this.form.action = "' . $app->url->create('comment/remove-all/' . $pageId). '"',
				],
		]);
		
		$app->views->add('comment/form', [
				'get'		=> $app->request->getGet('comment'),
				'form'		=> $form->getHTML(),
		]);
	}
	
}