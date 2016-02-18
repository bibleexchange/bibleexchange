@if($paginator->getLastPage() > 1)
    <div class="pagination">
        {{ with(new Acme\Pagination\Presenters\MinimalPaginationPresenter($paginator))->render() }}
    </div>
@endif