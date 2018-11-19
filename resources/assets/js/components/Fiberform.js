import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import request from 'superagent';
import Modal from 'react-responsive-modal';

export default class FiberForm extends Component {
    constructor(props){
      super(props);

      this.state={
        name:'',
        email:'',
        phone:'',
        address:'',
        message:'',
        isValidate:false,
        messagebox_shown:false,
        messagebox_data:"",
          button_text:"Submit",
          button_disabled:false
      };

        this.onCloseModal = this.onCloseModal.bind(this);
      this.handleChange = this.handleChange.bind(this);
      this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(event){
      this.setState({
        [event.target.name]:event.target.value
      })
    }

    handleSubmit(){

        this.setState({
            button_text:"Submitting...",
            button_disabled:true
        });

        let data = new FormData();

        data.append('name',this.state.name);
        data.append('email',this.state.email);
        data.append('phone',this.state.phone);
        data.append('address',this.state.address);
        data.append('message',this.state.message);
        data.append('_token',$('meta[name="csrf-token"]').attr('content'));

        fetch('/api/mail',{
            method:'POST',
            body:data,
            credentials: "same-origin"
        }).then(response => {
            return response.json();
        })
        .then(data => {
            if(data.name) this.onOpenModal(data.name[0]);
            else if(data.email) this.onOpenModal(data.email[0]);
            else if(data.phone) this.onOpenModal(data.phone[0]);
            else if(data.address) this.onOpenModal(data.address[0]);
            else if(data.message) this.onOpenModal(data.message[0]);
            else if(data.success) this.onOpenModal(data.success);

            this.resetButton();
        });
    }

    resetButton(){
        this.setState({
            button_disabled:false,
            button_text:"Submit"
        });
    }

    onOpenModal(data){
        this.setState({
            messagebox_shown: true,
            messagebox_data: data
        });

    };
    onCloseModal(){
        this.setState({
            messagebox_shown: false,
            messagebox_data: ""
        });
    };

    buttonText(){
        return {__html: this.state.button_text};
    }

    createMarkup(){
        return {__html: this.state.messagebox_data};
    }

    render() {
        const { messagebox_shown } = this.state;
        return (
        <div className="form-wrapper">
          <form action="">
            <input type="text" className="form-control col-8" placeholder="Name"   value={this.state.name} name="name"  onChange={this.handleChange}/>
            <input type="email" className="form-control col-8" placeholder="Email"   value={this.state.email} name="email"  onChange={this.handleChange} />
            <input type="text" className="form-control col-8" placeholder="Phone"   value={this.state.phone} name="phone"  onChange={this.handleChange}/>
            <input type="text" className="form-control col-8" placeholder="Address" value={this.state.address} name="address"  onChange={this.handleChange}/>
            <textarea className="form-control col-8" rows="5" placeholder="Message" value={this.state.message} name="message"  onChange={this.handleChange}></textarea>
          </form>

          <button id="fiberform_button" type="button" className="btn" onClick={() => this.handleSubmit()} disabled={this.state.button_disabled} dangerouslySetInnerHTML={this.buttonText()}></button>

            <Modal open={messagebox_shown} onClose={this.onCloseModal} closeIconSize={20} showCloseIcon={false}>
                <div>
                    <div dangerouslySetInnerHTML={this.createMarkup()}>
                    </div>
                </div>
            </Modal>


        </div>
      );
    }
}
