<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <gigaprog@proton.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Src;

use PDO;
use Exception;
use Src\Model;

/**
 * @package GiGaFlow\QueryBuilder
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 * @see Model
 */
class QueryBuilder extends Model
{
	/**
	 * Set the name of the table request.
	 *
	 * @access protected
	 * @var string
	 */
	protected string $table;

	/**
	 * Constructor.
	 *
	 * @param string $table
	 */
	public function __construct(string $table)
	{
		$this->table = $table;
	}

	/**
	 * Return all records from a table.
	 *
	 * @param string $table
	 * @param PDO $fetchType
	 * @param string $orderBy
	 * @param string $sort
	 * @return mixed
	 */
	public function findAll( 
		int $fetchType = \PDO::FETCH_OBJ,
		string $orderBy = "id",
		string $sort = "DESC"
	): mixed
	{
		$stmt = Model::getDB()->query("SELECT * FROM $this->table ORDER BY $orderBy $sort"); 
		
    return $stmt->fetchAll($fetchType);
	}

	/**
	 * Get record from an id.
	 *
	 * @param string $table
	 * @param int $id
	 * @param int $fetchType
	 * @return mixed
	 */
	public function findById(
		int $id,
		int $fetchType = \PDO::FETCH_OBJ
	): mixed 
	{
		$sql = "SELECT * FROM $this->table WHERE id=:id";
		$stmt = Model::getDB()->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		if (! $stmt->execute()) {
			throw new \Exception(sprintf(
				"Error PDO exec: %s", implode(", ", Model::getDB()->errorInfo())
			));
		}

		return $stmt->fetch($fetchType);
	}

	/**
	 * Find record with one condition true.
	 *
	 * @param string $field
	 * @param string $value
	 * @param int $fetchType
	 * @return mixed
	 */
	public function findLastOne(
		string $field, 
		string|int $value,
		int $fetchType = \PDO::FETCH_OBJ
	): mixed
	{
		$sql = "SELECT * FROM $this->table WHERE $field = :$field ORDER BY id DESC";
		$stmt = Model::getDB()->prepare($sql);
		$stmt->bindValue(":$field", $value);
		
		if (! $stmt->execute()) {
			throw new \Exception(sprintf(
				"Error PDO exec: %s", implode(", ", Model::getDB()->errorInfo())
			));
		}
		
		return $stmt->fetch($fetchType);
	}

	/**
	 * Find latest records with one condition true.
	 *
	 * @param string $field
	 * @param string $value
	 * @param int $fetchType
	 * @return mixed
	 */
	public function findLatest(
		string $field, 
		string|int $value,
		int $limit,
		int $fetchType = \PDO::FETCH_OBJ
	): mixed
	{
		$sql = "SELECT * FROM $this->table WHERE $field = :$field ORDER BY id DESC LIMIT $limit";
		$stmt = Model::getDB()->prepare($sql);
		$stmt->bindValue(":$field", $value);
		
		if (! $stmt->execute()) {
			throw new \Exception(sprintf(
				"Error PDO exec: %s", implode(", ", Model::getDB()->errorInfo())
			));
		}
		
		return $stmt->fetchAll($fetchType);
	}

	/**
	 * Find record with one condition true.
	 *
	 * @param string $field
	 * @param string $value
	 * @param int $fetchType
	 * @return mixed
	 */
	public function findWhere(
		string $field, 
		string|int $value,
		int $fetchType = \PDO::FETCH_OBJ
	): mixed
	{
		$sql = "SELECT * FROM $this->table WHERE $field = :$field";
		$stmt = Model::getDB()->prepare($sql);
		$stmt->bindValue(":$field", $value);
		
		if (! $stmt->execute()) {
			throw new \Exception(sprintf(
				"Error PDO exec: %s", implode(", ", Model::getDB()->errorInfo())
			));
		}
		
		return $stmt->fetch($fetchType);
	}

	/**
	 * Find record with one condition false.
	 *
	 * @param string $field
	 * @param string $value
	 * @param int $fetchType
	 * @return mixed
	 */
	public function findAllWhereNot(
		string $field, 
		string|int $value,
		int $fetchType = \PDO::FETCH_OBJ
	): mixed
	{
		$sql = "SELECT * FROM $this->table WHERE $field != :$field";
		$stmt = Model::getDB()->prepare($sql);
		$stmt->bindValue(":$field", $value);
		
		if (! $stmt->execute()) {
			throw new \Exception(sprintf(
				"Error PDO exec: %s", implode(", ", Model::getDB()->errorInfo())
			));
		}
		
		return $stmt->fetchAll($fetchType);
	}

	/**
	 * Find record with one condition true.
	 *
	 * @param string $field
	 * @param string $value
	 * @param int $fetchType
	 * @return mixed
	 */
	public function findAllWhere(
		string $field, 
		string|int $value,
		int $fetchType = \PDO::FETCH_OBJ
	): mixed
	{
		$sql = "SELECT * FROM $this->table WHERE $field = :$field";
		$stmt = Model::getDB()->prepare($sql);
		$stmt->bindValue(":$field", $value);
		
		if (! $stmt->execute()) {
			throw new \Exception(sprintf(
				"Error PDO exec: %s", implode(", ", Model::getDB()->errorInfo())
			));
		}
		
		return $stmt->fetchAll($fetchType);
	}

	/**
	 * Find record has two conditions true.
	 *
	 * @param string $firstField
	 * @param string $firstValue
	 * @param string $secondField
	 * @param string|int $secondValue
	 * @param int $fetchType
	 * @return mixed
	 */
	public function findWhereAnd(
		string $firstField, 
		string $firstValue,
		string $secondField,
		string|int $secondValue,
		int $fetchType = \PDO::FETCH_OBJ
	): mixed
	{
		$sql = "SELECT * FROM $this->table WHERE $firstField = :$firstField AND $secondField = :$secondField";
		$stmt = Model::getDB()->prepare($sql);
		$data = [
			":$firstField" => $firstValue,
			":$secondField" => $secondValue
		];
		if (! $stmt->execute($data)) {
			throw new \Exception(sprintf(
				"Error PDO exec: %s", implode(", ", Model::getDB()->errorInfo())
			));
		}
		
		return $stmt->fetch($fetchType);
	}

	/**
	 * Insert record into database.
	 *
	 * @param array $values
	 * @return void
	 */
	public function insert(
		array $values
	): void
	{
		$arrayFields = array_keys($values);
		$fields = implode(", ", $arrayFields);
		$sql = "INSERT INTO $this->table ($fields) VALUES ";
		$paramsBinded = array_map(function($item) {
			return ":" . $item;
		}, $arrayFields);
		$sql .= "(" . implode(", ", $paramsBinded) . ")";
		$stmt = Model::getDB()->prepare($sql);
		
		$data = [];
		foreach ($values as $key => $value) {
			$data[":" . $key] = $value;
		}
		
		if (! $stmt->execute($data)) {
			throw new \Exception(sprintf(
				"Error PDO exec: %s", implode(", ", Model::getDB()->errorInfo())
			));
		}
	}

	/**
	 * Update resource.
	 *
	 * @param string $table
	 * @param string|integer $id
	 * @param array $values
	 * @return bool
	 */
	public function update(
		string|int $id,
		array $values
	): bool 
	{
		$arrayFields = array_keys($values);
		$paramsBinded = array_map(function($item) {
			return $item . "=:" . $item;
		}, $arrayFields);
		$params = implode(', ', $paramsBinded);
		$sql = "UPDATE $this->table SET $params WHERE id = :id";
		$stmt = Model::getDB()->prepare($sql);

		$data = [
			":id" => $id
		];
		foreach ($values as $key => $value) {
			$data[":" . $key] = $value;
		}
		
		if (! $stmt->execute($data)) {
			throw new \Exception(sprintf(
				"Error PDO exec: %s", implode(", ", Model::getDB()->errorInfo())
			));
		}
		
		return $stmt->execute($data);
	}

	/**
	 * Update resource.
	 *
	 * @param string $table
	 * @param string|int $id
	 * @param array $values
	 * @return bool
	 */
	public function updateWhere(
		string $field,
		string|int $id,
		array $values
	): bool 
	{
		$arrayFields = array_keys($values);
		$paramsBinded = array_map(function($item) {
			return $item . "=:" . $item;
		}, $arrayFields);
		$params = implode(', ', $paramsBinded);
		$sql = "UPDATE $this->table SET $params WHERE $field = :id";
		$stmt = Model::getDB()->prepare($sql);

		$data = [
			":id" => $id
		];
		foreach ($values as $key => $value) {
			$data[":" . $key] = $value;
		}
		
		if (! $stmt->execute($data)) {
			throw new \Exception(sprintf(
				"Error PDO exec: %s", implode(", ", Model::getDB()->errorInfo())
			));
		}

		return $stmt->execute($data);
	}



	/**
	 * DElete record.
	 *
	 * @param string $table
	 * @param string|int $id
	 * @return void
	 */
	public function delete(
		string|int $id
	): void 
	{
		$sql = "DELETE FROM $this->table WHERE id=:id";
        $stmt = Model::getDB()->prepare($sql);
        $stmt->bindParam(":id", $id);

        if ( ! $stmt->execute()) {
            throw new Exception(sprintf(
                "Error PDO exec: %s", implode(',', Model::getDB()->errorInfo())
            ));
        }
	}
}