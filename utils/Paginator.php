<?php

require_once "../vendor/autoload.php";

use Doctrine\ORM\Query;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Paginator
 *
 * @author Asus
 */
class Paginator {
    
    /**
     * Return the paginated result of the given query with a given offset and limit
     * @param type $query the query to be executed
     * @param type $offset the offset
     * @param type $limit the limit
     * @return array an array that contains the data and the total count.
     */
    public function paginate($query, $offset, $limit){
        $totalCount = self::processCountQuery($query);
        
        $query->setFirstResult($offset);
        $query->setMaxResults($limit);
        $result = $query->getResult();
        
        return array("count" => $totalCount,
                     "offset" => $offset,
                     "limit" => $limit,
                     "data" => $result);
    }
    
    
    /**
     * Build a new query from the source query in order to count the total result.
     * @param type $query the source query
     * @return Query the new count query.
     */
    protected function processCountQuery($query){
        $countQuery = self::cloneQuery($query);
        $countQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, 
                    array('Doctrine\ORM\Tools\Pagination\CountWalker'));
        return intval($countQuery->getSingleScalarResult());
    }
    
    
    /**
     * Clones a query
     * @param Query $query the query to be cloned
     * @return \Query the new query
     */
    private function cloneQuery($query)
    {
        /* @var $cloneQuery Query */
        $cloneQuery = clone $query;

        $cloneQuery->setParameters(clone $query->getParameters());

        foreach ($query->getHints() as $name => $value) {
            $cloneQuery->setHint($name, $value);
        }

        return $cloneQuery;
    }
}

?>
