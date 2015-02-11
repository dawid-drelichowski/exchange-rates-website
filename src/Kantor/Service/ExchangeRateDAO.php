<?php

namespace Kantor\Service;

use Doctrine\DBAL\Connection;

class ExchangeRateDAO
{
    const TABLE_NAME = 'ExchangeRate';

    const TYPE_RETAIL = 1;

    const TYPE_WHOLESALE = 2;

    /**
     * @var Connection
     */
    private $db;

    /**
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }


    /**
     * @param $typeId
     * @return array
     */
    public function getByTypeId($typeId)
    {
        $query = sprintf('SELECT * FROM `%s` WHERE `typeId` = ?', self::TABLE_NAME);
        return $this->db->fetchAll($query, array($typeId));
    }

    /**
     * @param array $data
     * @param $id
     * @return int
     */
    public function update(array $data, $id)
    {
        return $this->db->executeUpdate('CALL `updateExchangeRate`(?, ?, ?, ?, ?, ?)', array(
            $id, $data['typeId'], $data['country'], $data['currency'], $data['purchase'], $data['sale']
        ));
    }

    /**
     * @param array $data
     * @return int
     */
    public function add(array $data)
    {
        return $this->db->insert(self::TABLE_NAME, $data);
    }

    /**
     * @param $id
     * @return int
     */
    public function remove($id)
    {
        return $this->db->delete(self::TABLE_NAME, array('id' => $id));
    }
} 