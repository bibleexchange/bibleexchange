<?php namespace BibleExperience\Repository\Report;

interface Repository extends \BibleExperience\Repository\Base\Repository {
  public function setQuery($lrs, $query, $field, $wheres);
  public function statements($id, array $opts);
}