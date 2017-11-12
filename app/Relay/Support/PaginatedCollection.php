<?php namespace BibleExperience\Relay\Support;

use BibleExperience\Relay\Support\GraphQLGenerator;

class PaginatedCollection {

   function __construct($args, $model){ 
      $this->args = $args;
      $this->direction = 'ASC';

      $this
        ->setPerPage()
        ->setCursor()
        ->setModel($model)
        ->setTotalCount()
        ->setOrderByField()
        ->setFilter()
        ->setCurrentPage()
        ->setEdges()
        ->setTotalPagesCount()
        ->setArgs()
        ->setPageInfo()
        ->build();
   }

 public function setPerPage()
  {
    if(isset($this->args['first'])){
      $this->perPage = $this->args['first'];
    }else if(isset($this->args['perPage'])){
      $this->perPage = $this->args['perPage'];
    }else{
      $this->perPage = 5;
    }

    return $this;
  }

  public function setCursor()
  {

    $this->cursor = ["before"=>null, "after"=> 0];

    if(isset($this->args['before'])){
      $this->cursor = ["before"=> GraphQLGenerator::decodeCursor($this->args['before']), "after"=>null];
    }else 
    if(isset($this->args['after'])){
     $this->cursor = ["before"=> null, "after"=> GraphQLGenerator::decodeCursor($this->args['after'])];
   }

    return $this;
  }

 public function setModel($model)
  {

      if(isset($this->args['filter'])){
        $filter = explode(":", $this->args['filter']);
        $this->model = $model->where($filter[0], 'like', '%'.$filter[1].'%');
      }else{
        $this->model = $model;
      }

    return $this;
  }

    public function setTotalCount(){
     $this->totalCount = $this->model->count();
     return $this;
  }

   public function setOrderByField()
  {
      if(isset($this->args['order_by'])){
        $x = explode(":",$this->args['order_by']);
        $this->orderByField = $x[1];
        $this->direction = $x[0]? $x[0]:'id';
      } if(isset($this->args['orderBy'])){
        $x = explode(":",$this->args['orderBy']);
        $this->direction = $x[1];
        $this->orderByField = $x[0]? $x[0]:'id';
      }else{
        $this->orderByField = 'id';
        $this->direction = 'ASC';
      }

    return $this;
  }

     public function setFilter()
  {
      if(isset($this->args['filter'])){
        $x = explode(":",$this->args['filter']);
        $this->filterField = $x[0];
        $this->filterValue = $x[1]? $x[1]:'';
      }else{
        $this->filterField = false;
        $this->filterValue = false;
      }

    return $this;
  }

public function setCurrentPage(){
  if(isset($this->args['page'])){$this->currentPage = $this->args['page'];}else{
    $this->currentPage = null;
  }
  return $this;
}

public function setTotalPagesCount(){
   if(isset($this->args['page'])){$this->totalPagesCount = ceil($this->totalCount/$this->perPage);}else{
    $this->totalPagesCount = null;
   }
  return $this;
}

  public function setEdges()
  {
    $this->edges = [];

    if($this->model->first() === null){
      return $this;
    }

    $items = $this->model->orderBy($this->orderByField, $this->direction);

    if($this->filterField !== false){
      $items = $items->where($this->filterField, $this->filterValue);
    }

    if(isset($this->cursor["after"]) && $this->cursor["after"] !== null && $this->model->first()) {
      $items = $items
          ->where($this->model->first()->getTable() .'.id', '>', $this->cursor["after"])
          ->take($this->perPage)
          ->get();

    }else {
      $items = $items
          ->where('id', '<', $this->cursor["before"])
          ->take($this->perPage)
          ->get();
    }

      foreach($items as $item){

        $this->edges[] = [
          "cursor"=> GraphQLGenerator::makeCursor($item->id),
          "node"=>$item
        ];
      }

      return $this;
  }

     public function setArgs(){
        $this->args = array_merge($this->args, [
        'totalCount' => $this->totalCount,
        'perPage' => $this->perPage,
        'totalPagesCount' => $this->totalPagesCount,
        'currentPage' => $this->cursor
        ]);

        return $this;
   }

  public function setPageInfo(){

    $startCursor = null;
    $endCursor = null;

    if(count($this->edges) >= 1){
      $startCursor = $this->edges[0]['cursor'];
      $endCursor = $this->edges[count($this->edges)-1]['cursor'];
    }

    $this->resultsInfo = [
      "currentPage"=> $this->cursor,
      "perPage" => $this->perPage,
      "totalCount" => $this->totalCount,
      "totalPagesCount" => $this->totalPagesCount,
      "currentPage" => $this->currentPage
    ];

    $this->pageInfo = [
      "hasNextPage"=> $this->currentPage < $this->totalPagesCount,
      "hasPreviousPage"=> $this->currentPage > 1,
      "startCursor"=> $startCursor,
      "endCursor"=> $endCursor
    ];

      return $this;
  }

 public function build()
  {
    return $this;
}

 }