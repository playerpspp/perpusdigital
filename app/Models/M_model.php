<?php

namespace App\Models;
use CodeIgniter\Model;

class M_model extends model
{

	public function tampil($table)
	{
		$primaryKey = $this->db->getFieldData($table)[0]->name; // Get the name of the primary key column
		return $this->db->table($table)
						->orderBy($primaryKey, 'desc')
						->get()
						->getResult();
	}

	public function like ($table, $where)
	{
		return $this->db->table($table)->like($where)->get()->getResult();
	}
	public function like_row ($table, $where)
	{
		return $this->db->table($table)->like($where)->get()->getRowArray();
	}

	public function filter ($table, $where)
	{
		return $this->db->table($table)->getWhere($where)->getResult();
	}

	public function filter2 ($table,$column,$where)
	{
		return $this->db->query("
			SELECT *
			FROM ".$table."
			WHERE ".$column."
			LIKE '%".$where."%'

		")->getResult();
	}

	public function filter_pj ($table,$awal,$akhir)
	{
		return $this->db->query("
			SELECT *
			FROM ".$table."
			join buku
			on ".$table.".id_buku=buku.id_buku
			join karyawan
			on ".$table.".id_user=karyawan.id_user
			WHERE ".$table.".tgl_pinjam
			BETWEEN '".$awal."'
			and '".$akhir."'and status=0"
		)->getResult();
	}

	public function filter_pg ($table,$awal,$akhir)
	{
		return $this->db->query("
			SELECT *
			FROM ".$table."
			join buku
			on ".$table.".id_buku=buku.id_buku
			join karyawan
			on ".$table.".id_user_kembali=karyawan.id_user
			WHERE ".$table.".tgl_kembali
			BETWEEN '".$awal."'
			and '".$akhir."'and status=1"
		)->getResult();
	}

	public function count_b ()
	{
		return $this->db->query("
			SELECT COUNT(id_buku)
			FROM buku	
			")->getResult();
	}

	public function hapus($table, $where)
	{
		return $this->db->table($table)->delete($where);
	}

	public function simpan($table, $data)
	{
		return $this->db->table($table)->insert($data);
	}

	public function simpanID($table, $data)
	{
		$this->db->table($table)->insert($data);
		return $this->db->insertID();
	}

	public function getWhereKey($table, $where,$key)
	{
		$query = $this->db->table($table)->getWhere($where)->getResult();

		$result = [];
		foreach ($query as $row) {
			$result[$row->$key] = $row;
		}

		return $result;
	}

	public function getwhereInKey($table, $where, $key)
	{
		$query = $this->db->table($table)->whereIn($key, array_column($where, $key))->get()->getResult();

		$result = [];
		foreach ($query as $row) {
			$result[$row->$key] = $row;
		}

		return $result;
	}

	public function getwhereInKey_student($table, $where, $key)
	{
		$query = $this->db->table($table)->whereIn($key, array_column($where, $key))->orderBy('student_id','asc')->get()->getResult();

		$result = [];
		foreach ($query as $row) {
			$result[$row->$key] = $row;
		}

		return $result;
	}

	public function getwhereInKey_where($table, $where, $key, $where2)
	{
		$query = $this->db->table($table)->whereIn($key, array_column($where, $key))->getWhere($where2)->getResult();

		$result = [];
		foreach ($query as $row) {
			$result[$row->$key] = $row;
		}

		return $result;
	}

	public function getwhereInKey2($table, $where, $key)
	{
		$query = $this->db->table($table)->whereIn($key, array_column($where, $key))->get()->getResult();

		$result = [];
		foreach ($query as $row) {
			$result[$row->$key][] = $row;
		}

		return $result;
	}

	public function getwhereInKey2_where($table, $where, $key, $where2)
	{
		$query = $this->db->table($table)->whereIn($key, array_column($where, $key))->getWhere($where2)->getResult();

		$result = [];
		foreach ($query as $row) {
			$result[$row->$key][] = $row;
		}

		return $result;
	}

	public function getwhereInKey3($table, $where, $key)
	{
		$query = $this->db->table($table)->whereIn($key, array_column($where, $key))->get()->getResult();

		$result = [];
		foreach ($query as $row) {
			$result[$row->$key][] = $row;
		}

		foreach ($result as $k => $v) {
			shuffle($result[$k]);
		}

		return $result;
	}

	public function getwhereInKey4($table, $where, $key)
	{
		$query = $this->db->table($table)->whereIn($key, array_column($where, $key))->orderBy('option','asc')->get()->getResult();

		$result = [];
		foreach ($query as $row) {
			$result[$row->$key][] = $row;
		}

		

		return $result;
	}

	public function getWhere($table, $where)
	{
		return $this->db->table($table)->getWhere($where)->getResult();
	}

	public function whereIncount($table, $where, $column)
	{
		// return $this->db->table($table)->whereIn($where)->count($column);
	}

	public function getwhereIn($table, $column, $whereIn)
	{
		return $this->db->table($table)->whereIn($column, $whereIn)->get()->getResult();
	}

	public function getwhereIn2($table, $column, $whereIn, $where)
	{
		return $this->db->table($table)->whereIn($column, $whereIn)->where($where)->get()->getResult();
	}

	public function getWhere2($table, $where,$tgl)
	{
		return $this->db->query("
			SELECT *
			FROM ".$table."
			WHERE ".$table.".tgl_kembali
			='".$tgl."'and status=1"
		)->getResult();
	}

	public function getRow($table, $where)
	{
		return $this->db->table($table)->getWhere($where)->getRow();
	}

	public function edit($table, $data, $where)
	{
		return $this->db->table($table)->update($data, $where);
	}

	public function getRowArray($table, $where)
	{
		return $this->db->table($table)->getWhere($where)->getRowArray();
	}

	public function getarray_f($table, $where)
	{
		// return $this->db->table($table)->getWhere($where)->orderBy('created_at','DESC')->get()->getRowArray();
	}

	public function countGroup($table,$select,$group)
	{
		$query = $this->db->table($table)
		->select($select)
		->groupBy($group)
		->get()
		->getResult();

		$result = [];
		foreach ($query as $row) {
			$result[$row->$group] = $row;
		}

		return $result;
	}

	public function countGroup_w($table,$select,$group,$where)
	{
		$query = $this->db->table($table)
		->select($select)
		->groupBy($group)
		->getWhere($where)
		->getResult();

		$result = [];
		foreach ($query as $row) {
			$result[$row->$group] = $row;
		}

		return $result;
	}

	public function countGroup2($check,$check2,$table,$select,$group)
	{
		$tablecheck = $this->db->table($check)->get()->getResult();
		$query = $this->db->table($table)
		->select($select)
		->groupBy($group)
		->get()
		->getResult();

		$result = [];
		$no=0;
		foreach ($tablecheck as $tc) {
			if ($query[$no]->$group == $tc->$check2){
			$result[$tc->$check2] = $query[$no];
			}else{
				$result[$tc->$check2]= '0';
			}
			$no++;
		}

		return $result;
	}


	public function fusion($table1, $table2, $on)
	{
		$primaryKey = $this->db->getFieldData($table1)[0]->name;
		return $this->db->table($table1)->join($table2, $on)
		->orderBy($primaryKey, 'desc')->get()->getResult();
	}

	public function classes($table1, $table2, $on)
	{
		$sql = "SELECT ".$table1.".*, COUNT(".$table2.".id) as num_students
		FROM ".$table1."
		LEFT JOIN ".$table2." ON ".$on."
		GROUP BY ".$table1.".class_id";
		$query = $this->db->query($sql);
		return $query->getResult();
	}

	public function fusionArray($table1, $table2, $on ,$where)
	{
		return $this->db->table($table1)->join($table2, $on)->getWhere($where)->getRowArray();
	}
	public function fusionRow($table1, $table2, $on ,$where)
	{
		return $this->db->table($table1)->join($table2, $on)->getWhere($where)->getRow();
	}

	public function fusionleft($table1, $table2, $on)
	{
		return $this->db->table($table1)->join($table2, $on, 'left')->get()->getResult();
	}

	public function fusion_where($table1, $table2, $on,$where)
	{
		return $this->db->table($table1)->join($table2, $on)->getWhere($where)->getResult();
	}

	public function fusion_whereIn($table1, $table2, $on, $column, $whereIn)
	{
		return $this->db->table($table1)
		->join($table2, $on)
		->whereIn($column, $whereIn)
		->get()
		->getResult();

	}

	public function super($table1, $table2, $table3, $on, $on2)
	{
		$primaryKey = $this->db->getFieldData($table1)[0]->name;
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)
		->orderBy($primaryKey, 'desc')->get()->getResult();
	}
	public function superLeft($table1, $table2, $table3, $on, $on2)
	{
		$primaryKey = $this->db->getFieldData($table1)[0]->name;
		return $this->db->table($table1)->join($table2, $on, 'left')->join($table3, $on2, 'left')
		->orderBy($primaryKey, 'desc')
		->get()
		->getResult();
	}

	public function superLeftLike2($table1, $table2, $table3, $on, $on2 ,$where, $where2)
	{
		$primaryKey = $this->db->getFieldData($table1)[0]->name;
		return $this->db->table($table1)->join($table2, $on, 'left')->join($table3, $on2, 'left')
		->orderBy($primaryKey, 'desc')
		->like($where)
		->orLike($where2)
		->get()
		->getResult();
	}

	public function superLeftLike2_Where($table1, $table2, $table3, $on, $on2 ,$where, $where2, $where3)
	{
		$primaryKey = $this->db->getFieldData($table1)[0]->name;
		return $this->db->table($table1)->join($table2, $on, 'left')->join($table3, $on2, 'left')
		->orderBy($primaryKey, 'desc')
		->like($where)
		->orLike($where2)
		->getWhere($where3)
		->getResult();
	}

	public function superLeft_where($table1, $table2, $table3, $on, $on2, $where)
	{
		$primaryKey = $this->db->getFieldData($table1)[0]->name;
		return $this->db->table($table1)->join($table2, $on, 'left')->join($table3, $on2, 'left')
		->orderBy($primaryKey, 'desc')->getWhere($where)->getResult();
	}

	public function superLeft_row($table1, $table2, $table3, $on, $on2, $where)
	{
		return $this->db->table($table1)->join($table2, $on, 'left')->join($table3, $on2, 'left')->getWhere($where)->getRow();
	}

	public function super_w($table1, $table2, $table3, $on, $on2,$where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->getWhere($where)->getResult();
	}

	public function super_row($table1, $table2, $table3, $on, $on2,$where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->getWhere($where)->getRow();
	}

	public function superArray($table1, $table2, $table3, $on, $on2,$where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->getWhere($where)->getRowArray();
	}

	public function super_whereIn($table1, $table2, $table3, $on, $on2, $column, $whereIn)
	{
		return $this->db->table($table1)
		->join($table2, $on)
		->join($table3, $on2)
		->whereIn($column, $whereIn)
		->get()
		->getResult();

	}

	public function super_whereInKey($table1, $table2, $table3, $on, $on2, $column, $whereIn,$key)
	{
		$query = $this->db->table($table1)
		->join($table2, $on)
		->join($table3, $on2)
		->whereIn($column, $whereIn)
		->get()
		->getResult();

		$result = [];
		foreach ($query as $row) {
			$result[$row->$key] = $row;
		}

		return $result;

	}

	public function super_whereIn2($table1, $table2, $table3, $on, $on2, $column, $whereIn, $where)
	{
		return $this->db->table($table1)
		->join($table2, $on)
		->join($table3, $on2)
		->whereIn($column, $whereIn)
		->getWhere($where)
		->getResult();

	}

	public function ultra($table1, $table2, $table3, $table4, $on, $on2, $on3)
	{
		$primaryKey = $this->db->getFieldData($table1)[2]->name; // Get the name of the primary key column
		return $this->db->table($table1)
		->orderBy($primaryKey, 'asc')
		->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->get()->getResult();
	}

	public function ultra_left($table1, $table2, $table3, $table4, $on, $on2, $on3)
	{
		$primaryKey = $this->db->getFieldData($table1)[0]->name;
		return $this->db->table($table1)->join($table2, $on, 'left')->join($table3, $on2, 'left')->join($table4, $on3, 'left')->orderBy($primaryKey, 'desc')->get()->getResult();
	}

	public function ultra_leftWhere($table1, $table2, $table3, $table4, $on, $on2, $on3, $where)
	{
		$primaryKey = $this->db->getFieldData($table1)[0]->name;
		return $this->db->table($table1)->join($table2, $on, 'left')->join($table3, $on2, 'left')->join($table4, $on3, 'left')->orderBy($primaryKey, 'desc')->getwhere($where)->getResult();
	}

	public function ultra_leftRow($table1, $table2, $table3, $table4, $on, $on2, $on3, $where)
	{
		$primaryKey = $this->db->getFieldData($table1)[0]->name;
		return $this->db->table($table1)
		->join($table2, $on, 'left')
		->join($table3, $on2, 'left')
		->join($table4, $on3, 'left')
		->orderBy($primaryKey, 'desc')
		->getwhere($where)
		->getRow();
	}

	public function ultra_w($table1, $table2, $table3, $table4, $on, $on2, $on3, $where)
	{
		return $this->db->table($table1)->join($table2, $on, 'left')->join($table3, $on2, 'left')->join($table4, $on3, 'left')->getwhere($where)->getResult();
	}

}