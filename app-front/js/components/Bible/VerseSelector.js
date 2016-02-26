import React from 'react';
import { Modal, Button } from 'react-bootstrap';
import BibleBooksList from './BibleBooksList';
class VerseSelector extends React.Component {
  
	constructor(props) {
		super(props);	
		this.state = {showModal:false};
	  }
	
  toggleModal() {
    const show = !this.state.showModal;
    this.setState({showModal:show});
  }
  
  close(){
	const show = !this.state.showModal;
    this.setState({showModal:show});
  }
  
  render() {
		
		let rand = ()=> (Math.floor(Math.random() * 20) - 10);
		
		const modalStyle = {
		  position: 'relative',
		  zIndex: 1040,
		  top: 100, bottom: 0, left: 0, right: 0,
		  verticalAlign: 'middle'
		};

		const backdropStyle = {
		  position: 'fixed',
		  top: 0, bottom: 0, left: 0, right: 0,
		  zIndex: 'auto',
		  backgroundColor: '#000',
		  opacity: 0.5
		};
		
		const verseSelectorButtonStyle = {
		  border:'none', background:'transparent'
		};
		

		const dialogStyle = function() {

		  return {
			position: 'absolute',
			border: '1px solid #e5e5e5',
			backgroundColor: 'white',
			boxShadow: '0 5px 15px rgba(0,0,0,.5)',
			padding: 20
		  };
		};
		
		const bibleBooks = [
			{"id":1,"n":"Genesis","slug":"genesis","t":"OT","g":1,"chapters":50},{"id":2,"n":"Exodus","slug":"exodus","t":"OT","g":1,"chapters":40},{"id":3,"n":"Leviticus","slug":"leviticus","t":"OT","g":1,"chapters":27},{"id":4,"n":"Numbers","slug":"numbers","t":"OT","g":1,"chapters":36},{"id":5,"n":"Deuteronomy","slug":"deuteronomy","t":"OT","g":1,"chapters":34},{"id":6,"n":"Joshua","slug":"joshua","t":"OT","g":2,"chapters":24},{"id":7,"n":"Judges","slug":"judges","t":"OT","g":2,"chapters":21},{"id":8,"n":"Ruth","slug":"ruth","t":"OT","g":2,"chapters":4},{"id":9,"n":"1 Samuel","slug":"1samuel","t":"OT","g":2,"chapters":31},{"id":10,"n":"2 Samuel","slug":"2samuel","t":"OT","g":2,"chapters":24},{"id":11,"n":"1 Kings","slug":"1kings","t":"OT","g":2,"chapters":22},{"id":12,"n":"2 Kings","slug":"2kings","t":"OT","g":2,"chapters":25},{"id":13,"n":"1 Chronicles","slug":"1chronicles","t":"OT","g":2,"chapters":29},{"id":14,"n":"2 Chronicles","slug":"2chronicles","t":"OT","g":2,"chapters":36},{"id":15,"n":"Ezra","slug":"ezra","t":"OT","g":2,"chapters":10},{"id":16,"n":"Nehemiah","slug":"nehemiah","t":"OT","g":2,"chapters":13},{"id":17,"n":"Esther","slug":"esther","t":"OT","g":2,"chapters":10},{"id":18,"n":"Job","slug":"job","t":"OT","g":3,"chapters":42},{"id":19,"n":"Psalms","slug":"psalms","t":"OT","g":3,"chapters":150},{"id":20,"n":"Proverbs","slug":"proverbs","t":"OT","g":3,"chapters":31},{"id":21,"n":"Ecclesiastes","slug":"ecclesiastes","t":"OT","g":3,"chapters":12},{"id":22,"n":"Song of Solomon","slug":"songofsolomon","t":"OT","g":3,"chapters":8},{"id":23,"n":"Isaiah","slug":"isaiah","t":"OT","g":4,"chapters":66},{"id":24,"n":"Jeremiah","slug":"jeremiah","t":"OT","g":4,"chapters":52},{"id":25,"n":"Lamentations","slug":"lamentations","t":"OT","g":4,"chapters":5},{"id":26,"n":"Ezekiel","slug":"ezekiel","t":"OT","g":4,"chapters":48},{"id":27,"n":"Daniel","slug":"daniel","t":"OT","g":4,"chapters":12},{"id":28,"n":"Hosea","slug":"hosea","t":"OT","g":4,"chapters":14},{"id":29,"n":"Joel","slug":"joel","t":"OT","g":4,"chapters":3},{"id":30,"n":"Amos","slug":"amos","t":"OT","g":4,"chapters":9},{"id":31,"n":"Obadiah","slug":"obadiah","t":"OT","g":4,"chapters":1},{"id":32,"n":"Jonah","slug":"jonah","t":"OT","g":4,"chapters":4},{"id":33,"n":"Micah","slug":"micah","t":"OT","g":4,"chapters":7},{"id":34,"n":"Nahum","slug":"nahum","t":"OT","g":4,"chapters":3},{"id":35,"n":"Habakkuk","slug":"habakkuk","t":"OT","g":4,"chapters":3},{"id":36,"n":"Zephaniah","slug":"zephaniah","t":"OT","g":4,"chapters":3},{"id":37,"n":"Haggai","slug":"haggai","t":"OT","g":4,"chapters":2},{"id":38,"n":"Zechariah","slug":"zechariah","t":"OT","g":4,"chapters":14},{"id":39,"n":"Malachi","slug":"malachi","t":"OT","g":4,"chapters":4},{"id":40,"n":"Matthew","slug":"matthew","t":"NT","g":5,"chapters":28},{"id":41,"n":"Mark","slug":"mark","t":"NT","g":5,"chapters":16},{"id":42,"n":"Luke","slug":"luke","t":"NT","g":5,"chapters":24},{"id":43,"n":"John","slug":"john","t":"NT","g":5,"chapters":21},{"id":44,"n":"Acts","slug":"acts","t":"NT","g":6,"chapters":28},{"id":45,"n":"Romans","slug":"romans","t":"NT","g":7,"chapters":16},{"id":46,"n":"1 Corinthians","slug":"1corinthians","t":"NT","g":7,"chapters":16},{"id":47,"n":"2 Corinthians","slug":"2corinthians","t":"NT","g":7,"chapters":13},{"id":48,"n":"Galatians","slug":"galatians","t":"NT","g":7,"chapters":6},{"id":49,"n":"Ephesians","slug":"ephesians","t":"NT","g":7,"chapters":6},{"id":50,"n":"Philippians","slug":"philippians","t":"NT","g":7,"chapters":4},{"id":51,"n":"Colossians","slug":"colossians","t":"NT","g":7,"chapters":4},{"id":52,"n":"1 Thessalonians","slug":"1thessalonians","t":"NT","g":7,"chapters":5},{"id":53,"n":"2 Thessalonians","slug":"2thessalonians","t":"NT","g":7,"chapters":3},{"id":54,"n":"1 Timothy","slug":"1timothy","t":"NT","g":7,"chapters":6},{"id":55,"n":"2 Timothy","slug":"2timothy","t":"NT","g":7,"chapters":4},{"id":56,"n":"Titus","slug":"titus","t":"NT","g":7,"chapters":3},{"id":57,"n":"Philemon","slug":"philemon","t":"NT","g":7,"chapters":1},{"id":58,"n":"Hebrews","slug":"hebrews","t":"NT","g":7,"chapters":13},{"id":59,"n":"James","slug":"james","t":"NT","g":7,"chapters":5},{"id":60,"n":"1 Peter","slug":"1peter","t":"NT","g":7,"chapters":5},{"id":61,"n":"2 Peter","slug":"2peter","t":"NT","g":7,"chapters":3},{"id":62,"n":"1 John","slug":"1john","t":"NT","g":7,"chapters":5},{"id":63,"n":"2 John","slug":"2john","t":"NT","g":7,"chapters":1},{"id":64,"n":"3 John","slug":"3john","t":"NT","g":7,"chapters":1},{"id":65,"n":"Jude","slug":"jude","t":"NT","g":7,"chapters":1},{"id":66,"n":"Revelation","slug":"revelation","t":"NT","g":8,"chapters":22}	
		];
		
    return (
	
		<span>
			<Button onClick={this.toggleModal.bind(this)} style={verseSelectorButtonStyle}>
			  <span className="glyphicon glyphicon-th"></span>
			</Button>
	        
			<Modal
			  aria-labelledby='modal-label'
			  style={modalStyle}
			  backdropStyle={backdropStyle}
			  show={this.state.showModal}
			  onHide={this.close.bind(this)}
			  bsSize='lg'
			>
			  <div style={dialogStyle()} >
				
				<Button onClick={this.toggleModal.bind(this)}>
				  <span ariaHidden="true">&times;</span>
				</Button>
				
				<h4 className="modal-title" id="myModalLabel">
					Choose a book and chapter to open
				</h4>
				
				<BibleBooksList books={bibleBooks} closeAll={this.close.bind(this)}/>	
				
			  </div>
			</Modal>
		</span>
    )
  }
}

module.exports = VerseSelector;