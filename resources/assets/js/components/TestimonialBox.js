import React, { Component } from 'react';
import ReactDOM from 'react-dom';


export default class TestimonialBox extends Component {
    constructor(props){
      super(props);

    }

    render() {
        return (

                <div className="col-md-4">
                  <div className="testimonial-box">
                    <div className="testimonial-pic">
                      <img src={this.props.image} alt=""/>
                    </div>
                    <div className="testimonial-name">{this.props.name}</div>
                    <div className="testimonial-message">
                      {this.props.testimonial}
                    </div>
                  </div>
                </div>
        );
    }
}
