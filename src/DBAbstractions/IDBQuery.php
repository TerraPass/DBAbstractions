<?php

namespace DBAbstractions;

/**
 * This interface provides methods implemented by wrapped prepared statements.
 */
interface IDBQuery
{
    /**
     * Parametrize query, using values from $params array.
     * 
     * @param type $name Description
     * @return DBAbstractions\IDBQuery Returns this IDBQuery to allow chaining.
     */
    public function setParameters(array $params);
    
    /**
     * Execute query, optionally providing parameters along the way.
     * 
     * @param array $params If specified, the query will be parametrized using this array.
     * @return DBAbstractions\IDBQueryResult Query result.
     * @throws DBAbstractions\Exception\DatabaseQueryFailedException
     */
    public function execute(array $params = null);
}