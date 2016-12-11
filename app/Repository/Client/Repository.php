<?php namespace BibleExperience\Repository\Client;

interface Repository extends \BibleExperience\Repository\Base\Repository {
  public function showFromUserPass($username, $password, array $opts);
}