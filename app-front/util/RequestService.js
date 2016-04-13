import request from 'request';
import bluebird from 'bluebird';
import AppConstants from './AppConstants';
import SessionStore from '../stores/SessionStore'; 

class RequestService {

/* Session & User Authorization Stuff*/
 login(email, password) {
	 //  /graphql?query=mutation+UserSession{userSession(email:%22sgrjr@deliverance.me%22,password:%221230happy%22){id,email}}
	let URL = AppConstants.BASE_URL+"/graphql?query=mutation+UserSession{userSession(email:\""+email+"\",password:\""+password+"\"){id,email,firstname,token,gravatar,unreadNotifications{id,body}}}";
    
	return this.get(URL);
  }
	
  signup(username, password, extra) {
    return new bluebird( (resolve, reject) => {
      request.post(
        {
          url: AppConstants.SIGNUP_URL,
          body: {username, password, extra},
          json: true
        },
        (err, response, body) => {
          if(err){
            return reject(err);
          }
          if(response.statusCode >= 400){
            return reject(body);
          }
          return resolve(body);
        }
      );
    });
  }

    fetch(token) {
	 // /graphql?query=mutation+UserSession{userSession(token:"__TOKEN_HERE__"){id,email,token}}
	let URL = AppConstants.BASE_URL+"/graphql?query=mutation+UserSession{userSession(token:\""+token+"\"){id,email,firstname,token,gravatar,unreadNotifications{id,body}}}";

	return this.get(URL);
	
	}
/* END: Session & User Authorization Stuff*/

    bibleChapterByReference(ref) {
		let URL = AppConstants.BASE_URL+"/graphql?query=query+FetchBibleChapter{biblechapters(reference:\""+ref+"\"){id,next,previous,orderBy,reference,url,book{id,n},verses{id,v,t,url}}}";
	
		return this.get(URL);
	}
	
	getChapter(id) {
		let URL = AppConstants.BASE_URL+ "/graphql?query=query+FetchBibleChapter{biblechapters(id:\""+id+"\"){id,next,previous,orderBy,reference,url,book{id,n},verses{id,v,t,url}}}";
	
		return this.get(URL);
	}
	
	addChapter(id) {
		let URL = AppConstants.BASE_URL+ "/graphql?query=query+FetchBibleChapter{biblechapters(id:\""+id+"\"){id,next,previous,orderBy,reference,url,book{id,n},verses{id,v,t,url}}}";
	
		return this.get(URL);
	}
	
	////VERSES
	
	bibleVerseByReference(ref) {
		let URL = AppConstants.BASE_URL+"/graphql?query=query+FetchBibleVerse{bibleverses(reference:\""+ref+"\"){id,t,b,c,v,reference,url,chapterURL,notes{id,body,user{username}}}}";
		console.log(URL);
		return this.get(URL);
	}
	
	/// NOTES
	getNote(id) {
		let URL = AppConstants.BASE_URL+ "/graphql?query=query+FetchNote{notes(id:\""+id+"\"){id}}";
		return this.get(URL);
	}
	
	/// App
	bookMarkIt(urlToSave, token) {
		let URL = AppConstants.BASE_URL+"/graphql?query=mutation+UserBookmark{userBookmark(token:\""+token+"\",url:\""+urlToSave+"\",action:\"create\"){url,user{id}}}";
		return this.get(URL);
	} 
	
	createNote(note) {

		let object = "body: \""+note.body+"\",bible_verse_id: \""+note.bible_verse_id+"\",token: \""+SessionStore.token+"\"";
		console.log(object);
		let fields = "id,bible_verse_id";
 
		let URL = AppConstants.BASE_URL+"/graphql?query=mutation+NoteCreate{noteCreate("+object+"){"+fields+"}}";
		return this.get(URL);
	} 
	
	github(path=false){
		
		let base = "https://api.github.com/repos/bibleexchange/courses/contents";
		let URL = '';
		
		if(path){
			URL = base+path;	
		}else{
			URL = base;	
		}
		
		return this.get(URL);
	}
	
///MASTER SEND GET REQUEST:
  get(url){	  
	console.log(url);
	    return new bluebird( (resolve, reject) => {
		  request.get(
			{
			  url: url,
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