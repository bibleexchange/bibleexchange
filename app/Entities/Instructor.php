<?php namespace BibleExchange\Entities;

use Watson\Validating\ValidatingTrait;

class Instructor extends Eloquent {
	
	use ValidatingTrait;

	protected $observables = ['validating', 'validated','saving'];

	public $fillable = [
 'firstname' , 'lastname' , 'prefix' , 'middlename' , 'suffix' , 'memo', 'image'
	];

	protected $appends = ['fullName'];
	
	protected $rulesets = [
    'creating' => [
      'firstname' =>'required',
	  'lastname' =>'required',
	  'prefix' =>'',
	  'middlename' =>'',
	  'suffix' =>'',
	  'Birthday' =>'',
	  'memo' =>'',
	  'image' =>'',
	  'created_at' =>'integer',
	  'updated_at' =>'integer'
    ],

    'updating' => [
       'id' => 'required|exists:contacts,id'
    ],

    'deleting' => [
        'id'     => 'required|exists:contacts,id'
    ],

    'saving' => [
	  'id'     => 'required|exists:contacts,id',
	  'created_at' =>'integer',
	  'updated_at' =>'integer'
    ]
];
	
	public $timestamps = true;

	protected $hidden = array(NULL);
	
	protected $validationMessages = array(
        'firstname.required' => 'First name is required.',
        'lastname.required' => 'Last name is required.',
        'email.required' => 'Email is required.',
        'password.required' => 'Password is required.',
 
        'email.email' => 'Use a real email address!',
        'email.unique' => 'This email address already exists!',
        'password.min' => 'Password must be 6-12 character long.'
    );
	
		/**
	 * User exposed observable events
	 *
	 * @var array
	 */

	public $collections = array(
	  'mailable',
	  'maine',
	  'outofstate',
	  'portland',
	  'church',
	  'preacher',
	  'recorded',
	  'supported_mission'
    );
	
	public $collections_select = array(
	 'contacts.prefix','contacts.suffix','contacts.firstname','contacts.lastname','addresses.addressee','addresses.address','addresses.city','addresses.state','addresses.zip','addresses.country','addresses.type','addresses.updated_at'
    );
	
	public function addresses()
	  {
		return $this->belongsToMany('Address');
	  }
	  
	public function collections()
	  {
		return $this->belongsToMany('Collection');
	  }
	
	 public function gifts()
    {
        return $this->hasMany('Gift', 'contacts_id');
    }

	public function audios()
    {
        return $this->hasMany('audio', 'contacts_id');
    }

	public function getContactFullNameAttribute()
	{
		return $this->lastname .', '. $this->firstname;
	}

	public function selectList()
	{
		
	$contacts1 = $this->orderBy('lastname','ASC')->select('firstname','lastname','suffix','id')->get();
			
	foreach($contacts1 as $c)
		{
			$contacts[$c['id']] = $c['lastname'].', '.$c['firstname'].' '.$c['suffix'];
		}
	
	return $contacts;
	}
				

	public function preached($contact_id, $per_page=15)
	{
		return DB::table('contacts')
		->join('audios', 'audios.contacts_id', '=', 'contacts.id')
		->select('contacts.id','contacts.firstname','contacts.lastname','contacts.image','contacts.suffix','audios.date','audios.title','audios.bible')
		->orderBy('audios.date','DESC')
		->where('contacts.id','=',$contact_id)
		->paginate($per_page);
		
	}
	
	public function recorded()
	{
		$top = DB::table('contacts')
		->join('audios', 'audios.contacts_id', '=', 'contacts.id')
		->select('contacts.id','contacts.firstname','contacts.lastname','contacts.suffix')
		->orderBy(DB::raw('COUNT(contacts.id)'),'DESC')
		->orderBy('contacts.lastname','ASC')
		->orderBy('contacts.firstname','ASC')
		->groupBy('contacts.id')
		->limit(10)
		->get();
		
		$blank[0] =  new stdClass;
		$blank[0]->id = 'disabled';
		$blank[0]->firstname = '';
		$blank[0]->lastname = '';
		
		$blank[1] =  new stdClass;
		$blank[1]->id = 'disabled';
		$blank[1]->firstname = '';
		$blank[1]->lastname = '-- Alphabetical Listing --';
		
		$all = DB::table('contacts')
		->join('audios', 'audios.contacts_id', '=', 'contacts.id')
		->select('contacts.id','contacts.firstname','contacts.lastname','contacts.suffix')
		->orderBy('contacts.lastname','ASC')
		->orderBy('contacts.firstname','ASC')
		->groupBy('contacts.id')
		->get();
		
		$list = array_merge( $top,$blank,$all );
		
		return $list;
	}
	//Study on laravel scopes to better do this later.
	public function mailable()
	{
		
		return DB::table('addresses')
		->leftJoin('address_contact', 'addresses.id', '=', 'address_contact.address_id')
		->leftJoin('contacts', 'address_contact.contact_id', '=', 'contacts.id')
		->select($this->collections_select)
		->orderBy('addresses.zip','ASC')
		->groupBy('addresses.id')
		->get();
	}
	
	public function maine()
	{
		
		return DB::table('addresses')
		->leftJoin('address_contact', 'addresses.id', '=', 'address_contact.address_id')
		->leftJoin('contacts', 'address_contact.contact_id', '=', 'contacts.id')
		->select($this->collections_select)
		->orderBy('addresses.zip','ASC')
		->groupBy('addresses.id')
		->where('addresses.state','=','ME')
		->get();
	}

		public function outofstate()
	{
		
		return DB::table('addresses')
		->leftJoin('address_contact', 'addresses.id', '=', 'address_contact.address_id')
		->leftJoin('contacts', 'address_contact.contact_id', '=', 'contacts.id')
		->select($this->collections_select)
		->orderBy('addresses.zip','ASC')
		->groupBy('addresses.id')
		->where('addresses.state','!=','ME')
		->get();
	}

		public function supported_mission()
	{
		
		$supported_missions_id = Collection::find(19)->contacts()->lists('contact_id');
		
	return DB::table('addresses')
		->leftJoin('address_contact', 'addresses.id', '=', 'address_contact.address_id')
		->leftJoin('contacts', 'address_contact.contact_id', '=', 'contacts.id')
		->select($this->collections_select)
		->orderBy('addresses.zip','ASC')
		->groupBy('addresses.id')
		->whereIn('contacts.id', $supported_missions_id)
		->get();
				
	}
	
	 public function getFullNameAttribute()
    {    
		return $this->attributes['firstname'] . ' ' . $this->attributes['lastname']. ' ' . $this->attributes['suffix'];

    }
	
		public function allPerPage($integer,$sortBy)
	  {
		return $this->orderBy($sortBy)->paginate($integer);
	  }
	  
	  	public function filter($filter,$paginate)
	{
		$addresses = Address::where($filter[0],'=',$filter[1])->select('id')->lists('id');
		
		$contacts = Contact::whereHas('addresses', function($q) use ($addresses)
			{
				$q->whereIn('addresses.id', $addresses);

			})->paginate($paginate);
		
		return $contacts;
	}
}