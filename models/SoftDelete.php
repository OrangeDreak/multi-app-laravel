<?php

/*
 * @浪尖网络
 * @功能说明：修改系统自带的创建与修改删除字段类型
 * @更新说明：暂无
 * @文件名 SoftDelete.php
 * @编码 UTF-8
 * @创建时间 2014-7-8 12:57:10
 * @创建人 XH
 */
class SoftDelete extends DCEloquent {
	use SoftDeletingTrait;

	/**
	 * 创建软删除对象
	 *
	 * @return void
	 */
	public static function bootSoftDeletingTrait() {
		static::addGlobalScope(new SoftDeleteScope());
	}

	/**
	 * 只获取软删除的记录
	 *
	 * @return \Illuminate\Database\Eloquent\Builder|static
	 */
	public static function onlyTrashed() {
		$instance = new static();
		
		$column = $instance->getQualifiedDeletedAtColumn();
		
		return $instance->newQueryWithoutScope(new SoftDeleteScope())->where($column, '>', new Illuminate\Database\Query\Expression('0'));
	}

	/**
	 * 获取软删除与正常一起的记录
	 *
	 * @return \Illuminate\Database\Eloquent\Builder|static
	 */
	public static function withTrashed() {
		return with(new static())->newQueryWithoutScope(new SoftDeleteScope());
	}

	/**
	 * 检测是否重复
	 * 
	 * @param string $column        	
	 * @param object $value        	
	 * @param number $id        	
	 * @return boolean
	 */
	public static function checkRepeat($column, $value, $id = 0) {
		$query = static::where($column, $value);
		$model = new static();
		if ($id > 0) {
			$query->where($model->getKeyName(), '<>', $id);
		}
		return $query->count() > 0;
	}

}

class SoftDeleteScope extends Illuminate\Database\Eloquent\SoftDeletingScope {

	/**
	 * 只获取正常数据
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $builder        	
	 * @return void
	 */
	public function apply(Illuminate\Database\Eloquent\Builder $builder) {
		$model = $builder->getModel();
		
		$builder->where($model->getQualifiedDeletedAtColumn(), '=', new Illuminate\Database\Query\Expression('0'));
		
		$this->extend($builder);
	}

	/**
	 * 只获取软删除数据
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $builder        	
	 * @return void
	 */
	protected function addOnlyTrashed(Illuminate\Database\Eloquent\Builder $builder) {
		$builder->macro('onlyTrashed', function (Illuminate\Database\Eloquent\Builder $builder) {
			$this->remove($builder);
			
			$builder->getQuery()->where($builder->getModel()->getQualifiedDeletedAtColumn(), '>', new Illuminate\Database\Query\Expression('0'));
			
			return $builder;
		});
	}

	/**
	 * 去掉软删除条件
	 *
	 * @param array $where        	
	 * @param string $column        	
	 * @return bool
	 */
	protected function isSoftDeleteConstraint(array $where, $column) {
		return $where['type'] == 'Basic' && $where['operator'] == '=' && $where['value'] == '0' && $where['column'] == $column;
	}

	/**
	 * 检测是否重复
	 * 
	 * @param string $column        	
	 * @param object $value        	
	 * @param number $id        	
	 * @return boolean
	 */
	public static function checkRepeat($column, $value, $id = 0) {
		$query = static::where($column, $value);
		$model = new static();
		if ($id > 0) {
			$query->where($model->getKeyName(), '<>', $id);
		}
		return $query->count() > 0;
	}

}