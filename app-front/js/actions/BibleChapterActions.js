import dispatcher from "../dispatcher";
import axios from "axios";

export function getChapter(id){
	
var URL = "/graphql?query=query+FetchBibleChapter{biblechapters(id:\""+id+"\"){id,next,previous,reference,verses{id,v,t}}}";
  axios(URL).then((data) => {
	 dispatcher.dispatch({type: "GET_CHAPTER", data: data});
  })
 
}

export function addChapter(id){
var URL = "/graphql?query=query+FetchBibleChapter{biblechapters(id:\""+id+"\"){id,next,previous,reference,verses{id,v,t}}}";
  axios(URL).then((data) => {
	 dispatcher.dispatch({type: "ADD_CHAPTER", data: data});
  })

}