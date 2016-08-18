<?php namespace BibleExperience\Http\Controllers;

use \BibleExperience\Repository\Lrs\Repository as LrsRepo;
use \BibleExperience\Repository\Statement\EloquentRepository as StatementRepo;
use \BibleExperience\Repository\Statement\EloquentIndexer as StatementIndexer;
use \BibleExperience\Repository\Statement\IndexOptions as IndexOptions;

use \Response, \Request, \Redirect;

class LrsController extends BaseController {

  protected $lrs, $analytics, $statements;

  /**
   * Constructs a new LrsController.
   * @param LrsRepo $lrs
   * @param StatementRepo $statement
   */
  public function __construct(LrsRepo $lrs, StatementRepo $statement){
    $this->lrs = $lrs;
    $this->statement = $statement;

    // Defines filters.
    $this->middleware('auth');
   /* $this->middleware('csrf', ['only' => [
      'store', 'update', 'destroy', 'editCredentials', 'usersRemove', 'changeRole'
    ]]);*/
    $this->middleware('auth.lrs', ['except' => ['index','create','store']]); //check user can access LRS.
    $this->middleware('edit.lrs', ['only' => [
      'edit','update','endpoint',
      'users', 'usersRemove', 'inviteUsersForm',
      'changeRole', 'api', 'editCredentials'
    ]]); //check user can edit LRS.
    $this->middleware('create.lrs', ['only' => ['create','store']]); //Allowed to create an LRS?
  }

  private function getLrs($lrs_id) {
    $opts = ['user' => \Auth::user()];
    return [
      'lrs' => $this->lrs->show($lrs_id, $opts),
      'list' => $this->lrs->index($opts)
    ];
  }

  /**
   * Display a listing of LRSs available for user.
   * @return View
   */
  public function index() {
    $opts = ['user' => \Auth::user()];
    $lrs = $this->lrs->index($opts);
    return view('partials.lrs.list', ['lrs' => $lrs, 'list' => $lrs]);
  }

  /**
   * Show the form for creating a new resource.
   * @return View
   */
  public function create() {
    $verified = \Auth::user()->verified;
    return view('partials.lrs.create', ['verified' => $verified]);
  }

  /**
   * Store a newly created resource in storage.
   * @return View
   */
  public function store() {
    $data = \Input::all();

    //lrs input validation
    $rules['title']        = 'required';
    $rules['description']  = '';
    $validator = \Validator::make($data, $rules);
    if ($validator->fails()) return \Redirect::back()->withErrors($validator);

    // Store lrs
    $opts = ['user' => \Auth::user()];
    $s = $this->lrs->store($data, $opts);

    if($s){
      return \Redirect::to('/site#lrs')->with('success', trans('lrs.created'));
    }

    return \Redirect::back()
      ->withInput()
      ->with('error', trans('create_problem'));
  }

  /**
   * Show the form for editing the specified resource.
   * @param String $lrs_id
   * @return View
   */
  public function edit($lrs_id) {
    return view('partials.lrs.edit', array_merge($this->getLrs($lrs_id), [
      'account_nav' => true
    ]));
  }

  /**
   * Update the specified resource in storage.
   * @param String $lrs_id
   * @return View
   */
  public function update($lrs_id){
    $data = \Input::all();

    //lrs input validation
    $rules['title'] = 'required';
    $validator = \Validator::make($data, $rules);
    if ($validator->fails()) {
      return \Redirect::back()->withErrors($validator);
    };

    $opts = ['user' => \Auth::user()];
    $l = $this->lrs->update($lrs_id, $data, []);

    if ($l) {
      return \Redirect::back()->with('success', trans('lrs.updated'));
    }

    return \Redirect::back()
      ->withInput()
      ->withErrors($this->lrs->errors());
  }

  /**
   * Display the specified resource.
   * This is a temp hack until the single page app for
   * analytics is ready. v1.0 stable.
   * @param String $lrs_id
   * @return View
   */
  public function show($lrs_id) {
    $dashboard = new \BibleExperience\Locker\data\dashboards\LrsDashboard($lrs_id);
    return view('partials.lrs.dashboard', array_merge($this->getLrs($lrs_id), [
      'stats' => $dashboard->getStats(),
      'dash_nav' => true,
      'client' => (new \BibleExperience\Client)->where('lrs_id', $lrs_id)->first()
    ]));
  }

  public function getStats($lrs_id, $segment = '') {
    $dashboard = new \BibleExperience\Locker\data\dashboards\LrsDashboard($lrs_id);

    switch ($segment) {
      case 'topActivities':
        $get_stats = $dashboard->getTopActivities($lrs_id);
        $get_stats = $get_stats['result'];
        break;
      case 'activeUsers':
        $get_stats = $dashboard->getActiveUsers($lrs_id);
        $get_stats = $get_stats['result'];
        break;
      default:
        $get_stats = $dashboard->getStats();
        break;
    }
    return Response::json($get_stats);
  }

  public function getGraphData($lrs_id) {
    $startDate = \Request::get('graphStartDate');
    $endDate = \Request::get('graphEndDate');

    $startDate = !$startDate ? null : new \Carbon\Carbon($startDate);
    $endDate = !$endDate ? null : new \Carbon\Carbon($endDate);
    $dashboard = new \BibleExperience\Locker\data\dashboards\LrsDashboard($lrs_id);
    $graph_data = $dashboard->getGraphData($startDate, $endDate);
    return Response::json($graph_data);
  }

  /**
   * Remove the specified resource from storage.
   * @param String $lrs_id
   * @return View
   */
  public function destroy($lrs_id){
    $opts = ['user' => \Auth::user()];
    $this->lrs->destroy($lrs_id, $opts);
    return Response::json([
      'success' => 200,
      'message' => 'deleted'
    ]);
  }

  /**
   * Display statements for this LRS
   * @param String $lrs_id
   * @return View
   */
  public function statements($lrs_id){
    $site = \Site::first();
    $statements = (new StatementIndexer)->index(new IndexOptions([
      'lrs_id' => $lrs_id,
      'limit' => $this->statement->count([
        'lrs_id' => $lrs_id,
        'scopes' => ['all']
      ]),
      'scopes' => ['all']
    ]))->orderBy('stored', 'DESC')->paginate(15, ['*'], ['lrs_id'=>1], ['lrs_id'=>1, 'active'=>-1, 'voided'=>1]);

    return view('partials.statements.list', array_merge($this->getLrs($lrs_id), [
      'statements' => $statements,
      'statement_nav' => true,
      'lang' => $site->lang
    ]));
  }

  /**
   * Display the api view.
   * @param String $lrs_id
   * @return View
   */
  public function api($lrs_id) {
    return view('partials.lrs.api', array_merge($this->getLrs($lrs_id), [
      'api_nav' => true
    ]));
  }

  /**
   * Display users with access to this lrs.
   * @param String $lrs_id
   * @return View
   */
  public function users($lrs_id) {
    $opts = $this->getLrs($lrs_id);
    return view('partials.users.list', array_merge($opts, [
      'users'    => $opts['lrs']->users,
      'user_nav' => true
    ]));

  }

  public function inviteUsersForm($lrs_id) {
    $opts = $this->getLrs($lrs_id);
    return view('partials.lrs.invite', array_merge($opts, [
      'users'    => $opts['lrs']->users,
      'user_nav' => true
    ]));

  }

  public function usersRemove($lrs_id) {
    $lrs = $this->lrs->removeUser($lrs_id, Input::get('user'));
    return Redirect::back()->with('success', trans('lrs.remove_user'));
  }

  public function changeRole($lrs_id, $user, $role) {
    $change = $this->lrs->changeRole($lrs_id, $user, $role);
    return Response::json(['success' => true]);
  }
}
