<?php

namespace DBAbstractions;

/**
 * This interface provides methods implemented by wrapped prepared statements.
 * 
 * @todo Make Traversable
 */
interface IDBQueryResult
{
    /**
     * Get number of affected or selected rows
     * 
     * @return integer Number of affected rows for INSERT, UPDATE, DELETE queries,
     * number of rows in result set for SELECT queries
     */
    public function getNumberOfRows();
    
    /**
     * Check whether this result is for SELECT query
     * 
     * @return boolean TRUE if the result is for SELECT query, FALSE otherwise.
     */
    public function isSelectResult();

    /**
     * Get SELECT result set as a numbered array of associative arrays
     */
    public function getResultSetAssoc();
}