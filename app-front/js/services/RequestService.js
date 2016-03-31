import request from 'request';
import bluebird from 'bluebird';
import AppConstants from '../constants/AppConstants';

class RequestService {

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
		let URL = AppConstants.BASE_URL+"/graphql?query=query+FetchBibleVerse{bibleverses(reference:\""+ref+"\"){id,t,b,c,v,reference,url,chapterURL,bible_chapter_id,notes{id,body,user{username}}}}";
		console.log(URL);
		return this.get(URL);
	}
	
	/// NOTES
	getNote(id) {
		let URL = AppConstants.BASE_URL+ "/graphql?query=query+FetchNote{notes(id:\""+id+"\"){id}}";
		return this.get(URL);
	}
	
///MASTER SEND GET REQUEST:
  get(url){	  
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