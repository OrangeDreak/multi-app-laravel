<?php
namespace Service;
use active\ActiveModel;
class zzService {
	
	public function __construct(){
		$this->model = new ActiveModel();
	}

	public function index(){
		return $this->model->index();
	}
}