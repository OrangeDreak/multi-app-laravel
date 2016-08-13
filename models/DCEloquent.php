<?php

/*
 * @浪尖网络
 * @功能说明：修改系统自带的创建修改删除字段名
 * @更新说明：暂无
 * @文件名 DCEloquent.php
 * @编码 UTF-8
 * @创建时间 2014-7-15 10:11:23
 * @创建人 XH
 */
class DCEloquent extends Eloquent {

	const DELETED_AT = 'delete_at';

	const UPDATED_AT = 'update_at';

	const CREATED_AT = 'create_at';
	/**
	 *
	 * @var array 记录错误信息
	 */
	protected $errors = array();

	/**
	 * 设置错误信息,并返回相应的错误类型状态，一般为false,0,'',null,array()
	 *
	 * @param mix $error        	
	 * @param mix $returnValue        	
	 * @return mix
	 */
	public function setError($error, $returnValue = false) {
		if (is_array($error)) {
			foreach($error as $key=>$_error) {
				is_int($key) ? $this->errors[$key] = $_error : $this->errors[$key] = $_error;
			}
		} else {
			$this->errors[] = $error;
		}
		return $returnValue;
	
	}

	/**
	 * 取得单条错误信息
	 *
	 * @return string
	 */
	public function getError() {
		if ($this->errors)
			return array_pop($this->errors);
	
	}

	/**
	 * 获取所有错误类型
	 *
	 * @return array
	 */
	public function getErrors() {
		return $this->errors;
	
	}

	/**
	 * 指定时间字符
	 *
	 * @param \DateTime|int $value        	
	 * @return string
	 */
	public function fromDateTime($value) {
		return strtotime(parent::fromDateTime($value));
	
	}

	/**
	 * 附加属性值， 非字段属性不会赋值，避免报错
	 *
	 * @param baseEloquent $baseEloquent
	 * @param array $array
	 */
	public function attachAttribute(DCEloquent $baseEloquent, array $array) {
		foreach ( $array as $key => $value ) {
			$baseEloquent->$key = $value;
		}
	}

	/*
	 * 以下两个方法可以重写去掉系统自带的一些创建与修改字段
	 * public function setCreatedAt($value)添加创建时间字段
	 * {
	 * $this->{static::CREATED_AT} = $value;
	 * }
	 * public function setUpdatedAt($value)//添加修改时间字段
	 * {
	 * $this->{static::UPDATED_AT} = $value;
	 * }
	 */
	protected function asDateTime($val) {
		if (is_numeric($val)) {
			return $val;
		}
		return parent::asDateTime($val);
	
	}
	
	public function getPrimaryId(){
	    return $this->primaryKey;
	}

}