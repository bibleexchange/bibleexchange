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
				
				<BibleBooksList books={this.props.books} closeAll={this.close.bind(this)}/>	
				
			  </div>
			</Modal>
		</span>
    )
  }
}

module.exports = VerseSelector;