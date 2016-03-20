import React from 'react';

class StudyCard extends React.Component {
	
	constructor(props) {
		super(props);
	}
  
  editorsList(editors){
	var list = '';
	
	for (i = 0; i < editors.length; i++) { 
		list += '<a href="{{$editor->profileURL()}}" title="{!!$editor->fullname!!}">@include (users.partials.avatar, [size => 25,user=>$editor])</a>';
	}

	return list;
  }
  
 isPublicLook(isPublic){
	if(isPublic){
		return '<a href="{!!$study->url()!!}" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Open</a>';
	}else{
		return '<a class="btn btn-xs btn-default"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></a>';
	}
  }
  
    userAuth(user, study){
	  
		if (user.auth){		
			return '{!! Form::open([url=>/user/bookmarks]) !!}<input type="hidden" name="url" value="{!!url($study->url())!!}"><button type="submit" value="Next"class="btn btn-info" ><span class="glyphicon glyphicon-bookmark"></span> <span class="hidden-md">Bookmark</span></button>{!! Form::close()!!}';
		}else{
			if (user.id === study.creator.id){
				return '<a class="btn btn-warning" role="button" href="{!!$study->editUrl()!!}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> <span class="hidden-xs hidden-md">Edit</span></a>';
			}
		}
		  
	  }

			
  render() {
    return (
		<div class="panel panel-default panel-study pub_{{$study->is_published}}">
		  <a href="{!!$study->url()!!}" >
			<img class="study-object-default-image" src="{{$study->defaultImage->src}}?h=600&w=600" name="{{$study->defaultImage->name}}" alt="{{$study->defaultImage->alt_text}}" />
		  </a>
		  
		  <div class="panel-heading">
		  
			<a href="{!!$study->url()!!}">
			
				<h3 class="panel-title">
					this.props.study.title
				</h3>
			</a>
		  </div>
		  <div class="panel-body">
				this.props.study.description
				<span style="display:block; clear:both; margin-bottom:5px;"></span>
				
				{this.editorsList(this.props.study.editors)}
			 
		  </div>
		  <div class="panel-footer">
				
				{this.isPublicLook(this.props.study.isPublic)}
				
				{this.userAuth(this.props.user, this.props.study)}
				 
				<span class="updated"><span class="glyphicon glyphicon-time"></span>{this.props.study.lasChangeWasMade}</span>
			
		  </div>
		</div>
    )
  }
}

module.exports = StudyCard;