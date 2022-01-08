<?php

class Model
{
	protected $code;

	protected $table;

	protected $fillable;

	public static function all($columns = '*')
	{
		$where = array(
			'status' => 'Active',
			);

		return Amst::select((new static)->getQueryPrefix(), $columns, $where);
	}

	public static function id($id, $columns = '*')
	{
		$where = array(
			'AND' => array(
				'id' => $id,
				'status' => 'Active',
				),
			);

		return Amst::get((new static)->getQueryPrefix(), $columns, $where);
	}

	public static function create($data)
	{
		$instance = new static;

		$data = $instance->onlyFillable($data);

		return Amst::insert($instance->getQueryPrefix(), $data);
	}

	public static function update($id, $data)
	{
		$instance = new static;

		$data = $instance->onlyFillable($data);

		$where = array(
			'id' => $id,
			);

		return Amst::update($instance->getQueryPrefix(), $data, $where);
	}

	public static function delete($id)
	{
		$where = array(
			'id' => $id,
			);

		return Amst::delete((new static)->getQueryPrefix(), $where);
	}

	public static function softDelete($id)
	{
		$instance = new static;

		$data = array(
			'status' => 'Deleted',
			);

		$where = array(
			'id' => $id,
			);

		return Amst::update($instance->getQueryPrefix(), $data, $where);
	}

	public function onlyFillable($inputs)
	{
		if (!isset($this->fillable))
			return $inputs;

		foreach ($inputs as $key => $input) {
			if (!in_array($key, $this->fillable)) {
				unset($inputs[$key]);
			}
		}

		return $inputs;
	}

	public function getQueryPrefix()
	{
		return $this->getCode() . '_' . $this->getTable();
	}

	public function getTable()
	{
		return isset($this->table) ? $this->table : mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1_', get_class($this)), 'UTF-8');
	}

	public function getCode()
	{
		return isset($this->code) ? $this->code : $_GET['c'];
	}
}