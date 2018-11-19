import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Modal from 'react-responsive-modal';

export default class NewsLetterBox extends Component {
    constructor(props){
        super(props);
        this.state ={
            open:false
        }
        this.onOpenModal = this.onOpenModal.bind(this);
        this.onCloseModal = this.onCloseModal.bind(this);
    }

    onOpenModal(){
        this.setState({ open: true });
    };
    onCloseModal(){
        this.setState({ open: false });
    };

    render() {
        const { open } = this.state;
        return (
            <tr>
                <td><img src={this.props.volimg} alt=""/></td>
                <td>{this.props.volume}</td>
                <td>{this.props.dateletter}</td>
                <td><button className="btn btnreadmore" onClick={this.onOpenModal} >view</button></td>
                <Modal open={open} onClose={this.onCloseModal} closeIconSize={20}>
                    <div className="modal-wrapper">
                        <div className="volimg-wrapper">
                            <img src={this.props.volimg} alt=""/>
                        </div>
                    </div>
                </Modal>
            </tr>
        );
    }
}







