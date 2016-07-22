<?php namespace BibleExperience;

use BibleExperience\Study;

class StudyRepository {
	
	public function __construct()
	{
		//
	}
	
    /**
     * Persist a study
     *
     * @param Study $study
     * @return mixed
     */
    public function save(Study $study)
    {
    	$study->save();
    }    
   
    public function getPaginated($howMany = 25)
    {
        return Study::orderBy('title', 'asc')->whereNotNull('public')->paginate($howMany);
    }

    public function findById($id)
    {
        return Study::findOrFail($id);
    }

} 