import dispatcher from "../dispatcher";
import axios from "axios";
import appConstants from "../constants/appConstants";

export function keepOnlyThisChapter(data){
	dispatcher.dispatch({type: appConstants.KEEP_AND_CLEAR_CHAPTER, data: data});
}

export function addChapter(id){

// /graphql?query=query+FetchBibleChapter{biblechapters(reference:%22John%203%22){id,next,orderBy,previous,reference,url,book{id,n},verses{id,v,t}}}
var URL = "/graphql?query=query+FetchBibleChapter{biblechapters(id:\""+id+"\"){id,next,previous,reference,url,orderBy,book{id,n},verses{id,v,t}}}";

dispatcher.dispatch({type: appConstants.FETCH_CHAPTER});

  axios(URL).then((data) => {
	 dispatcher.dispatch({type: appConstants.ADD_CHAPTER, data: data.data.data.biblechapters[0]});
  })

}

export function getChapter(id){

var URL = "/graphql?query=query+FetchBibleChapter{biblechapters(id:\""+id+"\"){id,next,orderBy,previous,reference,url,book{id,n},verses{id,v,t}}}";
// /graphql?query=query+FetchBibleChapter{biblechapters(reference:%22John%203%22){id,next,orderBy,previous,reference,url,book{id,n},verses{id,v,t}}}

dispatcher.dispatch({type: appConstants.FETCH_CHAPTER});

  axios(URL).then((data) => {
	 dispatcher.dispatch({type: appConstants.GET_CHAPTER, data: data.data.data.biblechapters[0]});
  })
 
}

export function getChapterByReference(ref){
	
// /graphql?query=query+FetchBibleChapter{biblechapters(reference:%22John%203%22){id,next,orderBy,previous,reference,url,book{id,n},verses{id,v,t}}}
var URL = "/graphql?query=query+FetchBibleChapter{biblechapters(reference:\""+ref+"\"){id,next,previous,orderBy,reference,url,book{id,n},verses{id,v,t}}}";

dispatcher.dispatch({type: appConstants.FETCH_CHAPTER});

  axios(URL).then((data) => {
	 
	  if(data.data.errors){
		  dispatcher.dispatch({type: appConstants.FETCH_FAILED, data: data});
	  }else{
		console.log(Date.now());
		dispatcher.dispatch({type: appConstants.GET_CHAPTER, data: data.data.data.biblechapters[0]});
	  }
  })
 
}