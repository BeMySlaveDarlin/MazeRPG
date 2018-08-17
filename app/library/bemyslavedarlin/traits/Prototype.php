<?php
namespace Bemyslavedarlin\Traits;

/**
 * Trait Prototype
 * @package Bemyslavedarlin\Traits
 */
trait Prototype
{
	protected $user;
	
	protected function getUser()
	{
        if(!$this->session->get('user_id',false))
        {
            $this->user = new \Users();
            $this->user->session_id = $this->session->getId();
            $this->user->save();
            $this->session->set('user_id', $this->user->user_id);
        }else{
            $this->user = \Users::findFirst([$this->session->get('user_id')]);
        }
	}
}
