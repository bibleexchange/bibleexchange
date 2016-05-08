import request from 'request';
import bluebird from 'bluebird';
import AppConstants from './AppConstants';
import SessionStore from '../stores/SessionStore'; 

class RequestService {

/* Session & User Authorization Stuff*/
 login(email, password) {
	 //  /graphql?query=mutation+UserSession{userSession(email:%22sgrjr@deliverance.me%22,password:%221230happy%22){id,email}}
	let URL = AppConstants.BASE_URL+"/graphql?query=mutation+UserSession{userSession(email:\""+email+"\",password:\""+password+"\"){id,email,firstname,token,gravatar,unreadNotifications{id,body}}}";

		let options = {
			url: URL,
			data: {},
			method: "GET"
		};
		
		return this.get(options);
  }
	
  signup(email, password, extra) {
	
	let options = {
		url: '/graphql?query=mutation+User{addUser(data:{email:"'+email+'",userId:"ID!",password:"'+password+'"})}',
		data: {email, password, extra},
		method: "POST"
	};
		
	return this.get(options);

  }

    fetch(token) {
	 // /graphql?query=mutation+UserSession{userSession(token:"__TOKEN_HERE__"){id,email,token}}
	let URL = AppConstants.BASE_URL+"/graphql?query=mutation+UserSession{userSession(token:\""+token+"\"){id,email,firstname,token,gravatar,unreadNotifications{id,body}}}";

		let options = {
			url: URL,
			data: {},
			method: "GET"
		};
		
		return this.get(options);
	
	}
/* END: Session & User Authorization Stuff*/

    bibleChapterByReference(ref) {
		let URL = AppConstants.BASE_URL+"/graphql?query=query+FetchBibleChapter{biblechapters(reference:\""+ref+"\"){id,next,previous,orderBy,reference,url,book{id,n},verses{id,v,t,url}}}";
	
		let options = {
			url: URL,
			data: {},
			method: "GET"
		};
		
		return this.get(options);
	}
	
	getChapter(id) {
		let URL = AppConstants.BASE_URL+ "/graphql?query=query+FetchBibleChapter{biblechapters(id:\""+id+"\"){id,next,previous,orderBy,reference,url,book{id,n},verses{id,v,t,url}}}";
	
				let options = {
			url: URL,
			data: {},
			method: "GET"
		};
		
		return this.get(options);
	}
	
	addChapter(id) {
		let URL = AppConstants.BASE_URL+ "/graphql?query=query+FetchBibleChapter{biblechapters(id:\""+id+"\"){id,next,previous,orderBy,reference,url,book{id,n},verses{id,v,t,url}}}";

		let options = {
			url: URL,
			data: {},
			method: "GET"
		};
		
		return this.get(options);
	}
	
	////VERSES
	
	bibleVerseByReference(ref) {
		let URL = AppConstants.BASE_URL+"/graphql?query=query+FetchBibleVerse{bibleverses(reference:\""+ref+"\"){id,t,b,c,v,reference,url,chapterURL,notes{id,body,user{username}}}}";
		console.log(URL);
		
		let options = {
			url: URL,
			data: {},
			method: "GET"
		};
		
		return this.get(options);
	}
	
	/// NOTES
	getNote(id) {
		let URL = AppConstants.BASE_URL+ "/graphql?query=query+FetchNote{notes(id:\""+id+"\"){id}}";

		let options = {
			url: URL,
			data: {},
			method: "GET"
		};
		
		return this.get(options);
	}
	
	/// App
	bookMarkIt(urlToSave, token) {
		let URL = AppConstants.BASE_URL+"/graphql?query=mutation+UserBookmark{userBookmark(token:\""+token+"\",url:\""+urlToSave+"\",action:\"create\"){url,user{id}}}";

		let options = {
			url: URL,
			data: {},
			method: "GET"
		};
		
		return this.get(options);
	} 
	
	createNote(note) {

		let object = "body: \""+note.body+"\",bible_verse_id: \""+note.bible_verse_id+"\",token: \""+SessionStore.token+"\"";
		console.log(object);
		let fields = "id,bible_verse_id";
 
		let URL = AppConstants.BASE_URL+"/graphql?query=mutation+NoteCreate{noteCreate("+object+"){"+fields+"}}";

		let options = {
			url: URL,
			data: {},
			method: "GET"
		};
		
		return this.get(options);
	} 
	
	github(path, dir=true){
		
		let base = "https://api.github.com/repos/bibleexchange/courses/contents";
		
		if(!dir){
			base = "https://raw.githubusercontent.com/bibleexchange/courses/master/";
		}
		
		let URL = base+path;
		
		let options = {
			url: URL,
			data: {},
			method: "GET"
		};
		
		this.get(options);
	}

///MASTER SEND GET REQUEST:
  get(options){	  
	console.log(options);
	    return new bluebird( (resolve, reject) => {
		  request.get(
			{
			  url: options.url,
			  json: true
			},
			(err, response, body) => {
			  if(err){
				return reject(err);
			  }
			  if(body.errors){
				return reject(body.errors);
			  }
			  if(response.statusCode >= 400){
				return reject(body);
			  }
			  return resolve(body);
			}
		  );
		});
	  }  
}

export default new RequestService();